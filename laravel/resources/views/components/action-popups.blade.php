@php($isIndonesian = app()->getLocale() === 'id')
@if(request()->routeIs('login') && $errors->any())
    <dialog data-auth-success class="auth-success-popup rounded-2xl border border-border bg-paper p-8 text-center text-foreground shadow-2xl" aria-labelledby="login-error-title" aria-describedby="login-error-message">
        <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-100 text-red-800">
            <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="m7 7 10 10M17 7 7 17" /></svg>
        </span>
        <h2 id="login-error-title" class="mt-5 text-2xl font-extrabold text-deep">{{ $isIndonesian ? 'Login gagal' : 'Sign-in failed' }}</h2>
        <div id="login-error-message" class="mt-3 space-y-2 text-sm leading-relaxed text-muted-foreground">
            @foreach($errors->all() as $error)
                <p>{{ $isIndonesian && $error === 'The email or password is incorrect.' ? 'Email atau password salah. Silakan coba lagi.' : $error }}</p>
            @endforeach
        </div>
        <form method="dialog" class="mt-6"><button type="submit" class="btn w-full" autofocus>{{ $isIndonesian ? 'Coba lagi' : 'Try again' }}</button></form>
    </dialog>
@endif
@if(request()->routeIs('admin.products.*'))
    <dialog data-action-confirm class="auth-success-popup rounded-2xl border border-border bg-paper p-8 text-center text-foreground shadow-2xl" aria-labelledby="action-confirm-title" aria-describedby="action-confirm-message"
        data-save-title="{{ $isIndonesian ? 'Simpan perubahan?' : 'Save changes?' }}"
        data-save-message="{{ $isIndonesian ? 'Perubahan data produk akan disimpan. Pastikan data sudah benar.' : 'Your product changes will be saved. Please make sure the details are correct.' }}"
        data-save-label="{{ $isIndonesian ? 'Ya, simpan' : 'Yes, save' }}"
        data-delete-title="{{ $isIndonesian ? 'Hapus produk?' : 'Delete product?' }}"
        data-delete-message="{{ $isIndonesian ? 'Produk “:name” akan dihapus. Tindakan ini tidak dapat dibatalkan.' : 'Product “:name” will be deleted. This action cannot be undone.' }}"
        data-delete-label="{{ $isIndonesian ? 'Ya, hapus' : 'Yes, delete' }}">
        <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-sky text-primary">
            <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path d="M12 7v6m0 4h.01" /></svg>
        </span>
        <h2 id="action-confirm-title" class="mt-5 text-2xl font-extrabold text-deep"></h2>
        <p id="action-confirm-message" class="mt-3 text-sm leading-relaxed text-muted-foreground"></p>
        <form method="dialog" class="mt-6 flex flex-wrap justify-center gap-3">
            <button type="submit" value="cancel" class="btn-secondary flex-1" autofocus>{{ $isIndonesian ? 'Batal' : 'Cancel' }}</button>
            <button data-confirm-accept type="submit" value="confirm" class="btn flex-1"></button>
        </form>
    </dialog>
@endif
