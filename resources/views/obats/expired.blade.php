@php $prefix = auth()->user()->getRoutePrefix(); @endphp

@extends('layouts.app')

@section('title', 'Obat Kadaluarsa')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route($prefix . '.obats.index') }}">Obat</a></li>
            <li class="breadcrumb-item active">Kadaluarsa</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Obat Kadaluarsa</h3>
        <a href="{{ route($prefix . '.obats.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if ($obats->count() > 0)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="bi bi-exclamation-triangle-fill"></i> Perhatian!</strong>
            Terdapat {{ $obats->total() }} obat yang telah kadaluarsa. Segera lakukan penanganan untuk obat-obat ini.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @else
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="bi bi-check-circle-fill"></i> Baik!</strong>
            Semua obat Anda masih dalam kondisi baik. Tidak ada obat yang kadaluarsa.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Daftar Obat Kadaluarsa ({{ $obats->total() }} obat)</h6>
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
                                <th>Hari Berlalu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($obats as $obat)
                                <tr class="table-danger">
                                    <td><strong>{{ $obat->id_obat }}</strong></td>
                                    <td>{{ $obat->nama_obat }}</td>
                                    <td>{{ $obat->jenis }}</td>
                                    <td>{{ $obat->supplier->nama_supplier ?? '-' }}</td>
                                    <td><span class="badge bg-danger">{{ $obat->stok }}</span></td>
                                    <td>{{ $obat->tanggal_kadaluarsa->format('d/m/Y') }}</td>
                                    <td>
                                        @php
                                            $hari_berlalu = $obat->tanggal_kadaluarsa->diffInDays(\Carbon\Carbon::today());
                                        @endphp
                                        <span class="badge bg-dark">{{ $hari_berlalu }} hari</span>
                                    </td>
                                    <td>
                                        <form action="{{ route($prefix . '.obats.destroy', $obat) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Yakin ingin menghapus obat kadaluarsa ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        Tidak ada obat yang kadaluarsa
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
