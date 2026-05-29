<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    // Daftar semua artikel (publik) + search
    public function index(Request $request)
    {
        $query = Artikel::withCount(['komentars as jumlah_komentar'])
            ->with('admin')
            ->orderByDesc('id_artikel');

        if ($request->filled('keyword')) {
            $query->where('judul_artikel', 'like', '%' . $request->keyword . '%');
        }

        $artikels = $query->get();
        return view('artikel.index', compact('artikels'));
    }

    // Detail satu artikel + komentar (publik)
    public function show($id)
    {
        $artikel = Artikel::with(['admin', 'komentarsAktif'])
            ->withCount(['komentars as jumlah_komentar'])
            ->findOrFail($id);

        return view('artikel.show', compact('artikel'));
    }

    // Simpan artikel baru (admin)
    public function store(Request $request)
    {
        $request->validate([
            'judul'          => 'required|string|max:100',
            'gambar'         => 'nullable|url',
            'isi_artikel'    => 'required|string',
            'status_komentar'=> 'required|in:0,1',
        ]);

        Artikel::create([
            'judul_artikel'   => $request->judul,
            'isi_artikel'     => $request->isi_artikel,
            'gambar'          => $request->gambar ?? 'none',
            'tanggal_posting' => now()->toDateString(),
            'tanggal_edit'    => now()->toDateString(),
            'id_admin'        => session('admin_id'),
            'status_komentar' => $request->status_komentar,
        ]);

        return redirect()->route('dashboard')->with('success', 'Artikel berhasil dipost.');
    }

    // Hapus artikel (admin)
    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->delete();
        return redirect()->route('dashboard')->with('success', 'Artikel berhasil dihapus.');
    }

    // Toggle status komentar artikel (admin)
    public function toggleKomentar($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->status_komentar = !$artikel->status_komentar;
        $artikel->save();

        $status = $artikel->status_komentar ? 'DIBUKA' : 'DITUTUP';
        return redirect()->route('dashboard')->with('success', "Kolom komentar berhasil $status.");
    }
}
