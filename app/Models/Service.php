<?php

namespace App\Models;

use App\Enums\ItemType;
use App\Exceptions\ServiceRelatedProductInsufficientStockException;
use App\Exceptions\ServiceUnavailableException;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property bool $available
 * @property ?Product $dependable_product
 */
class Service extends Saleable
{
    protected $fillable = ['name', 'description', 'price', 'available'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'available' => 'boolean',
        ];
    }

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

    public function checkAvailability(int $quantity): void
    {
        if (!$this->available) {
            throw new ServiceUnavailableException($this);
        }

        if ($this->dependable_product && $this->dependable_product->stock < $quantity) {
            throw new ServiceRelatedProductInsufficientStockException($this);
        }
    }    
}
