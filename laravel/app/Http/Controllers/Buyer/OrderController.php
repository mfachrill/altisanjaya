<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\SupplyRequests;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return view('buyer.orders.index', ['orders' => $request->user()->orders()->latest()->paginate(15)]);
    }

    public function show(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id, 403);
        $order->load('orderItems.product');

        return view('buyer.orders.show', compact('order'));
    }

    public function store(Request $request, SupplyRequests $supply)
    {
        $data = $request->validate(['notes' => ['nullable', 'string', 'max:2000']]);
        $order = $supply->submit($request->user(), $request->session()->get('cart', []), $data['notes'] ?? null);
        $request->session()->forget('cart');

        return redirect()->route('buyer.orders.show', $order)->with('success', 'Request Order submitted successfully. Your request is now being reviewed by AJS.');
    }
}
