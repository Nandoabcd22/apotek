<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\User;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with('user')->paginate(10);
        return view('penjualans.index', compact('penjualans'));
    }

    public function create()
    {
        $pelanggans = User::where('role', 'pelanggan')->get();
        $obats = Obat::where('stok', '>', 0)->get();
        return view('penjualans.create', compact('pelanggans', 'obats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_penjualan' => 'required|unique:penjualans,no_penjualan',
            'tanggal_penjualan' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'items.*.id_obat' => 'required|exists:obats,id_obat',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $total = 0;

            // Hitung total
            foreach ($request->items as $item) {
                $total += $item['jumlah'] * $item['harga_satuan'];
            }

            $penjualan = Penjualan::create([
                'no_penjualan' => $request->no_penjualan,
                'tanggal_penjualan' => $request->tanggal_penjualan,
                'user_id' => $request->user_id,
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
            $prefix = auth()->user()->getRoutePrefix();
            return redirect()->route($prefix . '.penjualans.index')->with('success', 'Penjualan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Penjualan $penjualan)
    {
        $penjualan->load('user', 'details.obat');
        return view('penjualans.show', compact('penjualan'));
    }

    public function edit(Penjualan $penjualan)
    {
        $pelanggans = User::where('role', 'pelanggan')->get();
        $obats = Obat::all();
        $penjualan->load('details.obat');
        return view('penjualans.edit', compact('penjualan', 'pelanggans', 'obats'));
    }

    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'tanggal_penjualan' => 'required|date',
            'user_id' => 'required|exists:users,id',
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
            $total = 0;

            foreach ($request->items as $item) {
                $total += $item['jumlah'] * $item['harga_satuan'];
            }

            // Update penjualan
            $penjualan->update([
                'tanggal_penjualan' => $request->tanggal_penjualan,
                'user_id' => $request->user_id,
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
            $prefix = auth()->user()->getRoutePrefix();
            return redirect()->route($prefix . '.penjualans.index')->with('success', 'Penjualan berhasil diperbarui');
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
            $prefix = auth()->user()->getRoutePrefix();
            return redirect()->route($prefix . '.penjualans.index')->with('success', 'Penjualan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function history(Request $request)
    {
        $query = Penjualan::with('user')->orderBy('tanggal_penjualan', 'desc');

        // Filter by date range
        if ($request->filled('tanggal_dari')) {
            $tanggal_dari = Carbon::createFromFormat('Y-m-d', $request->tanggal_dari)->startOfDay();
            $query->where('tanggal_penjualan', '>=', $tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $tanggal_sampai = Carbon::createFromFormat('Y-m-d', $request->tanggal_sampai)->endOfDay();
            $query->where('tanggal_penjualan', '<=', $tanggal_sampai);
        }

        // Filter by pelanggan
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $penjualans = $query->paginate(15);
        $pelanggans = User::where('role', 'pelanggan')->get();

        return view('penjualans.history', compact('penjualans', 'pelanggans'));
    }
}
