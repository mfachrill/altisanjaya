@extends('layouts.app')
@section('title','My Supply Requests | AJS')
@section('content')
<div class="portal-shell">
<x-page-heading eyebrow="AJS / Buyer portal" title="My Supply Requests" description="Track the status of your procurement requests." />
<x-order-list :orders="$orders" />
<div class="mt-8">{{ $orders->links() }}</div>
</div>
@endsection
