<?php

namespace App\Models;

use App\Enums\ItemType;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property ?Product $dependable_product
 */
class Service extends Saleable
{
    public function sale_item(): MorphOne
    {
        return $this->morphOne(SaleItem::class, 'saleable');
    }

    public function dependable_product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'depends_on_product_id');
    }

    #[Scope]
    public function dependingOnProductStock(Builder $query, Product $product)
    {
        return $query->whereBelongsTo($product, 'dependable_product');
    }

    public function type(): ItemType
    {
        return ItemType::Service;
    }    
}
