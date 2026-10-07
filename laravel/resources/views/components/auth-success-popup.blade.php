@if(in_array(session('auth_success'), ['login', 'logout'], true))
    @php
        $isLogin = session('auth_success') === 'login';
        $isIndonesian = app()->getLocale() === 'id';
        $title = $isLogin
            ? ($isIndonesian ? 'Login berhasil!' : 'Signed in successfully!')
            : ($isIndonesian ? 'Logout berhasil!' : 'Signed out successfully!');
        $message = $isLogin
            ? ($isIndonesian ? 'Selamat datang kembali. Akun Anda siap digunakan.' : 'Welcome back. Your account is ready to use.')
            : ($isIndonesian ? 'Anda telah keluar dari akun dengan aman.' : 'You have been safely signed out of your account.');
    @endphp
    <dialog data-auth-success class="auth-success-popup rounded-2xl border border-border bg-paper p-8 text-center text-foreground shadow-2xl" aria-labelledby="auth-success-title" aria-describedby="auth-success-message">
        <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
            <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 4 4L19 6" /></svg>
        </span>
        <h2 id="auth-success-title" class="mt-5 text-2xl font-extrabold text-deep">{{ $title }}</h2>
        <p id="auth-success-message" class="mt-3 text-sm leading-relaxed text-muted-foreground">{{ $message }}</p>
        <form method="dialog" class="mt-6">
            <button type="submit" class="btn w-full" autofocus>{{ $isIndonesian ? 'Oke' : 'Okay' }}</button>
        </form>
    </dialog>
@endif
