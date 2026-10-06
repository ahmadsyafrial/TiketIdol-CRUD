@extends('layouts.admin')

@section('title', 'Detail Pesanan - ' . $order->order_code)
@section('page-title', 'Detail Transaksi Pesanan')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <!-- Order Header Card -->
        <div class="card card-admin p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                <div>
                    <span class="text-secondary small">Kode Booking / Pesanan:</span>
                    <h4 class="fw-bold font-monospace text-primary mb-0">{{ $order->order_code }}</h4>
                </div>
                <div>
                    {!! $order->status_badge !!}
                </div>
            </div>

            <div class="row g-3 small">
                <div class="col-md-6">
                    <span class="text-muted d-block">Konser:</span>
                    <strong class="text-dark fs-6">{{ $order->concert->title }}</strong>
                    <div class="text-secondary">{{ $order->concert->venue_name }}, {{ $order->concert->city }}</div>
                    <div class="text-secondary">{{ $order->concert->formatted_date }} ({{ $order->concert->formatted_time }})</div>
                </div>

                <div class="col-md-6">
                    <span class="text-muted d-block">Kategori Tiket:</span>
                    <span class="badge" style="background-color: {{ $order->ticketCategory->color_hex }}; color: #fff;">
                        {{ $order->ticketCategory->name }}
                    </span>
                    <div class="text-dark fw-bold mt-1">{{ $order->quantity }} Tiket ({{ $order->ticketCategory->type === 'standing' ? 'Festival Standing' : 'Numbered Seated' }})</div>
                    <div class="text-muted">Pintu Masuk: {{ $order->ticketCategory->entry_gate }}</div>
                </div>
            </div>
        </div>

        <!-- Data Pengunjung / Pemegang Tiket Table -->
        <div class="card card-admin p-4 mb-4">
            <h5 class="fw-bold text-dark mb-3">Daftar Pemegang Tiket ({{ $order->attendees->count() }} Pengunjung)</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle small mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No. Tiket</th>
                            <th>Nama Pengunjung</th>
                            <th>NIK / No. Identitas</th>
                            <th>No. Antrean / Kursi</th>
                            <th>Barcode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->attendees as $att)
                            <tr>
                                <td class="fw-bold font-monospace text-primary">{{ $att->ticket_number }}</td>
                                <td class="fw-semibold text-dark">{{ $att->attendee_name }}</td>
                                <td class="font-monospace text-secondary">{{ $att->attendee_nik }}</td>
                                <td>
                                    <span class="badge bg-dark font-monospace text-warning px-2 py-1">
                                        {{ $att->seat_or_queue_number }}
                                    </span>
                                </td>
                                <td class="font-monospace text-muted small">{{ $att->barcode_code }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Price Breakdown -->
        <div class="card card-admin p-4">
            <h5 class="fw-bold text-dark mb-3">Rincian Keuangan & Biaya</h5>
            <table class="table table-borderless small mb-0">
                <tbody>
                    <tr>
                        <td class="text-secondary">Harga Tiket:</td>
                        <td class="text-end fw-semibold text-dark">{{ $order->quantity }} x {{ $order->ticketCategory->formatted_price }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Subtotal Tiket:</td>
                        <td class="text-end fw-semibold text-dark">{{ $order->formatted_subtotal }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Pajak Hiburan 10%:</td>
                        <td class="text-end fw-semibold text-dark">{{ $order->formatted_tax }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Biaya Layanan Platform:</td>
                        <td class="text-end fw-semibold text-dark">{{ $order->formatted_admin_fee }}</td>
                    </tr>
                    @if($order->discount_amount > 0)
                        <tr class="text-success">
                            <td>Potongan Kupon Promo ({{ $order->promo_code }}):</td>
                            <td class="text-end fw-bold">- {{ $order->formatted_discount }}</td>
                        </tr>
                    @endif
                    <tr class="border-top">
                        <td class="fw-bold text-dark fs-6">Total Pembayaran:</td>
                        <td class="text-end fw-bold text-primary fs-5">{{ $order->formatted_total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right Column: Customer Info & Status Action -->
    <div class="col-lg-4">
        <!-- Customer Info Card -->
        <div class="card card-admin p-4 mb-4">
            <h5 class="fw-bold text-dark mb-3">Informasi Pemesan</h5>
            <div class="small d-flex flex-column gap-2 text-secondary">
                <div>
                    <span class="text-muted d-block">Nama Lengkap:</span>
                    <strong class="text-dark">{{ $order->customer_name }}</strong>
                </div>
                <div>
                    <span class="text-muted d-block">Email:</span>
                    <strong class="text-dark">{{ $order->customer_email }}</strong>
                </div>
                <div>
                    <span class="text-muted d-block">No. WhatsApp / HP:</span>
                    <strong class="text-dark">{{ $order->customer_phone }}</strong>
                </div>
                <div>
                    <span class="text-muted d-block">NIK / No. Identitas:</span>
                    <strong class="text-dark font-monospace">{{ $order->customer_nik }}</strong>
                </div>
                <div>
                    <span class="text-muted d-block">Metode Pembayaran:</span>
                    <span class="badge bg-light text-dark border text-uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                </div>
                <div>
                    <span class="text-muted d-block">Waktu Transaksi:</span>
                    <span>{{ $order->created_at->format('d/m/Y H:i:s') }}</span>
                </div>
                @if($order->paid_at)
                    <div>
                        <span class="text-muted d-block">Waktu Pembayaran Sukses:</span>
                        <span class="text-success fw-semibold">{{ $order->paid_at->format('d/m/Y H:i:s') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Status Management Card -->
        <div class="card card-admin p-4 mb-4">
            <h5 class="fw-bold text-dark mb-3">Ubah Status Pembayaran</h5>
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Pilih Status Baru</label>
                    <select name="payment_status" class="form-select">
                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid / Lunas (E-Ticket Aktif)</option>
                        <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid / Menunggu Pembayaran</option>
                        <option value="cancelled" {{ $order->payment_status === 'cancelled' ? 'selected' : '' }}>Cancelled / Dibatalkan</option>
                        <option value="expired" {{ $order->payment_status === 'expired' ? 'selected' : '' }}>Expired / Kadaluarsa</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-semibold">
                    <i class="bi bi-save me-1"></i> Update Status
                </button>
            </form>
        </div>

        <!-- Action Links -->
        <div class="d-flex flex-column gap-2">
            <a href="{{ route('booking.order', $order->order_code) }}" target="_blank" class="btn btn-outline-success">
                <i class="bi bi-box-arrow-up-right me-1"></i> Lihat E-Ticket Publik
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pesanan
            </a>
        </div>
    </div>
</div>
@endsection
