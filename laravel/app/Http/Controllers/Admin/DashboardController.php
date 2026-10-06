<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', ['pending' => Order::where('status', 'requested')->count(), 'products' => Product::count(), 'orders' => Order::with('user')->latest()->limit(5)->get()]);
    }
}
