@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('penjualans.index') }}">Penjualan</a></li>
            <li class="breadcrumb-item active">{{ $penjualan->no_penjualan }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Detail Penjualan</h3>
        <div>
            <a href="{{ route('penjualans.edit', $penjualan) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('penjualans.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Penjualan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">No. Penjualan</label>
                        <p class="text-muted"><strong>{{ $penjualan->no_penjualan }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <p class="text-muted">{{ $penjualan->tanggal_penjualan->format('d-m-Y') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pelanggan</label>
                        <p class="text-muted">
                            <a href="{{ route('pelanggans.show', $penjualan->pelanggan) }}">
                                {{ $penjualan->pelanggan->nama_pelanggan ?? '-' }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Ringkasan Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Subtotal</label>
                        <p class="text-muted">
                            Rp {{ number_format($penjualan->total / (1 - $penjualan->diskon / 100), 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Diskon</label>
                        <p class="text-muted">
                            {{ $penjualan->diskon }}% (Rp {{ number_format($penjualan->total / (1 - $penjualan->diskon / 100) * ($penjualan->diskon / 100), 0, ',', '.') }})
                        </p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label">Total Pembayaran</label>
                        <p class="text-muted"><strong>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Detail Item Penjualan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Obat</th>
                                    <th>Nama Obat</th>
                                    <th>Harga Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penjualan->details as $detail)
                                    <tr>
                                        <td><strong>{{ $detail->id_obat }}</strong></td>
                                        <td>{{ $detail->obat->nama_obat ?? '-' }}</td>
                                        <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                        <td>{{ $detail->jumlah }}</td>
                                        <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
