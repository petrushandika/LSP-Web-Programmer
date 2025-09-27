<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface untuk Order Repository
 * 
 * @package App\Repositories\Contracts
 */
interface OrderRepositoryInterface
{
    /**
     * Ambil semua order dengan pagination
     *
     * @param int $perPage
     * @param array $relations
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 15, array $relations = []): LengthAwarePaginator;

    /**
     * Ambil semua order tanpa pagination
     *
     * @param array $relations
     * @return Collection
     */
    public function getAll(array $relations = []): Collection;

    /**
     * Cari order berdasarkan ID
     *
     * @param int $id
     * @param array $relations
     * @return Order|null
     */
    public function findById(int $id, array $relations = []): ?Order;

    /**
     * Buat order baru
     *
     * @param array $data
     * @return Order
     */
    public function create(array $data): Order;

    /**
     * Update order
     *
     * @param Order $order
     * @param array $data
     * @return Order
     */
    public function update(Order $order, array $data): Order;

    /**
     * Hapus order
     *
     * @param Order $order
     * @return bool
     */
    public function delete(Order $order): bool;

    /**
     * Cari order berdasarkan user ID
     *
     * @param int $userId
     * @param array $relations
     * @return Collection
     */
    public function findByUserId(int $userId, array $relations = []): Collection;

    /**
     * Cari order berdasarkan catalogue ID
     *
     * @param int $catalogueId
     * @param array $relations
     * @return Collection
     */
    public function findByCatalogueId(int $catalogueId, array $relations = []): Collection;

    /**
     * Cari order berdasarkan status
     *
     * @param string $status
     * @param array $relations
     * @return Collection
     */
    public function findByStatus(string $status, array $relations = []): Collection;

    /**
     * Hitung total order
     *
     * @return int
     */
    public function count(): int;

    /**
     * Hitung order berdasarkan status
     *
     * @param string $status
     * @return int
     */
    public function countByStatus(string $status): int;

    /**
     * Ambil statistik order
     *
     * @return array
     */
    public function getStatistics(): array;

    /**
     * Cari order dengan filter
     *
     * @param array $filters
     * @param array $relations
     * @return Collection
     */
    public function findWithFilters(array $filters, array $relations = []): Collection;

    /**
     * Cari order berdasarkan range tanggal
     *
     * @param string|null $startDate
     * @param string|null $endDate
     * @param array $relations
     * @return Collection
     */
    public function findByDateRange(?string $startDate, ?string $endDate, array $relations = []): Collection;
}