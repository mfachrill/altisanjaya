@extends('layouts.app')
@section('title','Update Stock | AJS')
@section('content')
<div class="portal-shell">
<div class="mb-7 flex flex-wrap items-center justify-between gap-4"><a href="{{ route('admin.products.index') }}" class="text-sm font-bold text-primary">&larr; Back to stock management</a><x-status :value="$product->availability" /></div>
<x-page-heading eyebrow="AJS / Product management" :title="$product->name" description="Maintain product specification, stock quantity, MOQ, and availability for the B2B Request Order workflow." />
<div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
<div>@include('admin.products.form', ['product' => $product, 'imageOptions' => $imageOptions, 'action' => route('admin.products.update', $product), 'method' => 'PATCH', 'submitLabel' => 'Save changes'])</div>
<aside class="space-y-5 xl:sticky xl:top-6 xl:self-start">
<div class="overflow-hidden rounded-xl border border-border bg-paper"><img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="aspect-[4/3] w-full object-cover"><div class="p-5"><p class="text-xs font-extrabold uppercase tracking-widest text-primary">Current product</p><h2 class="mt-2 text-xl font-extrabold text-deep">{{ $product->name }}</h2><p class="mt-2 text-sm text-muted-foreground">{{ $product->origin }} · {{ $product->grade }} · {{ $product->form }}</p></div></div>
<div class="rounded-xl border border-border bg-sky p-5"><p class="text-xs font-extrabold uppercase tracking-widest text-primary">Stock snapshot</p><p class="display mt-3 text-5xl text-deep">{{ number_format($product->available_quantity, 2) }} <span class="text-xl">KG</span></p><p class="mt-2 text-sm text-muted-foreground">Current MOQ: {{ number_format($product->moq, 2) }} KG</p></div>
<form method="POST" action="{{ route('admin.products.destroy',$product) }}" onsubmit="return confirm('Delete {{ addslashes($product->name) }}? This cannot be undone.')">@csrf @method('DELETE')<button class="w-full rounded-lg border border-red-200 px-4 py-3 text-sm font-extrabold text-red-800 transition hover:bg-red-50" type="submit">Delete product</button></form>
</aside>
</div>
</div>
@endsection
