@extends('layouts.app')

@section('title', $concert->title . ' - TiketIdol.com')

@section('content')
<!-- Header Banner with Concert Backdrop -->
<div class="position-relative text-white py-5" style="background: linear-gradient(180deg, rgba(11, 19, 43, 0.9) 0%, rgba(15, 23, 42, 0.98) 100%), url('{{ $concert->banner_url ?? $concert->poster_url }}') center/cover no-repeat;">
    <div class="container py-2">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Konser</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $concert->artist_name }}</li>
            </ol>
        </nav>

        <div class="row align-items-center g-4">
            <div class="col-md-3 text-center text-md-start">
                <div class="position-relative d-inline-block rounded-4 overflow-hidden shadow-lg border border-secondary border-opacity-50">
                    <img src="{{ $concert->poster_url ?? 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=500&q=80' }}"
                         alt="{{ $concert->title }}"
                         class="img-fluid rounded-4"
                         style="max-height: 320px; object-fit: cover;">
                </div>
            </div>

            <div class="col-md-9">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <span class="badge bg-danger px-3 py-1 rounded-pill fw-bold">
                        <i class="bi bi-star-fill me-1"></i> {{ $concert->artist_name }}
                    </span>
                    @if($concert->fandom_name)
                        <span class="badge bg-purple px-3 py-1 rounded-pill fw-semibold" style="background-color: #8B5CF6;">
                            Fandom: {{ $concert->fandom_name }}
                        </span>
                    @endif
                    <span class="badge bg-success px-3 py-1 rounded-pill fw-semibold">
                        <i class="bi bi-shield-check me-1"></i> Tiket Resmi Terverifikasi
                    </span>
                </div>

                <h1 class="display-6 fw-bold text-white mb-3">{{ $concert->title }}</h1>

                <div class="row g-3 text-light opacity-90 small mb-3">
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-calendar3 text-warning fs-5"></i>
                            <div>
                                <div class="text-white-50">Tanggal Konser</div>
                                <div class="fw-bold">{{ $concert->formatted_date }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-clock-history text-info fs-5"></i>
                            <div>
                                <div class="text-white-50">Waktu Mulai</div>
                                <div class="fw-bold">{{ $concert->formatted_time }} (Gate {{ $concert->gate_open_time }})</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-geo-alt-fill text-danger fs-5"></i>
                            <div>
                                <div class="text-white-50">Lokasi / Venue</div>
                                <div class="fw-bold">{{ $concert->venue_name }}, {{ $concert->city }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-building-check text-success fs-5"></i>
                            <div>
                                <div class="text-white-50">Promotor Resmi</div>
                                <div class="fw-bold">{{ $concert->promoter_name }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert bg-white bg-opacity-10 border border-white border-opacity-20 text-white py-2 px-3 rounded-3 d-inline-flex align-items-center gap-2 small">
                    <i class="bi bi-info-circle-fill text-warning"></i>
                    <span>Ketentuan promotor: Maksimal pembelian 4 tiket per akun / NIK KTP.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Left Column: Description & Venue Layout -->
        <div class="col-lg-7">
            <!-- Deskripsi Konser -->
            <div class="card card-custom p-4 mb-4">
                <h4 class="fw-bold mb-3 d-flex align-items-center gap-2 text-dark">
                    <i class="bi bi-music-player-fill text-primary"></i> Tentang Konser & Lineup
                </h4>
                <div class="text-secondary leading-relaxed mb-4" style="white-space: pre-line;">
                    {{ $concert->description }}
                </div>

                <hr class="my-3">

                <h5 class="fw-bold mb-3 d-flex align-items-center gap-2 text-dark">
                    <i class="bi bi-card-checklist text-danger"></i> Syarat & Ketentuan Pemesanan
                </h5>
                <div class="bg-light p-3 rounded-3 text-secondary small" style="white-space: pre-line;">
                    {{ $concert->terms_conditions ?? "1. Maksimal pembelian 4 tiket per akun.\n2. Wajib menggunakan data diri KTP/Paspor yang sah.\n3. Tiket yang sudah dibeli tidak dapat ditukar atau dikembalikan." }}
                </div>
            </div>

            <!-- Denah Panggung Interaktif (Seating Plan) -->
            <div class="card card-custom p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-map-fill text-success"></i> Denah Panggung & Kategori (Seating Layout)
                    </h4>
                    <span class="badge bg-light text-secondary border">Interactive Map</span>
                </div>
                <p class="text-secondary small mb-3">
                    Arahkan kursor atau klik pada zona denah untuk melihat posisi kategori di arena:
                </p>

                <!-- SVG Interactive Stage Map -->
                <div class="bg-dark rounded-4 p-4 text-center position-relative overflow-hidden" style="background: #0F172A !important;">
                    <svg viewBox="0 0 600 420" class="w-100" style="max-height: 400px;" xmlns="http://www.w3.org/2000/svg">
                        <!-- Main Stage & Extended Thrust -->
                        <rect x="180" y="20" width="240" height="45" rx="6" fill="#1E293B" stroke="#64748B" stroke-width="2"/>
                        <text x="300" y="47" text-anchor="middle" fill="#FFFFFF" font-size="14" font-weight="bold">MAIN STAGE</text>
                        
                        <!-- Extended Runway Stage -->
                        <rect x="275" y="65" width="50" height="70" fill="#334155" stroke="#64748B" stroke-width="2"/>
                        <circle cx="300" cy="140" r="30" fill="#334155" stroke="#64748B" stroke-width="2"/>
                        <text x="300" y="145" text-anchor="middle" fill="#94A3B8" font-size="10" font-weight="bold">THRUST</text>

                        <!-- VIP Soundcheck (Surrounding stage) -->
                        <path d="M 120,70 L 265,70 L 265,180 L 120,180 Z" fill="#EC4899" fill-opacity="0.3" stroke="#EC4899" stroke-width="2.5" class="seat-zone" data-category="VIP"/>
                        <text x="192" y="130" text-anchor="middle" fill="#FFB4D6" font-size="12" font-weight="bold">VIP SOUNDCHECK (L)</text>

                        <path d="M 335,70 L 480,70 L 480,180 L 335,180 Z" fill="#EC4899" fill-opacity="0.3" stroke="#EC4899" stroke-width="2.5" class="seat-zone" data-category="VIP"/>
                        <text x="408" y="130" text-anchor="middle" fill="#FFB4D6" font-size="12" font-weight="bold">VIP SOUNDCHECK (R)</text>

                        <!-- CAT 1 Center Festival (Standing behind soundcheck) -->
                        <rect x="120" y="190" width="360" height="85" rx="8" fill="#8B5CF6" fill-opacity="0.35" stroke="#8B5CF6" stroke-width="2.5" class="seat-zone" data-category="CAT 1"/>
                        <text x="300" y="235" text-anchor="middle" fill="#DDD6FE" font-size="13" font-weight="bold">CAT 1 - FESTIVAL (STANDING)</text>

                        <!-- FOH Control -->
                        <rect x="260" y="280" width="80" height="25" rx="4" fill="#020617" stroke="#475569" stroke-width="1.5"/>
                        <text x="300" y="296" text-anchor="middle" fill="#94A3B8" font-size="10">FOH / SOUND</text>

                        <!-- CAT 2 Center Tribune (Numbered Seating) -->
                        <rect x="150" y="315" width="300" height="50" rx="8" fill="#3B82F6" fill-opacity="0.3" stroke="#3B82F6" stroke-width="2" class="seat-zone" data-category="CAT 2"/>
                        <text x="300" y="345" text-anchor="middle" fill="#BFDBFE" font-size="12" font-weight="bold">CAT 2 - CENTER TRIBUNE (SEATED)</text>

                        <!-- CAT 3 Tribune Wing Left & Right -->
                        <path d="M 40,110 L 105,110 L 105,330 L 40,330 Z" rx="6" fill="#10B981" fill-opacity="0.3" stroke="#10B981" stroke-width="2" class="seat-zone" data-category="CAT 3"/>
                        <text x="72" y="225" text-anchor="middle" fill="#A7F3D0" font-size="11" font-weight="bold" transform="rotate(-90 72 225)">CAT 3 WING (L)</text>

                        <path d="M 495,110 L 560,110 L 560,330 L 495,330 Z" rx="6" fill="#10B981" fill-opacity="0.3" stroke="#10B981" stroke-width="2" class="seat-zone" data-category="CAT 3"/>
                        <text x="528" y="225" text-anchor="middle" fill="#A7F3D0" font-size="11" font-weight="bold" transform="rotate(90 528 225)">CAT 3 WING (R)</text>

                        <!-- CAT 4 Upper Tribune -->
                        <rect x="100" y="375" width="400" height="35" rx="6" fill="#F59E0B" fill-opacity="0.3" stroke="#F59E0B" stroke-width="2" class="seat-zone" data-category="CAT 4"/>
                        <text x="300" y="397" text-anchor="middle" fill="#FDE68A" font-size="11" font-weight="bold">CAT 4 - UPPER TRIBUNE (SEATED)</text>
                    </svg>

                    <div class="d-flex flex-wrap justify-content-center gap-3 mt-3 pt-3 border-top border-secondary border-opacity-25 small text-white">
                        <span class="d-inline-flex align-items-center gap-1"><span class="badge rounded-circle p-1" style="background:#EC4899;">&nbsp;</span> VIP</span>
                        <span class="d-inline-flex align-items-center gap-1"><span class="badge rounded-circle p-1" style="background:#8B5CF6;">&nbsp;</span> CAT 1</span>
                        <span class="d-inline-flex align-items-center gap-1"><span class="badge rounded-circle p-1" style="background:#3B82F6;">&nbsp;</span> CAT 2</span>
                        <span class="d-inline-flex align-items-center gap-1"><span class="badge rounded-circle p-1" style="background:#10B981;">&nbsp;</span> CAT 3</span>
                        <span class="d-inline-flex align-items-center gap-1"><span class="badge rounded-circle p-1" style="background:#F59E0B;">&nbsp;</span> CAT 4</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Pilihan Kategori Tiket (Category Selection) -->
        <div class="col-lg-5">
            <div class="card card-custom p-4 position-sticky" style="top: 90px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0 text-dark">Pilihan Kategori Tiket</h4>
                    <span class="badge bg-primary-subtle text-primary fw-bold">{{ $concert->ticketCategories->count() }} Kategori</span>
                </div>
                <p class="text-secondary small mb-4">
                    Pilih salah satu kategori tiket di bawah ini untuk melanjutkan pemesanan:
                </p>

                <!-- Category Cards List -->
                <div class="d-flex flex-column gap-3 mb-4" id="categoryContainer">
                    @foreach($concert->ticketCategories as $index => $category)
                        <div class="card p-3 border rounded-3 category-card {{ $index === 0 ? 'border-primary shadow-sm bg-primary-subtle bg-opacity-10' : '' }}"
                             style="cursor: pointer; transition: all 0.2s ease;"
                             onclick="selectCategory({{ $category->id }}, '{{ addslashes($category->name) }}', {{ $category->price }}, {{ $category->available_quota }})"
                             id="cat-card-{{ $category->id }}">
                            
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="radio" name="selected_category" id="radio_{{ $category->id }}" value="{{ $category->id }}" {{ $index === 0 ? 'checked' : '' }} class="form-check-input mt-0">
                                        <span class="fw-bold text-dark fs-6">{{ $category->name }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <span class="badge" style="background-color: {{ $category->color_hex }}; color: #fff;">
                                            {{ strtoupper($category->type) }}
                                        </span>
                                        <span class="text-muted small">Pintu Masuk: {{ $category->entry_gate }}</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <h5 class="fw-bold text-primary mb-0">{{ $category->formatted_price }}</h5>
                                    <small class="text-muted">/ tiket</small>
                                </div>
                            </div>

                            <!-- Benefits List -->
                            @if(!empty($category->benefits_list))
                                <div class="bg-light p-2 rounded-2 mt-2">
                                    <ul class="list-unstyled mb-0 small text-secondary">
                                        @foreach($category->benefits_list as $benefit)
                                            <li class="d-flex align-items-center gap-1 mb-1">
                                                <i class="bi bi-check-circle-fill text-success" style="font-size: 0.75rem;"></i>
                                                <span>{{ $benefit }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Quota Indicator -->
                            <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center small">
                                <span class="text-secondary">
                                    <i class="bi bi-ticket me-1"></i> Sisa Kuota: 
                                    <strong class="{{ $category->available_quota < 50 ? 'text-danger' : 'text-dark' }}">
                                        {{ $category->available_quota }} tiket
                                    </strong>
                                </span>
                                @if($category->available_quota <= 0)
                                    <span class="badge bg-danger">HABIS</span>
                                @elseif($category->available_quota < 50)
                                    <span class="badge bg-warning text-dark"><i class="bi bi-fire me-1"></i> Cepat Habis</span>
                                @else
                                    <span class="badge bg-success-subtle text-success">Tersedia</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Ticket Quantity Selector -->
                <div class="p-3 bg-light rounded-3 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold text-dark">Jumlah Tiket</div>
                            <small class="text-muted">Maksimal 4 tiket per transaksi</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle" style="width: 32px; height: 32px;" onclick="changeQty(-1)">
                                <i class="bi bi-dash"></i>
                            </button>
                            <span class="fw-bold fs-5 px-2" id="ticketQtyText">1</span>
                            <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle" style="width: 32px; height: 32px;" onclick="changeQty(1)">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Live Subtotal Calculation -->
                <div class="d-flex justify-content-between align-items-center mb-3 pt-2 border-top">
                    <div>
                        <span class="text-secondary small d-block">Subtotal Harga Tiket</span>
                        <h4 class="fw-bold text-primary mb-0" id="subtotalDisplay">
                            {{ $concert->ticketCategories->first() ? $concert->ticketCategories->first()->formatted_price : 'Rp 0' }}
                        </h4>
                    </div>
                    <form action="" method="GET" id="bookingForm">
                        <button type="button" onclick="proceedToCheckout()" class="btn btn-tiket-accent px-4 py-3 fw-bold">
                            Pesan Tiket <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </form>
                </div>

                <div class="text-center text-muted small">
                    <i class="bi bi-shield-lock-fill text-success me-1"></i> Pembayaran aman & tiket terbit otomatis
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentCategoryId = {{ $concert->ticketCategories->first()->id ?? 0 }};
    let currentPrice = {{ $concert->ticketCategories->first()->price ?? 0 }};
    let currentMaxQuota = {{ $concert->ticketCategories->first()->available_quota ?? 0 }};
    let quantity = 1;

    function selectCategory(id, name, price, quota) {
        currentCategoryId = id;
        currentPrice = price;
        currentMaxQuota = quota;

        // Update radio check
        document.getElementById('radio_' + id).checked = true;

        // Reset styling for all cards
        document.querySelectorAll('.category-card').forEach(card => {
            card.classList.remove('border-primary', 'shadow-sm', 'bg-primary-subtle', 'bg-opacity-10');
            card.classList.add('border');
        });

        // Add active class to selected card
        const selectedCard = document.getElementById('cat-card-' + id);
        if (selectedCard) {
            selectedCard.classList.add('border-primary', 'shadow-sm', 'bg-primary-subtle', 'bg-opacity-10');
        }

        updateCalculations();
    }

    function changeQty(delta) {
        let newQty = quantity + delta;
        if (newQty >= 1 && newQty <= Math.min(4, currentMaxQuota)) {
            quantity = newQty;
            document.getElementById('ticketQtyText').innerText = quantity;
            updateCalculations();
        } else if (newQty > currentMaxQuota) {
            Swal.fire({
                icon: 'warning',
                title: 'Batas Kuota',
                text: 'Sisa kuota untuk kategori ini hanya ' + currentMaxQuota + ' tiket.',
                confirmButtonColor: '#0064D2'
            });
        }
    }

    function updateCalculations() {
        let subtotal = currentPrice * quantity;
        document.getElementById('subtotalDisplay').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
    }

    function proceedToCheckout() {
        if (!currentCategoryId) {
            Swal.fire('Peringatan', 'Silakan pilih kategori tiket terlebih dahulu.', 'warning');
            return;
        }

        if (currentMaxQuota <= 0) {
            Swal.fire('Maaf', 'Kategori tiket ini sudah habis terjual.', 'error');
            return;
        }

        const checkoutUrl = "{{ url('/checkout') }}/" + currentCategoryId + "?qty=" + quantity;
        window.location.href = checkoutUrl;
    }
</script>
@endpush
@endsection
