@extends('layouts.app')
@section('title','Commodity Catalog | AJS')
@section('content')
<div class="portal-shell">
@unless(request()->routeIs('buyer.*'))
<x-page-heading eyebrow="AJS / {{ __('ui.procurement_catalog') }}" title="{{ __('ui.catalog_title') }}" description="{{ __('ui.catalog_copy') }}" />
<div class="mb-8 grid gap-px overflow-hidden rounded-xl border border-border bg-border sm:grid-cols-3">
<div class="bg-paper p-5"><p class="text-xs font-extrabold uppercase tracking-widest text-primary">Availability</p><p class="mt-2 text-sm text-muted-foreground">Stock is shown in KG and checked again when you submit a request.</p></div>
<div class="bg-paper p-5"><p class="text-xs font-extrabold uppercase tracking-widest text-primary">MOQ</p><p class="mt-2 text-sm text-muted-foreground">Each product has a minimum quantity to support practical procurement.</p></div>
<div class="bg-paper p-5"><p class="text-xs font-extrabold uppercase tracking-widest text-primary">AJS review</p><p class="mt-2 text-sm text-muted-foreground">A Request Order is reviewed before it is confirmed; it is not a retail purchase.</p></div>
</div>
@else
<div class="mb-6 flex items-center justify-between gap-4 border-b border-border pb-5"><p class="text-sm text-muted-foreground">Review a commodity to see its specification, MOQ, and current stock.</p><a class="text-sm font-bold text-primary" href="{{ route('buyer.cart') }}">View request cart &rarr;</a></div>
@endunless
<div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
@forelse($products as $product)<x-product-card :product="$product" />
@empty<div class="card">No commodities are currently listed. Please contact AJS to discuss your supply requirements.</div>
@endforelse</div>
<div class="mt-8">{{ $products->links() }}</div>
@unless(request()->routeIs('buyer.*'))<p class="mt-9 border-l-2 border-gold pl-4 text-sm text-muted-foreground">Specifications and availability are subject to sourcing conditions and confirmation by AJS.</p>@endunless
</div>
@endsection
