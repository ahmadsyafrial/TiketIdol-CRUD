@extends('layouts.admin')

@section('title', 'Tambah Konser Baru - Admin')
@section('page-title', 'Tambah Konser Idol Baru')

@section('content')
<div class="card card-admin p-4 max-w-900 mx-auto">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h5 class="fw-bold text-dark mb-0">Form Tambah Konser</h5>
        <a href="{{ route('admin.concerts.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    <form action="{{ route('admin.concerts.store') }}" method="POST">
        @csrf

        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label fw-semibold small">Judul Konser Resmi <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" placeholder="Contoh: BABYMONSTER 1ST WORLD TOUR <HELLO MONSTERS> IN JAKARTA" value="{{ old('title') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Nama Artis / Grup Idol <span class="text-danger">*</span></label>
                <input type="text" name="artist_name" class="form-control" placeholder="Contoh: BABYMONSTER" value="{{ old('artist_name') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Nama Fandom Resmi</label>
                <input type="text" name="fandom_name" class="form-control" placeholder="Contoh: MONSTIEZ" value="{{ old('fandom_name') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Nama Venue / Gedung Konser <span class="text-danger">*</span></label>
                <input type="text" name="venue_name" class="form-control" placeholder="Contoh: ICE BSD City Hall 5-6" value="{{ old('venue_name') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Kota Pelaksanaan <span class="text-danger">*</span></label>
                <input type="text" name="city" class="form-control" placeholder="Contoh: Tangerang / Jakarta" value="{{ old('city', 'Jakarta') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Tanggal & Waktu Konser <span class="text-danger">*</span></label>
                <input type="datetime-local" name="concert_date" class="form-control" value="{{ old('concert_date') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Waktu Open Gate <span class="text-danger">*</span></label>
                <input type="text" name="gate_open_time" class="form-control" placeholder="Contoh: 15:30 WIB (Soundcheck 16:30)" value="{{ old('gate_open_time', '16:00 WIB') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">URL Poster Konser (Portrait Image)</label>
                <input type="url" name="poster_url" class="form-control" placeholder="https://example.com/poster.jpg" value="{{ old('poster_url') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">URL Banner Konser (Landscape Image)</label>
                <input type="url" name="banner_url" class="form-control" placeholder="https://example.com/banner.jpg" value="{{ old('banner_url') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Nama Promotor Resmi <span class="text-danger">*</span></label>
                <input type="text" name="promoter_name" class="form-control" placeholder="Contoh: YG Entertainment x Live Nation" value="{{ old('promoter_name', 'Live Nation') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Status Konser <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif (Penjualan Tiket Dibuka)</option>
                    <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Upcoming (Segera Hadir)</option>
                    <option value="sold_out" {{ old('status') == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold small">Deskripsi Konser & Lineup <span class="text-danger">*</span></label>
                <textarea name="description" rows="4" class="form-control" placeholder="Tuliskan latar belakang tur, member yang tampil, dan konsep konser..." required>{{ old('description') }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold small">Syarat & Ketentuan Konser</label>
                <textarea name="terms_conditions" rows="3" class="form-control" placeholder="Contoh aturan penukaran wristband, larangan membawa kamera, dsb...">{{ old('terms_conditions') }}</textarea>
            </div>

            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" checked>
                    <label class="form-check-label fw-semibold small" for="is_featured">Tampilkan sebagai Konser Unggulan (Hero Banner)</label>
                </div>
            </div>

            <div class="col-12 pt-3 border-top mt-3">
                <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                    <i class="bi bi-check-circle me-1"></i> Simpan & Lanjut Kelola Kategori Tiket
                </button>
                <a href="{{ route('admin.concerts.index') }}" class="btn btn-light px-4 py-2">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection
