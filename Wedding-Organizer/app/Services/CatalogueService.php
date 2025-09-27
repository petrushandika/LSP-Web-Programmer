<?php

namespace App\Services;

use App\Models\Catalogue;
use App\Repositories\Contracts\CatalogueRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Exception;

/**
 * Service untuk logika bisnis Catalogue
 * 
 * @package App\Services
 */
class CatalogueService
{
    /**
     * @var CatalogueRepositoryInterface
     */
    protected CatalogueRepositoryInterface $catalogueRepository;

    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * Constructor
     *
     * @param CatalogueRepositoryInterface $catalogueRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        CatalogueRepositoryInterface $catalogueRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->catalogueRepository = $catalogueRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Ambil semua catalogue dengan pagination
     *
     * @param int $perPage
     * @param bool $withRelations
     * @return LengthAwarePaginator
     */
    public function getAllCatalogues(int $perPage = 15, bool $withRelations = false): LengthAwarePaginator
    {
        try {
            $relations = $withRelations ? ['user', 'orders'] : [];
            return $this->catalogueRepository->getAllPaginated($perPage, $relations);
        } catch (Exception $e) {
            Log::error('Error getting all catalogues: ' . $e->getMessage());
            throw new Exception('Gagal mengambil data catalogue');
        }
    }

    /**
     * Ambil catalogue yang dipublish
     *
     * @param bool $withRelations
     * @return Collection
     */
    public function getPublishedCatalogues(bool $withRelations = false): Collection
    {
        try {
            $relations = $withRelations ? ['user', 'orders'] : [];
            return $this->catalogueRepository->getPublished($relations);
        } catch (Exception $e) {
            Log::error('Error getting published catalogues: ' . $e->getMessage());
            throw new Exception('Gagal mengambil data catalogue yang dipublish');
        }
    }

