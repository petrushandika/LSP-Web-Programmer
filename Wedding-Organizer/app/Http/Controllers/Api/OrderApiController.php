<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Resources\OrderResource;
use App\Services\OrderService;
use App\Exceptions\CustomException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * API Controller untuk Order
 * 
 * @package App\Http\Controllers\Api
 */
class OrderApiController extends Controller
{
    /**
     * @var OrderService
     */
    protected OrderService $orderService;

    /**
     * Constructor
     *
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of orders
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 10);
            $orders = $this->orderService->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data order berhasil diambil',
                'data' => OrderResource::collection($orders->items()),
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'per_page' => $orders->perPage(),
                    'total' => $orders->total(),
                    'last_page' => $orders->lastPage(),
                    'from' => $orders->firstItem(),
                    'to' => $orders->lastItem(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching orders: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mengambil data order');
        }
    }

    /**
     * Store a newly created order
     *
     * @param CreateOrderRequest $request
     * @return JsonResponse
     */
    public function store(CreateOrderRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->createOrder($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil dibuat',
                'data' => new OrderResource($order)
            ], 201);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error creating order: ' . $e->getMessage());
            throw CustomException::serverError('Gagal membuat order');
        }
    }

    /**
     * Display the specified order
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $order = $this->orderService->findById($id);

            return response()->json([
                'success' => true,
                'message' => 'Data order berhasil diambil',
                'data' => new OrderResource($order)
            ]);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error fetching order: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mengambil data order');
        }
    }

    /**
     * Update the specified order
     *
     * @param UpdateOrderRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateOrderRequest $request, int $id): JsonResponse
    {
        try {
            $order = $this->orderService->updateOrder($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil diperbarui',
                'data' => new OrderResource($order)
            ]);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error updating order: ' . $e->getMessage());
            throw CustomException::serverError('Gagal memperbarui order');
        }
    }

    /**
     * Remove the specified order
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->orderService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil dihapus'
            ]);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error deleting order: ' . $e->getMessage());
            throw CustomException::serverError('Gagal menghapus order');
        }
    }

    /**
     * Get orders by user
     *
     * @param int $userId
     * @param Request $request
     * @return JsonResponse
     */
    public function getByUser(int $userId, Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 10);
            $orders = $this->orderService->findByUserId($userId, $perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data order user berhasil diambil',
                'data' => OrderResource::collection($orders->items()),
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'per_page' => $orders->perPage(),
                    'total' => $orders->total(),
                    'last_page' => $orders->lastPage(),
                    'from' => $orders->firstItem(),
                    'to' => $orders->lastItem(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching user orders: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mengambil data order user');
        }
    }

    /**
     * Get orders by catalogue
     *
     * @param int $catalogueId
     * @param Request $request
     * @return JsonResponse
     */
    public function getByCatalogue(int $catalogueId, Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 10);
            $orders = $this->orderService->findByCatalogueId($catalogueId, $perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data order katalog berhasil diambil',
                'data' => OrderResource::collection($orders->items()),
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'per_page' => $orders->perPage(),
                    'total' => $orders->total(),
                    'last_page' => $orders->lastPage(),
                    'from' => $orders->firstItem(),
                    'to' => $orders->lastItem(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching catalogue orders: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mengambil data order katalog');
        }
    }

    /**
     * Get orders by status
     *
     * @param string $status
     * @param Request $request
     * @return JsonResponse
     */
    public function getByStatus(string $status, Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 10);
            $orders = $this->orderService->findByStatus($status, $perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data order berdasarkan status berhasil diambil',
                'data' => OrderResource::collection($orders->items()),
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'per_page' => $orders->perPage(),
                    'total' => $orders->total(),
                    'last_page' => $orders->lastPage(),
                    'from' => $orders->firstItem(),
                    'to' => $orders->lastItem(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching orders by status: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mengambil data order berdasarkan status');
        }
    }

    /**
     * Search orders with filters
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $filters = $request->only(['user_id', 'catalogue_id', 'status', 'order_date', 'created_from', 'created_to']);
            $perPage = $request->get('per_page', 10);
            
            $orders = $this->orderService->search($filters, $perPage);

            return response()->json([
                'success' => true,
                'message' => 'Pencarian order berhasil',
                'data' => OrderResource::collection($orders->items()),
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'per_page' => $orders->perPage(),
                    'total' => $orders->total(),
                    'last_page' => $orders->lastPage(),
                    'from' => $orders->firstItem(),
                    'to' => $orders->lastItem(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error searching orders: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mencari order');
        }
    }

    /**
     * Approve order
     *
     * @param int $id
     * @return JsonResponse
     */
    public function approve(int $id): JsonResponse
    {
        try {
            $order = $this->orderService->approve($id);

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil disetujui',
                'data' => new OrderResource($order)
            ]);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error approving order: ' . $e->getMessage());
            throw CustomException::serverError('Gagal menyetujui order');
        }
    }

    /**
     * Reject order
     *
     * @param int $id
     * @return JsonResponse
     */
    public function reject(int $id): JsonResponse
    {
        try {
            $order = $this->orderService->reject($id);

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil ditolak',
                'data' => new OrderResource($order)
            ]);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error rejecting order: ' . $e->getMessage());
            throw CustomException::serverError('Gagal menolak order');
        }
    }

    /**
     * Complete order
     *
     * @param int $id
     * @return JsonResponse
     */
    public function complete(int $id): JsonResponse
    {
        try {
            $order = $this->orderService->complete($id);

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil diselesaikan',
                'data' => new OrderResource($order)
            ]);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error completing order: ' . $e->getMessage());
            throw CustomException::serverError('Gagal menyelesaikan order');
        }
    }

    /**
     * Cancel order
     *
     * @param int $id
     * @return JsonResponse
     */
    public function cancel(int $id): JsonResponse
    {
        try {
            $order = $this->orderService->cancel($id);

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil dibatalkan',
                'data' => new OrderResource($order)
            ]);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error canceling order: ' . $e->getMessage());
            throw CustomException::serverError('Gagal membatalkan order');
        }
    }

    /**
     * Get order statistics
     *
     * @return JsonResponse
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->orderService->getStatistics();

            return response()->json([
                'success' => true,
                'message' => 'Statistik order berhasil diambil',
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching order statistics: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mengambil statistik order');
        }
    }
}