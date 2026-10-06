@extends('layouts.app')
@section('title','Buyer Dashboard | AJS')
@section('content')
<div class="portal-shell">
<x-page-heading eyebrow="AJS / Buyer portal" :title="'Welcome, '.auth()->user()->name" description="Build your supply request from current availability. AJS will review the quantities and specifications before confirmation." />
<div class="mb-12 flex flex-wrap gap-3">
<a class="btn" href="{{ route('buyer.catalog') }}">Request Order →</a>
<a class="btn-secondary" href="{{ route('buyer.orders.index') }}">View my requests</a>
</div>
<section class="mb-12 grid gap-5 md:grid-cols-3" aria-label="Procurement overview">
    <div class="card">
        <h2 class="section-kicker">Stock availability</h2>
        <p class="display mt-4 text-5xl text-deep">{{ $products->count() }}</p>
        <p class="mt-3 text-sm text-muted-foreground">Commodities currently available to request, with stock meeting MOQ.</p>
        <a class="mt-5 inline-block text-sm font-bold text-primary underline" href="{{ route('buyer.stock') }}">View current stock</a>
    </div>
    <div class="card">
        <h2 class="section-kicker">Supply cart summary</h2>
        <p class="display mt-4 text-5xl text-deep">{{ $cartCount }}</p>
        <p class="mt-3 text-sm text-muted-foreground">Commodity type(s) in your cart</p>
        <p class="mt-2 font-bold text-ocean">{{ number_format($cartQuantity, 2) }} KG requested</p>
        <a class="mt-5 inline-block text-sm font-bold text-primary underline" href="{{ route('buyer.cart') }}">Review supply cart</a>
    </div>
    <div class="card">
        <h2 class="section-kicker">Request status summary</h2>
        <dl class="mt-5 space-y-3">
            @foreach(['requested', 'confirmed', 'rejected'] as $status)
                <div class="flex items-center justify-between gap-3">
                    <dt><x-status :value="$status" /></dt>
                    <dd class="font-extrabold text-deep">{{ $orderCounts->get($status, 0) }}</dd>
                </div>
            @endforeach
        </dl>
        <a class="mt-5 inline-block text-sm font-bold text-primary underline" href="{{ route('buyer.orders.index') }}">View all requests</a>
    </div>
</section>
<h2 class="mb-6 text-2xl font-extrabold text-deep">Available commodities</h2>
<div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
@forelse($products as $product)<x-product-card :product="$product" />
@empty<div class="card">No stock is available for requests right now. Please contact AJS.</div>
@endforelse</div>
<h2 class="mb-6 mt-12 text-2xl font-extrabold text-deep">Recent supply requests</h2>
<x-order-list :orders="$orders" />
</div>
@endsection
