<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Concert;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $concertId = $request->query('concert_id');

        $query = Order::with(['concert', 'ticketCategory', 'attendees']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_nik', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('payment_status', $status);
        }

        if ($concertId) {
            $query->where('concert_id', $concertId);
        }

        $orders = $query->latest()->paginate(15);
        $concerts = Concert::select('id', 'title', 'artist_name')->get();

        // Dashboard stats
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_price');
        $totalTicketsSold = Order::where('payment_status', 'paid')->sum('quantity');
        $totalOrdersCount = Order::count();
        $pendingOrdersCount = Order::where('payment_status', 'unpaid')->count();

        return view('admin.orders.index', compact('orders', 'concerts', 'search', 'status', 'concertId', 'totalRevenue', 'totalTicketsSold', 'totalOrdersCount', 'pendingOrdersCount'));
    }

    public function show($id)
    {
        $order = Order::with(['concert', 'ticketCategory', 'attendees'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $status = $request->validate([
            'payment_status' => 'required|in:unpaid,paid,cancelled,expired',
        ])['payment_status'];

        $order->payment_status = $status;
        if ($status === 'paid' && !$order->paid_at) {
            $order->paid_at = now();
        }
        $order->save();

        return redirect()->back()->with('success', "Status pesanan {$order->order_code} berhasil diubah menjadi {$status}.");
    }
}
