<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Repository untuk operasi database Order
 * 
 * @package App\Repositories
 */
class OrderRepository implements OrderRepositoryInterface
{
    /**
     * @var Order
     */
    protected Order $model;

    /**
     * Constructor
     *
     * @param Order $model
     */
    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    /**
     * Ambil semua order dengan pagination
     *
     * @param int $perPage
     * @param array $relations
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 15, array $relations = []): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Ambil semua order tanpa pagination
     *
     * @param array $relations
     * @return Collection
     */
    public function getAll(array $relations = []): Collection
    {
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->latest()->get();
    }

    /**
     * Cari order berdasarkan ID
     *
     * @param int $id
     * @param array $relations
     * @return Order|null
     */
    public function findById(int $id, array $relations = []): ?Order
    {
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->find($id);
    }

    /**
     * Buat order baru
     *
     * @param array $data
     * @return Order
     */
    public function create(array $data): Order
    {
        return $this->model->create($data);
    }

    /**
     * Update order
     *
     * @param Order $order
     * @param array $data
     * @return Order
     */
    public function update(Order $order, array $data): Order
    {
        $order->update($data);
        return $order->fresh();
    }

    /**
     * Hapus order
     *
     * @param Order $order
     * @return bool
     */
    public function delete(Order $order): bool
    {
        return $order->delete();
    }

    /**
     * Cari order berdasarkan user ID
     *
     * @param int $userId
     * @param array $relations
     * @return Collection
     */
    public function findByUserId(int $userId, array $relations = []): Collection
    {
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->where('user_id', $userId)->latest()->get();
    }

    /**
     * Cari order berdasarkan catalogue ID
     *
     * @param int $catalogueId
     * @param array $relations
     * @return Collection
     */
    public function findByCatalogueId(int $catalogueId, array $relations = []): Collection
    {
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->where('catalogue_id', $catalogueId)->latest()->get();
    }

    /**
     * Cari order berdasarkan status
     *
     * @param string $status
     * @param array $relations
     * @return Collection
     */
    public function findByStatus(string $status, array $relations = []): Collection
    {
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->where('status', $status)->latest()->get();
    }

    /**
     * Hitung total order
     *
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * Hitung order berdasarkan status
     *
     * @param string $status
     * @return int
     */
    public function countByStatus(string $status): int
    {
        return $this->model->where('status', $status)->count();
    }

    /**
     * Ambil statistik order
     *
     * @return array
     */
    public function getStatistics(): array
    {
        $totalOrders = $this->count();
        
        $statusCounts = $this->model
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $monthlyOrders = $this->model
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('count(*) as count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get()
            ->toArray();

        return [
            'total_orders' => $totalOrders,
            'status_breakdown' => [
                'pending' => $statusCounts['pending'] ?? 0,
                'approved' => $statusCounts['approved'] ?? 0,
                'rejected' => $statusCounts['rejected'] ?? 0,
                'completed' => $statusCounts['completed'] ?? 0,
                'cancelled' => $statusCounts['cancelled'] ?? 0,
            ],
            'monthly_orders' => $monthlyOrders,
        ];
    }

    /**
     * Cari order dengan filter
     *
     * @param array $filters
     * @param array $relations
     * @return Collection
     */
    public function findWithFilters(array $filters, array $relations = []): Collection
    {
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            $query->with($relations);
        }

        // Filter berdasarkan user_id
        if (isset($filters['user_id']) && !empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        // Filter berdasarkan catalogue_id
        if (isset($filters['catalogue_id']) && !empty($filters['catalogue_id'])) {
            $query->where('catalogue_id', $filters['catalogue_id']);
        }

        // Filter berdasarkan status
        if (isset($filters['status']) && !empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter berdasarkan tanggal order
        if (isset($filters['order_date_from']) && !empty($filters['order_date_from'])) {
            $query->whereDate('order_date', '>=', $filters['order_date_from']);
        }

        if (isset($filters['order_date_to']) && !empty($filters['order_date_to'])) {
            $query->whereDate('order_date', '<=', $filters['order_date_to']);
        }

        // Filter berdasarkan tanggal dibuat
        if (isset($filters['created_from']) && !empty($filters['created_from'])) {
            $query->whereDate('created_at', '>=', $filters['created_from']);
        }

        if (isset($filters['created_to']) && !empty($filters['created_to'])) {
            $query->whereDate('created_at', '<=', $filters['created_to']);
        }

        return $query->latest()->get();
    }

    /**
     * Cari order berdasarkan range tanggal
     *
     * @param string|null $startDate
     * @param string|null $endDate
     * @param array $relations
     * @return Collection
     */
    public function findByDateRange(?string $startDate, ?string $endDate, array $relations = []): Collection
    {
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            $query->with($relations);
        }

        if ($startDate !== null) {
            $query->whereDate('order_date', '>=', $startDate);
        }

        if ($endDate !== null) {
            $query->whereDate('order_date', '<=', $endDate);
        }

        return $query->latest()->get();
    }
}