<?php

namespace App\Exceptions;

use App\Models\Service;

class ServiceRelatedProductInsufficientStockException extends SaleCreationException
{
    public function __construct(Service $service)
    {
        return parent::__construct("Insufficient stock of related product for service \"{$service->name}\".", 6000);
    }
}
