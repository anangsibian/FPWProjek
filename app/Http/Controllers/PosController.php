<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        return view('pos.index');
    }

    public function store(Request $request)
    {
        // Logika simpan transaksi
    }

    public function history()
    {
        return view('pos.history');
    }
}
