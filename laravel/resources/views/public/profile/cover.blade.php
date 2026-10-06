<section class="relative isolate min-h-[680px] overflow-hidden bg-deep text-deep-foreground md:min-h-[760px]" aria-labelledby="cover-title">
<div class="absolute inset-0 md:left-[38%]">
<img src="{{ asset('assets/ajs/cover.jpg') }}" alt="Fish commodity activity at Muara Baru harbour" class="h-full w-full object-cover object-center"/>
<div class="absolute inset-0 bg-deep/45 md:bg-transparent">
</div>
</div>
<div class="absolute inset-0 bg-gradient-to-r from-deep via-deep/90 to-transparent">
</div>
<div class="relative mx-auto flex min-h-[680px] max-w-[1440px] flex-col justify-center px-5 py-16 md:min-h-[760px] md:px-10 lg:px-20">
<p class="mb-4 text-xs font-extrabold uppercase tracking-[.18em] text-gold">{{ __('ui.b2b_procurement') }}</p>
<h1 id="cover-title" class="display max-w-4xl text-[clamp(3.9rem,9vw,8.3rem)]">{{ __('ui.reliable_supply') }}
</h1>
<p class="mt-7 max-w-xl text-base leading-8 text-deep-foreground/80 md:text-lg">{{ __('ui.hero_copy') }}</p>
<div class="mt-7 flex flex-wrap gap-2 text-xs font-extrabold uppercase tracking-wide text-deep-foreground">
<span class="border border-white/25 bg-deep/40 px-3 py-2">{{ app()->getLocale() === 'id' ? 'Pasokan andal' : 'Reliable supply' }}</span>
<span class="border border-white/25 bg-deep/40 px-3 py-2">{{ __('ui.flexible_sourcing') }}</span>
<span class="border border-white/25 bg-deep/40 px-3 py-2">{{ __('ui.trusted_partnership') }}</span>
</div>
<div class="mt-8 flex flex-wrap gap-3">
<a class="btn !border-gold !bg-gold !text-deep hover:!bg-gold/85" href="{{ route('commodities.index') }}">{{ __('ui.request_supply') }} &rarr;</a>
<a class="btn-secondary border-white/35 bg-deep/40 text-deep-foreground hover:bg-white/10" href="{{ route('commodities.index') }}">{{ __('ui.view_commodities') }}</a>
</div>
<div class="mt-9 flex flex-wrap gap-x-8 gap-y-2 border-t border-gold/60 pt-5 text-sm">
<span class="flex items-center gap-2">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin h-4 w-4 text-gold" aria-hidden="true">
<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
</path>
<circle cx="12" cy="10" r="3">
</circle>
</svg> Jakarta, Indonesia</span>
<span class="flex items-center gap-2">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days h-4 w-4 text-gold" aria-hidden="true">
<path d="M8 2v4">
</path>
<path d="M16 2v4">
</path>
<rect width="18" height="18" x="3" y="4" rx="2">
</rect>
<path d="M3 10h18">
</path>
<path d="M8 14h.01">
</path>
<path d="M12 14h.01">
</path>
<path d="M16 14h.01">
</path>
<path d="M8 18h.01">
</path>
<path d="M12 18h.01">
</path>
<path d="M16 18h.01">
</path>
</svg> Established 2022</span>
</div>
<a href="#who-we-are" aria-label="Scroll to Who We Are" class="absolute bottom-5 right-6 flex h-10 w-10 items-center justify-center rounded-full border border-deep-foreground/60 text-deep-foreground transition hover:bg-deep-foreground/20">
<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down" aria-hidden="true">
<path d="M12 5v14">
</path>
<path d="m19 12-7 7-7-7">
</path>
</svg>
</a>
</div>
</section>
