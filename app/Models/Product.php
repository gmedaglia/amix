<?php

namespace App\Models;

use App\Enums\ItemType;
use App\Exceptions\InsufficientStockException;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property int $stock
 */
class Product extends Saleable
{
    public function sale_item(): MorphOne
    {
        return $this->morphOne(SaleItem::class, 'saleable');
    }

    public function type(): ItemType
    {
        return ItemType::Product;
    }

    public function checkAvailability(int $quantity): void
    {
        if ($this->stock < $quantity) {
            throw new InsufficientStockException($this);
        }
    }
}
