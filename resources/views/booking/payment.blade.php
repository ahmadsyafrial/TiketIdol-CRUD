@extends('layouts.app')

@section('title', 'Pembayaran Tiket - ' . $order->order_code)

@section('content')
<!-- Step Progress Bar -->
<div class="step-progress-wrapper shadow-sm">
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
            <div class="step-item active">
                <span class="step-circle">3</span>
                <span>3. Pembayaran</span>
            </div>
            <div class="step-divider"></div>
            <div class="step-item">
                <span class="step-circle">4</span>
                <span>4. E-Ticket</span>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Payment Header Card -->
            <div class="card card-custom p-4 mb-4 border text-center">
                <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-2 rounded-pill mx-auto mb-2 fw-bold">
                    <i class="bi bi-clock-history me-1"></i> Menunggu Pembayaran
                </span>
                <h3 class="fw-bold text-dark mb-1">Selesaikan Pembayaran Anda</h3>
                <p class="text-secondary small mb-3">
                    Kode Pesanan: <strong class="text-dark">{{ $order->order_code }}</strong> &bull; Batas waktu: <span class="text-danger fw-bold" id="payCountdown">29:59</span>
                </p>

                <div class="p-3 bg-light rounded-4 d-inline-block mx-auto border px-5">
                    <div class="text-secondary small">Total yang harus dibayar:</div>
                    <h2 class="display-6 fw-extrabold text-primary mb-0">
                        {{ $order->formatted_total }}
                    </h2>
                </div>
            </div>

            <!-- Payment Method Details -->
            <div class="card card-custom p-4 mb-4 border">
                @if($order->payment_method === 'qris')
                    <div class="text-center">
                        <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                            <span class="badge bg-danger px-3 py-2 fs-6 fw-bold">QRIS</span>
                            <span class="text-muted">Standar Pembayaran Nasional</span>
                        </div>
                        <p class="text-secondary small">
                            Buka aplikasi BCA Mobile, Livin', BRImo, GoPay, OVO, Dana, atau ShopeePay Anda, lalu scan kode QR di bawah ini:
                        </p>

                        <!-- High Quality Dynamic SVG QR Code Simulation -->
                        <div class="p-4 bg-white rounded-4 border d-inline-block shadow-sm my-2">
                            <svg width="220" height="220" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                <!-- Background -->
                                <rect width="200" height="200" fill="#ffffff"/>
                                <!-- Top-Left Finder -->
                                <rect x="20" y="20" width="50" height="50" fill="#000000" rx="4"/>
                                <rect x="30" y="30" width="30" height="30" fill="#ffffff" rx="2"/>
                                <rect x="38" y="38" width="14" height="14" fill="#000000" rx="1"/>
                                <!-- Top-Right Finder -->
                                <rect x="130" y="20" width="50" height="50" fill="#000000" rx="4"/>
                                <rect x="140" y="30" width="30" height="30" fill="#ffffff" rx="2"/>
                                <rect x="148" y="38" width="14" height="14" fill="#000000" rx="1"/>
                                <!-- Bottom-Left Finder -->
                                <rect x="20" y="130" width="50" height="50" fill="#000000" rx="4"/>
                                <rect x="30" y="140" width="30" height="30" fill="#ffffff" rx="2"/>
                                <rect x="38" y="148" width="14" height="14" fill="#000000" rx="1"/>
                                <!-- Decorative Data Matrix Pixels -->
                                <rect x="80" y="25" width="10" height="10" fill="#000"/>
                                <rect x="100" y="25" width="10" height="10" fill="#000"/>
                                <rect x="80" y="45" width="20" height="10" fill="#000"/>
                                <rect x="105" y="45" width="10" height="20" fill="#000"/>
                                <rect x="80" y="80" width="40" height="40" fill="#FF2D78" rx="4"/>
                                <circle cx="100" cy="100" r="12" fill="#ffffff"/>
                                <text x="100" y="104" font-size="11" font-weight="bold" fill="#FF2D78" text-anchor="middle">TIKET</text>
                                <rect x="25" y="85" width="15" height="10" fill="#000"/>
                                <rect x="50" y="85" width="10" height="20" fill="#000"/>
                                <rect x="30" y="105" width="30" height="10" fill="#000"/>
                                <rect x="140" y="85" width="20" height="10" fill="#000"/>
                                <rect x="130" y="105" width="15" height="15" fill="#000"/>
                                <rect x="155" y="105" width="25" height="10" fill="#000"/>
                                <rect x="80" y="135" width="15" height="15" fill="#000"/>
                                <rect x="105" y="145" width="20" height="10" fill="#000"/>
                                <rect x="85" y="165" width="30" height="15" fill="#000"/>
                                <rect x="135" y="135" width="10" height="25" fill="#000"/>
                                <rect x="155" y="145" width="20" height="20" fill="#000"/>
                                <rect x="140" y="170" width="15" height="10" fill="#000"/>
                            </svg>
                        </div>

                        <div class="mt-2 text-center">
                            <span class="badge bg-light text-secondary border px-3 py-1">NMID: ID102026849201948</span>
                        </div>
                    </div>
                @else
                    <!-- Virtual Account UI -->
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Nomor Virtual Account</h5>
                            <span class="badge bg-primary px-3 py-2 text-uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                        </div>

                        <div class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center mb-3 border">
                            <span class="fs-4 fw-extrabold text-dark font-monospace" id="vaNumber">88019{{ rand(1000000000, 9999999999) }}</span>
                            <button type="button" class="btn btn-outline-primary btn-sm px-3 py-1 fw-bold" onclick="copyVA()">
                                <i class="bi bi-clipboard me-1"></i> Salin
                            </button>
                        </div>
                        <div class="small text-muted">
                            Atas Nama: <strong>TiketIdol / {{ $order->customer_name }}</strong>
                        </div>
                    </div>
                @endif

                <hr class="my-4">

                <!-- Order Summary Breakdown -->
                <div class="bg-light p-3 rounded-3 mb-4">
                    <h6 class="fw-bold text-dark mb-2">Ringkasan Pembelian:</h6>
                    <div class="small text-secondary mb-1">
                        Konser: <strong>{{ $order->concert->title }}</strong>
                    </div>
                    <div class="small text-secondary mb-1">
                        Kategori Tiket: <strong>{{ $order->ticketCategory->name }} ({{ $order->quantity }} Tiket)</strong>
                    </div>
                    <div class="small text-secondary">
                        Nama Pemesan: <strong>{{ $order->customer_name }} ({{ $order->customer_email }})</strong>
                    </div>
                </div>

                <!-- Simulation Action Button -->
                <form action="{{ route('booking.confirmPayment', $order->order_code) }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_method" value="{{ $order->payment_method }}">
                    <button type="submit" class="btn btn-tiket-accent w-100 py-3 fw-bold fs-5 shadow">
                        <i class="bi bi-check2-circle me-1"></i> Simulasikan Bayar Sekarang (Berhasil)
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('home') }}" class="text-secondary small text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda (Bayar Nanti)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyVA() {
        const va = document.getElementById('vaNumber').innerText;
        navigator.clipboard.writeText(va).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Tersalin!',
                text: 'Nomor Virtual Account telah disalin ke clipboard.',
                timer: 1500,
                showConfirmButton: false
            });
        });
    }

    // Payment countdown 30 mins
    let timeLeft = 30 * 60;
    const timerElem = document.getElementById('payCountdown');
    setInterval(function() {
        timeLeft--;
        if (timeLeft >= 0) {
            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;
            timerElem.innerText = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
        }
    }, 1000);
</script>
@endpush
@endsection
