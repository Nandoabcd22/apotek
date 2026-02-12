<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Pelanggan;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with('pelanggan')->paginate(10);
        return view('penjualans.index', compact('penjualans'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        $obats = Obat::where('stok', '>', 0)->get();
        return view('penjualans.create', compact('pelanggans', 'obats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_penjualan' => 'required|unique:penjualans,no_penjualan',
            'tanggal_penjualan' => 'required|date',
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
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

            $penjualan = Penjualan::create([
                'no_penjualan' => $request->no_penjualan,
                'tanggal_penjualan' => $request->tanggal_penjualan,
                'id_pelanggan' => $request->id_pelanggan,
                'diskon' => $diskon,
                'total' => $total,
            ]);

            // Simpan detail penjualan dan update stok
            foreach ($request->items as $item) {
                $subtotal = $item['jumlah'] * $item['harga_satuan'];
                
                PenjualanDetail::create([
                    'no_penjualan' => $penjualan->no_penjualan,
                    'id_obat' => $item['id_obat'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $subtotal,
                ]);

                // Update stok obat
                $obat = Obat::find($item['id_obat']);
                $obat->stok -= $item['jumlah'];
                $obat->save();
            }

            DB::commit();
            return redirect()->route('penjualans.index')->with('success', 'Penjualan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Penjualan $penjualan)
    {
        $penjualan->load('pelanggan', 'details.obat');
        return view('penjualans.show', compact('penjualan'));
    }

    public function edit(Penjualan $penjualan)
    {
        $pelanggans = Pelanggan::all();
        $obats = Obat::all();
        $penjualan->load('details.obat');
        return view('penjualans.edit', compact('penjualan', 'pelanggans', 'obats'));
    }

    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'tanggal_penjualan' => 'required|date',
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
            'diskon' => 'nullable|numeric|min:0|max:100',
            'items' => 'required|array',
            'items.*.id_obat' => 'required|exists:obats,id_obat',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Restore stok lama
            foreach ($penjualan->details as $detail) {
                $obat = Obat::find($detail->id_obat);
                $obat->stok += $detail->jumlah;
                $obat->save();
            }

            // Hapus detail lama
            $penjualan->details()->delete();

            // Hitung total baru
            $diskon = $request->diskon ?? 0;
            $total = 0;

            foreach ($request->items as $item) {
                $total += $item['jumlah'] * $item['harga_satuan'];
            }

            $total = $total * (1 - $diskon / 100);

            // Update penjualan
            $penjualan->update([
                'tanggal_penjualan' => $request->tanggal_penjualan,
                'id_pelanggan' => $request->id_pelanggan,
                'diskon' => $diskon,
                'total' => $total,
            ]);

            // Simpan detail baru
            foreach ($request->items as $item) {
                $subtotal = $item['jumlah'] * $item['harga_satuan'];
                
                PenjualanDetail::create([
                    'no_penjualan' => $penjualan->no_penjualan,
                    'id_obat' => $item['id_obat'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $subtotal,
                ]);

                // Update stok obat
                $obat = Obat::find($item['id_obat']);
                $obat->stok -= $item['jumlah'];
                $obat->save();
            }

            DB::commit();
            return redirect()->route('penjualans.index')->with('success', 'Penjualan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Penjualan $penjualan)
    {
        try {
            DB::beginTransaction();

            // Restore stok
            foreach ($penjualan->details as $detail) {
                $obat = Obat::find($detail->id_obat);
                $obat->stok += $detail->jumlah;
                $obat->save();
            }

            $penjualan->delete();
            DB::commit();
            return redirect()->route('penjualans.index')->with('success', 'Penjualan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
