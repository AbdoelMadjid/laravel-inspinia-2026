<section>
    <header class="mb-4">
        <h6 class="fs-15 fw-semibold text-dark mb-1">Pengaturan Tampilan Profil</h6>
        <p class="text-muted fs-13 mb-0">
            Kelola motto quote dan gambar sampul header (cover image) yang muncul di bagian atas halaman profil Anda.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        @php
            $profile = $user->getOrCreateProfile();
        @endphp

        <div class="mb-3">
            <label for="motto" class="form-label fw-semibold">Motto / Banner Quote</label>
            <input id="motto" name="motto" type="text" class="form-control" value="{{ old('motto', $profile->motto) }}" placeholder="Contoh: Designing the future, one template at a time" />
        </div>

        <div class="mb-4">
            <label for="cover_image" class="form-label fw-semibold">Gambar Sampul Header (Cover Image)</label>
            <input id="cover_image" name="cover_image" type="file" class="form-control" accept="image/*" />
            @if($profile->cover_image)
                <div class="mt-2">
                    <img src="{{ $profile->cover_image_url }}" alt="Cover" class="img-thumbnail rounded" style="max-height: 100px; object-fit: cover;" />
                </div>
            @endif
        </div>

        <input type="hidden" name="form_section" value="header" />

        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
                <i class="ti ti-device-floppy fs-16"></i> Simpan Tampilan Header
            </button>
        </div>
    </form>
</section>
