<?php

namespace App\Repositories\Contracts;

use App\Models\Catalogue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface untuk Catalogue Repository
 * 
 * @package App\Repositories\Contracts
 */
interface CatalogueRepositoryInterface
{
    /**
     * Ambil semua catalogue dengan pagination
     *
     * @param int $perPage
     * @param array $relations
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 15, array $relations = []): LengthAwarePaginator;

    /**
     * Ambil semua catalogue tanpa pagination
     *
     * @param array $relations
     * @return Collection
     */
    public function getAll(array $relations = []): Collection;

    /**
     * Cari catalogue berdasarkan ID
     *
     * @param int $id
     * @param array $relations
     * @return Catalogue|null
     */
    public function findById(int $id, array $relations = []): ?Catalogue;

    /**
     * Buat catalogue baru
     *
     * @param array $data
     * @return Catalogue
     */
    public function create(array $data): Catalogue;

    /**
     * Update catalogue
     *
     * @param Catalogue $catalogue
     * @param array $data
     * @return Catalogue
     */
    public function update(Catalogue $catalogue, array $data): Catalogue;

    /**
     * Hapus catalogue
     *
     * @param Catalogue $catalogue
     * @return bool
     */
    public function delete(Catalogue $catalogue): bool;

    /**
     * Ambil catalogue yang dipublish
     *
     * @param array $relations
     * @return Collection
     */
    public function getPublished(array $relations = []): Collection;

    /**
     * Cari catalogue berdasarkan user ID
     *
     * @param int $userId
     * @param array $relations
     * @return Collection
     */
    public function findByUserId(int $userId, array $relations = []): Collection;

    /**
     * Hitung total catalogue
     *
     * @return int
     */
    public function count(): int;

    /**
     * Hitung catalogue berdasarkan status publish
     *
     * @param bool $isPublish
     * @return int
     */
    public function countByPublishStatus(bool $isPublish): int;

    /**
     * Cari catalogue dengan filter
     *
     * @param array $filters
     * @param array $relations
     * @return Collection
     */
    public function findWithFilters(array $filters, array $relations = []): Collection;

    /**
     * Cari catalogue berdasarkan range harga
     *
     * @param float|null $minPrice
     * @param float|null $maxPrice
     * @param array $relations
     * @return Collection
     */
    public function findByPriceRange(?float $minPrice, ?float $maxPrice, array $relations = []): Collection;
}