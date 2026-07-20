<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
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
                        this.successMsg = 'Foto profil berhasil langsung diperbarui!';
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
        }">
            <x-input-label for="avatar_input" :value="__('Foto Profil')" />
            
            <!-- Hidden File Input -->
            <input type="file" id="avatar_input" class="hidden" x-ref="photoInput" x-on:change="uploadPhoto($event)" accept="image/*" />

            <div class="flex items-center gap-4 mt-2">
                <!-- Clickable Avatar Container -->
                <div class="relative group cursor-pointer" x-on:click="$refs.photoInput.click()" title="Klik foto untuk langsung mengganti foto profil">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="user-avatar-img h-24 w-24 rounded-full object-cover border-4 border-indigo-500 shadow-md group-hover:opacity-75 transition duration-150" :class="{ 'opacity-50 animate-pulse': uploading }" />

                    <!-- Hover Camera Overlay -->
                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition duration-150 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-[10px] font-medium mt-0.5">Ganti Foto</span>
                    </div>

                    <!-- Uploading Spinner -->
                    <template x-if="uploading">
                        <div class="absolute inset-0 bg-black/60 rounded-full flex items-center justify-center text-white">
                            <svg class="animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </template>
                </div>

                <div>
                    <button type="button" x-on:click="$refs.photoInput.click()" class="px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition">
                        Pilih Foto Baru
                    </button>
                    <p class="text-xs text-gray-500 mt-1">Klik gambar foto di atas untuk memilih dan langsung mengganti foto profil.</p>
                    <template x-if="successMsg">
                        <p class="text-xs font-semibold text-green-600 mt-1" x-text="successMsg"></p>
                    </template>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
