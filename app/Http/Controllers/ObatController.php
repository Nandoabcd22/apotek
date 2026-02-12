<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Supplier;
use Illuminate\Http\Request;

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
            'id_supplier' => 'required|exists:suppliers,id_supplier',
        ]);

        Obat::create($request->all());
        return redirect()->route('obats.index')->with('success', 'Obat berhasil ditambahkan');
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
            'id_supplier' => 'required|exists:suppliers,id_supplier',
        ]);

        $obat->update($request->all());
        return redirect()->route('obats.index')->with('success', 'Obat berhasil diperbarui');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();
        return redirect()->route('obats.index')->with('success', 'Obat berhasil dihapus');
    }
}
