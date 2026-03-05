<?php

namespace App\Exceptions;

use App\Models\Service;

class ServiceUnavailableException extends SaleCreationException
{
    public function __construct(Service $service)
    {
        return parent::__construct("Service \"{$service->name}\" is unavailable.", 7000);
    }
}
