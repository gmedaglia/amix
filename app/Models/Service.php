<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property ?Product $dependable_product
 */
class Service extends Saleable
{
    use SoftDeletes;
    use HasFactory;

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
}
