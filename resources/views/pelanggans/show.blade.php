@extends('layouts.app')

@section('title', 'Detail Pelanggan')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pelanggans.index') }}">Pelanggan</a></li>
            <li class="breadcrumb-item active">{{ $pelanggan->id_pelanggan }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Detail Pelanggan</h3>
        <div>
            <a href="{{ route('pelanggans.edit', $pelanggan) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Pelanggan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">ID Pelanggan</label>
                        <p class="text-muted">{{ $pelanggan->id_pelanggan }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Pelanggan</label>
                        <p class="text-muted">{{ $pelanggan->nama_pelanggan }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <p class="text-muted">{{ $pelanggan->alamat }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kota</label>
                        <p class="text-muted">{{ $pelanggan->kota }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <p class="text-muted">{{ $pelanggan->telepon }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statistik Pembelian</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Total Transaksi</label>
                        <p class="text-muted fs-5"><strong>{{ $pelanggan->penjualans->count() }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Pembelian</label>
                        <p class="text-muted fs-5">
                            <strong>Rp {{ number_format($pelanggan->penjualans->sum('total'), 0, ',', '.') }}</strong>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rata-rata Pembelian</label>
                        <p class="text-muted fs-5">
                            <strong>Rp {{ number_format($pelanggan->penjualans->avg('total') ?? 0, 0, ',', '.') }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Riwayat Penjualan</h5>
                </div>
                <div class="card-body">
                    @if ($pelanggan->penjualans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>No. Penjualan</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah Item</th>
                                        <th>Diskon</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pelanggan->penjualans as $penjualan)
                                        <tr>
                                            <td><strong>{{ $penjualan->no_penjualan }}</strong></td>
                                            <td>{{ $penjualan->tanggal_penjualan->format('d-m-Y') }}</td>
                                            <td>{{ $penjualan->details->count() }}</td>
                                            <td>{{ $penjualan->diskon }}%</td>
                                            <td>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                                            <td>
                                                <a href="{{ route('penjualans.show', $penjualan) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">Pelanggan ini belum memiliki riwayat pembelian</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
