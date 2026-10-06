<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SupplyRequests
{
    public function validateQuantity(Product $product, float $quantity): void
    {
        if ($product->availability !== 'available') {
            $this->fail("$product->name is currently unavailable.");
        }
        if ($quantity < (float) $product->moq) {
            $this->fail("The minimum request for $product->name is $product->moq KG.");
        }
        if ($quantity > (float) $product->available_quantity) {
            $this->fail("Only $product->available_quantity KG of $product->name is available.");
        }
    }

    public function submit(User $user, array $cart, ?string $notes): Order
    {
        if (! $cart) {
            $this->fail('Your cart is empty. Add a commodity before submitting a request.');
        }

        return DB::transaction(function () use ($user, $cart, $notes) {
            // Consistent lock order avoids deadlocks between overlapping requests.
            $products = Product::whereIn('id', array_keys($cart))->orderBy('id')->lockForUpdate()->get()->keyBy('id');
            if ($products->count() !== count($cart)) {
                $this->fail('A commodity is no longer available. Please review your cart.');
            }
            foreach ($cart as $id => $quantity) {
                $this->validateQuantity($products[$id], (float) $quantity);
            }
            $order = $user->orders()->create(['status' => 'requested', 'notes' => $notes]);
            foreach ($cart as $id => $quantity) {
                $order->orderItems()->create(['product_id' => $id, 'quantity' => $quantity]);
            }

            return $order;
        }, 3);
    }

    public function review(Order $order, string $status): void
    {
        DB::transaction(function () use ($order, $status) {
            $locked = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();
            if ($locked->status !== 'requested') {
                $this->fail('This request has already been reviewed. Stock was not changed.');
            }
            if ($status === 'confirmed') {
                $items = $locked->orderItems()->orderBy('product_id')->get();
                $products = Product::whereIn('id', $items->pluck('product_id'))->orderBy('id')->lockForUpdate()->get()->keyBy('id');
                foreach ($items as $item) {
                    $this->validateQuantity($products[$item->product_id], (float) $item->quantity);
                }
                foreach ($items as $item) {
                    $product = $products[$item->product_id];
                    $product->decrement('available_quantity', $item->quantity);
                    if ((float) $product->available_quantity === 0.0) {
                        $product->update(['availability' => 'unavailable']);
                    }
                }
            }
            $locked->update(['status' => $status]);
        }, 3);
    }

    private function fail(string $message): never
    {
        throw ValidationException::withMessages(['supply' => $message]);
    }
}
