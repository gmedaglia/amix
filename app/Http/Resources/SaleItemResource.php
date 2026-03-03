<?php

namespace App\Http\Resources;

use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read SaleItem $resource
 */
class SaleItemResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->saleable->id,
            'name' => $this->resource->saleable->name,
            'description' => $this->resource->saleable->name,
            'quantity' => $this->resource->quantity,
            'unit_price' => $this->resource->unit_price,
        ];
    }
}
