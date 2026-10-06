<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'buyer';
    }

    public function rules(): array
    {
        return ['quantity' => ['required', 'numeric', 'decimal:0,2', 'min:0.01', 'max:9999999999.99']];
    }

    public function messages(): array
    {
        return ['quantity.decimal' => 'Use at most two decimal places for the requested KG.'];
    }
}
