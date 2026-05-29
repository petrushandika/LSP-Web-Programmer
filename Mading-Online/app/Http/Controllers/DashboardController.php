<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Komentar;

class DashboardController extends Controller
{
    public function index()
    {
        $menu = request('menu', 'menu_daftar_artikel');

        $artikels  = Artikel::with('admin')->orderByDesc('id_artikel')->get();
        $komentars = Komentar::with('artikel')->orderByDesc('id_komentar')->get();

        return view('dashboard.index', compact('menu', 'artikels', 'komentars'));
    }
}
