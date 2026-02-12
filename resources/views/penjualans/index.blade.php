@extends('layouts.app')

@section('title', 'Data Penjualan')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Penjualan</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Data Penjualan</h3>
        <a href="{{ route('penjualans.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Buat Penjualan
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No. Penjualan</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Item</th>
                            <th>Diskon</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penjualans as $penjualan)
                            <tr>
                                <td><strong>{{ $penjualan->no_penjualan }}</strong></td>
                                <td>{{ $penjualan->tanggal_penjualan->format('d-m-Y') }}</td>
                                <td>{{ $penjualan->pelanggan->nama_pelanggan ?? '-' }}</td>
                                <td><span class="badge bg-secondary">{{ $penjualan->details->count() }}</span></td>
                                <td>{{ $penjualan->diskon }}%</td>
                                <td>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('penjualans.show', $penjualan) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('penjualans.edit', $penjualan) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('penjualans.destroy', $penjualan) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $penjualans->links() }}
            </div>
        </div>
    </div>
@endsection
