@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Obat</h6>
                    <h3>{{ \App\Models\Obat::count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Supplier</h6>
                    <h3>{{ \App\Models\Supplier::count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Pelanggan</h6>
                    <h3>{{ \App\Models\Pelanggan::count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Transaksi</h6>
                    <h3>{{ \App\Models\Penjualan::count() + \App\Models\Pembelian::count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Penjualan Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>No. Penjualan</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (\App\Models\Penjualan::latest()->take(5)->get() as $penjualan)
                                    <tr>
                                        <td><a href="{{ route('penjualans.show', $penjualan) }}">{{ $penjualan->no_penjualan }}</a></td>
                                        <td>{{ $penjualan->pelanggan->nama_pelanggan ?? '-' }}</td>
                                        <td>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                                        <td>{{ $penjualan->tanggal_penjualan->format('d-m-Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Pembelian Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>No. Pembelian</th>
                                    <th>Supplier</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (\App\Models\Pembelian::latest()->take(5)->get() as $pembelian)
                                    <tr>
                                        <td><a href="{{ route('pembelians.show', $pembelian) }}">{{ $pembelian->no_pembelian }}</a></td>
                                        <td>{{ $pembelian->supplier->nama_supplier ?? '-' }}</td>
                                        <td>Rp {{ number_format($pembelian->total, 0, ',', '.') }}</td>
                                        <td>{{ $pembelian->tanggal_pembelian->format('d-m-Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Obat dengan Stok Rendah</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Kode Obat</th>
                                    <th>Nama Obat</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (\App\Models\Obat::where('stok', '<', 10)->get() as $obat)
                                    <tr>
                                        <td>{{ $obat->id_obat }}</td>
                                        <td>{{ $obat->nama_obat }}</td>
                                        <td>{{ $obat->stok }}</td>
                                        <td>
                                            @if ($obat->stok == 0)
                                                <span class="badge bg-danger">Habis</span>
                                            @elseif ($obat->stok < 5)
                                                <span class="badge bg-warning">Kritis</span>
                                            @else
                                                <span class="badge bg-info">Rendah</span>
                                            @endif
                                        </td>
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
