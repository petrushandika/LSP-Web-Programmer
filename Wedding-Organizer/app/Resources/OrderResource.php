<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource untuk response Order
 * 
 * @package App\Resources
 */
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'catalogue_id' => $this->catalogue_id,
            'status' => [
                'value' => $this->status,
                'label' => $this->getStatusLabel()
            ],
            'notes' => $this->notes,
            'order_date' => $this->order_date?->format('Y-m-d'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            
            // Relasi
            'user' => new UserResource($this->whenLoaded('user')),
            'catalogue' => new CatalogueResource($this->whenLoaded('catalogue')),
            
            // Informasi tambahan
            'total_price' => $this->when($this->catalogue, function () {
                return [
                    'raw' => $this->catalogue->price,
                    'formatted' => 'Rp ' . number_format($this->catalogue->price, 0, ',', '.')
                ];
            }),
        ];
    }

    /**
     * Get status label in Indonesian
     *
     * @return string
     */
    private function getStatusLabel(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        return [
            'success' => true,
            'message' => 'Data order berhasil diambil'
        ];
    }
}