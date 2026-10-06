<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')->ignore($productId)],
            'description' => ['required', 'string', 'max:2000'],
            'image' => ['required', 'string', Rule::in([
                'assets/ajs/cakalang.jpg', 'assets/ajs/deho.jpg', 'assets/ajs/tuna.jpg',
                'assets/ajs/dori.jpg', 'assets/ajs/kerapu.jpg', 'assets/ajs/kakatua.jpg',
            ])],
            'grade' => ['required', 'string', 'max:100'],
            'form' => ['required', 'string', 'max:100'],
            'origin' => ['required', 'string', 'max:255'],
            'available_quantity' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:9999999999.99'],
            'moq' => ['required', 'numeric', 'decimal:0,2', 'min:0.01', 'max:9999999999.99'],
            'availability' => ['required', Rule::in(['available', 'unavailable'])],
        ];
    }
}
