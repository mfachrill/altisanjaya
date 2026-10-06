<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\SupplyRequests;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index', ['orders' => Order::with('user')->latest()->paginate(15)]);
    }

    public function show(Order $order)
    {
        $order->load('user', 'orderItems.product');

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order, SupplyRequests $supply)
    {
        $data = $request->validate(['status' => ['required', Rule::in(['confirmed', 'rejected'])]]);
        $supply->review($order, $data['status']);

        return back()->with('success', 'Request '.$data['status'].'.'.($data['status'] === 'confirmed' ? ' Stock has been updated.' : ' Stock was not changed.'));
    }
}
