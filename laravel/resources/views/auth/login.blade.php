@extends('layouts.guest')
@section('title','Buyer & Admin Login | AJS')
@section('content')
<div class="portal-shell grid items-center gap-10 lg:grid-cols-[.9fr_1.1fr]">

<div>
<p class="section-kicker mb-5">AJS / Supply partnerships</p>
    <h1 class="portal-title">Reliable supply.<br>
<span class="text-ocean">Trusted partnership.</span>
</h1>
<div class="section-rule">
</div>
<p class="section-copy">Access your supply requests, review current commodities and connect your requirements with AJS.</p>
<div class="mt-8 grid gap-3 sm:grid-cols-3">
    <div class="rounded-xl border border-border bg-sky p-5">
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-7 w-7 text-primary" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 10v4M12 2v3M19 13V7a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v6"/><path d="M3 14l8.19-3.64a2 2 0 0 1 1.62 0L21 14a11.6 11.6 0 0 1-2.81 7.76"/><path d="M2 21c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1s1.2 1 2.5 1c2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/></svg>
        <p class="mt-4 text-xs font-extrabold uppercase text-deep">Supply requests</p>
    </div>
    <div class="rounded-xl border border-border bg-sky p-5">
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-7 w-7 text-primary" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
        <p class="mt-4 text-xs font-extrabold uppercase text-deep">Order review</p>
    </div>
    <div class="rounded-xl border border-border bg-sky p-5">
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-7 w-7 text-primary" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3v18M18 3v18M6 7h12M6 17h12"/><path d="M9 7v10M15 7v10"/></svg>
        <p class="mt-4 text-xs font-extrabold uppercase text-deep">Stock access</p>
    </div>
</div>
</div>
<div class="card mx-auto w-full max-w-lg !p-8 md:!p-10">
    <h2 class="text-2xl font-extrabold text-deep">Welcome back</h2>
<p class="mt-3 text-sm text-muted-foreground">Sign in to your buyer or admin account.</p>
<form action="{{ route('login.store') }}" method="POST" class="mt-8 space-y-5">@csrf
<div>
<label for="email" class="field-label">Email address</label>
    <input class="field" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
</div>
<div>
    <label for="password" class="field-label">Password</label>
    <input class="field" id="password" name="password" type="password" autocomplete="current-password" required>
</div>
<button class="btn w-full" type="submit">Sign in →</button>
</form>
<p class="mt-6 text-sm text-muted-foreground">Need a supply partnership? <a class="font-bold text-primary underline" href="{{ route('home') }}#contact">Contact AJS</a>
</p>
</div>
</div>
@endsection
