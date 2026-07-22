<section>
    <header class="mb-4">
        <h6 class="fs-15 fw-semibold text-dark mb-1">Profil Profesional & Tautan Sosial Media</h6>
        <p class="text-muted fs-13 mb-0">
            Kelola profesi, pendidikan, domisili publik, keahlian (skills), deskripsi tentang saya (about me), dan link sosial media.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        @php
            $profile = $user->getOrCreateProfile();
            $socials = $profile->social_links ?? [];
        @endphp

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="job_title" class="form-label fw-semibold">Profesi / Pekerjaan</label>
                <input id="job_title" name="job_title" type="text" class="form-control" value="{{ old('job_title', $profile->job_title) }}" placeholder="Contoh: UI/UX Designer & Full-Stack Developer" />
            </div>
            <div class="col-md-6 mb-3">
                <label for="education" class="form-label fw-semibold">Pendidikan / Institusi</label>
                <input id="education" name="education" type="text" class="form-control" value="{{ old('education', $profile->education) }}" placeholder="Contoh: Stanford University" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="location" class="form-label fw-semibold">Lokasi Ringkas / Domisili Publik</label>
                <input id="location" name="location" type="text" class="form-control" value="{{ old('location', $profile->location) }}" placeholder="Contoh: San Francisco, CA" />
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label fw-semibold">Nomor Telepon / WA</label>
                <input id="phone" name="phone" type="text" class="form-control" value="{{ old('phone', $profile->phone) }}" placeholder="Contoh: +62 812 3456 7890" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="website" class="form-label fw-semibold">Website</label>
                <input id="website" name="website" type="text" class="form-control" value="{{ old('website', $profile->website) }}" placeholder="Contoh: www.example.dev" />
            </div>
            <div class="col-md-6 mb-3">
                <label for="languages" class="form-label fw-semibold">Bahasa Dikuasai (Pisahkan Koma)</label>
                <input id="languages" name="languages" type="text" class="form-control" value="{{ old('languages', is_array($profile->languages) ? implode(', ', $profile->languages) : $profile->languages) }}" placeholder="Contoh: English, Indonesian, Japanese" />
            </div>
        </div>

        <div class="mb-3">
            <label for="skills" class="form-label fw-semibold">Skill / Keahlian (Pisahkan Koma)</label>
            <input id="skills" name="skills" type="text" class="form-control" value="{{ old('skills', is_array($profile->skills) ? implode(', ', $profile->skills) : $profile->skills) }}" placeholder="Contoh: Product Design, UI/UX, Laravel, Bootstrap, React.js" />
        </div>

        <div class="mb-3">
            <label for="about_me" class="form-label fw-semibold">Tentang Saya (About Me)</label>
            <textarea id="about_me" name="about_me" class="form-control" rows="3" placeholder="Tuliskan deskripsi singkat mengenai diri Anda...">{{ old('about_me', $profile->about_me) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold mb-2"><i class="ti ti-brand-share me-1 text-primary"></i> Link Tautan Sosial Media</label>
            <div class="row g-2">
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="ti ti-brand-facebook text-primary"></i></span>
                        <input type="text" name="social_links[facebook]" class="form-control" placeholder="Facebook URL" value="{{ old('social_links.facebook', $socials['facebook'] ?? '') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="ti ti-brand-x text-dark"></i></span>
                        <input type="text" name="social_links[twitter]" class="form-control" placeholder="Twitter / X URL" value="{{ old('social_links.twitter', $socials['twitter'] ?? '') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="ti ti-brand-instagram text-danger"></i></span>
                        <input type="text" name="social_links[instagram]" class="form-control" placeholder="Instagram URL" value="{{ old('social_links.instagram', $socials['instagram'] ?? '') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="ti ti-brand-linkedin text-info"></i></span>
                        <input type="text" name="social_links[linkedin]" class="form-control" placeholder="LinkedIn URL" value="{{ old('social_links.linkedin', $socials['linkedin'] ?? '') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="ti ti-brand-dribbble text-warning"></i></span>
                        <input type="text" name="social_links[dribbble]" class="form-control" placeholder="Dribbble URL" value="{{ old('social_links.dribbble', $socials['dribbble'] ?? '') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="ti ti-brand-youtube text-danger"></i></span>
                        <input type="text" name="social_links[youtube]" class="form-control" placeholder="YouTube URL" value="{{ old('social_links.youtube', $socials['youtube'] ?? '') }}" />
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="form_section" value="professional" />

        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
                <i class="ti ti-device-floppy fs-16"></i> Simpan Profil Profesional & Sosmed
            </button>
        </div>
    </form>
</section>
