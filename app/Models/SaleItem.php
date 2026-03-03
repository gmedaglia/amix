<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property-read int $id
 * @property-read Sale $sale
 * @property-read Product|Service $saleable
 * @property int $quantity
 * @property float $unit_price
 */
class SaleItem extends Model
{
    public $table = 'sale_items';

    public $timestamps = false;

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function saleable(): MorphTo
    {
        return $this->morphTo('saleable');
    }
}
