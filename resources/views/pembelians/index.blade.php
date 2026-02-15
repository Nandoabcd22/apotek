@extends('layouts.app')

@section('title', 'Data Pembelian')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Pembelian</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Data Pembelian</h3>
        <a href="{{ route('admin.pembelians.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Buat Pembelian
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No. Pembelian</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Item</th>
                            <th>Diskon</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pembelians as $pembelian)
                            <tr>
                                <td><strong>{{ $pembelian->no_pembelian }}</strong></td>
                                <td>{{ $pembelian->tanggal_pembelian->format('d-m-Y') }}</td>
                                <td>{{ $pembelian->supplier->nama_supplier ?? '-' }}</td>
                                <td><span class="badge bg-secondary">{{ $pembelian->details->count() }}</span></td>
                                <td>{{ $pembelian->diskon }}%</td>
                                <td>Rp {{ number_format($pembelian->total, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('admin.pembelians.show', $pembelian) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pembelians.edit', $pembelian) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.pembelians.destroy', $pembelian) }}" method="POST" style="display:inline;">
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
                {{ $pembelians->links() }}
            </div>
        </div>
    </div>
@endsection
