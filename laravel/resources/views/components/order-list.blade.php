@props(['orders','admin'=>false])
<div class="space-y-3">
@forelse($orders as $order)
<a href="{{ route($admin ? 'admin.orders.show' : 'buyer.orders.show',$order) }}" class="card flex flex-wrap items-center justify-between gap-4">
<div>
<p class="font-extrabold text-deep">Request #{{ $order->id }}</p>
<p class="mt-1 text-sm text-muted-foreground">{{ $order->created_at->format('d M Y, H:i') }}@if($admin) · {{ $order->user->name }}@endif</p>
</div>
<div class="flex items-center gap-4">
<x-status :value="$order->status" />
<span class="text-sm font-bold text-primary">View →</span>
</div>
</a>
@empty<div class="card">
<p class="font-bold">No order requests yet.</p>
<p class="mt-2 text-sm text-muted-foreground">{{ $admin ? 'New buyer requests will appear here for review.' : 'Explore the commodity catalog to start your first supply request.' }}</p>
</div>
@endforelse
</div>
