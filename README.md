# Laravel INSPINIA Admin Management System (2026)

Aplikasi Web Admin Dashboard & Management System berbasis **Laravel 11**, **Spatie Permission**, dan tema **INSPINIA Bootstrap 5**. Aplikasi ini dilengkapi dengan Manajemen Menu Dinamis, Profile Aplikasi, Backup Database, Manajemen Pengguna & Impersonasi, Fitur Reset Password Admin, Notifikasi Topbar Dinamis & Role Scoping, Sistem Poin Login Harian, Penanganan Human Error Autentikasi, serta Dukungan Multi-Bahasa.

---

## 🚀 Fitur Utamanya

### 1. 🛠️ Manajemen Aplikasi (Apps Management)
- **Manajemen Menu Dinamis**: Pengaturan menu bertingkat (*tree menu*) lengkap dengan permission, pengurutan, icon, serta sinkronisasi otomatis terjemahan multi-bahasa (`en.json` & `id.json`).
- **Profil Aplikasi & Kebijakan (Apps Profile)**: Pengaturan terpusat untuk Nama Aplikasi, Deskripsi Meta, Tahun, Nama & Link Pengembang, Branding Logo (Light, Dark, Small, Favicon), serta Kebijakan Pendaftaran Akun (Toggle Buka/Tutup Registrasi Publik, Otomatis/Manual Approval, dan Role Default Pendaftar).
- **Fitur Aplikasi & Modus Pemeliharaan (App Features)**: Kontrol toggle status aktif/non-aktif komponen aplikasi, serta fitur **Modus Pemeliharaan (Maintenance Mode)** di mana sistem dialihkan ke tampilan perbaikan untuk pengguna biasa/tamu, tetapi role **Admin** tetap diizinkan login dan mengakses seluruh aplikasi.
- **Backup Database**: Generator backup database SQL (Full Backup atau Pilih Tabel Tertentu) langsung dari dashboard dengan fitur unduh & hapus berkas backup.
- **Data Login & Poin Login Harian**:
  - Catatan otomatis aktivitas login pengguna (*IP Address*, *User Agent*, dan *Waktu Login*).
  - Sistem **Poin Login Harian** (diberikan **+1 Poin per user per hari** saat login langsung oleh pengguna; login ulang di hari yang sama atau beralih akun (*switch account / impersonasi*) tidak menambah poin).
  - Tampilan Audit Log *Read-Only* yang rapi, dilengkapi filter berdasarkan **Hari Ini**, **Role**, **Poin**, dan **Kata Kunci**.

### 2. 👥 Pengaturan Pengguna & Akses (Users Setting)
- **Manajemen Pengguna & Impersonasi (Contacts / Users)**: Manajemen akun pengguna, foto avatar, penetapan role tunggal/massal (*Bulk Assign Role*), serta fitur **Switch Akun (Impersonasi)** untuk beralih ke akun pengguna lain secara aman tanpa menambah poin login harian target.
- **Permintaan Reset Password (Password Reset Requests)**: Panel kelola permintaan reset kata sandi dari pengguna yang lupa password dengan fitur approval dan reset instan oleh Admin.
- **Export Data Pengguna (Excel & PDF)**:
  - Tombol **Export Excel** mengunduh berkas terformat `.xlsx` menggunakan PhpSpreadsheet secara otomatis sesuai filter pencarian/role/status.
  - Tombol **Cetak / Export PDF** membuka tampilan laporan rekap resmi terstruktur yang siap dicetak/disimpan sebagai PDF.
- **Aksi Massal Lengkap (Bulk Actions)**:
  - **Setujui Massal (Bulk Approve)**: Menyetujui persetujuan banyak pengguna baru sekaligus dalam satu klik.
  - **Hapus Massal (Bulk Delete)**: Menghapus banyak akun pengguna secara massal dengan dialog konfirmasi SweetAlert2.
- **Indikator Status Online / Offline Real-Time**:
  - Middleware `UpdateUserLastSeen` mencatat waktu aktif pengguna secara otomatis (`last_seen_at`).
  - Tampilan avatar pengguna dilengkapi bulatan status **Online** (hijau) atau **Offline** (abu-abu) beserta tooltip interaktif (contoh: *"Online sekarang"*, *"Aktif 5 menit yang lalu"*).
