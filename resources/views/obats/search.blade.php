@php $prefix = auth()->user()->getRoutePrefix(); @endphp

@extends('layouts.app')

@section('title', 'Cari & Filter Obat')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route($prefix . '.obats.index') }}">Obat</a></li>
            <li class="breadcrumb-item active">Cari & Filter</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Cari & Filter Obat</h3>
        <a href="{{ route($prefix . '.obats.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Filter & Pencarian</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route($prefix . '.obats.search') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="nama_obat" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control" id="nama_obat" name="nama_obat" 
                                   placeholder="Cari nama obat..." value="{{ request('nama_obat') }}">
                        </div>

                        <div class="col-md-4">
                            <label for="jenis" class="form-label">Jenis</label>
                            <input type="text" class="form-control" id="jenis" name="jenis" 
                                   placeholder="Contoh: Tablet, Kapsul" value="{{ request('jenis') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label d-block">Filter Stok</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="stok_rendah" name="stok_rendah"
                                       {{ request('stok_rendah') ? 'checked' : '' }}>
                                <label class="form-check-label" for="stok_rendah">
                                    Hanya Stok Rendah (&lt; 20)
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label d-block">Filter Kadaluarsa</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="akan_kadaluarsa" name="akan_kadaluarsa"
                                       {{ request('akan_kadaluarsa') ? 'checked' : '' }}>
                                <label class="form-check-label" for="akan_kadaluarsa">
                                    Akan Kadaluarsa (0-3 bulan)
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary mt-4 w-100">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route($prefix . '.obats.search') }}" class="btn btn-secondary mt-4 w-100">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Hasil Pencarian ({{ $obats->total() }} obat)</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kode</th>
                                <th>Nama Obat</th>
                                <th>Jenis</th>
                                <th>Supplier</th>
                                <th>Stok</th>
                                <th>Tanggal Kadaluarsa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($obats as $obat)
                                <tr>
                                    <td><strong>{{ $obat->id_obat }}</strong></td>
                                    <td>{{ $obat->nama_obat }}</td>
                                    <td>{{ $obat->jenis }}</td>
                                    <td>{{ $obat->supplier->nama_supplier ?? '-' }}</td>
                                    <td>
                                        @if ($obat->stok < 20)
                                            <span class="badge bg-danger">{{ $obat->stok }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $obat->stok }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $today = \Carbon\Carbon::today();
                                            $kadaluarsa = $obat->tanggal_kadaluarsa;
                                        @endphp
                                        @if ($kadaluarsa < $today)
                                            <span class="badge bg-danger">{{ $kadaluarsa->format('d/m/Y') }} (Kadaluarsa)</span>
                                        @elseif ($kadaluarsa->diffInDays($today) <= 90)
                                            <span class="badge bg-warning">{{ $kadaluarsa->format('d/m/Y') }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $kadaluarsa->format('d/m/Y') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route($prefix . '.obats.show', $obat) }}" class="btn btn-info" title="Lihat">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if(auth()->user()->isAdmin() || auth()->user()->isApoteker())
                                            <a href="{{ route($prefix . '.obats.edit', $obat) }}" class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route($prefix . '.obats.destroy', $obat) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Yakin ingin menghapus?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Tidak ada obat yang sesuai dengan kriteria pencarian
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($obats->hasPages())
                    <div class="card-footer bg-light">
                        {{ $obats->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
