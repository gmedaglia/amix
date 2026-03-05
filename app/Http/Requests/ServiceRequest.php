<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Validation\Rule;

class ServiceRequest extends SaleableRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'available' => ['required', Rule::in([true, false])],
            'depends_on_product_id' => ['nullable', Rule::exists(Product::class, 'id')->withoutTrashed()],
        ]);
    }
}
