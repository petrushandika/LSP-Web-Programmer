<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface untuk User Repository
 * 
 * @package App\Repositories\Contracts
 */
interface UserRepositoryInterface
{
    /**
     * Ambil semua user dengan pagination
     *
     * @param int $perPage
     * @param array $relations
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 15, array $relations = []): LengthAwarePaginator;

    /**
     * Ambil semua user tanpa pagination
     *
     * @param array $relations
     * @return Collection
     */
    public function getAll(array $relations = []): Collection;

    /**
     * Cari user berdasarkan ID
     *
     * @param int $id
     * @param array $relations
     * @return User|null
     */
    public function findById(int $id, array $relations = []): ?User;

    /**
     * Cari user berdasarkan email
     *
     * @param string $email
     * @param array $relations
     * @return User|null
     */
    public function findByEmail(string $email, array $relations = []): ?User;

    /**
     * Buat user baru
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User;

    /**
     * Update user
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function update(User $user, array $data): User;

    /**
     * Hapus user
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool;

    /**
     * Cari user berdasarkan role
     *
     * @param string $role
     * @param array $relations
     * @return Collection
     */
    public function findByRole(string $role, array $relations = []): Collection;

    /**
     * Hitung total user
     *
     * @return int
     */
    public function count(): int;

    /**
     * Cari user dengan filter
     *
     * @param array $filters
     * @param array $relations
     * @return Collection
     */
    public function findWithFilters(array $filters, array $relations = []): Collection;
}