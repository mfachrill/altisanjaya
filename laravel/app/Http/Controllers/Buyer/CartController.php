<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Product;
use App\Services\SupplyRequests;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get();

        return view('buyer.cart', compact('cart', 'products'));
    }

    public function store(CartRequest $request, Product $product, SupplyRequests $supply)
    {
        $quantity = (float) $request->validated('quantity');
        $supply->validateQuantity($product, $quantity);
        $request->session()->put("cart.$product->id", number_format($quantity, 2, '.', ''));

        return redirect()->route('buyer.cart')->with('success', 'Requested quantity saved to your cart.');
    }

    public function destroy(Request $request, Product $product)
    {
        $request->session()->forget("cart.$product->id");

        return back()->with('success', 'Commodity removed from your cart.');
    }
}
