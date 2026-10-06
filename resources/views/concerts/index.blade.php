@extends('layouts.app')

@section('title', 'TiketIdol.com - Pemesanan Tiket Konser Idol & K-Pop Resmi')

@section('content')
<!-- Hero Section with Featured Carousel -->
<section class="position-relative bg-dark text-white overflow-hidden py-5" style="background: linear-gradient(135deg, #0A1128 0%, #1C1938 50%, #0F172A 100%);">
    <div class="container py-3">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-danger bg-opacity-25 border border-danger border-opacity-50 text-danger fw-bold small mb-3">
                    <span class="spinner-grow spinner-grow-sm text-danger" role="status"></span>
                    WAR TIKET DIBUKA HARI INI
                </div>
                <h1 class="display-5 fw-extrabold text-white mb-3" style="letter-spacing: -0.5px;">
                    BABYMONSTER 1ST WORLD TOUR <br>
                    <span class="text-transparent bg-clip-text" style="background: linear-gradient(90deg, #FF2D78 0%, #FF8A00 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        &lt;HELLO MONSTERS&gt;
                    </span> IN JAKARTA
                </h1>
                <p class="lead text-light opacity-75 mb-4 fs-6">
                    Saksikan penampilan perdana Ruka, Pharita, Asa, Ahyeon, Rami, Rora, dan Chiquita di ICE BSD City! Nikmati soundcheck eksklusif, panggung spektakuler, dan euforia live bersama MONSTIEZ Indonesia.
                </p>

                <div class="d-flex flex-wrap gap-4 text-light mb-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-calendar2-event-fill text-warning fs-5"></i>
                        <div>
                            <div class="text-white-50 small">Tanggal Konser</div>
                            <div class="fw-bold">14 November 2026</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-geo-alt-fill text-danger fs-5"></i>
                        <div>
                            <div class="text-white-50 small">Venue</div>
                            <div class="fw-bold">ICE BSD City Hall 5-6</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-tag-fill text-info fs-5"></i>
                        <div>
                            <div class="text-white-50 small">Harga Mulai Dari</div>
                            <div class="fw-bold text-warning">Rp 1.100.000</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('concerts.show', 'babymonster-hello-monsters-jakarta-2026') }}" class="btn btn-tiket-accent btn-lg px-4 py-3 fw-bold">
                        <i class="bi bi-ticket-perforated me-2"></i> Pesan Tiket BABYMONSTER
                    </a>
                    <a href="#katalog-konser" class="btn btn-outline-light btn-lg px-4 py-3 fw-semibold">
                        Lihat Semua Konser <i class="bi bi-arrow-down-short ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="position-relative">
                    <div class="card border-0 rounded-4 overflow-hidden shadow-lg position-relative" style="background: #1E293B;">
                        <img src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=800&q=80" alt="BABYMONSTER Poster" class="img-fluid w-100 object-fit-cover" style="height: 380px;">
                        <div class="card-img-overlay d-flex flex-column justify-content-between p-4" style="background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(11, 19, 43, 0.95) 100%);">
                            <div class="d-flex justify-content-between">
                                <span class="badge bg-danger px-3 py-2 rounded-pill fw-bold">OFFICIAL YG CONCERT</span>
                                <span class="badge bg-dark bg-opacity-75 text-warning px-3 py-2 rounded-pill border border-warning border-opacity-50">
                                    <i class="bi bi-fire me-1"></i> Hot Selling
                                </span>
                            </div>
                            <div>
                                <span class="badge bg-primary px-3 py-1 mb-2">MONSTIEZ INDONESIA</span>
                                <h4 class="text-white fw-bold mb-1">ICE BSD City Hall 5-6</h4>
                                <p class="text-white-50 small mb-0">Tersedia Kategori VIP Soundcheck, CAT 1 Festival, CAT 2-4 Tribune</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Widget (tiket.com flight search inspired) -->
