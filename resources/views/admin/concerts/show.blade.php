@extends('layouts.admin')

@section('title', $concert->title . ' - Kelola Konser & Kategori')
@section('page-title', 'Detail & Kategori Tiket Konser')

@section('content')
<div class="row g-4 mb-4">
    <!-- Concert Overview Card -->
    <div class="col-lg-4">
        <div class="card card-admin p-4 h-100">
            <div class="text-center mb-3">
                <img src="{{ $concert->poster_url ?? 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=400&q=80' }}"
                     alt="{{ $concert->title }}"
                     class="rounded-4 object-fit-cover shadow-sm w-100 mb-3"
                     style="max-height: 280px;">
                <span class="badge bg-danger fs-6 px-3 py-1 rounded-pill mb-2">{{ $concert->artist_name }}</span>
                <h5 class="fw-bold text-dark mb-1">{{ $concert->title }}</h5>
                <div class="text-muted small">Fandom: {{ $concert->fandom_name ?? '-' }}</div>
            </div>

            <hr class="my-3">

            <div class="small text-secondary d-flex flex-column gap-2 mb-4">
                <div><i class="bi bi-geo-alt-fill text-danger me-2"></i> <strong>Venue:</strong> {{ $concert->venue_name }}, {{ $concert->city }}</div>
                <div><i class="bi bi-calendar3 text-primary me-2"></i> <strong>Waktu:</strong> {{ $concert->formatted_date }} ({{ $concert->formatted_time }})</div>
                <div><i class="bi bi-door-open text-warning me-2"></i> <strong>Gate Open:</strong> {{ $concert->gate_open_time }}</div>
                <div><i class="bi bi-building text-success me-2"></i> <strong>Promotor:</strong> {{ $concert->promoter_name }}</div>
                <div><i class="bi bi-tag text-info me-2"></i> <strong>Status:</strong> <span class="badge bg-primary">{{ ucfirst($concert->status) }}</span></div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.concerts.edit', $concert->id) }}" class="btn btn-outline-secondary w-50">
                    <i class="bi bi-pencil me-1"></i> Edit
                </a>
                <a href="{{ route('concerts.show', $concert->slug) }}" target="_blank" class="btn btn-outline-primary w-50">
                    <i class="bi bi-box-arrow-up-right me-1"></i> Publik
                </a>
            </div>
        </div>
    </div>

    <!-- Ticket Categories Management (CRUD Tiers) -->
    <div class="col-lg-8">
        <div class="card card-admin p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold text-dark mb-1">Daftar Kategori Tiket (Tiers)</h5>
                    <div class="text-muted small">Kelola harga, kuota tiket, dan benefit setiap kategori.</div>
                </div>
                <button type="button" class="btn btn-primary btn-sm px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalAddCategory">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                </button>
            </div>

            <!-- Categories Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small">
                        <tr>
                            <th>Kategori & Tipe</th>
                            <th>Harga</th>
                            <th>Sisa / Kuota</th>
                            <th>Pintu & Sektor</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($concert->ticketCategories as $cat)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge rounded-circle p-2" style="background-color: {{ $cat->color_hex }};">&nbsp;</span>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $cat->name }}</div>
                                            <span class="badge bg-secondary-subtle text-secondary small text-uppercase">{{ $cat->type }}</span>
                                            @if($cat->code)
                                                <span class="badge bg-light text-muted border small">{{ $cat->code }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">{{ $cat->formatted_price }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $cat->available_quota }} / {{ $cat->quota }}</div>
                                    <div class="progress mt-1" style="height: 6px; width: 100px;">
                                        @php
                                            $percent = $cat->quota > 0 ? ($cat->available_quota / $cat->quota) * 100 : 0;
                                        @endphp
                                        <div class="progress-bar {{ $percent < 25 ? 'bg-danger' : 'bg-success' }}" style="width: {{ $percent }}%;"></div>
                                    </div>
                                </td>
                                <td class="small text-muted">
                                    <div>{{ $cat->entry_gate }}</div>
                                    <div>{{ $cat->seat_section ?? '-' }}</div>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <button type="button" class="btn btn-outline-secondary btn-sm px-2"
                                                onclick="openEditCategoryModal({{ json_encode($cat) }})" title="Edit Kategori">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori tiket {{ $cat->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2" title="Hapus Kategori">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    Belum ada kategori tiket untuk konser ini. Klik tombol "Tambah Kategori" di atas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Orders for this Concert -->
        <div class="card card-admin p-4">
            <h5 class="fw-bold text-dark mb-3">Riwayat Pesanan Konser Ini ({{ $concert->orders->count() }})</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Order</th>
                            <th>Pemesan</th>
                            <th>Kategori & Qty</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($concert->orders->take(5) as $order)
                            <tr>
                                <td class="fw-bold font-monospace text-primary">{{ $order->order_code }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $order->customer_name }}</div>
                                    <div class="text-muted small">{{ $order->customer_email }}</div>
                                </td>
                                <td>
                                    <span>{{ $order->ticketCategory->name ?? '-' }}</span>
                                    <span class="badge bg-light text-dark border">{{ $order->quantity }}x</span>
                                </td>
                                <td class="fw-bold">{{ $order->formatted_total }}</td>
                                <td>{!! $order->status_badge !!}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm px-2">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-3 text-muted">Belum ada pesanan untuk konser ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Category -->
<div class="modal fade" id="modalAddCategory" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.categories.store', $concert->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Kategori Tiket Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: VIP SOUNDCHECK PACKAGE" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Kode Singkat</label>
                            <input type="text" name="code" class="form-control" placeholder="Contoh: VIP-SND">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Tipe Kategori <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="standing">Standing (Festival)</option>
                                <option value="seated">Seated (Kursi Bernomor)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Warna Label / Denah</label>
                            <input type="color" name="color_hex" class="form-control form-control-color w-100" value="#EC4899">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" placeholder="3500000" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Total Kuota Tiket <span class="text-danger">*</span></label>
                            <input type="number" name="quota" class="form-control" placeholder="200" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Pintu Masuk (Gate) <span class="text-danger">*</span></label>
                            <input type="text" name="entry_gate" class="form-control" placeholder="Contoh: Gate VIP East" value="Gate 1" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Sektor / Zona Kursi</label>
                            <input type="text" name="seat_section" class="form-control" placeholder="Contoh: Zone A Front Stage">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Benefit / Fasilitas Kategori (1 baris per benefit)</label>
                            <textarea name="benefits" rows="3" class="form-control" placeholder="Soundcheck pass&#10;Lanyard PVC Pass&#10;Queue Number otomatis"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-semibold">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Category -->
<div class="modal fade" id="modalEditCategory" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="POST" id="formEditCategory">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Kategori Tiket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_cat_name" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Kode Singkat</label>
                            <input type="text" name="code" id="edit_cat_code" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Tipe Kategori <span class="text-danger">*</span></label>
                            <select name="type" id="edit_cat_type" class="form-select" required>
                                <option value="standing">Standing (Festival)</option>
                                <option value="seated">Seated (Kursi Bernomor)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Warna Label</label>
                            <input type="color" name="color_hex" id="edit_cat_color" class="form-control form-control-color w-100">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="price" id="edit_cat_price" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Total Kuota <span class="text-danger">*</span></label>
                            <input type="number" name="quota" id="edit_cat_quota" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Sisa Kuota Tersedia <span class="text-danger">*</span></label>
                            <input type="number" name="available_quota" id="edit_cat_available" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Pintu Masuk (Gate) <span class="text-danger">*</span></label>
                            <input type="text" name="entry_gate" id="edit_cat_gate" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Sektor / Zona</label>
                            <input type="text" name="seat_section" id="edit_cat_section" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Benefit / Fasilitas</label>
                            <textarea name="benefits" id="edit_cat_benefits" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-semibold">Perbarui Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openEditCategoryModal(cat) {
        document.getElementById('formEditCategory').action = "{{ url('admin/categories') }}/" + cat.id;
        document.getElementById('edit_cat_name').value = cat.name;
        document.getElementById('edit_cat_code').value = cat.code || '';
        document.getElementById('edit_cat_type').value = cat.type;
        document.getElementById('edit_cat_color').value = cat.color_hex;
        document.getElementById('edit_cat_price').value = cat.price;
        document.getElementById('edit_cat_quota').value = cat.quota;
        document.getElementById('edit_cat_available').value = cat.available_quota;
        document.getElementById('edit_cat_gate').value = cat.entry_gate;
        document.getElementById('edit_cat_section').value = cat.seat_section || '';
        document.getElementById('edit_cat_benefits').value = cat.benefits || '';

        new bootstrap.Modal(document.getElementById('modalEditCategory')).show();
    }
</script>
@endpush
@endsection
