@extends('layouts.app')

@section('title', 'E-Ticket Konser Resmi - ' . $order->order_code)

@section('content')
<!-- Step Progress Bar -->
<div class="step-progress-wrapper shadow-sm btn-print-hide">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center max-w-700 mx-auto">
            <div class="step-item completed">
                <span class="step-circle"><i class="bi bi-check"></i></span>
                <span>1. Pilih Tiket</span>
            </div>
            <div class="step-divider active"></div>
            <div class="step-item completed">
                <span class="step-circle"><i class="bi bi-check"></i></span>
                <span>2. Detail Pemesan</span>
            </div>
            <div class="step-divider active"></div>
            <div class="step-item completed">
                <span class="step-circle"><i class="bi bi-check"></i></span>
                <span>3. Pembayaran</span>
            </div>
            <div class="step-divider active"></div>
            <div class="step-item active">
                <span class="step-circle"><i class="bi bi-check-all fs-5"></i></span>
                <span>4. E-Ticket Terbit</span>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <!-- Success Alert Header -->
    <div class="card card-custom p-4 mb-4 border-success bg-success-subtle bg-opacity-10 text-center btn-print-hide">
        <div class="d-inline-flex p-3 rounded-circle bg-success text-white mx-auto mb-3 shadow-sm">
            <i class="bi bi-check-lg fs-1"></i>
        </div>
        <h2 class="fw-bold text-dark mb-1">Pemesanan & Pembayaran Berhasil!</h2>
        <p class="text-secondary small mb-3">
            E-Ticket resmi konser Anda telah diterbitkan dan aktif. Simpan atau cetak tiket di bawah ini untuk penukaran wristband.
        </p>

        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <button onclick="window.print()" class="btn btn-dark px-4 py-2 rounded-pill fw-semibold shadow-sm">
                <i class="bi bi-printer-fill me-1"></i> Cetak / Simpan E-Ticket (PDF)
            </button>
            <a href="{{ route('home') }}" class="btn btn-outline-primary px-4 py-2 rounded-pill fw-semibold">
                <i class="bi bi-house-door-fill me-1"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <!-- Order Metadata Summary Card -->
    <div class="card card-custom p-4 mb-4 border">
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <div class="text-secondary small">Kode Booking / Pesanan:</div>
                <div class="fs-5 fw-bold text-primary font-monospace">{{ $order->order_code }}</div>
            </div>
            <div class="col-md-3">
                <div class="text-secondary small">Status Pembayaran:</div>
                <div>{!! $order->status_badge !!}</div>
            </div>
            <div class="col-md-3">
                <div class="text-secondary small">Waktu Transaksi:</div>
                <div class="fw-semibold text-dark">{{ $order->created_at->translatedFormat('d M Y, H:i') }} WIB</div>
            </div>
            <div class="col-md-3">
                <div class="text-secondary small">Total Pembayaran:</div>
                <div class="fs-5 fw-bold text-dark">{{ $order->formatted_total }}</div>
            </div>
        </div>
    </div>

    <!-- E-TICKET CARDS LIST (Concert Pass Style) -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-ticket-perforated-fill text-primary"></i> E-Ticket Resmi Konser ({{ $order->attendees->count() }} Tiket)
            </h4>
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill">
                Wajib Membawa KTP Asli
            </span>
        </div>

        <div class="row g-4">
            @foreach($order->attendees as $attIndex => $att)
                <div class="col-lg-6">
                    <div class="ticket-wrapper p-0 border shadow-sm">
                        <!-- Perforated Notches -->
                        <div class="ticket-notch-left"></div>
                        <div class="ticket-notch-right"></div>

                        <!-- Ticket Header (Holographic / Gradient) -->
                        <div class="p-3 text-white d-flex justify-content-between align-items-center"
                             style="background: linear-gradient(135deg, {{ $order->ticketCategory->color_hex }} 0%, #0B132B 100%);">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-stars fs-5"></i>
                                <div>
                                    <div class="fw-bold small line-clamp-1">{{ $order->concert->title }}</div>
                                    <div class="small opacity-75">{{ $order->concert->artist_name }} Official Concert</div>
                                </div>
                            </div>
                            <span class="badge bg-white text-dark fw-bold px-2 py-1">
                                #{{ $attIndex + 1 }}
                            </span>
                        </div>

                        <!-- Ticket Body -->
                        <div class="p-4 bg-white">
                            <div class="row g-3">
                                <div class="col-7">
                                    <div class="mb-2">
                                        <div class="text-secondary small" style="font-size: 0.75rem;">NAMA PENGUNJUNG</div>
                                        <div class="fw-bold text-dark fs-6">{{ $att->attendee_name }}</div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="text-secondary small" style="font-size: 0.75rem;">NIK / NO. IDENTITAS</div>
                                        <div class="fw-semibold text-secondary small font-monospace">{{ $att->attendee_nik }}</div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="text-secondary small" style="font-size: 0.75rem;">KATEGORI & PINTU MASUK</div>
                                        <span class="badge" style="background-color: {{ $order->ticketCategory->color_hex }}; color: #fff;">
                                            {{ $order->ticketCategory->name }}
                                        </span>
                                        <div class="small text-muted mt-1">{{ $order->ticketCategory->entry_gate }}</div>
                                    </div>
                                    <div>
                                        <div class="text-secondary small" style="font-size: 0.75rem;">VENUE & WAKTU</div>
                                        <div class="small fw-semibold text-dark">{{ $order->concert->venue_name }}</div>
                                        <div class="small text-muted">{{ $order->concert->formatted_date }} (Gate: {{ $order->concert->gate_open_time }})</div>
                                    </div>
                                </div>

                                <div class="col-5 text-center d-flex flex-column justify-content-between border-start ps-3">
                                    <div>
                                        <div class="text-secondary small mb-1" style="font-size: 0.75rem;">
                                            {{ $order->ticketCategory->type === 'standing' ? 'NOMOR ANTREAN (QN)' : 'NOMOR KURSI' }}
                                        </div>
                                        <div class="badge bg-dark fs-6 font-monospace py-2 px-3 text-warning">
                                            {{ $att->seat_or_queue_number }}
                                        </div>
                                    </div>

                                    <!-- QR Code Simulation -->
                                    <div class="my-2">
                                        <svg width="100" height="100" viewBox="0 0 100 100" class="mx-auto" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="100" height="100" fill="#fff"/>
                                            <rect x="10" y="10" width="26" height="26" fill="#000"/>
                                            <rect x="15" y="15" width="16" height="16" fill="#fff"/>
                                            <rect x="19" y="19" width="8" height="8" fill="#000"/>

                                            <rect x="64" y="10" width="26" height="26" fill="#000"/>
                                            <rect x="69" y="15" width="16" height="16" fill="#fff"/>
                                            <rect x="73" y="19" width="8" height="8" fill="#000"/>

                                            <rect x="10" y="64" width="26" height="26" fill="#000"/>
                                            <rect x="15" y="69" width="16" height="16" fill="#fff"/>
                                            <rect x="19" y="73" width="8" height="8" fill="#000"/>

                                            <rect x="42" y="15" width="10" height="10" fill="#000"/>
                                            <rect x="42" y="35" width="16" height="10" fill="#000"/>
                                            <rect x="64" y="45" width="12" height="12" fill="#000"/>
                                            <rect x="42" y="64" width="10" height="26" fill="#000"/>
                                            <rect x="60" y="64" width="30" height="10" fill="#000"/>
                                            <rect x="70" y="80" width="20" height="10" fill="#000"/>
                                        </svg>
                                    </div>

                                    <div>
                                        <div class="small font-monospace text-muted" style="font-size: 0.7rem;">{{ $att->ticket_number }}</div>
                                        <span class="badge bg-success-subtle text-success small" style="font-size: 0.65rem;">VALID & ACTIVE</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ticket Footer -->
                        <div class="px-4 py-2 bg-light border-top d-flex justify-content-between align-items-center small text-muted">
                            <span><i class="bi bi-shield-check text-success me-1"></i> Official Promotor Pass</span>
                            <span class="font-monospace">BC: {{ $att->barcode_code }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Price Breakdown & Customer Details Table -->
    <div class="card card-custom p-4 border">
        <h5 class="fw-bold text-dark mb-3">Rincian Pembayaran Resmi</h5>
        <div class="table-responsive">
            <table class="table table-borderless small mb-0">
                <tbody>
                    <tr>
                        <td class="text-secondary" style="width: 50%;">Kategori Tiket:</td>
                        <td class="fw-semibold text-dark">{{ $order->ticketCategory->name }} ({{ $order->quantity }} tiket)</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Subtotal Harga Tiket:</td>
                        <td class="fw-semibold text-dark">{{ $order->formatted_subtotal }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Pajak Hiburan & Pemerintah (10%):</td>
                        <td class="fw-semibold text-dark">{{ $order->formatted_tax }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary">Biaya Layanan Platform:</td>
                        <td class="fw-semibold text-dark">{{ $order->formatted_admin_fee }}</td>
                    </tr>
                    @if($order->discount_amount > 0)
                        <tr class="text-success">
                            <td>Potongan Promo ({{ $order->promo_code }}):</td>
                            <td class="fw-bold">- {{ $order->formatted_discount }}</td>
                        </tr>
                    @endif
                    <tr class="border-top">
                        <td class="fw-bold text-dark fs-6">Total Pembayaran Akhir:</td>
                        <td class="fw-extrabold text-primary fs-5">{{ $order->formatted_total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
