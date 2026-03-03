<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Saleable
{
    use SoftDeletes;
    use HasFactory;

    public function sale_item(): MorphOne
    {
        return $this->morphOne(SaleItem::class, 'saleable');
    }
}
