<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * Resource untuk response Catalogue
 * 
 * @package App\Resources
 */
class CatalogueResource extends JsonResource
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
            'title' => $this->title,
            'user_id' => $this->user_id,
            'price' => [
                'raw' => $this->price,
                'formatted' => 'Rp ' . number_format($this->price, 0, ',', '.')
            ],
            'is_publish' => $this->is_publish,
            'description' => $this->description,
            'image' => [
                'filename' => $this->image,
                'url' => $this->image ? Storage::url($this->image) : null,
                'full_url' => $this->image ? asset('storage/' . $this->image) : null
            ],
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            
            // Relasi
            'user' => new UserResource($this->whenLoaded('user')),
            'orders_count' => $this->whenCounted('orders'),
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
        ];
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
            'message' => 'Data catalogue berhasil diambil'
        ];
    }
}