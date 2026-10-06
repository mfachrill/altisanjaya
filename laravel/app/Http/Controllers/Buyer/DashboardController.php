<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $products = Product::where('availability', 'available')
            ->whereColumn('available_quantity', '>=', 'moq')->get();
        $orders = $request->user()->orders()->latest()->limit(5)->get();
        $orderCounts = $request->user()->orders()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')->pluck('total', 'status');
        $cart = $request->session()->get('cart', []);
        $cartCount = count($cart);
        $cartQuantity = array_sum($cart);

        return view('buyer.dashboard', compact(
            'products', 'orders', 'orderCounts', 'cartCount', 'cartQuantity'
        ));
    }
}