<div class="container" style="margin-top: -30px; position: relative; z-index: 20;">
    <div class="card card-custom p-4 shadow-lg border-0">
        <form action="{{ route('home') }}" method="GET">
            <div class="row g-3 align-items-center">
                <div class="col-lg-4 col-md-6">
                    <label class="form-label text-secondary small fw-bold mb-1">
                        <i class="bi bi-search text-primary me-1"></i> CARI KONSER / ARTIS IDOL
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-heart text-secondary"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-start-0 py-2" placeholder="Contoh: BABYMONSTER, aespa, Jakarta..." value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label text-secondary small fw-bold mb-1">
                        <i class="bi bi-star-fill text-warning me-1"></i> PILIH ARTIS IDOL
                    </label>
                    <select name="artist" class="form-select bg-light py-2">
                        <option value="">Semua Idol</option>
                        @foreach($artists as $art)
                            <option value="{{ $art }}" {{ request('artist') == $art ? 'selected' : '' }}>{{ $art }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label text-secondary small fw-bold mb-1">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> LOKASI / VENUE
                    </label>
                    <select name="city" class="form-select bg-light py-2">
                        <option value="">Semua Kota</option>
                        @foreach($cities as $ct)
                            <option value="{{ $ct }}" {{ request('city') == $ct ? 'selected' : '' }}>{{ $ct }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-tiket-primary w-100 py-2 mt-4">
                        <i class="bi bi-search me-1"></i> Cari Tiket
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Promo Banner Carousel -->
<div class="container mt-4">
    <div class="d-flex overflow-auto gap-3 pb-2" style="scrollbar-width: thin;">
        <div class="p-3 rounded-4 bg-primary text-white d-flex align-items-center justify-content-between flex-shrink-0 shadow-sm" style="width: 360px; background: linear-gradient(135deg, #0064D2 0%, #3B82F6 100%);">
            <div>
                <span class="badge bg-white text-primary fw-bold mb-1">KODE PROMO</span>
                <h5 class="fw-bold mb-0">BABYMONSTERID</h5>
                <small class="opacity-75">Diskon 10% s.d. Rp 250.000 untuk konser BABYMONSTER</small>
            </div>
            <i class="bi bi-gift-fill fs-1 opacity-50 ms-3"></i>
        </div>

        <div class="p-3 rounded-4 bg-purple text-white d-flex align-items-center justify-content-between flex-shrink-0 shadow-sm" style="width: 360px; background: linear-gradient(135deg, #8B5CF6 0%, #A855F7 100%);">
            <div>
                <span class="badge bg-white text-purple fw-bold mb-1">KODE PROMO</span>
                <h5 class="fw-bold mb-0">MONSTIEZVIP</h5>
                <small class="opacity-75">Potongan Rp 100.000 kategori VIP Soundcheck</small>
            </div>
            <i class="bi bi-stars fs-1 opacity-50 ms-3"></i>
        </div>

        <div class="p-3 rounded-4 text-white d-flex align-items-center justify-content-between flex-shrink-0 shadow-sm" style="width: 360px; background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
            <div>
                <span class="badge bg-white text-success fw-bold mb-1">SEMUA KONSER</span>
                <h5 class="fw-bold mb-0">TIKETIDOL50</h5>
                <small class="opacity-75">Diskon langsung Rp 50.000 tanpa batas kuota</small>
            </div>
            <i class="bi bi-lightning-charge-fill fs-1 opacity-50 ms-3"></i>
        </div>
    </div>
</div>

<!-- Main Concert Catalog Section -->
<section class="py-5" id="katalog-konser">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
            <div>
                <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-1 rounded-pill mb-2">LINEUP IDOL RESMI</span>
                <h2 class="fw-bold text-dark mb-0">Daftar Konser Idol Paling Dinanti</h2>
                <p class="text-secondary small mb-0">Pilih idol favoritmu, pilih kategori tiket terbaik, dan dapatkan E-Ticket resmi seketika.</p>
            </div>
            <div>
                @if(request('search') || request('artist') || request('city'))
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                        <i class="bi bi-x-circle me-1"></i> Reset Filter
                    </a>
                @endif
            </div>
        </div>

        @if($concerts->isEmpty())
            <div class="card card-custom p-5 text-center my-4">
                <i class="bi bi-ticket-detailed text-muted" style="font-size: 4rem;"></i>
                <h4 class="fw-bold mt-3">Konser Tidak Ditemukan</h4>
                <p class="text-secondary">Tidak ada konser idol yang cocok dengan filter pencarian Anda. Coba kata kunci lain atau reset filter.</p>
                <div class="mt-2">
                    <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4">Tampilkan Semua Konser</a>
                </div>
            </div>
        @else
            <div class="row g-4">
                @foreach($concerts as $concert)
                    <div class="col-lg-6">
                        <div class="card card-custom card-hover h-100 overflow-hidden border">
                            <div class="row g-0 h-100">
                                <div class="col-sm-5 position-relative">
                                    <img src="{{ $concert->poster_url ?? 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=600&q=80' }}"
                                         alt="{{ $concert->title }}"
                                         class="w-100 h-100 object-fit-cover"
                                         style="min-height: 240px; max-height: 320px;">
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-danger fw-bold rounded-pill px-3 py-1 shadow-sm">
                                            {{ $concert->artist_name }}
                                        </span>
                                    </div>
                                    @if($concert->fandom_name)
                                        <div class="position-absolute bottom-0 start-0 m-3">
                                            <span class="badge bg-dark bg-opacity-75 text-light fw-normal rounded-pill px-3 py-1">
                                                <i class="bi bi-heart-fill text-danger me-1"></i> {{ $concert->fandom_name }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-sm-7 d-flex flex-column justify-content-between p-4">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 small rounded">
                                                {{ $concert->promoter_name }}
                                            </span>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 small rounded">
                                                <i class="bi bi-shield-check me-1"></i> 100% Resmi
                                            </span>
                                        </div>

                                        <h5 class="card-title fw-bold text-dark mb-2 line-clamp-2">
                                            {{ $concert->title }}
                                        </h5>

                                        <div class="text-secondary small mb-3">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <i class="bi bi-calendar3 text-primary"></i>
                                                <span class="fw-semibold text-dark">{{ $concert->formatted_date }}</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <i class="bi bi-clock text-warning"></i>
                                                <span>Mulai {{ $concert->formatted_time }} (Gate {{ $concert->gate_open_time }})</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-geo-alt-fill text-danger"></i>
                                                <span>{{ $concert->venue_name }}, {{ $concert->city }}</span>
                                            </div>
                                        </div>

                                        <!-- Ticket Tiers Preview -->
                                        <div class="mb-3">
                                            <div class="text-muted small fw-semibold mb-1">Kategori Tiket:</div>
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($concert->ticketCategories->take(3) as $cat)
                                                    <span class="badge" style="background-color: {{ $cat->color_hex }}15; color: {{ $cat->color_hex }}; border: 1px solid {{ $cat->color_hex }}40; font-size: 0.72rem;">
                                                        {{ $cat->name }}
                                                    </span>
                                                @endforeach
                                                @if($concert->ticketCategories->count() > 3)
                                                    <span class="badge bg-light text-secondary border small">+{{ $concert->ticketCategories->count() - 3 }} lainnya</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="text-muted small d-block">Harga mulai dari</span>
                                            <h5 class="fw-bold text-primary mb-0">{{ $concert->formatted_lowest_price }}</h5>
                                        </div>
                                        <a href="{{ route('concerts.show', $concert->slug) }}" class="btn btn-tiket-primary px-3 py-2 fw-semibold">
                                            Pilih Tiket <i class="bi bi-arrow-right-short ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Why Choose Us / tiket.com Experience -->
<section class="py-5 bg-white border-top border-bottom" id="panduan">
    <div class="container">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-1 rounded-pill mb-2">PENGALAMAN TIKET.COM</span>
            <h2 class="fw-bold">Kenapa Beli Tiket Idol di TiketIdol.com?</h2>
            <p class="text-secondary">Dirancang untuk memudahkan fans setia K-Pop dan idol mendapatkan tiket dengan transparan, anti bot, dan instan.</p>
        </div>

        <div class="row g-4 text-center">
            <div class="col-md-3">
                <div class="p-4 rounded-4 bg-light h-100">
                    <div class="d-inline-flex p-3 rounded-circle bg-primary bg-opacity-10 text-primary mb-3">
                        <i class="bi bi-patch-check-fill fs-2"></i>
                    </div>
                    <h5 class="fw-bold">100% Tiket Resmi</h5>
                    <p class="text-secondary small mb-0">Tiket berpartner langsung dengan promotor resmi (YG, SM, ADOR, Live Nation). Bebas calo dan dijamin valid di gerbang masuk.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-4 rounded-4 bg-light h-100">
                    <div class="d-inline-flex p-3 rounded-circle bg-danger bg-opacity-10 text-danger mb-3">
                        <i class="bi bi-qr-code-scan fs-2"></i>
                    </div>
                    <h5 class="fw-bold">E-Ticket Instan & Barcode</h5>
                    <p class="text-secondary small mb-0">Langsung dapatkan E-Ticket resmi ber-barcode dan Nomor Antrean / Kursi otomatis setelah pembayaran berhasil.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-4 rounded-4 bg-light h-100">
                    <div class="d-inline-flex p-3 rounded-circle bg-success bg-opacity-10 text-success mb-3">
                        <i class="bi bi-credit-card-2-front-fill fs-2"></i>
                    </div>
                    <h5 class="fw-bold">Pembayaran Lengkap</h5>
                    <p class="text-secondary small mb-0">Bayar mudah via QRIS (semua e-wallet & mobile banking), Virtual Account BCA, Mandiri, BRI, BNI dengan verifikasi instan.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-4 rounded-4 bg-light h-100">
                    <div class="d-inline-flex p-3 rounded-circle bg-warning bg-opacity-10 text-warning mb-3">
                        <i class="bi bi-ticket-perforated-fill fs-2"></i>
                    </div>
                    <h5 class="fw-bold">Cek Pesanan Kapan Saja</h5>
                    <p class="text-secondary small mb-0">Cukup masukkan Kode Pesanan atau Email untuk melihat kembali atau mencetak tiket Anda sewaktu-waktu.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
