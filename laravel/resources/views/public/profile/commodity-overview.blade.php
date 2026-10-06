<section id="commodities" class="scroll-mt-16 bg-sky">
    <div class="section-shell !py-[clamp(4rem,6vw,6rem)]">
        <div class="flex flex-col justify-between gap-7 border-b border-border pb-8 lg:flex-row lg:items-end">
            <div class="max-w-3xl">
                <h2 class="section-title text-deep">{{ __('ui.core_commodities') }}</h2>
                <p class="section-copy mt-5">{{ __('ui.overview_copy') }}</p>
            </div>
            <a class="btn shrink-0" href="{{ route('commodities.index') }}">{{ __('ui.view_commodities') }} &rarr;</a>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @forelse($featuredProducts as $product)
                <a href="{{ route('commodities.show', $product->slug) }}" class="group overflow-hidden rounded-xl border border-border bg-paper shadow-sm transition duration-300 hover:-translate-y-1 hover:border-primary/40 hover:shadow-lg">
                    <div class="relative aspect-[4/3] overflow-hidden bg-deep">
                        <img loading="lazy" src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-deep/75 via-transparent to-transparent"></div>
                        <div class="absolute bottom-4 left-4"><x-status :value="$product->availability" /></div>
                    </div>
                    <div class="p-5">
                        <p class="text-xs font-extrabold uppercase tracking-widest text-primary">{{ $product->origin }}</p>
                        <h3 class="mt-2 text-lg font-extrabold text-deep">{{ $product->name }}</h3>
                        <p class="mt-2 text-sm text-muted-foreground">{{ $product->grade }} grade · {{ $product->form }}</p>
                        <div class="mt-4 flex items-center justify-between border-t border-border pt-3 text-xs font-bold">
                            <span>{{ __('ui.moq') }} {{ number_format($product->moq, 0) }} KG</span>
                            <span class="text-ocean">{{ __('ui.view_detail') }} &rarr;</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="card sm:col-span-2 xl:col-span-4">No commodities are currently listed. Please contact AJS to discuss your supply requirements.</div>
            @endforelse
        </div>

        <div class="mt-6 grid gap-px overflow-hidden rounded-xl border border-border bg-border md:grid-cols-3">
            <div class="bg-paper px-5 py-4 text-sm"><span class="font-extrabold text-deep">{{ __('ui.specification_led') }}</span><span class="text-muted-foreground"> · {{ app()->getLocale() === 'id' ? 'berdasarkan spesies, grade, dan bentuk' : 'by species, grade and form' }}</span></div>
            <div class="bg-paper px-5 py-4 text-sm"><span class="font-extrabold text-deep">{{ __('ui.quantity_aware') }}</span><span class="text-muted-foreground"> · {{ app()->getLocale() === 'id' ? 'MOQ dan stok dalam KG' : 'MOQ and available stock in KG' }}</span></div>
            <div class="bg-paper px-5 py-4 text-sm"><span class="font-extrabold text-deep">{{ __('ui.request_based') }}</span><span class="text-muted-foreground"> · {{ app()->getLocale() === 'id' ? 'konfirmasi oleh AJS sebelum pasokan' : 'confirmation by AJS before supply' }}</span></div>
        </div>
    </div>
</section>
