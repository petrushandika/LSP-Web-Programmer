<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogue\CreateCatalogueRequest;
use App\Http\Requests\Catalogue\UpdateCatalogueRequest;
use App\Resources\CatalogueResource;
use App\Services\CatalogueService;
use App\Exceptions\CustomException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * API Controller untuk Catalogue
 * 
 * @package App\Http\Controllers\Api
 */
class CatalogueApiController extends Controller
{
    /**
     * @var CatalogueService
     */
    protected CatalogueService $catalogueService;

    /**
     * Constructor
     *
     * @param CatalogueService $catalogueService
     */
    public function __construct(CatalogueService $catalogueService)
    {
        $this->catalogueService = $catalogueService;
    }

    /**
     * Display a listing of catalogues
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 10);
            $catalogues = $this->catalogueService->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data katalog berhasil diambil',
                'data' => CatalogueResource::collection($catalogues->items()),
                'pagination' => [
                    'current_page' => $catalogues->currentPage(),
                    'per_page' => $catalogues->perPage(),
                    'total' => $catalogues->total(),
                    'last_page' => $catalogues->lastPage(),
                    'from' => $catalogues->firstItem(),
                    'to' => $catalogues->lastItem(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching catalogues: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mengambil data katalog');
        }
    }

    /**
     * Store a newly created catalogue
     *
     * @param CreateCatalogueRequest $request
     * @return JsonResponse
     */
    public function store(CreateCatalogueRequest $request): JsonResponse
    {
        try {
            $catalogue = $this->catalogueService->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Katalog berhasil dibuat',
                'data' => new CatalogueResource($catalogue)
            ], 201);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error creating catalogue: ' . $e->getMessage());
            throw CustomException::serverError('Gagal membuat katalog');
        }
    }

    /**
     * Display the specified catalogue
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $catalogue = $this->catalogueService->findById($id);

            return response()->json([
                'success' => true,
                'message' => 'Data katalog berhasil diambil',
                'data' => new CatalogueResource($catalogue)
            ]);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error fetching catalogue: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mengambil data katalog');
        }
    }

    /**
     * Update the specified catalogue
     *
     * @param UpdateCatalogueRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateCatalogueRequest $request, int $id): JsonResponse
    {
        try {
            $catalogue = $this->catalogueService->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Katalog berhasil diperbarui',
                'data' => new CatalogueResource($catalogue)
            ]);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error updating catalogue: ' . $e->getMessage());
            throw CustomException::serverError('Gagal memperbarui katalog');
        }
    }

    /**
     * Remove the specified catalogue
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->catalogueService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Katalog berhasil dihapus'
            ]);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error deleting catalogue: ' . $e->getMessage());
            throw CustomException::serverError('Gagal menghapus katalog');
        }
    }

    /**
     * Get published catalogues
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function published(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 10);
            $catalogues = $this->catalogueService->getPublished($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data katalog yang dipublikasi berhasil diambil',
                'data' => CatalogueResource::collection($catalogues->items()),
                'pagination' => [
                    'current_page' => $catalogues->currentPage(),
                    'per_page' => $catalogues->perPage(),
                    'total' => $catalogues->total(),
                    'last_page' => $catalogues->lastPage(),
                    'from' => $catalogues->firstItem(),
                    'to' => $catalogues->lastItem(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching published catalogues: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mengambil data katalog');
        }
    }

    /**
     * Search catalogues with filters
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $filters = $request->only(['title', 'user_id', 'is_publish', 'min_price', 'max_price', 'created_from', 'created_to']);
            $perPage = $request->get('per_page', 10);
            
            $catalogues = $this->catalogueService->search($filters, $perPage);

            return response()->json([
                'success' => true,
                'message' => 'Pencarian katalog berhasil',
                'data' => CatalogueResource::collection($catalogues->items()),
                'pagination' => [
                    'current_page' => $catalogues->currentPage(),
                    'per_page' => $catalogues->perPage(),
                    'total' => $catalogues->total(),
                    'last_page' => $catalogues->lastPage(),
                    'from' => $catalogues->firstItem(),
                    'to' => $catalogues->lastItem(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error searching catalogues: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mencari katalog');
        }
    }

    /**
     * Get catalogues by user
     *
     * @param int $userId
     * @param Request $request
     * @return JsonResponse
     */
    public function getByUser(int $userId, Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 10);
            $catalogues = $this->catalogueService->findByUserId($userId, $perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data katalog user berhasil diambil',
                'data' => CatalogueResource::collection($catalogues->items()),
                'pagination' => [
                    'current_page' => $catalogues->currentPage(),
                    'per_page' => $catalogues->perPage(),
                    'total' => $catalogues->total(),
                    'last_page' => $catalogues->lastPage(),
                    'from' => $catalogues->firstItem(),
                    'to' => $catalogues->lastItem(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching user catalogues: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mengambil data katalog user');
        }
    }

    /**
     * Toggle publish status
     *
     * @param int $id
     * @return JsonResponse
     */
    public function togglePublish(int $id): JsonResponse
    {
        try {
            $catalogue = $this->catalogueService->togglePublish($id);

            return response()->json([
                'success' => true,
                'message' => 'Status publikasi katalog berhasil diubah',
                'data' => new CatalogueResource($catalogue)
            ]);
        } catch (CustomException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error toggling catalogue publish status: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mengubah status publikasi katalog');
        }
    }

    /**
     * Get catalogue statistics
     *
     * @return JsonResponse
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->catalogueService->getStatistics();

            return response()->json([
                'success' => true,
                'message' => 'Statistik katalog berhasil diambil',
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching catalogue statistics: ' . $e->getMessage());
            throw CustomException::serverError('Gagal mengambil statistik katalog');
        }
    }
}