@extends('layouts.app')

@section('title', 'Tentang Aplikasi & Dokumentasi Sistem | INSPINIA')

@section('content')
<div class="container-fluid">
    @php
        $appProfile = \App\Models\Admin\System\AppProfile::get();
    @endphp

    <!-- Page Header -->
    <div class="page-title-head d-flex align-items-center justify-content-between py-3">
        <div>
            <h4 class="page-main-title m-0 fw-bold">
                <i class="ti ti-info-circle me-2 text-primary"></i>
                <span data-lang="about-title">Tentang Aplikasi &amp; Dokumentasi Sistem</span>
            </h4>
            <p class="text-muted mb-0 fs-13" data-lang="about-desc">
                Pusat informasi, panduan penggunaan menu, serta dokumentasi teknis sistem {{ $appProfile->app_name }}.
            </p>
        </div>
        <div>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-lang="dashboards">Dashboard</a></li>
                <li class="breadcrumb-item active" data-lang="about-app">Tentang Aplikasi</li>
            </ol>
        </div>
    </div>

    <!-- User Welcome & App Info Banner -->
    <div class="card shadow-sm border-0 bg-primary-subtle mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white p-2 rounded-3 shadow-sm d-flex align-items-center justify-content-center">
                            <img src="{{ $appProfile->logo_dark_url }}" alt="{{ $appProfile->app_name }}" style="max-height: 42px; max-width: 160px;">
                        </div>
                        <div>
                            <h4 class="fw-bold text-primary mb-1">{{ $appProfile->app_name }}</h4>
                            <p class="text-dark-subtle mb-0 fs-13">
                                {{ $appProfile->app_description ?: 'Sistem Manajemen Aplikasi Terpadu berbasis Laravel & Admin INSPINIA UI Kit.' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <span class="badge bg-primary fs-12 px-3 py-2 rounded-pill me-2">
                        <i class="ti ti-calendar me-1"></i>Tahun {{ $appProfile->app_year }}
                    </span>
                    @if($appProfile->developer_name)
                    <span class="badge bg-dark fs-12 px-3 py-2 rounded-pill">
                        <i class="ti ti-code me-1"></i>{{ $appProfile->developer_name }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @role('admin')
    <!-- System Health & Real-time Metrics Widgets (Khusus Admin) -->
    <div class="row g-3 mb-4">
        <!-- PHP Version Widget -->
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 mb-0">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="avatar-md bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center fs-24 flex-shrink-0">
                        <i class="ti ti-brand-php"></i>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <span class="text-muted text-uppercase fs-11 fw-bold tracking-wider d-block">PHP Version</span>
                        <h4 class="mb-0 fw-bold text-dark text-truncate">{{ $systemInfo['php_version'] }}</h4>
                        <small class="text-success fs-11"><i class="ti ti-circle-check me-1"></i>Runtime Ready</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laravel Version Widget -->
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 mb-0">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="avatar-md bg-danger-subtle text-danger rounded-3 d-flex align-items-center justify-content-center fs-24 flex-shrink-0">
                        <i class="ti ti-brand-laravel"></i>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <span class="text-muted text-uppercase fs-11 fw-bold tracking-wider d-block">Framework</span>
                        <h4 class="mb-0 fw-bold text-dark text-truncate">Laravel {{ $systemInfo['laravel_version'] }}</h4>
                        <small class="text-danger fs-11"><i class="ti ti-shield-check me-1"></i>ENV: {{ strtoupper($systemInfo['app_env']) }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Database Engine Widget -->
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 mb-0">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="avatar-md bg-info-subtle text-info rounded-3 d-flex align-items-center justify-content-center fs-24 flex-shrink-0">
                        <i class="ti ti-database"></i>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <span class="text-muted text-uppercase fs-11 fw-bold tracking-wider d-block">Database Engine</span>
                        <h4 class="mb-0 fw-bold text-dark text-truncate">{{ strtoupper($systemInfo['db_connection']) }}</h4>
                        <small class="text-info fs-11" title="{{ $systemInfo['db_version'] }}"><i class="ti ti-cpu me-1"></i>v{{ Str::limit($systemInfo['db_version'], 18) }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Entities & Users Summary Widget -->
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100 mb-0">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="avatar-md bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center fs-24 flex-shrink-0">
                        <i class="ti ti-users"></i>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <span class="text-muted text-uppercase fs-11 fw-bold tracking-wider d-block">Pengguna &amp; Peran</span>
                        <h4 class="mb-0 fw-bold text-dark text-truncate">{{ $metrics['total_users'] }} Users</h4>
                        <small class="text-success fs-11"><i class="ti ti-shield me-1"></i>{{ $metrics['total_roles'] }} Roles / {{ $metrics['total_permissions'] }} Permissions</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole

    <!-- Navigation Tabs -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom p-0">
            <ul class="nav nav-tabs nav-tabs-custom card-header-tabs ms-0 border-0" id="aboutUserTab" role="tablist">
                <!-- Tabs Umum (Dapat Dilihat Semua Role) -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link active py-3 px-4 fw-semibold" id="menu-guide-tab" data-bs-toggle="tab" data-bs-target="#tab-menu-guide" type="button" role="tab">
                        <i class="ti ti-book me-2 fs-18 text-primary"></i>Panduan &amp; Deskripsi Menu
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-3 px-4 fw-semibold" id="navigation-tab" data-bs-toggle="tab" data-bs-target="#tab-navigation" type="button" role="tab">
                        <i class="ti ti-layout me-2 fs-18 text-success"></i>Fitur Navigasi &amp; Tampilan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-3 px-4 fw-semibold" id="security-guide-tab" data-bs-toggle="tab" data-bs-target="#tab-security-guide" type="button" role="tab">
                        <i class="ti ti-shield-check me-2 fs-18 text-warning"></i>Keamanan Akun &amp; Etika
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-3 px-4 fw-semibold" id="faq-tab" data-bs-toggle="tab" data-bs-target="#tab-faq" type="button" role="tab">
                        <i class="ti ti-help-circle me-2 fs-18 text-info"></i>Pertanyaan Umum (FAQ)
                    </button>
                </li>

                <!-- Tabs Khusus Admin -->
                @role('admin')
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-3 px-4 fw-semibold text-danger" id="techstack-tab" data-bs-toggle="tab" data-bs-target="#tab-techstack" type="button" role="tab">
                        <i class="ti ti-code me-2 fs-18"></i>Arsitektur System (Admin)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-3 px-4 fw-semibold text-danger" id="structure-tab" data-bs-toggle="tab" data-bs-target="#tab-structure" type="button" role="tab">
                        <i class="ti ti-folder-tree me-2 fs-18"></i>Struktur Direktori (Admin)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-3 px-4 fw-semibold text-danger" id="database-tab" data-bs-toggle="tab" data-bs-target="#tab-database" type="button" role="tab">
                        <i class="ti ti-table me-2 fs-18"></i>Skema Database (Admin)
                    </button>
                </li>
                @endrole
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="aboutUserTabContent">
                
                <!-- ==================== TAB 1: PANDUAN & DESKRIPSI MENU (UMUM) ==================== -->
                <div class="tab-pane fade show active" id="tab-menu-guide" role="tabpanel">
                    <h5 class="fw-bold text-dark mb-3"><i class="ti ti-list-details text-primary me-2"></i>Penjelasan Teoretis Setiap Menu</h5>
                    <p class="text-muted fs-14 mb-4">
                        Setiap menu di dalam aplikasi dirancang dengan fungsi spesifik untuk mendukung pekerjaan Anda. Berikut adalah penjelasan fungsional setiap menu yang tersedia:
                    </p>

                    <div class="row g-4">
                        <!-- Menu Card 1: Dashboard -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border shadow-none bg-light-subtle">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="avatar-md bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center fs-22">
                                            <i class="ti ti-dashboard"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0">Dashboard (Dasbor)</h6>
                                            <small class="text-muted">Halaman Utama Sistem</small>
                                        </div>
                                    </div>
                                    <p class="text-muted fs-13 mb-0">
                                        Halaman ikhtisar ringkasan yang menampilkan data statistik penting, grafik indikator kinerja, serta jalan pintas navigasi ke fitur-fitur yang paling sering diakses.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Card 2: Profil Saya -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border shadow-none bg-light-subtle">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="avatar-md bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center fs-22">
                                            <i class="ti ti-user-circle"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0">Profil Pengguna (Profile)</h6>
                                            <small class="text-muted">Manajemen Akun Pribadi</small>
                                        </div>
                                    </div>
                                    <p class="text-muted fs-13 mb-0">
                                        Menu untuk mengelola informasi pribadi Anda, seperti memperbarui nama, alamat email, mengganti foto profil (avatar), serta melakukan pembaruan kata sandi secara mandiri.
                                    </p>
                                </div>
                            </div>
                        </div>

                        @role('admin')
                        <!-- Menu Card 3: Manajemen Aplikasi (Admin Only) -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border shadow-none bg-light-subtle">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="avatar-md bg-warning-subtle text-warning rounded-3 d-flex align-items-center justify-content-center fs-22">
                                            <i class="ti ti-apps"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0">Manajemen Aplikasi (Apps)</h6>
                                            <span class="badge bg-warning-subtle text-warning fs-11">Khusus Admin</span>
                                        </div>
                                    </div>
                                    <p class="text-muted fs-13 mb-0">
                                        Fasilitas khusus administrator untuk mengatur hirarki menu navigasi, identitas logo brand, mengaktifkan/mematikan fitur aplikasi (Feature Toggle), dan cadangan database.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Card 4: Pengaturan User (Admin Only) -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border shadow-none bg-light-subtle">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="avatar-md bg-danger-subtle text-danger rounded-3 d-flex align-items-center justify-content-center fs-22">
                                            <i class="ti ti-users-group"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0">Pengaturan User &amp; Hak Akses</h6>
                                            <span class="badge bg-danger-subtle text-danger fs-11">Khusus Admin</span>
                                        </div>
                                    </div>
                                    <p class="text-muted fs-13 mb-0">
                                        Modul pengelolaan seluruh akun pengguna di sistem, pemberian Peran (Role), pengesahan akun pendaftar (Approval), serta permintaan reset password.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Card 5: Audit Log & Log Login -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border shadow-none bg-light-subtle">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="avatar-md bg-info-subtle text-info rounded-3 d-flex align-items-center justify-content-center fs-22">
                                            <i class="ti ti-history"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0">Log Aktivitas &amp; Login</h6>
                                            <span class="badge bg-info-subtle text-info fs-11">Transparansi System</span>
                                        </div>
                                    </div>
                                    <p class="text-muted fs-13 mb-0">
                                        Jurnal catatan riwayat akses yang mencatat IP address, waktu login, dan aktivitas penting guna menjamin keamanan serta akuntabilitas data.
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endrole

                        <!-- Menu Card 6: Tentang Aplikasi -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border shadow-none bg-light-subtle">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="avatar-md bg-secondary-subtle text-secondary rounded-3 d-flex align-items-center justify-content-center fs-22">
                                            <i class="ti ti-info-circle"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0">Tentang Aplikasi (About)</h6>
                                            <small class="text-muted">Pusat Bantuan &amp; Panduan</small>
                                        </div>
                                    </div>
                                    <p class="text-muted fs-13 mb-0">
                                        Halaman yang Anda buka saat ini, berfungsi sebagai panduan teoretis penggunaan sistem, instruksi navigasi, dan jawaban atas pertanyaan umum (FAQ).
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================== TAB 2: FITUR NAVIGASI & TAMPILAN (UMUM) ==================== -->
                <div class="tab-pane fade" id="tab-navigation" role="tabpanel">
                    <h5 class="fw-bold text-dark mb-3"><i class="ti ti-compass text-success me-2"></i>Panduan Komponen Antarmuka Pengguna</h5>
                    <p class="text-muted fs-14 mb-4">
                        Aplikasi ini dilengkapi dengan antarmuka modern yang responsif dan dapat disesuaikan. Berikut adalah fungsi elemen-elemen penting pada antarmuka:
                    </p>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="border p-3 rounded-3 bg-white h-100 shadow-sm">
                                <h6 class="fw-bold text-dark mb-2"><i class="ti ti-layout-sidebar-left-collapse text-primary me-2"></i>1. Sidebar Navigation (Menu Samping)</h6>
                                <p class="text-muted fs-13 mb-2">
                                    Terletak di sebelah kiri layar. Anda dapat mengkliknya untuk berpindah modul. Jika Anda menginginkan tampilan layar yang lebih luas, klik tombol <i class="ti ti-menu-4"></i> di bagian atas untuk meminimalkan sidebar.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border p-3 rounded-3 bg-white h-100 shadow-sm">
                                <h6 class="fw-bold text-dark mb-2"><i class="ti ti-language text-info me-2"></i>2. Alih Bahasa (Multi-Language Switcher)</h6>
                                <p class="text-muted fs-13 mb-2">
                                    Di bagian atas (Topbar), terdapat ikon bendera yang memungkinkan Anda mengganti bahasa antarmuka antara **Bahasa Indonesia** dan **Bahasa Inggris** secara langsung tanpa perlu memuat ulang halaman.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border p-3 rounded-3 bg-white h-100 shadow-sm">
                                <h6 class="fw-bold text-dark mb-2"><i class="ti ti-palette text-warning me-2"></i>3. Customizer Tema &amp; Mode Gelap (Dark Mode)</h6>
                                <p class="text-muted fs-13 mb-2">
                                    Gunakan tombol pengatur tema (Customizer) untuk mengubah skema warna antarmuka dari mode Terang (Light Mode) ke Mode Gelap (Dark Mode) sesuai kenyamanan mata Anda.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border p-3 rounded-3 bg-white h-100 shadow-sm">
                                <h6 class="fw-bold text-dark mb-2"><i class="ti ti-bell text-danger me-2"></i>4. Pusat Notifikasi &amp; Profil Cepat</h6>
                                <p class="text-muted fs-13 mb-2">
                                    Ikon lonceng notifikasi di bagian kanan atas memberikan pemberitahuan instan mengenai aktivitas akun Anda. Klik foto profil untuk langsung masuk ke halaman pengaturan akun atau Keluar (Log Out).
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================== TAB 3: KEAMANAN AKUN & ETIKA (UMUM) ==================== -->
                <div class="tab-pane fade" id="tab-security-guide" role="tabpanel">
                    <h5 class="fw-bold text-dark mb-3"><i class="ti ti-shield-lock text-warning me-2"></i>Kebijakan Keamanan Akun &amp; Etika Penggunaan</h5>
                    <p class="text-muted fs-14 mb-4">
                        Keamanan data adalah prioritas bersama. Harap perhatikan petunjuk keamanan berikut saat mengoperasikan akun Anda:
                    </p>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="border p-3 rounded bg-light text-center h-100">
                                <div class="avatar-lg bg-warning-subtle text-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fs-28">
                                    <i class="ti ti-key"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-2">Kata Sandi Kuat</h6>
                                <p class="text-muted fs-12 mb-0">
                                    Gunakan kata sandi berupa kombinasi huruf kapital, huruf kecil, angka, dan simbol. Jangan bagikan kata sandi Anda kepada siapapun.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border p-3 rounded bg-light text-center h-100">
                                <div class="avatar-lg bg-danger-subtle text-danger rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fs-28">
                                    <i class="ti ti-logout"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-2">Selalu Log Out</h6>
                                <p class="text-muted fs-12 mb-0">
                                    Selalu akhiri sesi Anda dengan menekan tombol **Log Out** sebelum meninggalkan komputer atau saat menggunakan perangkat bersama.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border p-3 rounded bg-light text-center h-100">
                                <div class="avatar-lg bg-info-subtle text-info rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fs-28">
                                    <i class="ti ti-eye-check"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-2">Pencatatan Audit Log</h6>
                                <p class="text-muted fs-12 mb-0">
                                    Sistem secara otomatis mencatat setiap aktivitas dan lokasi login demi transparansi dan perlindungan akun dari akses tidak sah.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================== TAB 4: PERTANYAAN UMUM (FAQ - UMUM) ==================== -->
                <div class="tab-pane fade" id="tab-faq" role="tabpanel">
                    <h5 class="fw-bold text-dark mb-3"><i class="ti ti-help text-info me-2"></i>Pertanyaan Yang Sering Diajukan (FAQ)</h5>

                    <div class="accordion accordion-flush custom-accordion" id="faqAccordion">
                        <div class="accordion-item border rounded mb-3 overflow-hidden">
                            <h2 class="accordion-header" id="faqOne">
                                <button class="accordion-button fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true">
                                    <i class="ti ti-question-mark me-2 text-primary"></i>Bagaimana cara mengubah foto profil saya?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted fs-13">
                                    Anda dapat mengubah foto profil dengan dua cara:
                                    <ol class="mb-0 ps-3 mt-1">
                                        <li>Buka menu profil di pojok kanan atas, lalu pilih <strong>Profile</strong>. Unggah foto baru pada kartu profil.</li>
                                        <li>Atau jika fitur profil di sidebar aktif, klik langsung pada foto avatar Anda di bagian atas sidebar untuk memilih foto baru.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border rounded mb-3 overflow-hidden">
                            <h2 class="accordion-header" id="faqTwo">
                                <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    <i class="ti ti-question-mark me-2 text-primary"></i>Mengapa beberapa menu tidak tampil pada akun saya?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted fs-13">
                                    Visibilitas menu diatur berdasarkan <strong>Peran (Role)</strong> dan <strong>Hak Akses (Permission)</strong> akun Anda. Menu administratif hanya dapat diakses oleh akun dengan Peran Administrator. Hubungi admin sistem jika Anda memerlukan hak akses tambahan.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border rounded mb-3 overflow-hidden">
                            <h2 class="accordion-header" id="faqThree">
                                <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                    <i class="ti ti-question-mark me-2 text-primary"></i>Bagaimana jika saya lupa kata sandi (password)?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted fs-13">
                                    Pada halaman Login, klik tautan <strong>Lupa Password</strong> dan ikuti instruksi yang diberikan. Sistem akan mengirimkan permintaan reset password ke email Anda atau meneruskannya ke administrator untuk diverifikasi.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border rounded mb-0 overflow-hidden">
                            <h2 class="accordion-header" id="faqFour">
                                <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                    <i class="ti ti-question-mark me-2 text-primary"></i>Bagaimana cara mengubah bahasa aplikasi?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted fs-13">
                                    Klik ikon bendera di bagian kanan atas (Topbar) untuk berpindah antara pilihan <strong>English</strong> atau <strong>Bahasa Indonesia</strong>.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @role('admin')
                <!-- ==================== TAB 5: ARSITEKTUR & TECH STACK (KHUSUS ADMIN) ==================== -->
                <div class="tab-pane fade" id="tab-techstack" role="tabpanel">
                    <div class="row g-4">
                        <div class="col-lg-7">
                            <h5 class="fw-bold text-dark mb-3"><i class="ti ti-layers-intersect text-primary me-2"></i>Ringkasan Arsitektur &amp; Teknologi Utama</h5>
                            <p class="text-muted fs-14">
                                Aplikasi <span class="fw-bold text-primary">INSPINIA Laravel 2026</span> dibangun di atas fondasi ekosistem modern <span class="fw-bold text-danger">Laravel {{ $systemInfo['laravel_version'] }}</span> dengan arsitektur modular yang mengutamakan performa, fleksibilitas RBAC (Role-Based Access Control), dan antarmuka pengguna yang terstruktur rapi.
                            </p>

                            <div class="table-responsive mt-3">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 30%; min-width: 220px;">Komponen</th>
                                            <th style="width: 32%;">Teknologi / Library</th>
                                            <th>Keterangan / Fungsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold text-dark"><i class="ti ti-brand-laravel text-danger me-2"></i>Backend Framework</td>
                                            <td><span class="badge bg-danger-subtle text-danger fw-bold">Laravel {{ $systemInfo['laravel_version'] }}</span></td>
                                            <td>PHP Framework terpopuler dengan ORM Eloquent, Blade Engine, &amp; Service Container.</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-dark"><i class="ti ti-shield-lock text-success me-2"></i>Auth &amp; Security</td>
                                            <td><span class="badge bg-success-subtle text-success fw-bold">Breeze + Spatie Permission</span></td>
                                            <td>Autentikasi Breeze, manajemen Role &amp; Permission tersinkronisasi dengan Database.</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-dark"><i class="ti ti-layout text-primary me-2"></i>Frontend UI Kit</td>
                                            <td><span class="badge bg-primary-subtle text-primary fw-bold">INSPINIA Admin + Tabler Icons</span></td>
                                            <td>Template dashboard premium Bootstrap 5, dynamic customizer theme, &amp; 1000+ Tabler icons.</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-dark"><i class="ti ti-menu-2 text-warning me-2"></i>Dynamic Navigation</td>
                                            <td><span class="badge bg-warning-subtle text-warning fw-bold">View Composer (SidebarComposer)</span></td>
                                            <td>Menu dirender dinamis dari database sesuai Role/Permission user secara otomatis.</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-dark"><i class="ti ti-world text-info me-2"></i>Internasionalisasi (i18n)</td>
                                            <td><span class="badge bg-info-subtle text-info fw-bold">JSON i18n (en.json / id.json)</span></td>
                                            <td>Switching bahasa real-time di sisi client menggunakan data-lang attribute.</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-dark"><i class="ti ti-table text-secondary me-2"></i>Data Processing</td>
                                            <td><span class="badge bg-secondary-subtle text-secondary fw-bold">DataTables + Export Excel/PDF</span></td>
                                            <td>Manajemen tabel data besar, pencarian server-side, impor/ekspor file Excel &amp; PDF.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="card bg-light border p-4 rounded-3 h-100">
                                <h5 class="fw-bold text-dark mb-3"><i class="ti ti-info-circle text-info me-2"></i>Informasi Environment Server</h5>
                                <ul class="list-group list-group-flush bg-transparent">
                                    <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted">Status Debug (APP_DEBUG)</span>
                                        <span class="badge bg-{{ config('app.debug') ? 'warning' : 'success' }}">{{ $systemInfo['app_debug'] }}</span>
                                    </li>
                                    <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted">Zona Waktu (Timezone)</span>
                                        <span class="fw-semibold text-dark">{{ $systemInfo['timezone'] }}</span>
                                    </li>
                                    <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted">Sistem Operasi Host</span>
                                        <span class="fw-semibold text-dark">{{ $systemInfo['os'] }}</span>
                                    </li>
                                    <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted">Web Server</span>
                                        <span class="fw-semibold text-dark text-truncate style-max-w" style="max-width: 180px;">{{ $systemInfo['server_software'] }}</span>
                                    </li>
                                    <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted">Total Backup File</span>
                                        <span class="badge bg-primary rounded-pill">{{ $metrics['total_backups'] }} File</span>
                                    </li>
                                    <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                                        <span class="text-muted">Total Activity Audit Logs</span>
                                        <span class="badge bg-secondary rounded-pill">{{ number_format($metrics['total_activity_logs']) }} Logs</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================== TAB 6: STRUKTUR DIREKTORI (KHUSUS ADMIN) ==================== -->
                <div class="tab-pane fade" id="tab-structure" role="tabpanel">
                    <h5 class="fw-bold text-dark mb-3"><i class="ti ti-folder-check text-warning me-2"></i>Struktur Organisasi Kode &amp; Direktori Utama</h5>
                    <p class="text-muted fs-14 mb-4">
                        Proyek ini mengikuti standar struktur direktori <span class="fw-bold text-danger">Laravel {{ $systemInfo['laravel_version'] }}</span>, dengan pemisahan kontroler &amp; model sistem administrasi di dalam namespace <code>App\Http\Controllers\Admin\System</code> dan <code>App\Models\Admin\System</code>.
                    </p>

                    <div class="row g-3">
                        <div class="col-md-6 col-lg-4">
                            <div class="border rounded p-3 bg-white h-100 shadow-sm">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="ti ti-brand-laravel fs-24 text-danger"></i>
                                    <h6 class="mb-0 fw-bold text-dark">app/Http/Controllers/Admin/System</h6>
                                </div>
                                <p class="text-muted fs-12 mb-2">Mengolah semua logika bisnis manajemen aplikasi dan penggunanya:</p>
                                <ul class="fs-12 text-muted ps-3 mb-0">
                                    <li><code>UserController.php</code> : CRUD User, Impersonate, Approval, Import/Export</li>
                                    <li><code>RoleController.php</code> : Manajemen Peran (Admin, User, dsb.)</li>
                                    <li><code>PermissionController.php</code> : Hak akses terperinci</li>
                                    <li><code>MenuController.php</code> : Pengaturan susunan &amp; urutan menu</li>
                                    <li><code>AppFeatureController.php</code> : Toggle fitur sistem secara runtime</li>
                                    <li><code>AppProfileController.php</code> : Identitas logo &amp; nama aplikasi</li>
                                    <li><code>BackupController.php</code> : Generator dump &amp; download backup DB</li>
                                    <li><code>LoginLogController.php</code> &amp; <code>ActivityLogController.php</code> : Audit trail</li>
                                    <li><code>AboutController.php</code> : Halaman dokumentasi &amp; info sistem</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="border rounded p-3 bg-white h-100 shadow-sm">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="ti ti-database fs-24 text-info"></i>
                                    <h6 class="mb-0 fw-bold text-dark">app/Models/Admin/System</h6>
                                </div>
                                <p class="text-muted fs-12 mb-2">Model Eloquent ORM yang merepresentasikan tabel di database:</p>
                                <ul class="fs-12 text-muted ps-3 mb-0">
                                    <li><code>User.php</code> : Entri akun pengguna, avatar, approval, &amp; last seen</li>
                                    <li><code>Menu.php</code> : Menu bertingkat (parent-child), ikon, &amp; relasi role</li>
                                    <li><code>AppFeature.php</code> : Feature toggle (status ON/OFF)</li>
                                    <li><code>AppProfile.php</code> : Pengaturan singleton identitas aplikasi &amp; logo</li>
                                    <li><code>LoginLog.php</code> : Catatan IP &amp; User Agent saat pengguna login</li>
                                    <li><code>ActivityLog.php</code> : Catatan aktivitas audit sistem</li>
                                    <li><code>PasswordResetRequest.php</code> : Permintaan lupa sandi terverifikasi</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="border rounded p-3 bg-white h-100 shadow-sm">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="ti ti-eye fs-24 text-primary"></i>
                                    <h6 class="mb-0 fw-bold text-dark">resources/views</h6>
                                </div>
                                <p class="text-muted fs-12 mb-2">Komponen antarmuka antarmuka (Blade templates):</p>
                                <ul class="fs-12 text-muted ps-3 mb-0">
                                    <li><code>layouts/app.blade.php</code> : Main layout wrapper</li>
                                    <li><code>layouts/partials/sidebar.blade.php</code> : Sidebar menu utama</li>
                                    <li><code>layouts/partials/topbar.blade.php</code> : Navigation bar atas</li>
                                    <li><code>admin/system/*</code> : Halaman administratif (users, roles, permissions, app-profile, menus, backups, activity-log, about)</li>
                                    <li><code>template/*</code> : Halaman demo UI kit INSPINIA</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="border rounded p-3 bg-white h-100 shadow-sm">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="ti ti-route fs-24 text-success"></i>
                                    <h6 class="mb-0 fw-bold text-dark">routes &amp; app/View/Composers</h6>
                                </div>
                                <p class="text-muted fs-12 mb-2">Rute navigasi &amp; penyedia data otomatis:</p>
                                <ul class="fs-12 text-muted ps-3 mb-0">
                                    <li><code>routes/web.php</code> : Rute terlindungi middleware `auth` &amp; `admin` prefix</li>
                                    <li><code>routes/auth.php</code> : Rute autentikasi Laravel Breeze</li>
                                    <li><code>SidebarComposer.php</code> : View Composer yang menyuntikkan menu dinamis ke sidebar secara otomatis sebelum view dibrandol</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="border rounded p-3 bg-white h-100 shadow-sm">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="ti ti-world fs-24 text-warning"></i>
                                    <h6 class="mb-0 fw-bold text-dark">public/assets/data/translations</h6>
                                </div>
                                <p class="text-muted fs-12 mb-2">Kamus Bahasa (Multi-Language i18n JSON):</p>
                                <ul class="fs-12 text-muted ps-3 mb-0">
                                    <li><code>en.json</code> : Terjemahan Bahasa Inggris</li>
                                    <li><code>id.json</code> : Terjemahan Bahasa Indonesia</li>
                                    <li>Terintegrasi otomatis dengan <code>data-lang</code> di setiap elemen Blade HTML.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="border rounded p-3 bg-white h-100 shadow-sm">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="ti ti-server-cog fs-24 text-secondary"></i>
                                    <h6 class="mb-0 fw-bold text-dark">database/seeders &amp; migrations</h6>
                                </div>
                                <p class="text-muted fs-12 mb-2">Struktur skema awal &amp; pengisian data awal:</p>
                                <ul class="fs-12 text-muted ps-3 mb-0">
                                    <li><code>MenuSeeder.php</code> : Memuat struktur hirarki menu utama ke tabel `menus`</li>
                                    <li><code>AppFeatureSeeder.php</code> : Inisialisasi daftar fitur toggle sistem</li>
                                    <li><code>DatabaseSeeder.php</code> : Runner utama seeder</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================== TAB 7: SKEMA DATABASE (KHUSUS ADMIN) ==================== -->
                <div class="tab-pane fade" id="tab-database" role="tabpanel">
                    <h5 class="fw-bold text-dark mb-3"><i class="ti ti-database-import text-info me-2"></i>Skema Tabel &amp; Kamus Data Database</h5>
                    <p class="text-muted fs-14 mb-4">
                        Database aplikasi ini dirancang secara terstruktur dengan relasi foreign key dan indeks yang dioptimalkan untuk performa tinggi serta keandalan audit trail.
                    </p>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle border">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 20%;">Nama Tabel</th>
                                    <th style="width: 45%;">Kolom Utama &amp; Struktur</th>
                                    <th style="width: 35%;">Fungsi &amp; Relasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-primary"><i class="ti ti-table me-1"></i>users</td>
                                    <td>
                                        <code class="fs-11">id, name, email, password, avatar, points, is_approved, last_seen_at, remember_token, created_at, updated_at</code>
                                    </td>
                                    <td>Menyimpan akun pengguna. Terhubung ke Spatie Roles (`model_has_roles`) dan `login_logs`.</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-primary"><i class="ti ti-table me-1"></i>roles &amp; permissions</td>
                                    <td>
                                        <code class="fs-11">id, name, guard_name, created_at, updated_at</code>
                                    </td>
                                    <td>Tabel standar <span class="fw-bold text-success">Spatie Laravel-Permission</span> untuk mengelola Peran &amp; Hak Akses Pengguna.</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-primary"><i class="ti ti-table me-1"></i>model_has_roles &amp; role_has_permissions</td>
                                    <td>
                                        <code class="fs-11">role_id, model_type, model_id / permission_id, role_id</code>
                                    </td>
                                    <td>Pivot table penghubung antara User dengan Role, serta Role dengan Permission.</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-primary"><i class="ti ti-table me-1"></i>menus</td>
                                    <td>
                                        <code class="fs-11">id, parent_id, type, name, icon, route_name, route_params, url, badge_text, badge_class, permission_name, data_lang, is_active, sort_order</code>
                                    </td>
                                    <td>Menyimpan menu navigasi dinamis. `parent_id` mendukung hirarki bertingkat. Relasi ke `menu_role`.</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-primary"><i class="ti ti-table me-1"></i>menu_role</td>
                                    <td>
                                        <code class="fs-11">menu_id, role_id</code>
                                    </td>
                                    <td>Pivot table yang menentukan role mana saja yang memiliki hak akses melihat menu tertentu.</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-primary"><i class="ti ti-table me-1"></i>app_features</td>
                                    <td>
                                        <code class="fs-11">id, feature_key, feature_name, description, is_enabled, created_at, updated_at</code>
                                    </td>
                                    <td>Menyimpan status sakelar fitur (Feature Toggle) seperti profil sidebar, menu template, dll.</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-primary"><i class="ti ti-table me-1"></i>app_profiles</td>
                                    <td>
                                        <code class="fs-11">id, app_name, app_description, app_year, developer_name, developer_url, logo_light, logo_dark, logo_sm, favicon, allow_registration, auto_approve_registration, default_registration_role</code>
                                    </td>
                                    <td>Tabel konfigurasi singleton identitas brand aplikasi, logo light/dark/icon, &amp; kebijakan registrasi.</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-primary"><i class="ti ti-table me-1"></i>login_logs</td>
                                    <td>
                                        <code class="fs-11">id, user_id, ip_address, user_agent, status, login_at</code>
                                    </td>
                                    <td>Catatan histori keamanan setiap kali ada pengguna yang mencoba atau berhasil masuk ke sistem.</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-primary"><i class="ti ti-table me-1"></i>activity_logs</td>
                                    <td>
                                        <code class="fs-11">id, user_id, log_type, title, description, ip_address, user_agent, created_at</code>
                                    </td>
                                    <td>Audit log mendetail atas setiap tindakan penting yang dilakukan oleh pengguna/admin di dalam aplikasi.</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-primary"><i class="ti ti-table me-1"></i>password_reset_requests</td>
                                    <td>
                                        <code class="fs-11">id, user_id, status, reason, requested_at, processed_at, processed_by</code>
                                    </td>
                                    <td>Permintaan reset password oleh pengguna yang memerlukan persetujuan atau aksi administrator.</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-primary"><i class="ti ti-table me-1"></i>app_notifications</td>
                                    <td>
                                        <code class="fs-11">id, user_id, title, message, type, is_read, link, created_at</code>
                                    </td>
                                    <td>Notifikasi internal real-time untuk pengguna (misal: permintaan reset password, akun disetujui, dll.).</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endrole

            </div>
        </div>
    </div>
</div>
@endsection
