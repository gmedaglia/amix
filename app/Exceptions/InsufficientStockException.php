<?php

namespace App\Exceptions;

use App\Models\Saleable;
use Exception;

class InsufficientStockException extends Exception
{
    public function __construct(Saleable $saleable)
    {
        return parent::__construct("Insufficient stock for item {$saleable->name}.", 4000);
    }
}