- **Impor Pengguna Massal (Bulk User Import)**:
  - Mengunduh berkas template asli `.xlsx` dan mengunggah data massal per kolom secara instan.
- **Sistem Persetujuan Pengguna Baru (User Registration Approval)**:
  - Akun pengguna baru mendaftar berstatus `Pending Approval` (`is_approved = false`) dan belum diizinkan login sebelum disetujui Admin (dapat diatur secara otomatis atau manual di menu Apps Profile).
- **Audit Log Aktivitas Sistem & Admin (Activity Audit Trail)**:
  - Menu `admin/apps-management/activity-logs` untuk memantau rekam jejak aksi administrasi lengkap dengan filter pelaku, jenis aksi, tanggal, dan IP address.

### 3. 🔔 Notifikasi Topbar Dinamis & Role Scoping (Group Notifications)
- **Notifikasi Lonceng Topbar Real-Time**: Ikon lonceng topbar dilengkapi dengan *unread badge count* dinamis.
- **Kategori Notifikasi Berkelompok**: Dukungan kategori notifikasi (`Reset Password`, `Pesan`, `Tugas`, `Sistem`).
- **Role Scoping Khusus Admin**: Notifikasi kategori `Reset Password` hanya tampak untuk pengguna ber-role **Admin**, sehingga terlindungi dari pengguna biasa.
- **Navigasi Interaktif**: Mengklik notifikasi akan menandai notifikasi tersebut dibaca dan langsung mengarahkan Admin ke halaman tujuan.
- **Aksi Massal & Hapus**: Tersedia fitur *"Tandai Semua Dibaca"* dan tombol hapus notifikasi individual.

### 4. 🔑 Autentikasi & Perlindungan Human Error
- **Halaman Login Ramah Pengguna**:
  - Dukungan masuk menggunakan **Email** maupun **Username**.
  - Tombol **Lihat Kata Sandi** (toggle ikon mata `ti ti-eye` / `ti ti-eye-off`).
  - Pesan galat presisi dalam Bahasa Indonesia:
    - Username/Email belum terdaftar: *"Username atau Email belum terdaftar."*
    - Kata sandi salah: *"Kata sandi yang Anda masukkan salah."*
- **Halaman Register & Checklist Syarat Real-Time**:
  - Penolakan email ganda: *"Email ini sudah terdaftar. Silakan gunakan email lain atau masuk ke akun Anda."*
  - **Checklist Syarat Kata Sandi Real-Time**: Indikator interaktif di bawah form register yang berubah menjadi centang hijau saat pengguna memenuhi kriteria:
    - Minimal 8 Karakter
    - Huruf Besar (A-Z)
    - Huruf Kecil (a-z)
    - Angka (0-9)
    - Konfirmasi Kata Sandi Cocok
  - Tombol **Lihat Kata Sandi** & Konfirmasi Kata Sandi.

### 5. 👤 Profil Saya & Kelengkapan Identitas Pengguna (User Identity & Profile)
- **Tabel Relasi Identity Pengguna (`user_profiles`)**: Relasi 1-to-1 dengan tabel `users` untuk menyimpan kelengkapan data pribadi, KTP, dan profil publik tanpa mengubah struktur tabel utama `users`.
- **Data KTP & Alamat Terperinci (Indonesian Identity Data)**:
  - Data KTP: `NIK` (16 digit), `Tempat Lahir`, `Tanggal Lahir`, `Jenis Kelamin`, `Agama`, dan `Status Perkawinan`.
  - Alamat Terperinci: `Alamat Jalan/Blok`, `RT`, `RW`, `Kelurahan/Desa`, `Kecamatan`, `Kota/Kabupaten`, `Provinsi`, dan `Kode Pos`.
