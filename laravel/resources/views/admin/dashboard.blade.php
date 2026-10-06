@extends('layouts.app')
@section('title','Admin Dashboard | AJS')
@section('content')
<div class="portal-shell">
<x-page-heading eyebrow="AJS / Admin portal" title="Supply Operations" description="Review buyer requests and manage available commodity stock." />
<div class="mb-12 grid gap-5 sm:grid-cols-2">
<a href="{{ route('admin.orders.index') }}" class="card">
<p class="section-kicker">Awaiting review</p>
<strong class="display mt-4 block text-6xl text-deep">{{ $pending }}</strong>
<p class="mt-4 font-bold text-primary">Review order requests ?</p>
</a>
<a href="{{ route('admin.products.index') }}" class="card">
<p class="section-kicker">Listed commodities</p>
<strong class="display mt-4 block text-6xl text-deep">{{ $products }}</strong>
<p class="mt-4 font-bold text-primary">Manage stock ?</p>
</a>
</div>
<h2 class="mb-6 text-2xl font-extrabold text-deep">Recent requests</h2>
<x-order-list :orders="$orders" :admin="true" />
</div>
@endsection
