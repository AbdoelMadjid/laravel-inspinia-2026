# Laravel INSPINIA Admin Management System (2026)

Aplikasi Web Admin Dashboard & Management System berbasis **Laravel 11**, **Spatie Permission**, dan tema **INSPINIA Bootstrap 5**. Aplikasi ini dilengkapi dengan Manajemen Menu Dinamis, Profile Aplikasi, Backup Database, Manajemen Pengguna & Impersonasi, Fitur Reset Password Admin, Notifikasi Topbar Dinamis & Role Scoping, Sistem Poin Login Harian, Penanganan Human Error Autentikasi, serta Dukungan Multi-Bahasa.

---

## 🚀 Fitur Utamanya

### 1. 🛠️ Manajemen Aplikasi (Apps Management)
- **Manajemen Menu Dinamis**: Pengaturan menu bertingkat (*tree menu*) lengkap dengan permission, pengurutan, icon, serta sinkronisasi otomatis terjemahan multi-bahasa (`en.json` & `id.json`).
- **Profil Aplikasi (Apps Profile)**: Pengaturan nama aplikasi, logo, favicon, deskripsi meta, dan teks footer dengan sistem caching bawaan.
- **Fitur Aplikasi (App Features)**: Kontrol toggle status aktif/non-aktif fitur aplikasi secara fleksibel.
- **Backup Database**: Generator backup database SQL (Full Backup atau Pilih Tabel Tertentu) langsung dari dashboard dengan fitur unduh & hapus berkas backup.
- **Data Login & Poin Login Harian**:
  - Catatan otomatis aktivitas login pengguna (*IP Address*, *User Agent*, dan *Waktu Login*).
  - Sistem **Poin Login Harian** (diberikan **+1 Poin per user per hari**, login ulang di hari yang sama mendapat 0 poin).
  - Tampilan Audit Log *Read-Only* yang rapi, dilengkapi filter berdasarkan **Hari Ini**, **Role**, **Poin**, dan **Kata Kunci**.

### 2. 👥 Pengaturan Pengguna & Akses (Users Setting)
- **Manajemen Pengguna (Contacts / Users)**: Manajemen akun pengguna, foto avatar, penetapan role tunggal/massal (*Bulk Assign Role*).
- **Fitur Impersonasi (User Impersonation)**: Administrator dapat *login sebagai* user lain untuk keperluan debugging atau bantuan teknis dengan bar notifikasi *Stop Impersonating*.
- **Permintaan Reset Password (Reset Password Requests)**:
  - Permintaan reset password oleh pengguna di halaman `/forgot-password` ditangkap otomatis di menu **Users Setting -> Reset Password**.
  - Administrator dapat mereset akun ke password default (`password123`) atau menolak permintaan.
  - Dialog konfirmasi aksi menggunakan **SweetAlert2 Modal Tengah** (`Swal.fire`).
- **Peran Pengguna (Roles Management)**: Pembuatan & pengaturan role (Spatie RBAC).
- **Izin Akses (Permissions Management)**: Matriks dan manajemen daftar permission aplikasi.

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

### 5. 👤 Profil Saya & Riwayat Aktivitas
- **Foto Profil AJAX**: Unggah foto profil pengguna secara langsung tanpa *reload* halaman.
- **Badge Total Poin Login**: Menampilkan total akumulasi poin login harian di header profil.
- **Tabel Riwayat Login**: Menampilkan 10 catatan aktivitas login terbaru milik pengguna di halaman profil.

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
