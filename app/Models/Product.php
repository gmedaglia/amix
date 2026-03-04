<?php

namespace App\Models;

use App\Enums\ItemType;
use Illuminate\Database\Eloquent\Relations\MorphOne;

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

    public function stockDependency(): ?Saleable
    {
        return null;
    }
}