- **Profil Profesional & Sosial Media**: Profesi/Pekerjaan, Pendidikan/Institusi, Domisili Publik, Nomor Telepon/WA, Website, Bahasa Dikuasai, Skill/Keahlian, Deskripsi *About Me*, serta Tautan Sosial Media (Facebook, Twitter/X, Instagram, LinkedIn, Dribbble, YouTube).
- **Pengaturan Tampilan Header & Banner**: Pengaturan *Motto / Banner Quote* dan *Gambar Sampul Header (Cover Image)* untuk mempercantik halaman profil pengguna.
- **Tata Letak Grid Responsif & Form Independen**:
  - Halaman `/profile` disusun menjadi 3 baris grid simetris (2 kolom berdampingan `col-lg-6` & `col-lg-6`) yang ergonomis.
  - Validasi form dikonfigurasi secara independen (`sometimes`) sehingga pengisian data di satu kartu tidak akan memicu kesalahan validasi pada kartu lain.
  - Notifikasi sukses menggunakan **SweetAlert2 Toast** berwarna hijau yang melayang interaktif di pojok kanan atas (`top-end`).
- **Foto Profil AJAX & Header Profil**: Unggah foto avatar pengguna secara langsung, indikator status online/offline, badge akumulasi poin login harian, serta tabel 10 catatan aktivitas login terbaru milik pengguna.

### 6. 🌐 UI & Fitur Antarmuka Modern
- **Auto Logout Idle (Inaktivitas Pengguna)**:
  - Pemantauan otomatis aktivitas pengguna (*mouse movement*, *keypress*, *scroll*, *click*, *touch*).
  - Sinkronisasi *localStorage* antar tab peramban sehingga interaksi di satu tab otomatis mereset timer di seluruh tab aktif.
  - Penghitungan waktu *Date.now()* akurat meskipun perangkat dalam posisi *sleep/standby* atau tab berada di *background*.
  - Mengarahkan kembali ke halaman login secara otomatis jika idle melebihi batas waktu (default 15 menit) dilengkapi pesan notifikasi *"Anda sudah logout otomatis karena tidak ada aktivitas."*
- **Dukungan Multi-Bahasa**: Peralihan bahasa cepat antara Bahasa Inggris (EN) & Bahasa Indonesia (ID).
- **Notifikasi SweetAlert2**: Integrasi konfirmasi aksi dan notifikasi toast modern dengan backdrop jernih.
- **Theme Customizer**: Pengaturan tema Dark/Light mode, warna sidebar, dan komponen responsif.
- **Tombol Scroll-to-Top**: Navigasi halaman cepat kembali ke paling atas.

---

## 📋 Langkah Instalasi (Setelah Clone dari GitHub)

Ikuti langkah-langkah berikut setelah meng-clone repository ini ke komputer lokal Anda:

### 1. Clone Repository
```bash
git clone https://github.com/AbdoelMadjid/laravel-inspinia-2026.git
cd laravel-inspinia-2026
```

### 2. Install Dependensi PHP & Node.js
```bash
composer install
npm install
```

### 3. Salin Berkas Lingkungan (.env)
```bash
# Untuk Linux/macOS:
cp .env.example .env

# Untuk Windows (Command Prompt / PowerShell):
copy .env.example .env
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Konfigurasi Database
Buka berkas `.env` lalu sesuaikan kredensial database Anda (misal: MySQL/MariaDB Laragon):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inspinia_laravel_2026
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Jalankan Migrasi & Database Seeder
Jalankan migrasi tabel beserta seeder default (termasuk MenuSeeder & Permission):
```bash
php artisan migrate --seed
php artisan db:seed MenuSeeder
```

### 7. Buat Symlink Storage
Agar foto avatar dan upload aplikasi dapat diakses secara publik:
```bash
php artisan storage:link
```

### 8. Jalankan Aplikasi Lokal
Jalankan development server Laravel dan pembangun aset frontend:
```bash
php artisan serve
```
Dan pada terminal terpisah:
```bash
npm run dev
```

Buka peramban Anda di: `http://127.0.0.1:8000`

---

## 🔑 Kredensial Akun Default (Seeder)

Setelah menjalankan `php artisan db:seed`, Anda dapat masuk menggunakan akun berikut:

- **Admin Login**:
  - **Email / Username**: `admin@example.com` atau `Admin`
  - **Password**: `password`
- **User Login**:
  - **Email / Username**: `user@example.com` atau `User`
  - **Password**: `password`

---

## 📄 Lisensi

Aplikasi ini dikembangkan menggunakan framework [Laravel](https://laravel.com) yang berlisensi [MIT License](https://opensource.org/licenses/MIT).
