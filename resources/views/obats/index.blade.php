@php $prefix = auth()->user()->getRoutePrefix(); @endphp

@extends('layouts.app')

@section('title', 'Data Obat')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Obat</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Data Obat</h3>
        @if(auth()->user()->isAdmin() || auth()->user()->isApoteker())
        <a href="{{ route($prefix . '.obats.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Obat
        </a>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Nama Obat</th>
                            <th>Jenis</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Harga Jual</th>
                            <th>Tanggal Kadaluarsa</th>
                            <th>Supplier</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($obats as $obat)
                            <tr>
                                <td><strong>{{ $obat->id_obat }}</strong></td>
                                <td>{{ $obat->nama_obat }}</td>
                                <td>{{ $obat->jenis }}</td>
                                <td>{{ $obat->satuan }}</td>
                                <td>
                                    @if ($obat->stok == 0)
                                        <span class="badge bg-danger">{{ $obat->stok }}</span>
                                    @elseif ($obat->stok < 20)
                                        <span class="badge bg-warning">{{ $obat->stok }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $obat->stok }}</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $today = \Carbon\Carbon::today();
                                        $kadaluarsa = $obat->tanggal_kadaluarsa;
                                    @endphp
                                    @if ($kadaluarsa < $today)
                                        <span class="badge bg-danger">{{ $kadaluarsa->format('d/m/Y') }}</span>
                                    @elseif ($kadaluarsa->diffInDays($today) <= 90)
                                        <span class="badge bg-warning">{{ $kadaluarsa->format('d/m/Y') }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $kadaluarsa->format('d/m/Y') }}</span>
                                    @endif
                                </td>
                                <td>{{ $obat->supplier->nama_supplier ?? '-' }}</td>
                                <td>
                                    <a href="{{ route($prefix . '.obats.show', $obat) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isApoteker())
                                    <a href="{{ route($prefix . '.obats.edit', $obat) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route($prefix . '.obats.destroy', $obat) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $obats->links() }}
            </div>
        </div>
    </div>
@endsection
