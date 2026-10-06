@if(auth()->check() && auth()->user()->role === 'buyer' && request()->routeIs('buyer.*'))
    <aside class="fixed inset-y-0 left-0 z-[60] hidden w-72 overflow-y-auto border-r border-border bg-paper lg:flex lg:flex-col" aria-label="Buyer portal navigation">
        <div class="border-b border-border px-6 py-6">
            <p class="text-xs font-extrabold uppercase tracking-[.16em] text-primary">AJS / Procurement</p>
            <p class="mt-2 font-display text-2xl font-bold uppercase text-deep">Buyer Portal</p>
        </div>
        <div class="border-b border-border px-6 py-5">
            <div class="flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-ocean text-sm font-extrabold text-primary-foreground">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <div class="min-w-0"><p class="truncate text-sm font-extrabold text-deep">{{ auth()->user()->name }}</p><p class="truncate text-xs text-muted-foreground">{{ auth()->user()->email }}</p></div>
            </div>
        </div>
        <nav class="space-y-1 p-4">
            <a href="{{ route('buyer.dashboard') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-extrabold transition {{ request()->routeIs('buyer.dashboard') ? 'bg-primary text-primary-foreground' : 'text-deep hover:bg-sky' }}">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 15v-3M12 15V7M17 15v-5"/></svg> Dashboard
            </a>
            <a href="{{ route('buyer.catalog') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-extrabold transition {{ request()->routeIs('buyer.catalog', 'buyer.products.*') ? 'bg-primary text-primary-foreground' : 'text-deep hover:bg-sky' }}">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="m4 7 8-4 8 4-8 4-8-4Z"/><path d="m4 12 8 4 8-4M4 17l8 4 8-4"/></svg> Catalog
            </a>
            <a href="{{ route('buyer.stock') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-extrabold transition {{ request()->routeIs('buyer.stock') ? 'bg-primary text-primary-foreground' : 'text-deep hover:bg-sky' }}"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 15v-3M12 15V7M17 15v-5"/></svg> Stock availability</a>
            <a href="{{ route('buyer.cart') }}" class="flex items-center justify-between gap-3 rounded-lg px-4 py-3 text-sm font-extrabold transition {{ request()->routeIs('buyer.cart') ? 'bg-primary text-primary-foreground' : 'text-deep hover:bg-sky' }}"><span class="flex items-center gap-3"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h2l2.5 12h10L21 7H6"/><circle cx="10" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg> Request cart</span><span class="rounded-full bg-sky px-2 py-0.5 text-xs text-deep">{{ count(session('cart', [])) }}</span></a>
            <a href="{{ route('buyer.orders.index') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-extrabold transition {{ request()->routeIs('buyer.orders.*') ? 'bg-primary text-primary-foreground' : 'text-deep hover:bg-sky' }}"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M5 3h14v18H5z"/><path d="M8 8h8M8 12h8M8 16h5"/></svg> Order requests</a>
        </nav>
        <div class="mt-auto border-t border-border p-4"><a href="{{ route('home') }}" class="block px-4 py-3 text-sm font-bold text-muted-foreground hover:text-deep">View public website</a><form method="POST" action="{{ route('logout') }}">@csrf<button class="w-full rounded-lg px-4 py-3 text-left text-sm font-extrabold text-red-800 hover:bg-red-50" type="submit">Log out</button></form></div>
    </aside>
    <nav class="border-b border-border bg-deep px-4 py-3 text-deep-foreground lg:hidden" aria-label="Buyer portal navigation"><div class="flex items-center justify-between gap-3 overflow-x-auto"><span class="shrink-0 text-xs font-extrabold uppercase tracking-wider text-gold">{{ auth()->user()->name }}</span><div class="flex shrink-0 gap-4 text-sm font-bold"><a href="{{ route('buyer.dashboard') }}">Dashboard</a><a href="{{ route('buyer.catalog') }}">Catalog</a><a href="{{ route('buyer.stock') }}">Stock</a><a href="{{ route('buyer.cart') }}">Cart</a><a href="{{ route('buyer.orders.index') }}">Orders</a></div></div></nav>
@endif
