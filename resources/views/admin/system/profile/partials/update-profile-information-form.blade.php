<section>
    <header class="mb-4">
        <h6 class="fs-15 fw-semibold text-dark mb-1">Detail Informasi Pengguna</h6>
        <p class="text-muted fs-13 mb-0">
            Perbarui informasi profil akun dan alamat email Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div x-data="{ 
            uploading: false,
            successMsg: '',
            uploadPhoto(event) {
                const file = event.target.files[0];
                if (!file) return;

                this.uploading = true;
                this.successMsg = '';

                const formData = new FormData();
                formData.append('avatar', file);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route("profile.avatar") }}', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    this.uploading = false;
                    if (data.success && data.avatar_url) {
                        const newUrl = data.avatar_url + '?t=' + new Date().getTime();
                        document.querySelectorAll('.user-avatar-img').forEach(img => img.src = newUrl);
                        this.successMsg = 'Foto profil berhasil diperbarui!';
                        setTimeout(() => this.successMsg = '', 4000);
                    } else {
                        alert('Gagal mengunggah foto.');
                    }
                })
                .catch(err => {
                    this.uploading = false;
                    console.error(err);
                    alert('Terjadi kesalahan saat mengunggah foto.');
                });
            }
        }" class="mb-4">
            <label class="form-label fw-semibold mb-2">Foto Profil</label>
            
            <!-- Hidden File Input -->
            <input type="file" id="avatar_input" class="d-none" x-ref="photoInput" x-on:change="uploadPhoto($event)" accept="image/*" />

            <div class="d-flex align-items-center gap-3">
                <!-- Clickable Avatar Container -->
                <div class="position-relative cursor-pointer group rounded-circle overflow-hidden border border-2 border-primary shadow-sm" style="width: 80px; height: 80px;" x-on:click="$refs.photoInput.click()" title="Klik foto untuk langsung mengganti foto profil">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="user-avatar-img img-fluid w-100 h-100 object-fit-cover transition-all" :class="{ 'opacity-50': uploading }" />

                    <!-- Hover Camera Overlay -->
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex flex-column align-items-center justify-content-center text-white opacity-0 group-hover-opacity-100 transition-all">
                        <i class="ti ti-camera fs-20"></i>
                        <span class="fs-10 fw-semibold">Ganti Foto</span>
                    </div>

                    <!-- Uploading Spinner -->
                    <template x-if="uploading">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75 d-flex align-items-center justify-content-center text-white">
                            <div class="spinner-border spinner-border-sm text-light" role="status"></div>
                        </div>
                    </template>
                </div>

                <div>
                    <button type="button" x-on:click="$refs.photoInput.click()" class="btn btn-sm btn-light border shadow-sm">
                        <i class="ti ti-upload me-1"></i> Pilih Foto Baru
                    </button>
                    <p class="fs-12 text-muted mt-1 mb-0">Klik foto atau tombol di atas untuk langsung mengganti foto profil Anda.</p>
                    <template x-if="successMsg">
                        <p class="fs-12 fw-semibold text-success mt-1 mb-0" x-text="successMsg"></p>
                    </template>
                </div>
            </div>
            @error('avatar')
                <div class="text-danger fs-12 mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autocomplete="name" placeholder="Masukkan nama lengkap" />
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username" placeholder="Masukkan alamat email" />
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="fs-13 text-muted mb-1">
                        {{ __('Alamat email Anda belum diverifikasi.') }}
                        <button form="send-verification" class="btn btn-link p-0 text-primary fs-13">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success fs-12 py-1 px-2 mb-0 mt-1" role="alert">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
                <i class="ti ti-device-floppy fs-16"></i> Simpan Perubahan
            </button>
        </div>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success alert-dismissible fade show mt-3 mb-0" role="alert">
                <i class="ti ti-check me-1"></i> Informasi profil berhasil diperbarui!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </form>
</section>
