@extends('layouts.app')
@section('title','Request #'.$order->id.' | AJS')
@section('content')
<div class="portal-shell">
<x-page-heading eyebrow="AJS / Supply request" :title="'Request #'.$order->id" :description="$order->status==='requested' ? 'Your request is now being reviewed by AJS.' : 'Your request has been '.$order->status.'. Please contact AJS for further coordination.'" />
<x-order-detail :order="$order" />
<a href="{{ route('buyer.orders.index') }}" class="btn-secondary mt-7">← My requests</a>
</div>
@endsection
