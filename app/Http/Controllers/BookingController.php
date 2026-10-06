<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use App\Models\TicketCategory;
use App\Models\Order;
use App\Models\OrderAttendee;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Show Checkout Form (tiket.com style)
     */
    public function checkout($categoryId, Request $request)
    {
        $category = TicketCategory::with('concert')->findOrFail($categoryId);

        if ($category->available_quota <= 0) {
            return redirect()->route('concerts.show', $category->concert->slug)
                             ->with('error', 'Maaf, kuota kategori tiket ini sudah habis.');
        }

        $quantity = min(max((int) $request->query('qty', 1), 1), min(4, $category->available_quota));
        $concert = $category->concert;

        // Default calculations
        $subtotal = $category->price * $quantity;
        $taxFee = (int) ($subtotal * 0.10); // 10% Gov/Entertainment Tax
        $adminFee = 20000; // Platform fee per transaction
        $total = $subtotal + $taxFee + $adminFee;

        return view('booking.checkout', compact('category', 'concert', 'quantity', 'subtotal', 'taxFee', 'adminFee', 'total'));
    }

    /**
     * AJAX Check Promo Code
     */
    public function checkPromo(Request $request)
    {
        $code = trim($request->input('code'));
        $subtotal = (int) $request->input('subtotal', 0);

        $promo = Promo::where('code', $code)
                      ->where('is_active', true)
                      ->where(function ($q) {
                          $q->whereNull('valid_until')->orWhere('valid_until', '>=', Carbon::now());
                      })
                      ->first();

        if (!$promo) {
            return response()->json([
                'success' => false,
                'message' => 'Kode promo tidak valid atau sudah kadaluarsa.',
            ], 404);
        }

        if ($subtotal < $promo->min_purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal pembelian untuk promo ini adalah Rp ' . number_format($promo->min_purchase, 0, ',', '.'),
            ], 422);
        }

        $discount = $promo->calculateDiscount($subtotal);

        return response()->json([
            'success' => true,
            'code' => $promo->code,
            'title' => $promo->title,
            'discount' => $discount,
            'formatted_discount' => 'Rp ' . number_format($discount, 0, ',', '.'),
            'message' => 'Kupon promo berhasil digunakan! Diskon ' . 'Rp ' . number_format($discount, 0, ',', '.'),
        ]);
    }

    /**
     * Process Checkout & Create Order
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'ticket_category_id' => 'required|exists:ticket_categories,id',
            'quantity' => 'required|integer|min:1|max:4',
            'customer_name' => 'required|string|max:150',
            'customer_email' => 'required|email|max:150',
            'customer_phone' => 'required|string|max:30',
            'customer_nik' => 'required|string|min:8|max:30',
            'attendees' => 'required|array',
            'attendees.*.name' => 'required|string|max:150',
            'attendees.*.nik' => 'required|string|min:8|max:30',
            'payment_method' => 'required|string',
            'promo_code' => 'nullable|string',
        ]);

        $category = TicketCategory::with('concert')->findOrFail($request->ticket_category_id);
        $quantity = (int) $request->quantity;

        if ($category->available_quota < $quantity) {
            return back()->withInput()->with('error', 'Maaf, sisa kuota tiket tidak mencukupi untuk jumlah pemesanan Anda.');
        }

        $subtotal = $category->price * $quantity;
        $taxFee = (int) ($subtotal * 0.10);
        $adminFee = 20000;
        $discountAmount = 0;
        $promoCode = null;

        if (!empty($request->promo_code)) {
            $promo = Promo::where('code', $request->promo_code)
                          ->where('is_active', true)
                          ->where(function ($q) {
                              $q->whereNull('valid_until')->orWhere('valid_until', '>=', Carbon::now());
                          })
                          ->first();

            if ($promo && $subtotal >= $promo->min_purchase) {
                $discountAmount = $promo->calculateDiscount($subtotal);
                $promoCode = $promo->code;
            }
        }

        $totalPrice = max(0, ($subtotal + $taxFee + $adminFee) - $discountAmount);

        // Generate Unique Order Code
        $artistPrefix = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $category->concert->artist_name), 0, 3));
        $orderCode = 'TK-' . $artistPrefix . '-' . date('Y') . '-' . strtoupper(Str::random(5));

        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_code' => $orderCode,
                'concert_id' => $category->concert_id,
                'ticket_category_id' => $category->id,
                'quantity' => $quantity,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_nik' => $request->customer_nik,
                'subtotal_price' => $subtotal,
                'tax_fee' => $taxFee,
                'admin_fee' => $adminFee,
                'discount_amount' => $discountAmount,
                'promo_code' => $promoCode,
                'total_price' => $totalPrice,
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
                'payment_deadline' => Carbon::now()->addMinutes(30),
                'notes' => $request->notes,
            ]);

            // Create Attendees
            $attendeesInput = $request->input('attendees', []);
            for ($i = 0; $i < $quantity; $i++) {
                $attData = $attendeesInput[$i] ?? [
                    'name' => $request->customer_name,
                    'nik' => $request->customer_nik,
                    'email' => $request->customer_email,
                ];

                $ticketNumber = 'ETK-' . $artistPrefix . '-' . strtoupper(substr($category->code ?? 'CAT', 0, 3)) . '-' . rand(1000, 9999);
                
                // Generate queue or seat
                if ($category->type === 'standing') {
                    $seatOrQueue = 'QN-' . str_pad((string) rand(1, 999), 3, '0', STR_PAD_LEFT);
                } else {
                    $rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                    $seatOrQueue = 'SEC-' . ($category->seat_section ? substr($category->seat_section, 0, 5) : 'TRB') . '-ROW-' . $rows[array_rand($rows)] . '-' . rand(1, 30);
                }

                $barcodeCode = 'BC' . rand(10000000, 99999999);

                OrderAttendee::create([
                    'order_id' => $order->id,
                    'ticket_number' => $ticketNumber,
                    'attendee_name' => $attData['name'] ?? $request->customer_name,
                    'attendee_nik' => $attData['nik'] ?? $request->customer_nik,
                    'attendee_email' => $attData['email'] ?? $request->customer_email,
                    'seat_or_queue_number' => $seatOrQueue,
                    'barcode_code' => $barcodeCode,
                    'check_in_status' => 'pending',
                ]);
            }

            // Decrement Category available quota
            $category->decrement('available_quota', $quantity);

            DB::commit();

            return redirect()->route('booking.payment', $order->order_code)
                             ->with('success', 'Pesanan Anda berhasil dibuat! Silakan selesaikan pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Payment simulation page
     */
    public function payment($orderCode)
    {
        $order = Order::with(['concert', 'ticketCategory', 'attendees'])->where('order_code', $orderCode)->firstOrFail();

        if ($order->payment_status === 'paid') {
            return redirect()->route('booking.order', $order->order_code);
        }

        return view('booking.payment', compact('order'));
    }

    /**
     * Process payment simulation (Confirm Payment)
     */
    public function confirmPayment(Request $request, $orderCode)
    {
        $order = Order::with(['concert', 'ticketCategory', 'attendees'])->where('order_code', $orderCode)->firstOrFail();

        $order->update([
            'payment_status' => 'paid',
            'paid_at' => Carbon::now(),
            'payment_method' => $request->input('payment_method', $order->payment_method),
        ]);

        return redirect()->route('booking.order', $order->order_code)
                         ->with('success', 'Pembayaran berhasil dikonfirmasi! E-Ticket konser Anda telah aktif.');
    }

    /**
     * Show Order Detail & E-Ticket (tiket.com style)
     */
    public function showOrder($orderCode)
    {
        $order = Order::with(['concert', 'ticketCategory', 'attendees'])->where('order_code', $orderCode)->firstOrFail();

        return view('booking.order', compact('order'));
    }

    /**
     * Cek Pesanan / My Booking form & result
     */
    public function checkBooking(Request $request)
    {
        $orderCode = trim($request->input('order_code', ''));
        $email = trim($request->input('email', ''));
        $orders = collect();
        $searched = false;

        if ($orderCode || $email) {
            $searched = true;
            $query = Order::with(['concert', 'ticketCategory', 'attendees'])->latest();

            if ($orderCode) {
                $query->where('order_code', 'like', "%{$orderCode}%");
            }

            if ($email) {
                $query->where('customer_email', $email);
            }

            $orders = $query->get();
        }

        return view('booking.check', compact('orders', 'searched', 'orderCode', 'email'));
    }
}
