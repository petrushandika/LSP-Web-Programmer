<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catalogues = Catalogue::with('user')->paginate(10);
        return view('catalogues.index', compact('catalogues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('catalogues.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_publish' => 'required|in:Y,N',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('catalogues', 'public');
        }

        Catalogue::create($validated);

        return redirect()->route('catalogues.index')->with('success', 'Katalog berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Catalogue $catalogue)
    {
        $catalogue->load('user');
        return view('catalogues.show', compact('catalogue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Catalogue $catalogue)
    {
        $users = User::all();
        return view('catalogues.edit', compact('catalogue', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Catalogue $catalogue)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_publish' => 'required|in:Y,N',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($catalogue->image) {
                Storage::disk('public')->delete($catalogue->image);
            }
            $validated['image'] = $request->file('image')->store('catalogues', 'public');
        }

        $catalogue->update($validated);

        return redirect()->route('catalogues.index')->with('success', 'Katalog berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Catalogue $catalogue)
    {
        // Delete image if exists
        if ($catalogue->image) {
            Storage::disk('public')->delete($catalogue->image);
        }

        $catalogue->delete();
        return redirect()->route('catalogues.index')->with('success', 'Katalog berhasil dihapus.');
    }
}
