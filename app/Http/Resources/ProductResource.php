<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * @property-read Product $resource
 */
class ProductResource extends SaleableResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'stock' => $this->resource->stock,
        ]);
    }    
}
