<?php

namespace App\Http\Requests;

class ProductRequest extends SaleableRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'stock' => ['required', 'integer', 'min:0'],
        ]);
    }    
}