    /**
     * Cari catalogue berdasarkan ID
     *
     * @param int $id
     * @param bool $withRelations
     * @return Catalogue
     * @throws Exception
     */
    public function getCatalogueById(int $id, bool $withRelations = false): Catalogue
    {
        try {
            $relations = $withRelations ? ['user', 'orders'] : [];
            $catalogue = $this->catalogueRepository->findById($id, $relations);
            
            if (!$catalogue) {
                throw new Exception('Catalogue tidak ditemukan');
            }

            return $catalogue;
        } catch (Exception $e) {
            Log::error('Error getting catalogue by ID: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Buat catalogue baru
     *
     * @param array $data
     * @return Catalogue
     * @throws Exception
     */
    public function createCatalogue(array $data): Catalogue
    {
        try {
            // Validasi user exists
            $user = $this->userRepository->findById($data['user_id']);
            if (!$user) {
                throw new Exception('User tidak ditemukan');
            }

            // Handle image upload
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $data['image'] = $this->handleImageUpload($data['image']);
            }

            // Set default publish status
            if (!isset($data['is_publish'])) {
                $data['is_publish'] = false;
            }

            $catalogue = $this->catalogueRepository->create($data);
            
            Log::info('Catalogue created successfully', ['catalogue_id' => $catalogue->id]);
            return $catalogue;
        } catch (Exception $e) {
            Log::error('Error creating catalogue: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update catalogue
     *
     * @param int $id
     * @param array $data
     * @return Catalogue
     * @throws Exception
     */
    public function updateCatalogue(int $id, array $data): Catalogue
    {
        try {
            $catalogue = $this->getCatalogueById($id);

            // Validasi user exists jika user_id diubah
            if (isset($data['user_id'])) {
                $user = $this->userRepository->findById($data['user_id']);
                if (!$user) {
                    throw new Exception('User tidak ditemukan');
                }
            }

            // Handle image upload
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                // Hapus gambar lama jika ada
                if ($catalogue->image) {
                    $this->deleteImage($catalogue->image);
                }
                $data['image'] = $this->handleImageUpload($data['image']);
            }

            $updatedCatalogue = $this->catalogueRepository->update($catalogue, $data);
            
            Log::info('Catalogue updated successfully', ['catalogue_id' => $updatedCatalogue->id]);
            return $updatedCatalogue;
        } catch (Exception $e) {
            Log::error('Error updating catalogue: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Hapus catalogue
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deleteCatalogue(int $id): bool
    {
        try {
            $catalogue = $this->getCatalogueById($id);

            // Cek apakah catalogue memiliki order
            $catalogue->loadCount('orders');
            
            if ($catalogue->orders_count > 0) {
                throw new Exception('Catalogue tidak dapat dihapus karena memiliki order');
            }

            // Hapus gambar jika ada
            if ($catalogue->image) {
                $this->deleteImage($catalogue->image);
            }

            $result = $this->catalogueRepository->delete($catalogue);
            
            if ($result) {
                Log::info('Catalogue deleted successfully', ['catalogue_id' => $id]);
            }

            return $result;
        } catch (Exception $e) {
            Log::error('Error deleting catalogue: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Cari catalogue berdasarkan user ID
     *
     * @param int $userId
     * @param bool $withRelations
     * @return Collection
     */
    public function getCataloguesByUserId(int $userId, bool $withRelations = false): Collection
    {
        try {
            $relations = $withRelations ? ['user', 'orders'] : [];
            return $this->catalogueRepository->findByUserId($userId, $relations);
        } catch (Exception $e) {
            Log::error('Error getting catalogues by user ID: ' . $e->getMessage());
            throw new Exception('Gagal mengambil data catalogue berdasarkan user');
        }
    }

    /**
     * Cari catalogue dengan filter
     *
     * @param array $filters
     * @param bool $withRelations
     * @return Collection
     */
    public function searchCatalogues(array $filters, bool $withRelations = false): Collection
    {
        try {
            $relations = $withRelations ? ['user', 'orders'] : [];
            return $this->catalogueRepository->findWithFilters($filters, $relations);
        } catch (Exception $e) {
            Log::error('Error searching catalogues: ' . $e->getMessage());
            throw new Exception('Gagal mencari data catalogue');
        }
    }

    /**
     * Cari catalogue berdasarkan range harga
     *
     * @param float|null $minPrice
     * @param float|null $maxPrice
     * @param bool $withRelations
     * @return Collection
     */
    public function getCataloguesByPriceRange(?float $minPrice, ?float $maxPrice, bool $withRelations = false): Collection
    {
        try {
            $relations = $withRelations ? ['user', 'orders'] : [];
            return $this->catalogueRepository->findByPriceRange($minPrice, $maxPrice, $relations);
        } catch (Exception $e) {
            Log::error('Error getting catalogues by price range: ' . $e->getMessage());
            throw new Exception('Gagal mengambil data catalogue berdasarkan range harga');
        }
    }

    /**
     * Ambil statistik catalogue
     *
     * @return array
     */
    public function getCatalogueStatistics(): array
    {
        try {
            $totalCatalogues = $this->catalogueRepository->count();
            $publishedCatalogues = $this->catalogueRepository->countByPublishStatus(true);
            $unpublishedCatalogues = $this->catalogueRepository->countByPublishStatus(false);

            return [
                'total_catalogues' => $totalCatalogues,
                'published' => $publishedCatalogues,
                'unpublished' => $unpublishedCatalogues,
                'percentage' => [
                    'published' => $totalCatalogues > 0 ? round(($publishedCatalogues / $totalCatalogues) * 100, 2) : 0,
                    'unpublished' => $totalCatalogues > 0 ? round(($unpublishedCatalogues / $totalCatalogues) * 100, 2) : 0,
                ]
            ];
        } catch (Exception $e) {
            Log::error('Error getting catalogue statistics: ' . $e->getMessage());
            throw new Exception('Gagal mengambil statistik catalogue');
        }
    }

    /**
     * Toggle status publish catalogue
     *
     * @param int $id
     * @return Catalogue
     * @throws Exception
     */
    public function togglePublishStatus(int $id): Catalogue
    {
        try {
            $catalogue = $this->getCatalogueById($id);
            
            $updatedCatalogue = $this->catalogueRepository->update($catalogue, [
                'is_publish' => !$catalogue->is_publish
            ]);

            Log::info('Catalogue publish status toggled', [
                'catalogue_id' => $id,
                'new_status' => $updatedCatalogue->is_publish
            ]);

            return $updatedCatalogue;
        } catch (Exception $e) {
            Log::error('Error toggling catalogue publish status: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle image upload
     *
     * @param UploadedFile $image
     * @return string
     * @throws Exception
     */
    private function handleImageUpload(UploadedFile $image): string
    {
        try {
            $path = $image->store('catalogues', 'public');
            return $path;
        } catch (Exception $e) {
            Log::error('Error uploading image: ' . $e->getMessage());
            throw new Exception('Gagal mengupload gambar');
        }
    }

    /**
     * Delete image from storage
     *
     * @param string $imagePath
     * @return bool
     */
    private function deleteImage(string $imagePath): bool
    {
        try {
            if (Storage::disk('public')->exists($imagePath)) {
                return Storage::disk('public')->delete($imagePath);
            }
            return true;
        } catch (Exception $e) {
            Log::error('Error deleting image: ' . $e->getMessage());
            return false;
        }
    }
}