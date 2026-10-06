@extends('layouts.app')
@section('title',$product->name.' | AJS')
@section('content')
<div class="portal-shell">
<a href="{{ route('commodities.index') }}" class="text-sm font-bold text-primary">← Commodity catalog</a>
<div class="mt-8 grid gap-10 lg:grid-cols-2">
<div>
<div class="image-frame aspect-[1.15]">
<img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
</div>
<p class="mt-4 text-sm text-muted-foreground">AJS commodity reference imagery. Actual supply is subject to review.</p>
</div>
<div>
<p class="section-kicker mb-4">{{ $product->origin }}</p>
<h1 class="portal-title">{{ $product->name }}</h1>
<div class="section-rule">
</div>
<x-status :value="$product->availability" />
<p class="mt-5 section-copy">{{ $product->description }}</p>
<dl class="mt-6 grid grid-cols-2 gap-4 border-y border-border py-6">
@foreach(['Grade'=>$product->grade,'Form'=>$product->form,'Origin'=>$product->origin,'Available quantity'=>number_format($product->available_quantity,2).' KG','Minimum order quantity'=>number_format($product->moq,2).' KG'] as $label=>$value)<div>
<dt class="text-xs font-bold uppercase text-muted-foreground">{{ $label }}</dt>
<dd class="mt-1 font-bold">{{ $value }}</dd>
</div>
@endforeach
</dl>
@if($product->availability==='available' && $product->available_quantity >= $product->moq)
@auth
@if(auth()->user()->role==='buyer')
<form class="mt-7" action="{{ route('buyer.cart.store',$product) }}" method="POST">@csrf
<label for="quantity" class="field-label">Requested quantity (KG)</label>
<input class="field max-w-xs" id="quantity" name="quantity" type="number" step="0.01" min="{{ $product->moq }}" max="{{ $product->available_quantity }}" value="{{ old('quantity',session('cart.'.$product->id,$product->moq)) }}" required aria-describedby="quantity-help">
<p id="quantity-help" class="mt-2 text-xs text-muted-foreground">Minimum {{ number_format($product->moq,2) }} KG. Adding again replaces this commodity's cart quantity.</p>
<button class="btn mt-5" type="submit">Add to supply cart →</button>
</form>
@else<a class="btn mt-7" href="{{ route('admin.products.edit',$product) }}">Manage stock</a>
@endif
@else<a class="btn mt-7" href="{{ route('buyer.products.show',$product->slug) }}">Login to Request Order →</a>
@endauth
@else<p class="notice mt-7">This commodity is currently unavailable for requests. Please contact AJS for sourcing requirements.</p>
@endif
<p class="mt-5 text-xs text-muted-foreground">No payment is collected. AJS reviews every supply request before confirmation.</p>
</div>
</div>
</div>
@endsection
