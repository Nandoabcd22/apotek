@php $prefix = auth()->user()->getRoutePrefix(); @endphp

@extends('layouts.app')

@section('title', 'Buat Penjualan')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route($prefix . '.penjualans.index') }}">Penjualan</a></li>
            <li class="breadcrumb-item active">Buat</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="page-header">
        <h3 class="mb-0">Buat Penjualan Baru</h3>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form action="{{ route($prefix . '.penjualans.store') }}" method="POST" id="formPenjualan">
                @csrf

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="no_penjualan" class="form-label">No. Penjualan</label>
                                    <input type="text" class="form-control @error('no_penjualan') is-invalid @enderror" 
                                           id="no_penjualan" name="no_penjualan" required>
                                    @error('no_penjualan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tanggal_penjualan" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control @error('tanggal_penjualan') is-invalid @enderror" 
                                           id="tanggal_penjualan" name="tanggal_penjualan" value="{{ date('Y-m-d') }}" required>
                                    @error('tanggal_penjualan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Pelanggan</label>
                                    <select class="form-select @error('user_id') is-invalid @enderror" 
                                            id="user_id" name="user_id" required>
                                        <option value="">-- Pilih Pelanggan --</option>
                                        @foreach ($pelanggans as $pelanggan)
                                            <option value="{{ $pelanggan->id }}">{{ $pelanggan->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Penjualan</h5>
                        <button type="button" class="btn btn-sm btn-primary" onclick="addItem()">
                            <i class="bi bi-plus-lg"></i> Tambah Item
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="itemsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Obat</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="itemsBody">
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div class="text-end flex-grow-1">
                                <h5 class="mb-0">Total: <span class="text-primary">Rp <span id="totalDisplay">0</span></span></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Simpan Penjualan
                    </button>
                    <a href="{{ route($prefix . '.penjualans.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-lg"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const obats = @json($obats);
        let itemCount = 0;

        function addItem() {
            itemCount++;
            const itemRow = `
                <tr class="item-row" data-item="${itemCount}">
                    <td>
                        <select class="form-select obat-select" name="items[${itemCount}][id_obat]" required onchange="updateItemPrice(${itemCount})">
                            <option value="">-- Pilih Obat --</option>
                            ${obats.map(o => `<option value="${o.id_obat}" data-harga="${o.harga_jual}">${o.nama_obat} (Stok: ${o.stok})</option>`).join('')}
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control harga-satuan" name="items[${itemCount}][harga_satuan]" readonly>
                    </td>
                    <td>
                        <input type="number" class="form-control jumlah" name="items[${itemCount}][jumlah]" min="1" value="1" required onchange="calculateSubtotal(${itemCount})">
                    </td>
                    <td>
                        <strong class="subtotal">Rp 0</strong>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(${itemCount})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            document.getElementById('itemsBody').insertAdjacentHTML('beforeend', itemRow);
        }

        function updateItemPrice(itemNum) {
            const select = document.querySelector(`[data-item="${itemNum}"] .obat-select`);
            const hargaInput = document.querySelector(`[data-item="${itemNum}"] .harga-satuan`);
            const harga = select.options[select.selectedIndex].dataset.harga;
            hargaInput.value = harga ? harga : '0';
            calculateSubtotal(itemNum);
        }

        function calculateSubtotal(itemNum) {
            const harga = parseFloat(document.querySelector(`[data-item="${itemNum}"] .harga-satuan`).value) || 0;
            const jumlah = parseInt(document.querySelector(`[data-item="${itemNum}"] .jumlah`).value) || 0;
            const subtotal = harga * jumlah;
            document.querySelector(`[data-item="${itemNum}"] .subtotal`).textContent = 'Rp ' + formatNumber(subtotal);
            calculateTotal();
        }

        function removeItem(itemNum) {
            document.querySelector(`[data-item="${itemNum}"]`).remove();
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const harga = parseFloat(row.querySelector('.harga-satuan').value) || 0;
                const jumlah = parseInt(row.querySelector('.jumlah').value) || 0;
                total += harga * jumlah;
            });

            document.getElementById('totalDisplay').textContent = formatNumber(total);
        }

        function formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }

        // Add initial item
        addItem();
    </script>
@endsection
