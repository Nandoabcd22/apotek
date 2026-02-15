<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of pelanggan users.
     */
    public function index()
    {
        $pelanggans = User::where('role', 'pelanggan')->paginate(10);
        return view('pelanggans.index', compact('pelanggans'));
    }

    /**
     * Show the form for creating a new pelanggan.
     */
    public function create()
    {
        return view('pelanggans.create');
    }

    /**
     * Store a newly created pelanggan in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = 'pelanggan';

        User::create($validated);

        return redirect()->route('admin.pelanggans.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    /**
     * Display the specified pelanggan.
     */
    public function show(User $pelanggan)
    {
        // Ensure the user is a pelanggan
        if ($pelanggan->role !== 'pelanggan') {
            abort(404);
        }
        
        $pelanggan->load('penjualans');
        return view('pelanggans.show', compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified pelanggan.
     */
    public function edit(User $pelanggan)
    {
        // Ensure the user is a pelanggan
        if ($pelanggan->role !== 'pelanggan') {
            abort(404);
        }
        
        return view('pelanggans.edit', compact('pelanggan'));
    }

    /**
     * Update the specified pelanggan in storage.
     */
    public function update(Request $request, User $pelanggan)
    {
        // Ensure the user is a pelanggan
        if ($pelanggan->role !== 'pelanggan') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pelanggan->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $pelanggan->update($validated);

        return redirect()->route('admin.pelanggans.show', $pelanggan)->with('success', 'Pelanggan berhasil diperbarui.');
    }

    /**
     * Remove the specified pelanggan from storage.
     */
    public function destroy(User $pelanggan)
    {
        // Ensure the user is a pelanggan
        if ($pelanggan->role !== 'pelanggan') {
            abort(404);
        }

        $pelanggan->delete();

        return redirect()->route('admin.pelanggans.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
