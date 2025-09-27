<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

/**
 * Repository untuk operasi database User
 * 
 * @package App\Repositories
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    protected User $model;

    /**
     * Constructor
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Ambil semua user dengan pagination
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
     * Ambil semua user tanpa pagination
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
     * Cari user berdasarkan ID
     *
     * @param int $id
     * @param array $relations
     * @return User|null
     */
    public function findById(int $id, array $relations = []): ?User
    {
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->find($id);
    }

    /**
     * Cari user berdasarkan email
     *
     * @param string $email
     * @param array $relations
     * @return User|null
     */
    public function findByEmail(string $email, array $relations = []): ?User
    {
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->where('email', $email)->first();
    }

    /**
     * Buat user baru
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        // Hash password jika ada
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->model->create($data);
    }

    /**
     * Update user
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function update(User $user, array $data): User
    {
        // Hash password jika ada dan tidak kosong
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Hapus password dari data jika kosong
            unset($data['password']);
        }

        $user->update($data);
        return $user->fresh();
    }

    /**
     * Hapus user
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->delete();
    }

    /**
     * Cari user berdasarkan role
     *
     * @param string $role
     * @param array $relations
     * @return Collection
     */
    public function findByRole(string $role, array $relations = []): Collection
    {
        $query = $this->model->newQuery();

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->where('role', $role)->get();
    }

    /**
     * Hitung total user
     *
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * Cari user dengan filter
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

        // Filter berdasarkan nama
        if (isset($filters['name']) && !empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        // Filter berdasarkan email
        if (isset($filters['email']) && !empty($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }

        // Filter berdasarkan role
        if (isset($filters['role']) && !empty($filters['role'])) {
            $query->where('role', $filters['role']);
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
}