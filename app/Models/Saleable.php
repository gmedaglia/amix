<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property int $stock
 */
abstract class Saleable extends Model
{
}
