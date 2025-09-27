<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\CatalogueRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Service untuk logika bisnis Order
 * 
 * @package App\Services
 */
class OrderService
{
    /**
     * @var OrderRepositoryInterface
     */
    protected OrderRepositoryInterface $orderRepository;

    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @var CatalogueRepositoryInterface
     */
    protected CatalogueRepositoryInterface $catalogueRepository;

    /**
     * Constructor
     *
     * @param OrderRepositoryInterface $orderRepository
     * @param UserRepositoryInterface $userRepository
     * @param CatalogueRepositoryInterface $catalogueRepository
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        UserRepositoryInterface $userRepository,
        CatalogueRepositoryInterface $catalogueRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->catalogueRepository = $catalogueRepository;
    }

    /**
     * Ambil semua order dengan pagination
     *
     * @param int $perPage
     * @param bool $withRelations
     * @return LengthAwarePaginator
     */
    public function getAllOrders(int $perPage = 15, bool $withRelations = false): LengthAwarePaginator
    {
        try {
            $relations = $withRelations ? ['user', 'catalogue'] : [];
            return $this->orderRepository->getAllPaginated($perPage, $relations);
        } catch (Exception $e) {
            Log::error('Error getting all orders: ' . $e->getMessage());
            throw new Exception('Gagal mengambil data order');
        }
    }

