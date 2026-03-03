<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaleRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'products' => [
                'array', 
                'max:500',
                Rule::exists(Product::class)
                    ->withoutTrashed()
                    ->where('stock', '>', 0)
            ],
            //'products' =>
            'services' => [
                'array', 
                'max:500', 
                Rule::exists(Service::class)
                    ->withoutTrashed()
                    ->where('stock', '>', 0)
            ],
        ];
    }
}
