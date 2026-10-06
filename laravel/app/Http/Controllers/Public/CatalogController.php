<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;

class CatalogController extends Controller
{
    public function index()
    {
        return view('public.commodities.index', ['products' => Product::orderBy('id')->paginate(12)]);
    }

    public function show(Product $product)
    {
        return view('public.commodities.show', compact('product'));
    }
}
