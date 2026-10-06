@extends('layouts.app')

@section('title', 'Cek Pesanan & E-Ticket - TiketIdol.com')

@section('content')
<div class="py-5" style="background: linear-gradient(135deg, #0A1128 0%, #161F38 100%);">
    <div class="container text-center text-white">
        <span class="badge bg-primary px-3 py-1 rounded-pill mb-2 fw-semibold">LAYANAN MANDIRI</span>
        <h1 class="display-6 fw-bold mb-2">Cek Status Pesanan & E-Ticket</h1>
        <p class="text-light opacity-75 max-w-700 mx-auto small">
            Lacak status transaksi Anda, dapatkan kembali salinan E-Ticket, atau unduh bukti pemesanan konser idol resmi Anda kapan saja.
        </p>
    </div>
</div>

<div class="container" style="margin-top: -30px;">
    <!-- Search Box Card -->
    <div class="card card-custom p-4 shadow-lg border-0 mb-4 max-w-700 mx-auto">
        <form action="{{ route('booking.check') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-secondary">KODE PESANAN</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-upc-scan text-primary"></i></span>
                        <input type="text" name="order_code" class="form-control bg-light border-start-0 py-2" placeholder="Contoh: TK-BBM-2026-9824" value="{{ $orderCode }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold small text-secondary">EMAIL PEMESAN</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-primary"></i></span>
                        <input type="email" name="email" class="form-control bg-light border-start-0 py-2" placeholder="nama@email.com" value="{{ $email }}">
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-tiket-primary w-100 py-2 fw-bold">
                        <i class="bi bi-search me-1"></i> Cari E-Ticket Saya
                    </button>
                </div>
            </div>
        </form>

        <div class="text-center mt-3 text-muted small">
            <span>Contoh pencarian demo: Kode <strong>TK-BBM-2026-9824</strong> atau email <strong>ahmadsyafrial@gmail.com</strong></span>
        </div>
    </div>

    <!-- Search Results Section -->
    @if($searched)
        <div class="mb-5">
            <h4 class="fw-bold text-dark mb-3">Hasil Pencarian Pesanan ({{ $orders->count() }})</h4>

            @if($orders->isEmpty())
                <div class="card card-custom p-5 text-center border">
                    <i class="bi bi-ticket-detailed text-muted" style="font-size: 3.5rem;"></i>
                    <h5 class="fw-bold mt-3">Pesanan Tidak Ditemukan</h5>
                    <p class="text-secondary small">Pastikan Kode Pesanan atau Email yang Anda masukkan sudah benar.</p>
                </div>
            @else
                <div class="d-flex flex-column gap-3">
                    @foreach($orders as $ord)
                        <div class="card card-custom p-4 border card-hover">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-3">
                                    <div class="text-secondary small">Kode Booking</div>
                                    <h5 class="fw-bold text-primary font-monospace mb-1">{{ $ord->order_code }}</h5>
                                    <span class="text-muted small">{{ $ord->created_at->translatedFormat('d M Y, H:i') }}</span>
                                </div>

                                <div class="col-md-4">
                                    <h6 class="fw-bold text-dark mb-1">{{ $ord->concert->title }}</h6>
                                    <div class="small text-secondary mb-1">
                                        <i class="bi bi-geo-alt me-1"></i> {{ $ord->concert->venue_name }}
                                    </div>
                                    <span class="badge" style="background-color: {{ $ord->ticketCategory->color_hex }}; color: #fff;">
                                        {{ $ord->ticketCategory->name }} ({{ $ord->quantity }} Tiket)
                                    </span>
                                </div>

                                <div class="col-md-2 text-md-center">
                                    <div class="text-secondary small mb-1">Status</div>
                                    {!! $ord->status_badge !!}
                                </div>

                                <div class="col-md-3 text-md-end">
                                    <div class="fw-bold text-dark mb-2">{{ $ord->formatted_total }}</div>
                                    @if($ord->payment_status === 'paid')
                                        <a href="{{ route('booking.order', $ord->order_code) }}" class="btn btn-tiket-primary btn-sm px-3 py-2 fw-semibold">
                                            <i class="bi bi-ticket-perforated me-1"></i> Buka E-Ticket
                                        </a>
                                    @else
                                        <a href="{{ route('booking.payment', $ord->order_code) }}" class="btn btn-warning btn-sm px-3 py-2 fw-bold text-dark">
                                            <i class="bi bi-wallet2 me-1"></i> Lanjut Bayar
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
