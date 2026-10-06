<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'image', 'grade', 'form', 'origin', 'available_quantity', 'moq', 'availability'];

    protected function casts(): array
    {
        return ['available_quantity' => 'decimal:2', 'moq' => 'decimal:2'];
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
