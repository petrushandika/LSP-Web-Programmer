<?php

namespace App\Http\Controllers;

use App\Models\Artikel;

class HomeController extends Controller
{
    public function index()
    {
        // 3 artikel terpopuler berdasarkan jumlah komentar
        $artikelPopuler = Artikel::withCount(['komentars as jumlah_komentar'])
            ->with('admin')
            ->orderByDesc('jumlah_komentar')
            ->limit(3)
            ->get();

        // 3 artikel terbaru
        $artikelTerbaru = Artikel::withCount(['komentars as jumlah_komentar'])
            ->with('admin')
            ->orderByDesc('id_artikel')
            ->limit(3)
            ->get();

        return view('home.index', compact('artikelPopuler', 'artikelTerbaru'));
    }
}
