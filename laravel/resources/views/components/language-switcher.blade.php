@php($locale = app()->getLocale())
<form method="POST" action="{{ route('locale.update') }}" class="flex w-[116px] shrink-0 rounded-full border border-white/15 bg-deep p-0.5 text-xs font-extrabold shadow-sm" aria-label="{{ __('ui.language') }}">
    @csrf
    <button name="locale" value="id" type="submit" class="flex-1 rounded-full px-2 py-2 transition {{ $locale === 'id' ? 'bg-emerald-500 text-gold' : 'text-deep-foreground hover:bg-white/10' }}" aria-pressed="{{ $locale === 'id' ? 'true' : 'false' }}">ID</button>
    <button name="locale" value="en" type="submit" class="flex-1 rounded-full px-2 py-2 transition {{ $locale === 'en' ? 'bg-emerald-500 text-gold' : 'text-deep-foreground hover:bg-white/10' }}" aria-pressed="{{ $locale === 'en' ? 'true' : 'false' }}">EN</button>
</form>
