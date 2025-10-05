<?php

namespace App\Repositories;

use App\Models\Catalogue;
use App\Repositories\Contracts\CatalogueRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Repository untuk operasi database Catalogue
 * 
 * @package App\Repositories
 */
class CatalogueRepository implements CatalogueRepositoryInterface
{
    /**
     * @var Catalogue
     */
    protected Catalogue $model;

    /**
     * Constructor
     *
     * @param Catalogue $model
     */
    public function __construct(Catalogue $model)
    {
        $this->model = $model;
    }

    /**
     * Ambil semua catalogue dengan pagination
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
     * Ambil semua catalogue tanpa pagination
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
     * Cari catalogue berdasarkan ID
     *
     * @param int $id
     * @param array $relations
     * @return Catalogue|null
     */
    public function findById(int $id, array $relations = []): ?Catalogue
    {
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->find($id);
    }

    /**
     * Buat catalogue baru
     *
     * @param array $data
     * @return Catalogue
     */
    public function create(array $data): Catalogue
    {
        return $this->model->create($data);
    }

    /**
     * Update catalogue
     *
     * @param Catalogue $catalogue
     * @param array $data
     * @return Catalogue
     */
    public function update(Catalogue $catalogue, array $data): Catalogue
    {
        $catalogue->update($data);
        return $catalogue->fresh();
    }

    /**
     * Hapus catalogue
     *
     * @param Catalogue $catalogue
     * @return bool
     */
    public function delete(Catalogue $catalogue): bool
    {
        return $catalogue->delete();
    }

    /**
     * Ambil catalogue yang dipublish
     *
     * @param array $relations
     * @return Collection
     */
    public function getPublished(array $relations = []): Collection
    {
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->where('is_publish', true)->latest()->get();
    }

    /**
     * Cari catalogue berdasarkan user ID
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
     * Hitung total catalogue
     *
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * Hitung catalogue berdasarkan status publish
     *
     * @param bool $isPublish
     * @return int
     */
    public function countByPublishStatus(bool $isPublish): int
    {
        return $this->model->where('is_publish', $isPublish)->count();
    }

    /**
     * Cari catalogue dengan filter
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

        // Filter berdasarkan package_name
        if (isset($filters['package_name']) && !empty($filters['package_name'])) {
            $query->where('package_name', 'like', '%' . $filters['package_name'] . '%');
        }

        // Filter berdasarkan user_id
        if (isset($filters['user_id']) && !empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        // Filter berdasarkan status publish
        if (isset($filters['is_publish']) && $filters['is_publish'] !== '') {
            $query->where('is_publish', (bool) $filters['is_publish']);
        }

        // Filter berdasarkan range harga
        if (isset($filters['min_price']) && !empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (isset($filters['max_price']) && !empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
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
     * Cari catalogue berdasarkan range harga
     *
     * @param float|null $minPrice
     * @param float|null $maxPrice
     * @param array $relations
     * @return Collection
     */
    public function findByPriceRange(?float $minPrice, ?float $maxPrice, array $relations = []): Collection
    {
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            $query->with($relations);
        }

        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query->latest()->get();
    }
}