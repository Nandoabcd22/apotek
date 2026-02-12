@extends('layouts.app')

@section('title', 'Detail Obat')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('obats.index') }}">Obat</a></li>
            <li class="breadcrumb-item active">{{ $obat->id_obat }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Detail Obat</h3>
        <div>
            <a href="{{ route('obats.edit', $obat) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('obats.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Obat</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Obat</label>
                        <p class="text-muted">{{ $obat->id_obat }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Obat</label>
                        <p class="text-muted">{{ $obat->nama_obat }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <p class="text-muted">{{ $obat->jenis }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Satuan</label>
                        <p class="text-muted">{{ $obat->satuan }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Harga & Stok</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Harga Beli</label>
                        <p class="text-muted">Rp {{ number_format($obat->harga_beli, 0, ',', '.') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Jual</label>
                        <p class="text-muted">Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Margin Keuntungan</label>
                        <p class="text-muted">Rp {{ number_format($obat->harga_jual - $obat->harga_beli, 0, ',', '.') }} 
                            ({{ round(($obat->harga_jual - $obat->harga_beli) / $obat->harga_beli * 100, 2) }}%)
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <p>
                            @if ($obat->stok == 0)
                                <span class="badge bg-danger fs-6">{{ $obat->stok }} - Habis</span>
                            @elseif ($obat->stok < 5)
                                <span class="badge bg-warning fs-6">{{ $obat->stok }} - Kritis</span>
                            @else
                                <span class="badge bg-success fs-6">{{ $obat->stok }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Supplier</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Supplier</label>
                        <p class="text-muted">{{ $obat->supplier->nama_supplier ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <p class="text-muted">{{ $obat->supplier->telepon ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <p class="text-muted">{{ $obat->supplier->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
