<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Komentar;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    // Daftar semua komentar (admin)
    public function index()
    {
        $komentars = Komentar::with('artikel')
            ->orderByDesc('id_komentar')
            ->get();

        return view('dashboard.komentar.index', compact('komentars'));
    }

    // Simpan komentar baru (publik)
    public function store(Request $request, $id_artikel)
    {
        $request->validate([
            'nama_user'    => 'required|string|max:25',
            'email_user'   => 'required|email|max:50',
            'komentar_user'=> 'required|string|max:280',
        ]);

        $artikel = Artikel::findOrFail($id_artikel);

        if (!$artikel->status_komentar) {
            return back()->with('error', 'Kolom komentar ditutup.');
        }

        Komentar::create([
            'id_artikel'       => $id_artikel,
            'nama_user'        => $request->nama_user,
            'email_user'       => $request->email_user,
            'isi_komentar'     => $request->komentar_user,
            'tanggal_komentar' => now()->toDateString(),
            'status_tampil'    => 1,
        ]);

        return redirect()->route('artikel.show', $id_artikel)
            ->with('success', 'Komentar berhasil dikirim.')
            ->withFragment('comment_section');
    }

    // Hapus komentar (admin)
    public function destroy($id)
    {
        $komentar = Komentar::findOrFail($id);
        $komentar->delete();
        return redirect()->route('dashboard', ['menu' => 'menu_komentar'])
            ->with('success', 'Komentar berhasil dihapus.');
    }

    // Toggle status tampil komentar (admin)
    public function toggleStatus($id)
    {
        $komentar = Komentar::findOrFail($id);
        $komentar->status_tampil = !$komentar->status_tampil;
        $komentar->save();
        return redirect()->route('dashboard', ['menu' => 'menu_komentar'])
            ->with('success', 'Status komentar berhasil diubah.');
    }
}
