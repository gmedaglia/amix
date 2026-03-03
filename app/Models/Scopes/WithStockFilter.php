<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

class WithStockFilter
{
    public function __invoke(Builder $query): void
    {
        $query->where('stock', '>', 0);
    }
}
