<?php

namespace App\Enums;

use App\Models\Product;
use App\Models\Service;

enum ItemType: string
{
    case Product = 'PRODUCT';
    case Service = 'SERVICE';

    public function className(): string
    {
        return match($this) {
            ItemType::Product => Product::class,
            ItemType::Service => Service::class,
        };
    }
}