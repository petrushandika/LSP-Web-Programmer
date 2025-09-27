<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Resources\UserResource;
use App\Services\UserService;
use App\Exceptions\CustomException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * API Controller untuk User
 * 
 * @package App\Http\Controllers\Api
 */
class UserApiController extends Controller
{
    /**
     * @var UserService
     */
    protected UserService $userService;

    /**
     * Constructor
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of users
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 10);
            $users = $this->userService->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data user berhasil diambil',
                'data' => UserResource::collection($users->items()),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                    'last_page' => $users->lastPage(),
                    'from' => $users->firstItem(),
                    'to' => $users->lastItem(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mengambil data user');
        }
    }

    /**
     * Store a newly created user
     *
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dibuat',
                'data' => new UserResource($user)
            ], 201);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            throw CustomException::serverError('Gagal membuat user');
        }
    }

    /**
     * Display the specified user
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->userService->findById($id);

            return response()->json([
                'success' => true,
                'message' => 'Data user berhasil diambil',
                'data' => new UserResource($user)
            ]);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error fetching user: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mengambil data user');
        }
    }

    /**
     * Update the specified user
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        try {
            $user = $this->userService->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'User berhasil diperbarui',
                'data' => new UserResource($user)
            ]);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            throw CustomException::serverError('Gagal memperbarui user');
        }
    }

    /**
     * Remove the specified user
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->userService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            throw CustomException::serverError('Gagal menghapus user');
        }
    }

    /**
     * Search users with filters
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $filters = $request->only(['name', 'email', 'role', 'created_from', 'created_to']);
            $perPage = $request->get('per_page', 10);
            
            $users = $this->userService->search($filters, $perPage);

            return response()->json([
                'success' => true,
                'message' => 'Pencarian user berhasil',
                'data' => UserResource::collection($users->items()),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                    'last_page' => $users->lastPage(),
                    'from' => $users->firstItem(),
                    'to' => $users->lastItem(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error searching users: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mencari user');
        }
    }

    /**
     * Get users by role
     *
     * @param string $role
     * @param Request $request
     * @return JsonResponse
     */
    public function getByRole(string $role, Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 10);
            $users = $this->userService->findByRole($role, $perPage);

            return response()->json([
                'success' => true,
                'message' => "Data user dengan role {$role} berhasil diambil",
                'data' => UserResource::collection($users->items()),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                    'last_page' => $users->lastPage(),
                    'from' => $users->firstItem(),
                    'to' => $users->lastItem(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching users by role: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mengambil data user');
        }
    }

    /**
     * Get user statistics
     *
     * @return JsonResponse
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->userService->getStatistics();

            return response()->json([
                'success' => true,
                'message' => 'Statistik user berhasil diambil',
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching user statistics: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mengambil statistik user');
        }
    }
}