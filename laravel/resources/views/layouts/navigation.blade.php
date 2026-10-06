<header @class(['sticky top-0 z-50 border-b border-border bg-paper/95 backdrop-blur-md', 'lg:pl-72' => auth()->check() && auth()->user()->role === 'admin' && request()->routeIs('admin.*')])>
<div class="mx-auto flex min-h-[76px] max-w-[1440px] items-center justify-between gap-2 px-4 sm:gap-4 sm:px-5 md:min-h-[82px] md:px-10 lg:px-20">
    <x-brand />
    <nav class="hidden items-center gap-7 xl:flex" aria-label="Main navigation">
        <a class="nav-link" href="{{ route('home') }}">{{ __('ui.home') }}</a>
        <a class="nav-link" href="{{ route('home') }}#who-we-are">{{ __('ui.about_us') }}</a>
        <a class="nav-link" href="{{ route('commodities.index') }}">{{ __('ui.commodities') }}</a>
        <a class="nav-link" href="{{ route('home') }}#contact">{{ __('ui.contact') }}</a>
    </nav>
    <div class="hidden items-center gap-4 xl:flex">
        @auth
        @if(auth()->user()->role === 'buyer')
        <a class="nav-link" href="{{ route(auth()->user()->role.'.dashboard') }}">{{ ucfirst(auth()->user()->role) }} portal</a>
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="nav-link" type="submit">{{ __('ui.log_out') }}</button></form>
        @else
        <a class="nav-link" href="{{ route('home') }}">View website</a>
        @endif
        @else
        <a class="btn btn-small" href="{{ route('buyer.dashboard') }}">{{ __('ui.request_order') }}</a>
        @endauth
    </div>
    <button type="button" class="rounded border border-border px-3 py-2 text-sm font-bold xl:hidden" data-menu-toggle aria-controls="mobile-menu" aria-expanded="false">Menu</button>
</div>
<nav id="mobile-menu" class="hidden border-t border-border bg-paper px-5 pb-4 xl:hidden" aria-label="Mobile navigation">
    <a href="{{ route('home') }}">{{ __('ui.home') }}</a><a href="{{ route('home') }}#who-we-are">{{ __('ui.about_us') }}</a>
    <a href="{{ route('commodities.index') }}">{{ __('ui.commodities') }}</a><a href="{{ route('home') }}#contact">{{ __('ui.contact') }}</a>
    @auth
    @if(auth()->user()->role === 'buyer')
    <a href="{{ route(auth()->user()->role.'.dashboard') }}">{{ ucfirst(auth()->user()->role) }} portal</a>
    <form method="POST" action="{{ route('logout') }}">@csrf<button class="py-3 font-bold" type="submit">Log out</button></form>
    @else
    <a href="{{ route('home') }}">View website</a>
    @endif
    @else<a href="{{ route('buyer.dashboard') }}">{{ __('ui.request_order') }} / {{ __('ui.login') }}</a>@endauth
</nav>
</header>
@if(auth()->check() && !request()->routeIs('home'))
<nav class="border-b border-border bg-sky" aria-label="Portal navigation"><div class="mx-auto flex max-w-[1280px] flex-wrap gap-x-6 gap-y-3 px-5 py-4 text-sm font-bold">
    @if(auth()->user()->role === 'buyer')
    <a href="{{ route('buyer.dashboard') }}">Dashboard</a><a href="{{ route('buyer.catalog') }}">Catalog</a>
    <a href="{{ route('buyer.cart') }}">Cart ({{ count(session('cart',[])) }})</a><a href="{{ route('buyer.orders.index') }}">My requests</a>
    @endif
</div></nav>
@endif
