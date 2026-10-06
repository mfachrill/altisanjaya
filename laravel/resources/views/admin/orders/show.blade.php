@extends('layouts.app')
@section('title','Review Request #'.$order->id.' | AJS')
@section('content')
<div class="portal-shell">
<x-page-heading eyebrow="AJS / Admin review" :title="'Request #'.$order->id" :description="$order->user->name.' · '.$order->user->email" />
<x-order-detail :order="$order" />
<div class="card mt-6">
<h2 class="text-xl font-extrabold">Current stock</h2>
<div class="mt-4 space-y-3">
@foreach($order->orderItems as $item)<p class="flex flex-wrap justify-between gap-2 text-sm">
<span>{{ $item->product->name }}</span>
<strong>{{ number_format($item->product->available_quantity,2) }} KG · {{ ucfirst($item->product->availability) }}</strong>
</p>
@endforeach</div>
</div>
@if($order->status==='requested')<div class="card mt-6">
<h2 class="text-xl font-extrabold">Review decision</h2>
<p class="mt-3 text-sm text-muted-foreground">Confirmation checks availability and deducts the requested quantities from stock. Rejection leaves stock unchanged. A reviewed request cannot be processed again.</p>
<form method="POST" action="{{ route('admin.orders.update',$order) }}" class="mt-6 flex flex-wrap gap-3">@csrf @method('PATCH')<button class="btn" type="submit" name="status" value="confirmed">Confirm request</button>
<button class="btn-secondary" type="submit" name="status" value="rejected">Reject request</button>
</form>
</div>
@else<p class="notice mt-6">This request has been {{ $order->status }}. No further review action is required.</p>
@endif
<a class="btn-secondary mt-6" href="{{ route('admin.orders.index') }}">← Order requests</a>
</div>
@endsection
