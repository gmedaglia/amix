<?php

namespace App\Observers;

use App\Models\Sale;
use App\Models\SaleItem;

class SaleObserver
{
    public function creating(Sale $sale): void
    {
        $maxClientSaleNumForDay = $sale
            ->query()
            ->forClientToday($sale->client)
            ->max('client_sale_num_for_day');

        $sale->client_sale_num_for_day = $maxClientSaleNumForDay + 1;
    }
}
