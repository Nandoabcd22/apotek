<?php

namespace App\Http\Controllers;

use App\Models\Obat;

class HomeController extends Controller
{
    /**
     * Display the home page with list of obats.
     */
    public function index()
    {
        $obats = Obat::paginate(12);
        return view('home', compact('obats'));
    }
}
