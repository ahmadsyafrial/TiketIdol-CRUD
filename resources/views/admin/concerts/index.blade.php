@extends('layouts.admin')

@section('title', 'Daftar Konser Idol - Admin')
@section('page-title', 'Manajemen Konser Idol')

@section('content')
<div class="card card-admin p-4 mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <form action="{{ route('admin.concerts.index') }}" method="GET" class="d-flex gap-2 flex-grow-1 max-w-500">
            <input type="text" name="search" class="form-control" placeholder="Cari nama konser, artis, atau venue..." value="{{ $search }}">
            <select name="status" class="form-select w-auto">
                <option value="">Semua Status</option>
                <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="upcoming" {{ $status == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                <option value="sold_out" {{ $status == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Selesai</option>
            </select>
            <button type="submit" class="btn btn-primary px-3">Filter</button>
            @if($search || $status)
                <a href="{{ route('admin.concerts.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </form>

        <a href="{{ route('admin.concerts.create') }}" class="btn btn-primary px-4 py-2 fw-semibold">
            <i class="bi bi-plus-lg me-1"></i> Tambah Konser Baru
        </a>
    </div>

    <!-- Table of Concerts -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 70px;">Poster</th>
                    <th>Detail Konser & Artis</th>
                    <th>Venue & Waktu</th>
                    <th>Kategori Tiket</th>
                    <th>Status</th>
                    <th class="text-end" style="width: 220px;">Aksi CRUD</th>
                </tr>
            </thead>
            <tbody>
                @forelse($concerts as $concert)
                    <tr>
                        <td>
                            <img src="{{ $concert->poster_url ?? 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=150&q=80' }}"
                                 alt="{{ $concert->title }}"
                                 class="rounded-3 object-fit-cover shadow-sm"
                                 style="width: 55px; height: 75px;">
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-danger rounded-pill px-2 py-1 small">{{ $concert->artist_name }}</span>
                                @if($concert->fandom_name)
                                    <span class="badge bg-secondary-subtle text-secondary small">{{ $concert->fandom_name }}</span>
                                @endif
                            </div>
                            <h6 class="fw-bold mb-1 text-dark">{{ $concert->title }}</h6>
                            <div class="small text-muted">Promotor: {{ $concert->promoter_name }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark small"><i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $concert->venue_name }}</div>
                            <div class="text-muted small"><i class="bi bi-calendar3 me-1"></i> {{ $concert->formatted_date }}</div>
                            <div class="text-muted small"><i class="bi bi-clock me-1"></i> {{ $concert->formatted_time }}</div>
                        </td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-bold">
                                {{ $concert->ticket_categories_count }} Kategori
                            </span>
                            <div class="small text-muted mt-1">{{ $concert->orders_count }} Pesanan Masuk</div>
                        </td>
                        <td>
                            @if($concert->status === 'active')
                                <span class="badge bg-success-subtle text-success border border-success px-3 py-1 rounded-pill">Aktif / Buka</span>
                            @elseif($concert->status === 'sold_out')
                                <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-1 rounded-pill">Sold Out</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-1 rounded-pill">{{ ucfirst($concert->status) }}</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('admin.concerts.show', $concert->id) }}" class="btn btn-outline-primary btn-sm px-2" title="Kelola Kategori & Detail">
                                    <i class="bi bi-ticket-detailed me-1"></i> Kategori
                                </a>
                                <a href="{{ route('admin.concerts.edit', $concert->id) }}" class="btn btn-outline-secondary btn-sm px-2" title="Edit Konser">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.concerts.destroy', $concert->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus konser {{ $concert->title }} beserta seluruh kategori tiketnya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm px-2" title="Hapus Konser">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                            Belum ada konser idol yang terdaftar. Silakan tambah konser baru!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $concerts->links() }}
    </div>
</div>
@endsection
