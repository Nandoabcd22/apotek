<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Supplier;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelian::with('supplier')->paginate(10);
        return view('pembelians.index', compact('pembelians'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $obats = Obat::all();
        return view('pembelians.create', compact('suppliers', 'obats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_pembelian' => 'required|unique:pembelians,no_pembelian',
            'tanggal_pembelian' => 'required|date',
            'id_supplier' => 'required|exists:suppliers,id_supplier',
            'diskon' => 'nullable|numeric|min:0|max:100',
            'items' => 'required|array',
            'items.*.id_obat' => 'required|exists:obats,id_obat',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $diskon = $request->diskon ?? 0;
            $total = 0;

            // Hitung total sebelum diskon
            foreach ($request->items as $item) {
                $total += $item['jumlah'] * $item['harga_satuan'];
            }

            // Terapkan diskon
            $total = $total * (1 - $diskon / 100);

            $pembelian = Pembelian::create([
                'no_pembelian' => $request->no_pembelian,
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'id_supplier' => $request->id_supplier,
                'diskon' => $diskon,
                'total' => $total,
            ]);

            // Simpan detail pembelian dan update stok
            foreach ($request->items as $item) {
                $subtotal = $item['jumlah'] * $item['harga_satuan'];
                
                PembelianDetail::create([
                    'no_pembelian' => $pembelian->no_pembelian,
                    'id_obat' => $item['id_obat'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $subtotal,
                ]);

                // Update stok obat
                $obat = Obat::find($item['id_obat']);
                $obat->stok += $item['jumlah'];
                $obat->save();
            }

            DB::commit();
            return redirect()->route('admin.pembelians.index')->with('success', 'Pembelian berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Pembelian $pembelian)
    {
        $pembelian->load('supplier', 'details.obat');
        return view('pembelians.show', compact('pembelian'));
    }

    public function edit(Pembelian $pembelian)
    {
        $suppliers = Supplier::all();
        $obats = Obat::all();
        $pembelian->load('details.obat');
        return view('pembelians.edit', compact('pembelian', 'suppliers', 'obats'));
    }

    public function update(Request $request, Pembelian $pembelian)
    {
        $request->validate([
            'tanggal_pembelian' => 'required|date',
            'id_supplier' => 'required|exists:suppliers,id_supplier',
            'diskon' => 'nullable|numeric|min:0|max:100',
            'items' => 'required|array',
            'items.*.id_obat' => 'required|exists:obats,id_obat',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Restore stok lama
            foreach ($pembelian->details as $detail) {
                $obat = Obat::find($detail->id_obat);
                $obat->stok -= $detail->jumlah;
                $obat->save();
            }

            // Hapus detail lama
            $pembelian->details()->delete();

            // Hitung total baru
            $diskon = $request->diskon ?? 0;
            $total = 0;

            foreach ($request->items as $item) {
                $total += $item['jumlah'] * $item['harga_satuan'];
            }

            $total = $total * (1 - $diskon / 100);

            // Update pembelian
            $pembelian->update([
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'id_supplier' => $request->id_supplier,
                'diskon' => $diskon,
                'total' => $total,
            ]);

            // Simpan detail baru
            foreach ($request->items as $item) {
                $subtotal = $item['jumlah'] * $item['harga_satuan'];
                
                PembelianDetail::create([
                    'no_pembelian' => $pembelian->no_pembelian,
                    'id_obat' => $item['id_obat'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $subtotal,
                ]);

                // Update stok obat
                $obat = Obat::find($item['id_obat']);
                $obat->stok += $item['jumlah'];
                $obat->save();
            }

            DB::commit();
            return redirect()->route('admin.pembelians.index')->with('success', 'Pembelian berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Pembelian $pembelian)
    {
        try {
            DB::beginTransaction();

            // Restore stok
            foreach ($pembelian->details as $detail) {
                $obat = Obat::find($detail->id_obat);
                $obat->stok -= $detail->jumlah;
                $obat->save();
            }

            $pembelian->delete();
            DB::commit();
            return redirect()->route('admin.pembelians.index')->with('success', 'Pembelian berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
