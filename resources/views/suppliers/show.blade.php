@extends('layouts.app')

@section('title', 'Detail Supplier')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.suppliers.index') }}">Supplier</a></li>
            <li class="breadcrumb-item active">{{ $supplier->id_supplier }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Detail Supplier</h3>
        <div>
            <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Supplier</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">ID Supplier</label>
                        <p class="text-muted">{{ $supplier->id_supplier }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Supplier</label>
                        <p class="text-muted">{{ $supplier->nama_supplier }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <p class="text-muted">{{ $supplier->alamat }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kota</label>
                        <p class="text-muted">{{ $supplier->kota }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <p class="text-muted">{{ $supplier->telepon }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Obat dari Supplier ini</h5>
                </div>
                <div class="card-body">
                    @if ($supplier->obats->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Obat</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supplier->obats as $obat)
                                        <tr>
                                            <td>{{ $obat->id_obat }}</td>
                                            <td>{{ $obat->nama_obat }}</td>
                                            <td>{{ $obat->stok }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">Tidak ada obat dari supplier ini</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
