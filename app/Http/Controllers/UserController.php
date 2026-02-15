<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of apoteker users.
     */
    public function index()
    {
        $users = User::where('role', 'apoteker')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new apoteker.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created apoteker in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = 'apoteker';

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Apoteker berhasil ditambahkan.');
    }

    /**
     * Display the specified apoteker.
     */
    public function show(User $user)
    {
        if ($user->role !== 'apoteker') {
            abort(404);
        }
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified apoteker.
     */
    public function edit(User $user)
    {
        if ($user->role !== 'apoteker') {
            abort(404);
        }
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified apoteker in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($user->role !== 'apoteker') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validated['password']) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)->with('success', 'Apoteker berhasil diperbarui');
    }

    /**
     * Remove the specified apoteker from storage.
     */
    public function destroy(User $user)
    {
        if ($user->role !== 'apoteker') {
            abort(404);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Apoteker berhasil dihapus');
    }
}
