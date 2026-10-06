@extends('layouts.app')
@section('title','Add Product | AJS')
@section('content')
<div class="portal-shell">
<x-page-heading eyebrow="AJS / Product management" title="Add Product" description="Create a commodity record for the catalog and B2B Request Order workflow." />
@include('admin.products.form', ['product' => null, 'imageOptions' => $imageOptions, 'action' => route('admin.products.store'), 'method' => 'POST', 'submitLabel' => 'Create product'])
</div>
@endsection
