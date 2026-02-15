@extends('layouts.app')

@section('title', 'Tambah Obat')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route($prefix . '.obats.index') }}">Obat</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="page-header">
        <h3 class="mb-0">Tambah Obat Baru</h3>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route($prefix . '.obats.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="id_obat" class="form-label">Kode Obat</label>
                            <input type="text" class="form-control @error('id_obat') is-invalid @enderror" 
                                   id="id_obat" name="id_obat" required>
                            @error('id_obat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_obat" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control @error('nama_obat') is-invalid @enderror" 
                                   id="nama_obat" name="nama_obat" required>
                            @error('nama_obat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis</label>
                            <input type="text" class="form-control @error('jenis') is-invalid @enderror" 
                                   id="jenis" name="jenis" placeholder="Tablet, Kapsul, Sirup, dll" required>
                            @error('jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <input type="text" class="form-control @error('satuan') is-invalid @enderror" 
                                   id="satuan" name="satuan" placeholder="Botol, Strip, Biji, dll" required>
                            @error('satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="harga_beli" class="form-label">Harga Beli</label>
                                    <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" 
                                           id="harga_beli" name="harga_beli" step="0.01" required>
                                    @error('harga_beli')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="harga_jual" class="form-label">Harga Jual</label>
                                    <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" 
                                           id="harga_jual" name="harga_jual" step="0.01" required>
                                    @error('harga_jual')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                   id="stok" name="stok" value="0" required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_supplier" class="form-label">Supplier</label>
                            <select class="form-select @error('id_supplier') is-invalid @enderror" 
                                    id="id_supplier" name="id_supplier" required>
                                <option value="">-- Pilih Supplier --</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id_supplier }}">{{ $supplier->nama_supplier }}</option>
                                @endforeach
                            </select>
                            @error('id_supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
                            <input type="date" class="form-control @error('tanggal_kadaluarsa') is-invalid @enderror" 
                                   id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" required>
                            @error('tanggal_kadaluarsa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Simpan
                            </button>
                            <a href="{{ route($prefix . '.obats.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
