<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property string $name
 * @property string $email
 */
class Client extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['name', 'email'];
}
