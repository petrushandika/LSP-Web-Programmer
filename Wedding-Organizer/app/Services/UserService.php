<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Service untuk logika bisnis User
 * 
 * @package App\Services
 */
class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * Constructor
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Ambil semua user dengan pagination
     *
     * @param int $perPage
     * @param bool $withRelations
     * @return LengthAwarePaginator
     */
    public function getAllUsers(int $perPage = 15, bool $withRelations = false): LengthAwarePaginator
    {
        try {
            $relations = $withRelations ? ['catalogues', 'orders'] : [];
            return $this->userRepository->getAllPaginated($perPage, $relations);
        } catch (Exception $e) {
            Log::error('Error getting all users: ' . $e->getMessage());
            throw new Exception('Gagal mengambil data user');
        }
    }

    /**
     * Cari user berdasarkan ID
     *
     * @param int $id
     * @param bool $withRelations
     * @return User
     * @throws Exception
     */
    public function getUserById(int $id, bool $withRelations = false): User
    {
        try {
            $relations = $withRelations ? ['catalogues', 'orders'] : [];
            $user = $this->userRepository->findById($id, $relations);
            
            if (!$user) {
                throw new Exception('User tidak ditemukan');
            }

            return $user;
        } catch (Exception $e) {
            Log::error('Error getting user by ID: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Buat user baru
     *
     * @param array $data
     * @return User
     * @throws Exception
     */
    public function createUser(array $data): User
    {
        try {
            // Validasi email unik
            $existingUser = $this->userRepository->findByEmail($data['email']);
            if ($existingUser) {
                throw new Exception('Email sudah digunakan');
            }

            // Set default role jika tidak ada
            if (!isset($data['role'])) {
                $data['role'] = 'customer';
            }

            $user = $this->userRepository->create($data);
            
            Log::info('User created successfully', ['user_id' => $user->id]);
            return $user;
        } catch (Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update user
     *
     * @param int $id
     * @param array $data
     * @return User
     * @throws Exception
     */
    public function updateUser(int $id, array $data): User
    {
        try {
            $user = $this->getUserById($id);

            // Validasi email unik (kecuali untuk user yang sama)
            if (isset($data['email'])) {
                $existingUser = $this->userRepository->findByEmail($data['email']);
                if ($existingUser && $existingUser->id !== $user->id) {
                    throw new Exception('Email sudah digunakan');
                }
            }

            $updatedUser = $this->userRepository->update($user, $data);
            
            Log::info('User updated successfully', ['user_id' => $updatedUser->id]);
            return $updatedUser;
        } catch (Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Hapus user
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deleteUser(int $id): bool
    {
        try {
            $user = $this->getUserById($id);

            // Cek apakah user memiliki catalogue atau order
            $user->loadCount(['catalogues', 'orders']);
            
            if ($user->catalogues_count > 0) {
                throw new Exception('User tidak dapat dihapus karena memiliki catalogue');
            }

            if ($user->orders_count > 0) {
                throw new Exception('User tidak dapat dihapus karena memiliki order');
            }

            $result = $this->userRepository->delete($user);
            
            if ($result) {
                Log::info('User deleted successfully', ['user_id' => $id]);
            }

            return $result;
        } catch (Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Cari user berdasarkan role
     *
     * @param string $role
     * @param bool $withRelations
     * @return Collection
     */
    public function getUsersByRole(string $role, bool $withRelations = false): Collection
    {
        try {
            $relations = $withRelations ? ['catalogues', 'orders'] : [];
            return $this->userRepository->findByRole($role, $relations);
        } catch (Exception $e) {
            Log::error('Error getting users by role: ' . $e->getMessage());
            throw new Exception('Gagal mengambil data user berdasarkan role');
        }
    }

    /**
     * Cari user dengan filter
     *
     * @param array $filters
     * @param bool $withRelations
     * @return Collection
     */
    public function searchUsers(array $filters, bool $withRelations = false): Collection
    {
        try {
            $relations = $withRelations ? ['catalogues', 'orders'] : [];
            return $this->userRepository->findWithFilters($filters, $relations);
        } catch (Exception $e) {
            Log::error('Error searching users: ' . $e->getMessage());
            throw new Exception('Gagal mencari data user');
        }
    }

    /**
     * Ambil statistik user
     *
     * @return array
     */
    public function getUserStatistics(): array
    {
        try {
            $totalUsers = $this->userRepository->count();
            $adminUsers = $this->userRepository->findByRole('admin')->count();
            $customerUsers = $this->userRepository->findByRole('customer')->count();
            $vendorUsers = $this->userRepository->findByRole('vendor')->count();

            return [
                'total_users' => $totalUsers,
                'role_breakdown' => [
                    'admin' => $adminUsers,
                    'customer' => $customerUsers,
                    'vendor' => $vendorUsers,
                ],
                'percentage' => [
                    'admin' => $totalUsers > 0 ? round(($adminUsers / $totalUsers) * 100, 2) : 0,
                    'customer' => $totalUsers > 0 ? round(($customerUsers / $totalUsers) * 100, 2) : 0,
                    'vendor' => $totalUsers > 0 ? round(($vendorUsers / $totalUsers) * 100, 2) : 0,
                ]
            ];
        } catch (Exception $e) {
            Log::error('Error getting user statistics: ' . $e->getMessage());
            throw new Exception('Gagal mengambil statistik user');
        }
    }

    /**
     * Verifikasi email user
     *
     * @param int $id
     * @return User
     * @throws Exception
     */
    public function verifyUserEmail(int $id): User
    {
        try {
            $user = $this->getUserById($id);
            
            if ($user->email_verified_at) {
                throw new Exception('Email sudah terverifikasi');
            }

            $updatedUser = $this->userRepository->update($user, [
                'email_verified_at' => now()
            ]);

            Log::info('User email verified successfully', ['user_id' => $id]);
            return $updatedUser;
        } catch (Exception $e) {
            Log::error('Error verifying user email: ' . $e->getMessage());
            throw $e;
        }
    }
}