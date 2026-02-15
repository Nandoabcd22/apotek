<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::with('supplier')->paginate(10);
        return view('obats.index', compact('obats'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('obats.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_obat' => 'required|unique:obats,id_obat|max:10',
            'nama_obat' => 'required|string|max:100',
            'jenis' => 'required|string|max:50',
            'satuan' => 'required|string|max:20',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'tanggal_kadaluarsa' => 'required|date|after:today',
            'id_supplier' => 'required|exists:suppliers,id_supplier',
        ]);

        Obat::create($request->all());
        $prefix = auth()->user()->getRoutePrefix();
        return redirect()->route($prefix . '.obats.index')->with('success', 'Obat berhasil ditambahkan');
    }

    public function show(Obat $obat)
    {
        $obat->load('supplier');
        return view('obats.show', compact('obat'));
    }

    public function edit(Obat $obat)
    {
        $suppliers = Supplier::all();
        return view('obats.edit', compact('obat', 'suppliers'));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:100',
            'jenis' => 'required|string|max:50',
            'satuan' => 'required|string|max:20',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'tanggal_kadaluarsa' => 'required|date|after:today',
            'id_supplier' => 'required|exists:suppliers,id_supplier',
        ]);

        $obat->update($request->all());
        $prefix = auth()->user()->getRoutePrefix();
        return redirect()->route($prefix . '.obats.index')->with('success', 'Obat berhasil diperbarui');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();
        $prefix = auth()->user()->getRoutePrefix();
        return redirect()->route($prefix . '.obats.index')->with('success', 'Obat berhasil dihapus');
    }

    // Custom method untuk obat yang kedaluarsa
    public function expired()
    {
        $today = Carbon::today();
        $obats = Obat::where('tanggal_kadaluarsa', '<', $today)
            ->with('supplier')
            ->paginate(10);
        return view('obats.expired', compact('obats'));
    }

    // Custom method untuk search obat
    public function search(Request $request)
    {
        $query = Obat::with('supplier');

        if ($request->filled('nama_obat')) {
            $query->where('nama_obat', 'like', '%' . $request->nama_obat . '%');
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('stok_rendah') && $request->stok_rendah == 'on') {
            $query->where('stok', '<', 20);
        }

        if ($request->filled('akan_kadaluarsa') && $request->akan_kadaluarsa == 'on') {
            $today = Carbon::today();
            $threeMonthsLater = Carbon::today()->addMonths(3);
            $query->whereBetween('tanggal_kadaluarsa', [$today, $threeMonthsLater]);
        }

        $obats = $query->paginate(10);
        
        return view('obats.search', compact('obats'));
    }
}
