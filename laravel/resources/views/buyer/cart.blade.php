@extends('layouts.app')
@section('title','Supply Cart | AJS')
@section('content')

<div class="portal-shell">

<x-page-heading eyebrow="AJS / Buyer portal" title="Your Supply Cart" description="Review your requested quantities. Stock is checked again when you submit. A request does not reserve inventory." />
@if($products->isEmpty())<div class="card">
<h2 class="text-xl font-bold">Your cart is empty</h2>
<p class="mt-3 text-muted-foreground">Select a commodity to start your supply request.</p>
<a class="btn mt-6" href="{{ route('buyer.catalog') }}">Explore commodities →</a>
</div>

@else<div class="grid gap-8 lg:grid-cols-[1.5fr_1fr]">
<div class="space-y-4">
    
@foreach($products as $product)<article class="card">

<div class="flex items-start gap-4">
<img src="{{ asset($product->image) }}" alt="" class="h-20 w-24 shrink-0 rounded object-cover">
<div class="min-w-0">
<a href="{{ route('commodities.show',$product->slug) }}" class="font-extrabold text-ocean">{{ $product->name }}</a>
<p class="mt-2 text-sm">{{ $product->grade }} · {{ $product->form }}</p>
<p class="mt-1 text-xs text-muted-foreground">MOQ {{ number_format($product->moq,2) }} KG · Available {{ number_format($product->available_quantity,2) }} KG</p>
</div>
</div>
<div class="mt-5 flex flex-wrap items-end gap-3">

<form method="POST" action="{{ route('buyer.cart.store',$product) }}" class="flex flex-wrap items-end gap-3">@csrf<div>
<label for="quantity-{{ $product->id }}" class="field-label">Requested KG</label>
<input class="field !w-36" type="number" id="quantity-{{ $product->id }}" name="quantity" min="{{ $product->moq }}" max="{{ $product->available_quantity }}" step="0.01" value="{{ $cart[$product->id] }}" required>
</div>
<button class="btn-secondary" type="submit">Update</button>
</form>
<form method="POST" action="{{ route('buyer.cart.destroy',$product) }}">@csrf @method('DELETE')<button class="px-3 py-3 text-sm font-bold text-red-800 underline" type="submit">Remove</button>
</form>
</div>
</article>
@endforeach</div>

<div class="card h-fit">
<h2 class="text-2xl font-extrabold text-deep">Request review</h2>
<p class="mt-3 text-sm text-muted-foreground">{{ $products->count() }} commodity type(s). No pricing or payment is part of this request.</p>
<form action="{{ route('buyer.orders.store') }}" method="POST" class="mt-6" data-submit-once>@csrf
<label for="notes" class="field-label">Supply requirements / notes (optional)</label>
<textarea class="field" rows="5" name="notes" id="notes" maxlength="2000" placeholder="Tell us about your supply requirements">{{ old('notes') }}</textarea>
<button class="btn mt-5 w-full" type="submit">Submit Request Order →</button>
<p class="mt-4 text-xs leading-relaxed text-muted-foreground">AJS will review your request. Stock changes only after admin confirmation. This is not a completed transaction.</p>
</form>
</div>
</div>
@endif
</div>
@endsection
