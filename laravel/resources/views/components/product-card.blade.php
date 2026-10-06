@props(['product'])
<article class="group overflow-hidden rounded-2xl border border-border bg-paper shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">
<a href="{{ route('commodities.show',$product->slug) }}" class="block">
<div class="relative aspect-[1.5] overflow-hidden bg-deep">
<img src="{{ asset($product->image) }}" alt="{{ $product->name }}" loading="lazy" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
<div class="absolute inset-0 bg-gradient-to-t from-deep/60 to-transparent">
</div>
<div class="absolute left-4 top-4">
<x-status :value="$product->availability" />
</div>
</div>
<div class="p-6">
<p class="mb-2 text-xs font-bold uppercase tracking-widest text-primary">{{ $product->origin }}</p>
<h2 class="text-xl font-extrabold text-deep">{{ $product->name }}</h2>
<p class="mt-3 text-sm text-muted-foreground">{{ $product->grade }} · {{ $product->form }}</p>
<div class="mt-5 grid grid-cols-2 gap-3 border-t border-border pt-4 text-sm">
<div><span class="block text-xs font-bold uppercase tracking-wide text-muted-foreground">{{ __('ui.available') }}</span><span class="font-bold">{{ number_format($product->available_quantity,2) }} KG</span></div>
<div><span class="block text-xs font-bold uppercase tracking-wide text-muted-foreground">{{ __('ui.moq') }}</span><span class="font-bold">{{ number_format($product->moq,2) }} KG</span></div>
</div>
<p class="mt-4 text-sm font-bold text-ocean">{{ __('ui.review_specification') }} &rarr;</p>
</div>
</a>
</article>
