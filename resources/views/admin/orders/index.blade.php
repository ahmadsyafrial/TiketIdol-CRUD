@extends('layouts.admin')

@section('title', 'Daftar Pesanan & Transaksi - Admin')
@section('page-title', 'Manajemen Pesanan & Transaksi Tiket')

@section('content')
<!-- Metric Statistics Row -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-admin p-3 border-start border-primary border-4">
            <div class="text-secondary small fw-bold">TOTAL PENDAPATAN (LUNAS)</div>
            <h4 class="fw-bold text-primary mb-0 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
            <div class="text-muted small mt-1">Dari transaksi tiket sukses</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin p-3 border-start border-success border-4">
            <div class="text-secondary small fw-bold">TIKET TERJUAL</div>
            <h4 class="fw-bold text-success mb-0 mt-1">{{ number_format($totalTicketsSold, 0, ',', '.') }} Tiket</h4>
            <div class="text-muted small mt-1">Seluruh kategori tiket idol</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin p-3 border-start border-info border-4">
            <div class="text-secondary small fw-bold">TOTAL TRANSAKSI</div>
            <h4 class="fw-bold text-dark mb-0 mt-1">{{ $totalOrdersCount }} Pesanan</h4>
            <div class="text-muted small mt-1">Total order terdaftar</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin p-3 border-start border-warning border-4">
            <div class="text-secondary small fw-bold">MENUNGGU PEMBAYARAN</div>
            <h4 class="fw-bold text-warning mb-0 mt-1">{{ $pendingOrdersCount }} Order</h4>
            <div class="text-muted small mt-1">Belum diselesaikan customer</div>
        </div>
    </div>
</div>

<!-- Filter & Search Card -->
<div class="card card-admin p-4 mb-4">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari Kode Order, Nama Pemesan, Email, NIK..." value="{{ $search }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="paid" {{ $status == 'paid' ? 'selected' : '' }}>Lunas / Terkonfirmasi</option>
                <option value="unpaid" {{ $status == 'unpaid' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="concert_id" class="form-select">
                <option value="">Semua Konser</option>
                @foreach($concerts as $c)
                    <option value="{{ $c->id }}" {{ $concertId == $c->id ? 'selected' : '' }}>{{ $c->artist_name }} - {{ $c->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
            @if($search || $status || $concertId)
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </div>
    </form>

    <!-- Orders Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light small">
                <tr>
                    <th>Kode Order</th>
                    <th>Konser Idol</th>
                    <th>Data Pemesan</th>
                    <th>Kategori & Qty</th>
                    <th>Metode & Total</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $ord)
                    <tr>
                        <td>
                            <div class="fw-bold font-monospace text-primary">{{ $ord->order_code }}</div>
                            <div class="text-muted small">{{ $ord->created_at->translatedFormat('d M Y, H:i') }}</div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark small line-clamp-1">{{ $ord->concert->title }}</div>
                            <span class="badge bg-danger rounded-pill px-2 py-1 small" style="font-size: 0.7rem;">{{ $ord->concert->artist_name }}</span>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark small">{{ $ord->customer_name }}</div>
                            <div class="text-muted small">{{ $ord->customer_email }}</div>
                            <div class="text-muted small font-monospace">NIK: {{ $ord->customer_nik }}</div>
                        </td>
                        <td>
                            <span class="badge" style="background-color: {{ $ord->ticketCategory->color_hex ?? '#333' }}; color: #fff;">
                                {{ $ord->ticketCategory->name ?? '-' }}
                            </span>
                            <div class="fw-bold small text-dark mt-1">{{ $ord->quantity }} Tiket</div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $ord->formatted_total }}</div>
                            <span class="badge bg-light text-secondary border small text-uppercase">{{ str_replace('_', ' ', $ord->payment_method) }}</span>
                        </td>
                        <td>
                            {!! $ord->status_badge !!}
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.orders.show', $ord->id) }}" class="btn btn-outline-primary btn-sm px-3">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-receipt fs-1 d-block mb-2"></i>
                            Tidak ada pesanan yang sesuai dengan filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
