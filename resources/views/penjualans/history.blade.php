@php $prefix = auth()->user()->getRoutePrefix(); @endphp

@extends('layouts.app')

@section('title', 'History Penjualan')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">History Penjualan</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">History Penjualan</h3>
        <a href="{{ route($prefix . '.penjualans.index') }}" class="btn btn-secondary btn-sm">
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
                    <form action="{{ route($prefix . '.penjualans.history') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="tanggal_dari" class="form-label">Tanggal Dari</label>
                            <input type="date" class="form-control" id="tanggal_dari" name="tanggal_dari" 
                                   value="{{ request('tanggal_dari') }}">
                        </div>

                        <div class="col-md-3">
                            <label for="tanggal_sampai" class="form-label">Tanggal Sampai</label>
                            <input type="date" class="form-control" id="tanggal_sampai" name="tanggal_sampai" 
                                   value="{{ request('tanggal_sampai') }}">
                        </div>

                        <div class="col-md-3">
                            <label for="user_id" class="form-label">Pelanggan</label>
                            <select class="form-select" id="user_id" name="user_id">
                                <option value="">-- Semua Pelanggan --</option>
                                @foreach ($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id }}" {{ request('user_id') == $pelanggan->id ? 'selected' : '' }}>
                                        {{ $pelanggan->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 d-flex gap-2 align-items-end">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-search"></i> Filter
                            </button>
                            <a href="{{ route($prefix . '.penjualans.history') }}" class="btn btn-secondary">
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
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0">History Penjualan ({{ $penjualans->total() }} transaksi)</h6>
                        </div>
                        <div class="col-auto text-end text-muted small">
                            Total: <strong>Rp {{ number_format($penjualans->sum('total'), 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No. Penjualan</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Jumlah Item</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penjualans as $penjualan)
                                <tr>
                                    <td><strong>{{ $penjualan->no_penjualan }}</strong></td>
                                    <td>{{ $penjualan->tanggal_penjualan->format('d/m/Y H:i') }}</td>
                                    <td>{{ $penjualan->user->name ?? '-' }}</td>
                                    <td>{{ $penjualan->details->count() }} item</td>
                                    <td>
                                        <strong>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route($prefix . '.penjualans.show', $penjualan) }}" class="btn btn-info" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if(auth()->user()->isApoteker() || auth()->user()->isPelanggan())
                                            <a href="{{ route($prefix . '.penjualans.edit', $penjualan) }}" class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route($prefix . '.penjualans.destroy', $penjualan) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Yakin ingin menghapus penjualan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Tidak ada history penjualan yang sesuai dengan kriteria filter
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($penjualans->hasPages())
                    <div class="card-footer bg-light">
                        {{ $penjualans->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
