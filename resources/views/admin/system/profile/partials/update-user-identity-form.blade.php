<section>
    <header class="mb-4">
        <h6 class="fs-15 fw-semibold text-dark mb-1">Identitas KTP & Alamat Lengkap</h6>
        <p class="text-muted fs-13 mb-0">
            Kelola data resmi KTP dan rincian alamat tempat tinggal terperinci.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        @php
            $profile = $user->getOrCreateProfile();
        @endphp

        <!-- Sub-section: Data Identitas KTP -->
        <div class="card bg-light-subtle border mb-4">
            <div class="card-header bg-transparent border-bottom py-2">
                <h6 class="card-title mb-0 fs-14 fw-bold text-primary d-flex align-items-center gap-1">
                    <i class="ti ti-id-badge-2 fs-18"></i> Data Identitas KTP / NIK
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nik" class="form-label fw-semibold">NIK (Nomor Induk Kependudukan)</label>
                        <input id="nik" name="nik" type="text" class="form-control" value="{{ old('nik', $profile->nik) }}" maxlength="20" placeholder="16 digit NIK KTP" />
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="birth_place" class="form-label fw-semibold">Tempat Lahir</label>
                        <input id="birth_place" name="birth_place" type="text" class="form-control" value="{{ old('birth_place', $profile->birth_place) }}" placeholder="Kota / Kabupaten Lahir" />
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="birth_date" class="form-label fw-semibold">Tanggal Lahir</label>
                        <input id="birth_date" name="birth_date" type="date" class="form-control" value="{{ old('birth_date', $profile->birth_date ? $profile->birth_date->format('Y-m-d') : '') }}" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="gender" class="form-label fw-semibold">Jenis Kelamin</label>
                        <select id="gender" name="gender" class="form-select">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" {{ old('gender', $profile->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender', $profile->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="religion" class="form-label fw-semibold">Agama</label>
                        <select id="religion" name="religion" class="form-select">
                            <option value="">-- Pilih Agama --</option>
                            @foreach(['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Lainnya'] as $rel)
                                <option value="{{ $rel }}" {{ old('religion', $profile->religion) == $rel ? 'selected' : '' }}>{{ $rel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="marital_status" class="form-label fw-semibold">Status Perkawinan</label>
                        <select id="marital_status" name="marital_status" class="form-select">
                            <option value="">-- Pilih Status --</option>
                            @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $st)
                                <option value="{{ $st }}" {{ old('marital_status', $profile->marital_status) == $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sub-section: Alamat Lengkap Sesuai KTP -->
        <div class="card bg-light-subtle border mb-4">
            <div class="card-header bg-transparent border-bottom py-2">
                <h6 class="card-title mb-0 fs-14 fw-bold text-success d-flex align-items-center gap-1">
                    <i class="ti ti-map-pins fs-18"></i> Alamat Lengkap (KTP & Domisili)
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="address" class="form-label fw-semibold">Alamat Jalan / Perumahan / Blok</label>
                    <textarea id="address" name="address" class="form-control" rows="2" placeholder="Nama Jalan, No. Rumah, Komplek / Dusun">{{ old('address', $profile->address) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="rt" class="form-label fw-semibold">RT</label>
                        <input id="rt" name="rt" type="text" class="form-control" value="{{ old('rt', $profile->rt) }}" placeholder="001" />
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="rw" class="form-label fw-semibold">RW</label>
                        <input id="rw" name="rw" type="text" class="form-control" value="{{ old('rw', $profile->rw) }}" placeholder="002" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="village" class="form-label fw-semibold">Kelurahan / Desa</label>
                        <input id="village" name="village" type="text" class="form-control" value="{{ old('village', $profile->village) }}" placeholder="Nama Kelurahan / Desa" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="district" class="form-label fw-semibold">Kecamatan</label>
                        <input id="district" name="district" type="text" class="form-control" value="{{ old('district', $profile->district) }}" placeholder="Nama Kecamatan" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="city_regency" class="form-label fw-semibold">Kota / Kabupaten</label>
                        <input id="city_regency" name="city_regency" type="text" class="form-control" value="{{ old('city_regency', $profile->city_regency) }}" placeholder="Nama Kota / Kabupaten" />
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="province" class="form-label fw-semibold">Provinsi</label>
                        <input id="province" name="province" type="text" class="form-control" value="{{ old('province', $profile->province) }}" placeholder="Nama Provinsi" />
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="postal_code" class="form-label fw-semibold">Kode Pos</label>
                        <input id="postal_code" name="postal_code" type="text" class="form-control" value="{{ old('postal_code', $profile->postal_code) }}" placeholder="12345" />
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="form_section" value="identity" />

        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
                <i class="ti ti-device-floppy fs-16"></i> Simpan Data Identitas KTP
            </button>
        </div>
    </form>
</section>
