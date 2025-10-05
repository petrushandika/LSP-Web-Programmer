<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
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
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })->orWhereHas('catalogue', function ($q) use ($request) {
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

    // API Methods for Catalogue Management
    
    /**
     * API: Get catalogues with search and filter
     */
    public function apiCatalogues(Request $request): JsonResponse
    {
        try {
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

            $perPage = $request->get('per_page', 10);
            $catalogues = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $catalogues,
                'message' => 'Catalogues retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve catalogues: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Store new catalogue
     */
    public function apiStoreCatalogue(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'package_name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'status_publish' => 'required|in:Y,N',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();
            $data['user_id'] = Auth::id();

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('catalogues', $imageName, 'public');
                $data['image_url'] = Storage::url($imagePath);
            }

            $catalogue = Catalogue::create($data);

            return response()->json([
                'success' => true,
                'data' => $catalogue->load('user'),
                'message' => 'Catalogue created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create catalogue: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Update catalogue
     */
    public function apiUpdateCatalogue(Request $request, $id): JsonResponse
    {
        try {
            $catalogue = Catalogue::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'package_name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'status_publish' => 'required|in:Y,N',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($catalogue->image_url) {
                    $oldImagePath = str_replace('/storage/', '', $catalogue->image_url);
                    Storage::disk('public')->delete($oldImagePath);
                }

                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('catalogues', $imageName, 'public');
                $data['image_url'] = Storage::url($imagePath);
            }

            $catalogue->update($data);

            return response()->json([
                'success' => true,
                'data' => $catalogue->load('user'),
                'message' => 'Catalogue updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update catalogue: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Delete catalogue
     */
    public function apiDeleteCatalogue($id): JsonResponse
    {
        try {
            $catalogue = Catalogue::findOrFail($id);

            // Delete image if exists
            if ($catalogue->image_url) {
                $imagePath = str_replace('/storage/', '', $catalogue->image_url);
                Storage::disk('public')->delete($imagePath);
            }

            $catalogue->delete();

            return response()->json([
                'success' => true,
                'message' => 'Catalogue deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete catalogue: ' . $e->getMessage()
            ], 500);
        }
    }

    // API Methods for Order Management
    
    /**
     * API: Get orders with search and filter
     */
    public function apiOrders(Request $request): JsonResponse
    {
        try {
            $query = Order::with(['user', 'catalogue']);

            // Search functionality
            if ($request->has('search') && $request->search) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%');
                })->orWhereHas('catalogue', function ($q) use ($request) {
                    $q->where('package_name', 'like', '%' . $request->search . '%');
                });
            }

            // Filter functionality
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            $perPage = $request->get('per_page', 10);
            $orders = $query->orderBy('created_at', 'desc')->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $orders,
                'message' => 'Orders retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve orders: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Update order status
     */
    public function apiUpdateOrderStatus(Request $request, $id): JsonResponse
    {
        try {
            $order = Order::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'status' => 'required|in:pending,confirmed,completed,cancelled'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $order->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'data' => $order->load(['user', 'catalogue']),
                'message' => 'Order status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Get single order details
     */
    public function apiGetOrder($id): JsonResponse
    {
        try {
            $order = Order::with(['user', 'catalogue'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $order,
                'message' => 'Order retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve order: ' . $e->getMessage()
            ], 500);
        }
    }
}
