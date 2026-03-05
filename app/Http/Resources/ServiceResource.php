<?php

namespace App\Http\Resources;

use App\Models\Service;
use Illuminate\Http\Request;

/**
 * @property-read Service $resource
 */
class ServiceResource extends SaleableResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'available' => $this->resource->available,
            'depends_on_product' => $this->resource->dependable_product
                ? ProductResource::make($this->resource->dependable_product)
                : null,
        ]);
    }
}
