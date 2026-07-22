<section>
    <header class="mb-4">
        <h6 class="fs-15 fw-semibold text-dark mb-1">Ganti Password Akun</h6>
        <p class="text-muted fs-13 mb-0">
            Pastikan akun Anda menggunakan password yang acak dan aman untuk menjaga keamanan.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label fw-semibold">Password Saat Ini <span class="text-danger">*</span></label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password" placeholder="Masukkan password saat ini" required />
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label fw-semibold">Password Baru <span class="text-danger">*</span></label>
            <input id="update_password_password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password" placeholder="Masukkan password baru" required />
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="update_password_password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" autocomplete="new-password" placeholder="Konfirmasi password baru" required />
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
                <i class="ti ti-key fs-16"></i> Perbarui Password
            </button>
        </div>
    </form>
</section>
