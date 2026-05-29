<?php

namespace App\Http\Controllers;

use App\Models\Artikel;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = Artikel::withCount(['komentars as jumlah_komentar'])
            ->orderByDesc('jumlah_komentar')
            ->get();

        $tanggal = now()->format('d/m/Y');

        return view('dashboard.laporan.index', compact('laporan', 'tanggal'));
    }
}
