<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource untuk response User
 * 
 * @package App\Resources
 */
class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'role' => $this->role,
            'address' => $this->address,
            'email_verified_at' => $this->when($this->email_verified_at, function () {
                return $this->email_verified_at?->format('Y-m-d H:i:s');
            }),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            
            // Relasi
            'catalogues_count' => $this->whenCounted('catalogues'),
            'orders_count' => $this->whenCounted('orders'),
            'catalogues' => CatalogueResource::collection($this->whenLoaded('catalogues')),
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
            'message' => 'Data user berhasil diambil'
        ];
    }
}