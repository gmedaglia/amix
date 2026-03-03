<?php

namespace App\Listeners;

use App\Events\ProductDeleted;
use App\Models\Service;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteServicesDependingOnDeletedProduct implements ShouldQueue
{
    public function handle(ProductDeleted $event): void
    {
        Service::query()
            ->dependingOnProductStock($event->product)
            ->delete();
    }
}
