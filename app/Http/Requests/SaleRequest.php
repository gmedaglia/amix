<?php

namespace App\Http\Requests;

use App\Enums\ItemType;
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
            'items' => ['required', 'array', 'min:1', 'max:200'],
            'items.*' => ['array:id,type,quantity'],
            'items.*.id' => ['required', 'integer'],
            'items.*.type' => ['required', Rule::enum(ItemType::class)],
            'items.*.quantity' => ['required', 'integer'],
        ];
    }
}