    /**
     * Cari order berdasarkan ID
     *
     * @param int $id
     * @param bool $withRelations
     * @return Order
     * @throws Exception
     */
    public function getOrderById(int $id, bool $withRelations = false): Order
    {
        try {
            $relations = $withRelations ? ['user', 'catalogue'] : [];
            $order = $this->orderRepository->findById($id, $relations);
            
            if (!$order) {
                throw new Exception('Order tidak ditemukan');
            }

            return $order;
        } catch (Exception $e) {
            Log::error('Error getting order by ID: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Buat order baru
     *
     * @param array $data
     * @return Order
     * @throws Exception
     */
    public function createOrder(array $data): Order
    {
        try {
            // Validasi user exists
            $user = $this->userRepository->findById($data['user_id']);
            if (!$user) {
                throw new Exception('User tidak ditemukan');
            }

            // Validasi catalogue exists dan published
            $catalogue = $this->catalogueRepository->findById($data['catalogue_id']);
            if (!$catalogue) {
                throw new Exception('Catalogue tidak ditemukan');
            }

            if (!$catalogue->is_publish) {
                throw new Exception('Catalogue tidak tersedia untuk dipesan');
            }

            // Set default values
            if (!isset($data['status'])) {
                $data['status'] = 'pending';
            }

            if (!isset($data['order_date'])) {
                $data['order_date'] = now()->toDateString();
            }

            $order = $this->orderRepository->create($data);
            
            Log::info('Order created successfully', ['order_id' => $order->id]);
            return $order;
        } catch (Exception $e) {
            Log::error('Error creating order: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update order
     *
     * @param int $id
     * @param array $data
     * @return Order
     * @throws Exception
     */
    public function updateOrder(int $id, array $data): Order
    {
        try {
            $order = $this->getOrderById($id);

            // Validasi user exists jika user_id diubah
            if (isset($data['user_id'])) {
                $user = $this->userRepository->findById($data['user_id']);
                if (!$user) {
                    throw new Exception('User tidak ditemukan');
                }
            }

            // Validasi catalogue exists jika catalogue_id diubah
            if (isset($data['catalogue_id'])) {
                $catalogue = $this->catalogueRepository->findById($data['catalogue_id']);
                if (!$catalogue) {
                    throw new Exception('Catalogue tidak ditemukan');
                }
            }

            // Validasi perubahan status
            if (isset($data['status'])) {
                $this->validateStatusTransition($order->status, $data['status']);
            }

            $updatedOrder = $this->orderRepository->update($order, $data);
            
            Log::info('Order updated successfully', ['order_id' => $updatedOrder->id]);
            return $updatedOrder;
        } catch (Exception $e) {
            Log::error('Error updating order: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Hapus order
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deleteOrder(int $id): bool
    {
        try {
            $order = $this->getOrderById($id);

            // Hanya order dengan status pending atau cancelled yang bisa dihapus
            if (!in_array($order->status, ['pending', 'cancelled'])) {
                throw new Exception('Order dengan status ' . $order->status . ' tidak dapat dihapus');
            }

            $result = $this->orderRepository->delete($order);
            
            if ($result) {
                Log::info('Order deleted successfully', ['order_id' => $id]);
            }

            return $result;
        } catch (Exception $e) {
            Log::error('Error deleting order: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Cari order berdasarkan user ID
     *
     * @param int $userId
     * @param bool $withRelations
     * @return Collection
     */
    public function getOrdersByUserId(int $userId, bool $withRelations = false): Collection
    {
        try {
            $relations = $withRelations ? ['user', 'catalogue'] : [];
            return $this->orderRepository->findByUserId($userId, $relations);
        } catch (Exception $e) {
            Log::error('Error getting orders by user ID: ' . $e->getMessage());
            throw new Exception('Gagal mengambil data order berdasarkan user');
        }
    }

    /**
     * Cari order berdasarkan catalogue ID
     *
     * @param int $catalogueId
     * @param bool $withRelations
     * @return Collection
     */
    public function getOrdersByCatalogueId(int $catalogueId, bool $withRelations = false): Collection
    {
        try {
            $relations = $withRelations ? ['user', 'catalogue'] : [];
            return $this->orderRepository->findByCatalogueId($catalogueId, $relations);
        } catch (Exception $e) {
            Log::error('Error getting orders by catalogue ID: ' . $e->getMessage());
            throw new Exception('Gagal mengambil data order berdasarkan catalogue');
        }
    }

    /**
     * Cari order berdasarkan status
     *
     * @param string $status
     * @param bool $withRelations
     * @return Collection
     */
    public function getOrdersByStatus(string $status, bool $withRelations = false): Collection
    {
        try {
            $relations = $withRelations ? ['user', 'catalogue'] : [];
            return $this->orderRepository->findByStatus($status, $relations);
        } catch (Exception $e) {
            Log::error('Error getting orders by status: ' . $e->getMessage());
            throw new Exception('Gagal mengambil data order berdasarkan status');
        }
    }

    /**
     * Cari order dengan filter
     *
     * @param array $filters
     * @param bool $withRelations
     * @return Collection
     */
    public function searchOrders(array $filters, bool $withRelations = false): Collection
    {
        try {
            $relations = $withRelations ? ['user', 'catalogue'] : [];
            return $this->orderRepository->findWithFilters($filters, $relations);
        } catch (Exception $e) {
            Log::error('Error searching orders: ' . $e->getMessage());
            throw new Exception('Gagal mencari data order');
        }
    }

    /**
     * Ambil statistik order
     *
     * @return array
     */
    public function getOrderStatistics(): array
    {
        try {
            return $this->orderRepository->getStatistics();
        } catch (Exception $e) {
            Log::error('Error getting order statistics: ' . $e->getMessage());
            throw new Exception('Gagal mengambil statistik order');
        }
    }

    /**
     * Approve order
     *
     * @param int $id
     * @return Order
     * @throws Exception
     */
    public function approveOrder(int $id): Order
    {
        try {
            $order = $this->getOrderById($id);
            
            if ($order->status !== 'pending') {
                throw new Exception('Hanya order dengan status pending yang dapat disetujui');
            }

            $updatedOrder = $this->orderRepository->update($order, [
                'status' => 'approved'
            ]);

            Log::info('Order approved successfully', ['order_id' => $id]);
            return $updatedOrder;
        } catch (Exception $e) {
            Log::error('Error approving order: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Reject order
     *
     * @param int $id
     * @param string|null $notes
     * @return Order
     * @throws Exception
     */
    public function rejectOrder(int $id, ?string $notes = null): Order
    {
        try {
            $order = $this->getOrderById($id);
            
            if ($order->status !== 'pending') {
                throw new Exception('Hanya order dengan status pending yang dapat ditolak');
            }

            $updateData = ['status' => 'rejected'];
            if ($notes) {
                $updateData['notes'] = $notes;
            }

            $updatedOrder = $this->orderRepository->update($order, $updateData);

            Log::info('Order rejected successfully', ['order_id' => $id]);
            return $updatedOrder;
        } catch (Exception $e) {
            Log::error('Error rejecting order: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Complete order
     *
     * @param int $id
     * @return Order
     * @throws Exception
     */
    public function completeOrder(int $id): Order
    {
        try {
            $order = $this->getOrderById($id);
            
            if ($order->status !== 'approved') {
                throw new Exception('Hanya order dengan status approved yang dapat diselesaikan');
            }

            $updatedOrder = $this->orderRepository->update($order, [
                'status' => 'completed'
            ]);

            Log::info('Order completed successfully', ['order_id' => $id]);
            return $updatedOrder;
        } catch (Exception $e) {
            Log::error('Error completing order: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Cancel order
     *
     * @param int $id
     * @param string|null $notes
     * @return Order
     * @throws Exception
     */
    public function cancelOrder(int $id, ?string $notes = null): Order
    {
        try {
            $order = $this->getOrderById($id);
            
            if (in_array($order->status, ['completed', 'cancelled'])) {
                throw new Exception('Order dengan status ' . $order->status . ' tidak dapat dibatalkan');
            }

            $updateData = ['status' => 'cancelled'];
            if ($notes) {
                $updateData['notes'] = $notes;
            }

            $updatedOrder = $this->orderRepository->update($order, $updateData);

            Log::info('Order cancelled successfully', ['order_id' => $id]);
            return $updatedOrder;
        } catch (Exception $e) {
            Log::error('Error cancelling order: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Validasi transisi status
     *
     * @param string $currentStatus
     * @param string $newStatus
     * @throws Exception
     */
    private function validateStatusTransition(string $currentStatus, string $newStatus): void
    {
        $allowedTransitions = [
            'pending' => ['approved', 'rejected', 'cancelled'],
            'approved' => ['completed', 'cancelled'],
            'rejected' => [],
            'completed' => [],
            'cancelled' => []
        ];

        if (!isset($allowedTransitions[$currentStatus]) || 
            !in_array($newStatus, $allowedTransitions[$currentStatus])) {
            throw new Exception("Transisi status dari {$currentStatus} ke {$newStatus} tidak diizinkan");
        }
    }
}