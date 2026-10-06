@extends('layouts.admin')

@section('title', 'Edit Konser - ' . $concert->title)
@section('page-title', 'Edit Data Konser')

@section('content')
<div class="card card-admin p-4 max-w-900 mx-auto">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h5 class="fw-bold text-dark mb-0">Edit Konser: {{ $concert->title }}</h5>
        <a href="{{ route('admin.concerts.show', $concert->id) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail
        </a>
    </div>

    <form action="{{ route('admin.concerts.update', $concert->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label fw-semibold small">Judul Konser Resmi <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $concert->title) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Nama Artis / Grup Idol <span class="text-danger">*</span></label>
                <input type="text" name="artist_name" class="form-control" value="{{ old('artist_name', $concert->artist_name) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Nama Fandom Resmi</label>
                <input type="text" name="fandom_name" class="form-control" value="{{ old('fandom_name', $concert->fandom_name) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Nama Venue / Gedung Konser <span class="text-danger">*</span></label>
                <input type="text" name="venue_name" class="form-control" value="{{ old('venue_name', $concert->venue_name) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Kota Pelaksanaan <span class="text-danger">*</span></label>
                <input type="text" name="city" class="form-control" value="{{ old('city', $concert->city) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Tanggal & Waktu Konser <span class="text-danger">*</span></label>
                <input type="datetime-local" name="concert_date" class="form-control" value="{{ old('concert_date', $concert->concert_date ? $concert->concert_date->format('Y-m-d\TH:i') : '') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Waktu Open Gate <span class="text-danger">*</span></label>
                <input type="text" name="gate_open_time" class="form-control" value="{{ old('gate_open_time', $concert->gate_open_time) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">URL Poster Konser (Portrait Image)</label>
                <input type="url" name="poster_url" class="form-control" value="{{ old('poster_url', $concert->poster_url) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">URL Banner Konser (Landscape Image)</label>
                <input type="url" name="banner_url" class="form-control" value="{{ old('banner_url', $concert->banner_url) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Nama Promotor Resmi <span class="text-danger">*</span></label>
                <input type="text" name="promoter_name" class="form-control" value="{{ old('promoter_name', $concert->promoter_name) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold small">Status Konser <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="active" {{ old('status', $concert->status) == 'active' ? 'selected' : '' }}>Aktif (Penjualan Tiket Dibuka)</option>
                    <option value="upcoming" {{ old('status', $concert->status) == 'upcoming' ? 'selected' : '' }}>Upcoming (Segera Hadir)</option>
                    <option value="sold_out" {{ old('status', $concert->status) == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                    <option value="completed" {{ old('status', $concert->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold small">Deskripsi Konser & Lineup <span class="text-danger">*</span></label>
                <textarea name="description" rows="4" class="form-control" required>{{ old('description', $concert->description) }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold small">Syarat & Ketentuan Konser</label>
                <textarea name="terms_conditions" rows="3" class="form-control">{{ old('terms_conditions', $concert->terms_conditions) }}</textarea>
            </div>

            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ $concert->is_featured ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold small" for="is_featured">Tampilkan sebagai Konser Unggulan (Hero Banner)</label>
                </div>
            </div>

            <div class="col-12 pt-3 border-top mt-3">
                <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                    <i class="bi bi-save me-1"></i> Perbarui Data Konser
                </button>
                <a href="{{ route('admin.concerts.show', $concert->id) }}" class="btn btn-light px-4 py-2">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection
