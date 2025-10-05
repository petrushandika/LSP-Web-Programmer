<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalCatalogues = Catalogue::count();
        
        return view('admin.dashboard', compact(
            'totalOrders', 
            'pendingOrders', 
            'completedOrders', 
            'totalCatalogues'
        ));
    }

    /**
     * Display catalogue management page
     */
    public function catalogues(Request $request)
    {
        $query = Catalogue::with('user');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('package_name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        // Filter functionality
        if ($request->has('status') && $request->status) {
            $query->where('status_publish', $request->status);
        }
        
        $catalogues = $query->paginate(10);
        
        return view('admin.catalogues', compact('catalogues'));
    }

    /**
     * Display order management page
     */
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'catalogue']);
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })->orWhereHas('catalogue', function($q) use ($request) {
                $q->where('package_name', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter functionality
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $orders = $query->paginate(10);
        
        return view('admin.orders', compact('orders'));
    }
}