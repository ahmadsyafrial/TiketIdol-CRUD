@extends('layouts.app')

@section('title', 'Detail Pemesanan Tiket - ' . $concert->title)

@section('content')
<!-- Step Progress Bar (tiket.com style) -->
<div class="step-progress-wrapper shadow-sm">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center max-w-700 mx-auto">
            <div class="step-item completed">
                <span class="step-circle"><i class="bi bi-check"></i></span>
                <span>1. Pilih Tiket</span>
            </div>
            <div class="step-divider active"></div>
            <div class="step-item active">
                <span class="step-circle">2</span>
                <span>2. Detail Pemesan</span>
            </div>
            <div class="step-divider"></div>
            <div class="step-item">
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
    <!-- Countdown Timer Notice (tiket.com style) -->
    <div class="countdown-box mb-4">
        <i class="bi bi-hourglass-split fs-4 text-warning"></i>
        <div class="flex-grow-1">
            <span>Selesaikan pemesanan Anda dalam: </span>
            <strong class="text-danger fs-5 ms-1" id="timerCount">14:59</strong>
            <span class="text-muted small ms-2 d-none d-md-inline">Tiket Anda telah diamankan sementara.</span>
        </div>
    </div>

    <form action="{{ route('booking.process') }}" method="POST" id="checkoutForm">
        @csrf
        <input type="hidden" name="ticket_category_id" value="{{ $category->id }}">
        <input type="hidden" name="quantity" value="{{ $quantity }}">
        <input type="hidden" name="promo_code" id="appliedPromoCode" value="">

        <div class="row g-4">
            <!-- Left Column: Data Pemesan & Pengunjung -->
            <div class="col-lg-7">
                <!-- 1. Detail Pemesan (Contact Info) -->
                <div class="card card-custom p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-person-lines-fill text-primary"></i> Data Pemesan
                        </h4>
                        <span class="text-muted small">*Wajib diisi sesuai KTP/Paspor</span>
                    </div>
                    <p class="text-secondary small mb-3">
                        E-Ticket dan konfirmasi pemesanan resmi akan dikirimkan ke alamat email dan nomor WhatsApp pemesan.
                    </p>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold small">Nama Lengkap (Sesuai KTP / Paspor) <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control py-2" placeholder="Contoh: Ahmad Syafrial Pratama" value="{{ old('customer_name') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Email Penerima Tiket <span class="text-danger">*</span></label>
                            <input type="email" name="customer_email" id="customer_email" class="form-control py-2" placeholder="nama@email.com" value="{{ old('customer_email') }}" required>
                            <div class="form-text small">E-ticket ber-barcode akan dikirim ke email ini.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Nomor Handphone / WhatsApp <span class="text-danger">*</span></label>
                            <input type="tel" name="customer_phone" id="customer_phone" class="form-control py-2" placeholder="081234567890" value="{{ old('customer_phone') }}" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold small">Nomor Identitas (NIK KTP / Paspor) <span class="text-danger">*</span></label>
                            <input type="text" name="customer_nik" id="customer_nik" class="form-control py-2" placeholder="Contoh: 3276012345670001" value="{{ old('customer_nik') }}" required>
                            <div class="form-text small">Digunakan untuk verifikasi penukaran wristband di venue konser.</div>
                        </div>
                    </div>
                </div>

                <!-- 2. Data Pengunjung / Pemegang Tiket (Passenger/Attendee details like tiket.com) -->
                <div class="card card-custom p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-people-fill text-danger"></i> Data Pengunjung / Pemegang Tiket
                        </h4>
                        <span class="badge bg-secondary-subtle text-secondary">{{ $quantity }} Tiket</span>
                    </div>
                    <p class="text-secondary small mb-3">
                        Masukkan identitas untuk setiap pemegang tiket. Nama akan tercetak pada gelang konser resmi (Wristband).
                    </p>

                    @for($i = 0; $i < $quantity; $i++)
                        <div class="p-3 bg-light rounded-3 mb-3 border">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                    <span class="badge bg-primary rounded-circle" style="width: 22px; height: 22px; display:inline-flex; align-items:center; justify-content:center;">{{ $i + 1 }}</span>
                                    Tiket {{ $i + 1 }}: {{ $category->name }}
                                </h6>
                                @if($i === 0)
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" id="sameAsCustomer" checked onchange="toggleSameCustomer(this)">
                                        <label class="form-check-label small fw-semibold" for="sameAsCustomer">Sama dengan pemesan</label>
                                    </div>
                                @endif
                            </div>

                            <div class="row g-2 mt-1">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-secondary">Nama Lengkap Pengunjung <span class="text-danger">*</span></label>
                                    <input type="text" name="attendees[{{ $i }}][name]" id="attendee_name_{{ $i }}" class="form-control form-control-sm py-2" placeholder="Nama sesuai KTP" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-secondary">NIK KTP / No. Paspor <span class="text-danger">*</span></label>
                                    <input type="text" name="attendees[{{ $i }}][nik]" id="attendee_nik_{{ $i }}" class="form-control form-control-sm py-2" placeholder="Nomor KTP Pengunjung" required>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <!-- 3. Metode Pembayaran Pilihan -->
                <div class="card card-custom p-4">
                    <h4 class="fw-bold mb-3 text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-wallet2 text-success"></i> Pilih Metode Pembayaran
                    </h4>

                    <div class="d-flex flex-column gap-2">
                        <!-- QRIS -->
                        <label class="card p-3 border rounded-3 d-flex flex-row align-items-center justify-content-between cursor-pointer payment-option-card border-primary bg-primary-subtle bg-opacity-10" style="cursor: pointer;">
                            <div class="d-flex align-items-center gap-3">
                                <input type="radio" name="payment_method" value="qris" class="form-check-input mt-0" checked>
                                <div>
                                    <div class="fw-bold text-dark">QRIS (Instan Semua Bank & E-Wallet)</div>
                                    <small class="text-muted">BCA, Mandiri, BRI, BNI, GoPay, OVO, Dana, ShopeePay</small>
                                </div>
                            </div>
                            <span class="badge bg-danger rounded-pill px-3 py-1">Rekomendasi</span>
                        </label>

                        <!-- Virtual Account BCA -->
                        <label class="card p-3 border rounded-3 d-flex flex-row align-items-center justify-content-between cursor-pointer payment-option-card" style="cursor: pointer;">
                            <div class="d-flex align-items-center gap-3">
                                <input type="radio" name="payment_method" value="bca_va" class="form-check-input mt-0">
                                <div>
                                    <div class="fw-bold text-dark">BCA Virtual Account</div>
                                    <small class="text-muted">Verifikasi instan via myBCA, BCA Mobile, & ATM</small>
                                </div>
                            </div>
                            <span class="badge bg-light text-secondary border">VA Bank</span>
                        </label>

                        <!-- Virtual Account Mandiri -->
                        <label class="card p-3 border rounded-3 d-flex flex-row align-items-center justify-content-between cursor-pointer payment-option-card" style="cursor: pointer;">
                            <div class="d-flex align-items-center gap-3">
                                <input type="radio" name="payment_method" value="mandiri_va" class="form-check-input mt-0">
                                <div>
                                    <div class="fw-bold text-dark">Mandiri Virtual Account (Livin')</div>
                                    <small class="text-muted">Verifikasi instan via Livin' by Mandiri</small>
                                </div>
                            </div>
                            <span class="badge bg-light text-secondary border">VA Bank</span>
                        </label>

                        <!-- Virtual Account BRI -->
                        <label class="card p-3 border rounded-3 d-flex flex-row align-items-center justify-content-between cursor-pointer payment-option-card" style="cursor: pointer;">
                            <div class="d-flex align-items-center gap-3">
                                <input type="radio" name="payment_method" value="bri_va" class="form-check-input mt-0">
                                <div>
                                    <div class="fw-bold text-dark">BRI Virtual Account (BRIMO)</div>
                                    <small class="text-muted">Verifikasi instan via aplikasi BRImo</small>
                                </div>
                            </div>
                            <span class="badge bg-light text-secondary border">VA Bank</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Right Column: Rincian Pesanan (Order Breakdown Summary Sidebar) -->
            <div class="col-lg-5">
                <div class="card card-custom p-4 position-sticky" style="top: 90px;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="fw-bold mb-0 text-dark">Rincian Pesanan</h4>
                        <span class="badge bg-primary">{{ $concert->artist_name }}</span>
                    </div>

                    <!-- Concert Mini Card -->
                    <div class="d-flex gap-3 p-3 bg-light rounded-3 mb-3 border">
                        <img src="{{ $concert->poster_url }}" alt="{{ $concert->title }}" class="rounded-2 object-fit-cover" style="width: 65px; height: 85px;">
                        <div>
                            <h6 class="fw-bold text-dark mb-1 line-clamp-1">{{ $concert->title }}</h6>
                            <div class="small text-secondary mb-1">
                                <i class="bi bi-calendar3 me-1"></i> {{ $concert->formatted_date }}
                            </div>
                            <div class="small text-secondary mb-1">
                                <i class="bi bi-geo-alt me-1"></i> {{ $concert->venue_name }}
                            </div>
                            <span class="badge" style="background-color: {{ $category->color_hex }}; color: #fff;">
                                {{ $category->name }} ({{ $quantity }}x)
                            </span>
                        </div>
                    </div>

                    <!-- Voucher Promo Input -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-secondary">
                            <i class="bi bi-ticket-perforated text-warning me-1"></i> PUNYA KODE PROMO?
                        </label>
                        <div class="input-group">
                            <input type="text" id="promoInput" class="form-control text-uppercase" placeholder="Contoh: BABYMONSTERID">
                            <button type="button" class="btn btn-outline-primary fw-semibold px-3" onclick="applyPromo()">
                                Terapkan
                            </button>
                        </div>
                        <div id="promoMessage" class="small mt-1"></div>
                    </div>

                    <!-- Rincian Biaya (Price Breakdown Table) -->
                    <div class="border-top pt-3 mb-3">
                        <h6 class="fw-bold text-dark mb-3">Rincian Pembayaran</h6>

                        <div class="d-flex justify-content-between mb-2 small text-secondary">
                            <span>Harga Tiket ({{ $quantity }}x {{ $category->formatted_price }})</span>
                            <span class="fw-semibold text-dark">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2 small text-secondary">
                            <span>Pajak Hiburan & Pemerintah (10%)</span>
                            <span class="fw-semibold text-dark">Rp {{ number_format($taxFee, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2 small text-secondary">
                            <span>Biaya Layanan & Penerbitan Tiket</span>
                            <span class="fw-semibold text-dark">Rp {{ number_format($adminFee, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2 small text-success d-none" id="discountRow">
                            <span id="discountLabel">Diskon Kupon Promo</span>
                            <span class="fw-bold" id="discountValue">- Rp 0</span>
                        </div>

                        <hr class="my-3">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-secondary small d-block">Total Pembayaran</span>
                                <h3 class="fw-bold text-primary mb-0" id="totalDisplay">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </h3>
                            </div>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                All-in Nett
                            </span>
                        </div>
                    </div>

                    <!-- Term Agreement Checkbox -->
                    <div class="form-check mb-4 small">
                        <input class="form-check-input" type="checkbox" id="termsCheck" required checked>
                        <label class="form-check-label text-secondary" for="termsCheck">
                            Saya menyetujui <a href="#" class="text-primary text-decoration-none">Syarat & Ketentuan Konser</a> serta memastikan data pemesan dan pengunjung sudah sesuai dengan KTP/Paspor.
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-tiket-primary w-100 py-3 fw-bold fs-6 shadow">
                        <i class="bi bi-lock-fill me-1"></i> Lanjut ke Pembayaran
                    </button>

                    <div class="text-center mt-3 text-muted small">
                        <i class="bi bi-shield-check text-success me-1"></i> Data Anda dienkripsi secara aman dengan standar tiket.com
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const subtotal = {{ $subtotal }};
    const taxFee = {{ $taxFee }};
    const adminFee = {{ $adminFee }};
    let currentDiscount = 0;

    // Auto-fill Ticket 1 attendee from customer info
    function syncCustomerToAttendee() {
        const check = document.getElementById('sameAsCustomer');
        if (check && check.checked) {
            const custName = document.getElementById('customer_name').value;
            const custNik = document.getElementById('customer_nik').value;
            document.getElementById('attendee_name_0').value = custName;
            document.getElementById('attendee_nik_0').value = custNik;
        }
    }

    document.getElementById('customer_name').addEventListener('input', syncCustomerToAttendee);
    document.getElementById('customer_nik').addEventListener('input', syncCustomerToAttendee);

    function toggleSameCustomer(elem) {
        if (elem.checked) {
            syncCustomerToAttendee();
        } else {
            document.getElementById('attendee_name_0').value = '';
            document.getElementById('attendee_nik_0').value = '';
        }
    }

    // Apply Promo Code via AJAX
    function applyPromo() {
        const code = document.getElementById('promoInput').value.trim();
        const msgDiv = document.getElementById('promoMessage');

        if (!code) {
            msgDiv.innerHTML = '<span class="text-danger">Silakan ketik kode promo.</span>';
            return;
        }

        fetch("{{ route('booking.checkPromo') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                code: code,
                subtotal: subtotal
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                currentDiscount = data.discount;
                document.getElementById('appliedPromoCode').value = data.code;
                msgDiv.innerHTML = '<span class="text-success"><i class="bi bi-check-circle me-1"></i>' + data.message + '</span>';

                // Show discount row
                document.getElementById('discountRow').classList.remove('d-none');
                document.getElementById('discountLabel').innerText = 'Diskon ' + data.code;
                document.getElementById('discountValue').innerText = '- ' + data.formatted_discount;

                // Update total
                let newTotal = Math.max(0, (subtotal + taxFee + adminFee) - currentDiscount);
                document.getElementById('totalDisplay').innerText = 'Rp ' + newTotal.toLocaleString('id-ID');

                Swal.fire({
                    icon: 'success',
                    title: 'Kupon Berhasil Dipakai!',
                    text: 'Anda mendapatkan potongan ' + data.formatted_discount,
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                msgDiv.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle me-1"></i>' + data.message + '</span>';
            }
        })
        .catch(err => {
            msgDiv.innerHTML = '<span class="text-danger">Gagal memeriksa kode promo. Coba lagi.</span>';
        });
    }

    // Countdown Timer (15 minutes)
    let timeLeft = 15 * 60;
    const timerElem = document.getElementById('timerCount');
    const timerInterval = setInterval(function() {
        timeLeft--;
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            Swal.fire({
                icon: 'warning',
                title: 'Waktu Habis',
                text: 'Batas waktu pemesanan tiket Anda telah habis. Halaman akan dimuat ulang.',
                confirmButtonColor: '#0064D2'
            }).then(() => {
                window.location.reload();
            });
        }
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        timerElem.innerText = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
    }, 1000);
</script>
@endpush
@endsection
