@extends('layouts.app')
@section('title','Stock Availability | AJS')
@section('content')
<div class="portal-shell">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 border-b border-border pb-5">
        <div><p class="text-xs font-extrabold uppercase tracking-widest text-primary">Live availability</p><p class="mt-2 text-sm text-muted-foreground">Stock is displayed in KG and is rechecked when you submit a Request Order.</p></div>
        <a class="btn-secondary" href="{{ route('buyer.catalog') }}">Browse catalog &rarr;</a>
    </div>
    <div class="overflow-hidden rounded-xl border border-border bg-paper">
        <div class="overflow-x-auto"><table class="min-w-[720px] w-full text-left text-sm"><thead class="border-b border-border bg-sky text-xs font-extrabold uppercase tracking-wider text-muted-foreground"><tr><th class="px-5 py-4">Commodity</th><th class="px-5 py-4">Specification</th><th class="px-5 py-4">Origin</th><th class="px-5 py-4">Status</th><th class="px-5 py-4 text-right">Available</th><th class="px-5 py-4 text-right">MOQ</th></tr></thead><tbody class="divide-y divide-border">@forelse($products as $product)<tr class="transition hover:bg-sky/45"><td class="px-5 py-4"><a href="{{ route('buyer.products.show', $product->slug) }}" class="flex items-center gap-3 font-extrabold text-deep hover:text-primary"><img src="{{ asset($product->image) }}" alt="" class="h-10 w-12 rounded object-cover">{{ $product->name }}</a></td><td class="px-5 py-4 text-muted-foreground">{{ $product->grade }} · {{ $product->form }}</td><td class="px-5 py-4 text-muted-foreground">{{ $product->origin }}</td><td class="px-5 py-4"><x-status :value="$product->availability" /></td><td class="px-5 py-4 text-right font-extrabold text-deep">{{ number_format($product->available_quantity, 2) }} KG</td><td class="px-5 py-4 text-right font-bold text-muted-foreground">{{ number_format($product->moq, 2) }} KG</td></tr>@empty<tr><td colspan="6" class="px-5 py-14 text-center text-muted-foreground">No stock records are available.</td></tr>@endforelse</tbody></table></div>
    </div>
    <div class="mt-6">{{ $products->links() }}</div>
</div>
@endsection
