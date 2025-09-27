<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Catalogue;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['user', 'catalogue'])->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $catalogues = Catalogue::where('status_publish', 'Y')->get();
        return view('orders.create', compact('users', 'catalogues'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'catalogue_id' => 'required|exists:catalogues,catalogue_id',
            'order_date' => 'required|date',
            'status' => 'required|in:requested,approved',
            'total_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        Order::create($validated);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'catalogue']);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $users = User::all();
        $catalogues = Catalogue::where('status_publish', 'Y')->get();
        return view('orders.edit', compact('order', 'users', 'catalogues'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'catalogue_id' => 'required|exists:catalogues,catalogue_id',
            'order_date' => 'required|date',
            'status' => 'required|in:requested,approved',
            'total_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $order->update($validated);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
