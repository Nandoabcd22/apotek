@extends('layouts.app')

@section('title', 'Detail Pembelian')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.pembelians.index') }}">Pembelian</a></li>
            <li class="breadcrumb-item active">{{ $pembelian->no_pembelian }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Detail Pembelian</h3>
        <div>
            <a href="{{ route('admin.pembelians.edit', $pembelian) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.pembelians.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Pembelian</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">No. Pembelian</label>
                        <p class="text-muted"><strong>{{ $pembelian->no_pembelian }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <p class="text-muted">{{ $pembelian->tanggal_pembelian->format('d-m-Y') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Supplier</label>
                        <p class="text-muted">
                            <a href="{{ route('admin.suppliers.show', $pembelian->supplier) }}">
                                {{ $pembelian->supplier->nama_supplier ?? '-' }}
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
                            Rp {{ number_format($pembelian->total / (1 - $pembelian->diskon / 100), 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Diskon</label>
                        <p class="text-muted">
                            {{ $pembelian->diskon }}% (Rp {{ number_format($pembelian->total / (1 - $pembelian->diskon / 100) * ($pembelian->diskon / 100), 0, ',', '.') }})
                        </p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label">Total Pembayaran</label>
                        <p class="text-muted"><strong>Rp {{ number_format($pembelian->total, 0, ',', '.') }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Detail Item Pembelian</h5>
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
                                @foreach ($pembelian->details as $detail)
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
