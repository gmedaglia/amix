<?php

namespace App\Models;

use App\Enums\ItemType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property string $name
 * @property string $description
 * @property float $price
 */
abstract class Saleable extends Model
{
    use SoftDeletes;
    use HasFactory;

    abstract public function type(): ItemType;

    abstract public function checkAvailability(int $quantity): void;
}
