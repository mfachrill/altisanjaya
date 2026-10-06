<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class StockController extends Controller
{
    public function __invoke(): View
    {
        return view('buyer.stock', [
            'products' => Product::query()->orderBy('name')->paginate(20),
        ]);
    }
}
