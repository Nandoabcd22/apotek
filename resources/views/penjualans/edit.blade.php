@extends('layouts.app')

@section('title', 'Edit Penjualan')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('penjualans.index') }}">Penjualan</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="page-header">
        <h3 class="mb-0">Edit Penjualan</h3>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('penjualans.update', $penjualan) }}" method="POST" id="formPenjualan">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="no_penjualan" class="form-label">No. Penjualan</label>
                                    <input type="text" class="form-control" readonly value="{{ $penjualan->no_penjualan }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="tanggal_penjualan" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control @error('tanggal_penjualan') is-invalid @enderror" 
                                           id="tanggal_penjualan" name="tanggal_penjualan" value="{{ $penjualan->tanggal_penjualan->format('Y-m-d') }}" required>
                                    @error('tanggal_penjualan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="id_pelanggan" class="form-label">Pelanggan</label>
                                    <select class="form-select @error('id_pelanggan') is-invalid @enderror" 
                                            id="id_pelanggan" name="id_pelanggan" required>
                                        @foreach ($pelanggans as $pelanggan)
                                            <option value="{{ $pelanggan->id_pelanggan }}" 
                                                {{ $penjualan->id_pelanggan == $pelanggan->id_pelanggan ? 'selected' : '' }}>
                                                {{ $pelanggan->nama_pelanggan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_pelanggan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="diskon" class="form-label">Diskon (%)</label>
                                    <input type="number" class="form-control @error('diskon') is-invalid @enderror" 
                                           id="diskon" name="diskon" value="{{ $penjualan->diskon }}" min="0" max="100" step="0.01">
                                    @error('diskon')
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

                        <div class="row mt-4">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-6"><strong>Subtotal:</strong></div>
                                            <div class="col-6 text-end">Rp <span id="subtotalDisplay">0</span></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6"><strong>Diskon:</strong></div>
                                            <div class="col-6 text-end"><span id="diskonDisplay">0</span>% (Rp <span id="diskonRUpDisplay">0</span>)</div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-6"><strong>Total:</strong></div>
                                            <div class="col-6 text-end"><strong>Rp <span id="totalDisplay">0</span></strong></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Perbarui Penjualan
                    </button>
                    <a href="{{ route('penjualans.index') }}" class="btn btn-secondary">
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
        const existingItems = @json($penjualan->details);
        let itemCount = 0;

        function addItem(obatId = '', harga = '', jumlah = 1) {
            itemCount++;
            const itemRow = `
                <tr class="item-row" data-item="${itemCount}">
                    <td>
                        <select class="form-select obat-select" name="items[${itemCount}][id_obat]" required onchange="updateItemPrice(${itemCount})">
                            <option value="">-- Pilih Obat --</option>
                            ${obats.map(o => `<option value="${o.id_obat}" data-harga="${o.harga_jual}" ${obatId === o.id_obat ? 'selected' : ''}>${o.nama_obat} (Stok: ${o.stok})</option>`).join('')}
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control harga-satuan" name="items[${itemCount}][harga_satuan]" readonly value="${obatId ? harga : ''}">
                    </td>
                    <td>
                        <input type="number" class="form-control jumlah" name="items[${itemCount}][jumlah]" min="1" value="${jumlah}" required onchange="calculateSubtotal(${itemCount})">
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
            if (obatId) calculateSubtotal(itemCount);
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

            const diskon = parseFloat(document.getElementById('diskon').value) || 0;
            const diskonRUp = total * (diskon / 100);
            const finalTotal = total - diskonRUp;

            document.getElementById('subtotalDisplay').textContent = formatNumber(total);
            document.getElementById('diskonDisplay').textContent = diskon;
            document.getElementById('diskonRUpDisplay').textContent = formatNumber(diskonRUp);
            document.getElementById('totalDisplay').textContent = formatNumber(finalTotal);
        }

        function formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }

        document.getElementById('diskon').addEventListener('change', calculateTotal);

        // Load existing items
        existingItems.forEach(item => {
            addItem(item.id_obat, item.harga_satuan, item.jumlah);
        });

        // If no items, add one empty row
        if (existingItems.length === 0) {
            addItem();
        }

        calculateTotal();
    </script>
@endsection
