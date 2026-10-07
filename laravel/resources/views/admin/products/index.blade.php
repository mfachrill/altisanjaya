@extends('layouts.app')
@section('title','Stock Management | AJS')
@section('content')
<div class="portal-shell">
    <div class="flex flex-col justify-between gap-6 border-b border-border pb-8 lg:flex-row lg:items-end">
        <x-page-heading eyebrow="AJS / Admin portal" title="Stock Management" description="Search, filter, and maintain commodity availability without opening individual product cards." />
        <a class="btn shrink-0" href="{{ route('admin.products.create') }}">Add product &rarr;</a>
    </div>

    <div class="mt-7 grid gap-3 sm:grid-cols-3">
        <div class="rounded-xl border border-border bg-paper p-5"><p class="text-xs font-extrabold uppercase tracking-widest text-muted-foreground">Listed products</p><p class="display mt-2 text-4xl text-deep">{{ number_format($summary['total']) }}</p></div>
        <div class="rounded-xl border border-border bg-paper p-5"><p class="text-xs font-extrabold uppercase tracking-widest text-muted-foreground">Available</p><p class="display mt-2 text-4xl text-emerald-700">{{ number_format($summary['available']) }}</p></div>
        <div class="rounded-xl border border-border bg-paper p-5"><p class="text-xs font-extrabold uppercase tracking-widest text-muted-foreground">Unavailable</p><p class="display mt-2 text-4xl text-red-800">{{ number_format($summary['unavailable']) }}</p></div>
    </div>

    <form method="GET" class="mt-7 grid gap-3 rounded-xl border border-border bg-paper p-4 lg:grid-cols-[1fr_180px_180px_auto]">
        <div><label class="sr-only" for="q">Search products</label><input class="field" id="q" name="q" value="{{ request('q') }}" placeholder="Search product, origin, or grade"></div>
        <div><label class="sr-only" for="availability">Availability</label><select class="field" id="availability" name="availability"><option value="">All availability</option><option value="available" @selected(request('availability') === 'available')>Available</option><option value="unavailable" @selected(request('availability') === 'unavailable')>Unavailable</option></select></div>
        <div><label class="sr-only" for="sort">Sort products</label><select class="field" id="sort" name="sort"><option value="newest" @selected(request('sort', 'newest') === 'newest')>Newest added</option><option value="name" @selected(request('sort') === 'name')>Product name</option><option value="stock" @selected(request('sort') === 'stock')>Lowest stock</option></select></div>
        <div class="flex gap-2"><button class="btn flex-1" type="submit">Apply</button><a class="btn-secondary" href="{{ route('admin.products.index') }}">Reset</a></div>
    </form>

    <div class="mt-6 overflow-hidden rounded-xl border border-border bg-paper">
        <div class="overflow-x-auto">
            <table class="min-w-[840px] w-full text-left text-sm">
                <thead class="border-b border-border bg-sky text-xs font-extrabold uppercase tracking-wider text-muted-foreground">
                    <tr><th class="px-5 py-4">Product</th><th class="px-5 py-4">Specification</th><th class="px-5 py-4">Origin</th><th class="px-5 py-4">Status</th><th class="px-5 py-4 text-right">Available stock</th><th class="px-5 py-4 text-right">MOQ</th><th class="px-5 py-4"><span class="sr-only">Actions</span></th></tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($products as $product)
                    <tr class="transition hover:bg-sky/45">
                        <td class="px-5 py-4"><div class="flex items-center gap-3"><img src="{{ asset($product->image) }}" alt="" class="h-11 w-14 shrink-0 rounded-md object-cover"><div><p class="font-extrabold text-deep">{{ $product->name }}</p><p class="mt-1 text-xs text-muted-foreground">SKU #{{ $product->id }}</p></div></div></td>
                        <td class="px-5 py-4 text-muted-foreground">{{ $product->grade }} · {{ $product->form }}</td>
                        <td class="px-5 py-4 text-muted-foreground">{{ $product->origin }}</td>
                        <td class="px-5 py-4"><x-status :value="$product->availability" /></td>
                        <td class="px-5 py-4 text-right font-extrabold text-deep">{{ number_format($product->available_quantity, 2) }} <span class="text-xs text-muted-foreground">KG</span></td>
                        <td class="px-5 py-4 text-right font-bold text-muted-foreground">{{ number_format($product->moq, 2) }} KG</td>
                        <td class="px-5 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-border text-ocean transition hover:border-primary hover:bg-sky" aria-label="Edit {{ $product->name }}" title="Edit product">
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" data-confirm-action="delete" data-product-name="{{ $product->name }}">
                                    @csrf @method('DELETE')
                                    <button class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-red-200 text-red-800 transition hover:bg-red-50" type="submit" aria-label="Delete {{ $product->name }}" title="Delete product">
                                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6M10 11v5M14 11v5"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-5 py-14 text-center text-sm text-muted-foreground">No products match this search. Try a different keyword or reset the filters.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">{{ $products->links() }}</div>
</div>
@endsection
