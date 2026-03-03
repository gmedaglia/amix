<?php

namespace App\Listeners;

use App\Events\OrderEmmited;
use Illuminate\Contracts\Queue\ShouldQueue;

class RefreshStocks implements ShouldQueue
{
    public function handle(OrderEmmited $event): void
    {
        $sale = $event->sale;

        // TODO Implement stock refresh logic.
    }
}
