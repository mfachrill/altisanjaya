@props(['order'])
<div class="card">
<div class="flex flex-wrap items-start justify-between gap-4">
<div>
<p class="font-bold">Submitted {{ $order->created_at->format('d M Y, H:i') }}</p>
<p class="mt-2 text-sm text-muted-foreground">This is a B2B supply request. It is not a purchase or payment.</p>
</div>
<x-status :value="$order->status" />
</div>
<div class="mt-6 divide-y divide-border">
@foreach($order->orderItems as $item)
<div class="flex flex-wrap items-center justify-between gap-4 py-5">
<div class="flex min-w-0 items-center gap-4">
<img src="{{ asset($item->product->image) }}" alt="" class="h-16 w-20 shrink-0 rounded object-cover">
<div class="min-w-0">
<a href="{{ route('commodities.show',$item->product->slug) }}" class="font-bold text-ocean">{{ $item->product->name }}</a>
<p class="mt-1 text-sm">{{ $item->product->grade }} · {{ $item->product->form }}</p>
</div>
</div>
<strong>{{ number_format($item->quantity,2) }} KG</strong>
</div>
@endforeach</div>
@if($order->notes)<div class="mt-5 border-t border-border pt-5">
<h2 class="font-bold">Supply requirements / notes</h2>
<p class="mt-2 whitespace-pre-wrap break-words text-sm">{{ $order->notes }}</p>
</div>
@endif
</div>
