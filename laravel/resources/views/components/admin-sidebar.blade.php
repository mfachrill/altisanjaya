@if(auth()->check() && auth()->user()->role === 'admin' && request()->routeIs('admin.*'))
    <aside class="fixed inset-y-0 left-0 z-[60] hidden w-72 overflow-y-auto border-r border-border bg-paper lg:flex lg:flex-col" aria-label="Admin navigation">
        <div class="border-b border-border px-6 py-6">
            <p class="text-xs font-extrabold uppercase tracking-[.16em] text-primary">AJS / Internal</p>
            <p class="mt-2 font-display text-2xl font-bold uppercase text-deep">Admin Workspace</p>
        </div>
        <div class="border-b border-border px-6 py-5">
            <div class="flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-primary text-sm font-extrabold text-primary-foreground">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-extrabold text-deep">{{ auth()->user()->name }}</p>
                    <p class="truncate text-xs text-muted-foreground">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
        <nav class="space-y-1 p-4">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-extrabold transition {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-primary-foreground' : 'text-deep hover:bg-sky' }}">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-extrabold transition {{ request()->routeIs('admin.orders.*') ? 'bg-primary text-primary-foreground' : 'text-deep hover:bg-sky' }}">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="3" width="14" height="18" rx="2"/><path d="M9 8h6M9 12h6M9 16h3"/></svg>
                Order Requests
            </a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-extrabold transition {{ request()->routeIs('admin.products.*') ? 'bg-primary text-primary-foreground' : 'text-deep hover:bg-sky' }}">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="m4 7 8-4 8 4-8 4-8-4Z"/><path d="m4 12 8 4 8-4M4 17l8 4 8-4"/></svg>
                Stock Management
            </a>
        </nav>
        <div class="mt-auto border-t border-border p-4">
            <a href="{{ route('home') }}" class="block px-4 py-3 text-sm font-bold text-muted-foreground hover:text-deep">View public website</a>
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="w-full rounded-lg px-4 py-3 text-left text-sm font-extrabold text-red-800 hover:bg-red-50" type="submit">Log out</button></form>
        </div>
    </aside>
    <nav class="border-b border-border bg-deep px-4 py-3 text-deep-foreground lg:hidden" aria-label="Admin navigation">
        <div class="flex items-center justify-between gap-3 overflow-x-auto">
            <span class="shrink-0 text-xs font-extrabold uppercase tracking-wider text-gold">{{ auth()->user()->name }}</span>
            <div class="flex shrink-0 gap-4 text-sm font-bold"><a href="{{ route('admin.dashboard') }}">Dashboard</a><a href="{{ route('admin.orders.index') }}">Orders</a><a href="{{ route('admin.products.index') }}">Stock</a></div>
        </div>
    </nav>
@endif
