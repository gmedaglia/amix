<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class SaleableRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'description' => ['string', 'nullable', 'min:3', 'max:255'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'integer', 'min:0'],
        ];
    }
}
