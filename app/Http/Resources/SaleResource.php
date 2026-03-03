<?php

namespace App\Http\Resources;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Sale $resource
 */
class SaleResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'client' => ClientResource::make($this->resource->client),
            'date' => $this->resource->created_at,
            'client_sale_num_for_day' => $this->resource->client_sale_num_for_day,
            'items' => SaleItemResource::collection($this->resource->items),
            'total' => $this->resource->total,
        ];
    }
}
