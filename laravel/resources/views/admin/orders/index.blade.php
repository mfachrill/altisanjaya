@extends('layouts.app')
@section('title','Order Requests | AJS Admin')
@section('content')
<div class="portal-shell">
<x-page-heading eyebrow="AJS / Admin portal" title="Order Requests" description="Review quantities and current stock before confirming a supply request." />
<x-order-list :orders="$orders" :admin="true" />
<div class="mt-8">{{ $orders->links() }}</div>
</div>
@endsection
