<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PT Altisan Jaya Sinergi · Fish Commodity Trading & Supply. Reliable supply, flexible sourcing, trusted partnership.">
    <title>@yield('title', 'PT Altisan Jaya Sinergi | Fish Commodity Trading & Supply')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body id="top" class="min-h-screen bg-background text-foreground">
    @php($isAdminWorkspace = auth()->check() && auth()->user()->role === 'admin' && request()->routeIs('admin.*'))
    @php($isBuyerWorkspace = auth()->check() && auth()->user()->role === 'buyer' && request()->routeIs('buyer.*'))
    @php($isPortalWorkspace = $isAdminWorkspace || $isBuyerWorkspace)
    <a class="skip-link" href="#main-content">{{ app()->getLocale() === 'id' ? 'Lewati ke konten' : 'Skip to content' }}</a>
    @if($isAdminWorkspace)
    <x-admin-sidebar />
    @elseif($isBuyerWorkspace)
    <x-buyer-sidebar />
    @else
    @include('layouts.navigation')
    @endif
    <main id="main-content" @class(['lg:pl-72' => $isPortalWorkspace])>
        @if(session('success') || $errors->any())
        <div class="mx-auto max-w-[1280px] px-5 pt-6" aria-live="polite">
            @if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="error-notice" role="alert"><p class="font-bold">Please review the following:</p><ul class="mt-2 list-inside list-disc">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        </div>
        @endif
        @yield('content')
    </main>
    @unless(request()->routeIs('home') || $isPortalWorkspace)
    <footer @class(['border-t border-border bg-deep px-5 py-8 text-center text-sm text-deep-foreground', 'lg:pl-72' => auth()->check() && auth()->user()->role === 'admin' && request()->routeIs('admin.*')])>
        <p class="font-bold">PT Altisan Jaya Sinergi</p><p class="mt-2 text-gold">Reliable Supply. Flexible Sourcing. Trusted Partnership.</p>
        <a href="{{ route('home') }}#contact" class="mt-4 inline-block underline underline-offset-4">Let's build a supply partnership</a>
    </footer>
    @endunless
    @unless(request()->routeIs('login') || $isPortalWorkspace)
    <aside class="fixed bottom-5 right-4 z-50 sm:bottom-6 sm:right-6" aria-label="{{ __('ui.language') }}">
        <div class="rounded-full border border-white/15 bg-deep/95 p-1.5 shadow-xl backdrop-blur-md">
            <x-language-switcher />
        </div>
    </aside>
    @endunless
    <x-auth-success-popup />
    <x-action-popups />
</body>
</html>
