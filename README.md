<div align="center">

# 🏥 MediCore Hospital System

**Sistem Manajemen Rumah Sakit Berbasis Web Modern**

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)](https://mysql.com)
[![Blade](https://img.shields.io/badge/Blade-Templating-F05340?logo=laravel&logoColor=white)](https://laravel.com/docs/blade)
[![License](https://img.shields.io/badge/License-MIT-22C55E)](#-lisensi)

</div>

---

## 📋 Deskripsi

**MediCore** adalah sistem informasi manajemen rumah sakit (*Hospital Information System*) berskala penuh yang dirancang untuk mengelola seluruh operasional klinik dan rumah sakit secara efisien. Dibangun dengan **Laravel 13** dan arsitektur *Single-Page Dashboard*, sistem ini menyediakan antarmuka modern yang sangat *user-friendly* dengan implementasi **Role-Based Access Control** (RBAC) yang memisahkan fitur dan akses berdasarkan peran: **Admin**, **Dokter**, **Kasir**, dan **Apoteker**.

### Highlight
- 🎨 UI/UX premium dengan glassmorphism, animasi mikro, dan desain responsif
- 📊 Dashboard analytics real-time dengan grafik pendapatan & kunjungan 7 hari terakhir
- 🔄 Single-Page Architecture — seluruh modul berjalan di satu halaman dashboard tanpa reload
- 📱 Fully responsive untuk desktop maupun mobile

---

## ✨ Fitur Utama

### 🔐 Role-Based Access Control (RBAC)
- Empat peran pengguna: **Admin**, **Dokter**, **Kasir**, dan **Apoteker**.
- Menu sidebar dan navigasi dinamis menyesuaikan wewenang masing-masing peran.
- Session management dan CSRF protection pada seluruh endpoint.

### 🧑‍⚕️ Manajemen Pasien & Data Master
- Pendaftaran pasien baru dengan **nomor rekam medis otomatis**.
- Data komprehensif: identitas, NIK, tanggal lahir, jenis kelamin, kontak, alamat.
- Dukungan jaminan kesehatan: **BPJS**, **Asuransi**, atau **Umum**.
- Pencarian dan filter pasien secara real-time.

### 🚶 Sistem Antrean Rawat Jalan
- Pembuatan **nomor antrean cerdas** otomatis saat registrasi rawat jalan.
- Nomor antrean menyesuaikan dengan poliklinik tujuan dan urutan per hari.
- Status progresif: `Menunggu` → `Diperiksa` → `Selesai` / `Dibatalkan`.
- Tracking jumlah pasien per status secara real-time.

### 🛏️ Manajemen Rawat Inap & Ruangan
- Pendaftaran pasien rawat inap beserta alokasi ruangan/bed.
- Monitoring kapasitas, ketersediaan bed, dan tarif per ruangan (VVIP, VIP, ICU, Umum).
- Status rawat inap: `Menunggu` → `Sedang Dirawat` → `Selesai`.
- Manajemen ruangan: tambah, edit, hapus, dan pantau status aktif/nonaktif.

### 📝 Rekam Medis Elektronik
- Histori rekam medis terpadu per pasien.
- Pencatatan diagnosis, keluhan, tindakan, dan catatan dokter.
- Pemisahan rekam medis berdasarkan tipe admisi (Rawat Jalan / Rawat Inap).
- Statistik jumlah rekam medis per kategori.

### 💊 Farmasi & E-Resep
- Manajemen stok obat lengkap dengan kode obat, harga, satuan, dan deskripsi.
- Peringatan **stok menipis** (*low stock warning*) secara otomatis.
- Pembuatan **E-Resep** oleh dokter yang langsung terhubung dengan apotek.
- Pengurangan stok otomatis saat resep ditebus.
- Status resep: `Menunggu` → `Diberikan` / `Dibatalkan`.
- Seeder bawaan menyertakan 8 jenis obat umum siap pakai.

### 💳 Keuangan & Invoicing
- Pembuatan tagihan (**Invoice**) terintegrasi dengan kunjungan pasien.
- Nomor invoice otomatis dengan format `INV-YYYYMMDD-XXXXX`.
- Dukungan metode pembayaran: **Tunai**, **Transfer Bank**, **Asuransi / BPJS**, dan **Kartu Kredit/Debit**.
- Fitur bayar **Sebagian (Parsial)** maupun **Lunas**, beserta riwayat status cicilan.
- Kalkulasi otomatis biaya berdasarkan tindakan, obat, dan ruangan.

### 🏥 Manajemen Poliklinik & Dokter
- CRUD poliklinik lengkap dengan status aktif/nonaktif.
- Manajemen data dokter: nama, spesialisasi, SIP, dan relasi poliklinik.
- Statistik jumlah dokter aktif dan spesialisasi unik.

### 📊 Dashboard Analytics & Laporan
- Visualisasi **grafik pendapatan** dan **grafik kunjungan pasien** 7 hari terakhir.
- Ringkasan KPI: Total Pasien, Dokter Aktif, Rawat Jalan Hari Ini, Rawat Inap Aktif.
- Monitoring pendapatan harian dan bulanan.
- Kalender jadwal kunjungan pasien.
- **Ekspor CSV** untuk laporan keuangan dan data pasien.

### 📅 Kalender & Jadwal
- Tampilan kalender interaktif untuk jadwal kunjungan.
- Pengelompokan admisi berdasarkan tanggal.
- Overview harian untuk seluruh aktivitas rumah sakit.

---

## 🛠️ Tech Stack

| Komponen       | Teknologi                                |
|----------------|------------------------------------------|
| Backend        | **Laravel 13.x** (PHP 8.3+)             |
| Database       | MySQL 8.0 / MariaDB                     |
| Frontend       | Blade Templating + Vanilla CSS           |
| Fonts          | Sora, Space Mono (Google Fonts)          |
| Icons          | SVG Inline                               |
| Auth           | Laravel Built-in Auth Guard              |
| Export         | Native CSV Streaming                     |
| Architecture   | Single-Page Dashboard, Fat Controllers   |

---

## 🚀 Instalasi & Setup

### Prasyarat
- PHP >= 8.3
- Composer
- MySQL / MariaDB
- Node.js & npm (untuk Vite asset build)

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/PresTuuu/Rumahsakit.git
cd Rumahsakit

# 2. Install dependency PHP
composer install

# 3. Install dependency JavaScript
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Konfigurasi database di .env
#    Sesuaikan dengan kredensial database lokal Anda:
#    DB_DATABASE=rumahsakit
#    DB_USERNAME=root
#    DB_PASSWORD=password

# 7. Jalankan migration dan seeder
#    (Wajib untuk membuat akun demo & data obat bawaan)
php artisan migrate --seed

# 8. Build asset frontend
npm run build

# 9. Jalankan server development
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

> **💡 Shortcut**: Jalankan `composer dev` untuk menjalankan server, queue, log watcher, dan Vite secara bersamaan menggunakan **concurrently**.

---

### 🔑 Akun Demo (Role-Based)

Gunakan salah satu kredensial berikut untuk menguji sistem:

| Role               | Nama                 | Email                      | Password                |
|--------------------|----------------------|----------------------------|-------------------------|
| **Administrator**  | System Administrator | `admin@medicore.hospital`  | `Admin@MediCore2024!`   |
| **Dokter**         | Dr. Budi Santoso     | `dokter@medicore.hospital` | `password`              |
| **Kasir**          | Mbak Kasir           | `kasir@medicore.hospital`  | `password`              |
| **Apoteker**       | Mas Apoteker         | `apoteker@medicore.hospital` | `password`            |

> ⚠️ **Catatan Keamanan**: Kredensial di atas hanya untuk lingkungan *development/staging*. Di production, segera ganti password setelah login pertama.

---

## 📁 Struktur Database

```
users                    → Akun sistem & peran (RBAC: admin, dokter, kasir, apoteker)
patients                 → Identitas pasien & data rekam medis
doctors                  → Tenaga medis, spesialisasi & SIP
polikliniks              → Unit layanan medis (poli)
rooms                    → Fasilitas rawat inap (kapasitas, tarif, ketersediaan)
medicines                → Inventaris farmasi (stok, harga, minimum stok)
admissions               → Pendaftaran kunjungan (Rawat Jalan & Rawat Inap)
medical_records          → Histori klinis & catatan medis
prescriptions            → E-Resep (header resep)
prescription_items       → Detail resep per obat (qty, dosis, aturan pakai)
invoices                 → Tagihan, pembayaran & metode bayar
```

### Entity Relationship

```
patients ──< admissions >── doctors
                │                │
                ├── rooms        ├── polikliniks
                │                │
                ├── medical_records
                │
                ├── invoices
                │
                └── prescriptions ──< prescription_items >── medicines
```

---

## 📂 Struktur Proyek

```
app/
├── Http/Controllers/
│   ├── Auth/LoginController.php       # Autentikasi & session
│   ├── DashboardController.php        # Dashboard utama (fat controller)
│   ├── PatientController.php          # CRUD pasien
│   ├── DoctorController.php           # CRUD dokter
│   ├── RoomController.php             # CRUD ruangan
│   ├── PoliklinikController.php       # CRUD poliklinik
│   ├── MedicineController.php         # CRUD obat
│   ├── AdmissionController.php        # Rawat Jalan & Rawat Inap
│   ├── MedicalRecordController.php    # Rekam medis
│   ├── PrescriptionController.php     # E-Resep & farmasi
│   ├── InvoiceController.php          # Tagihan & pembayaran
│   └── ExportController.php           # Ekspor CSV
├── Models/                            # 11 Eloquent models
database/
├── migrations/                        # 25 migration files
├── seeders/
│   ├── DatabaseSeeder.php             # Orchestrator
│   ├── UserSeeder.php                 # 4 akun demo
│   └── MedicineSeeder.php            # 8 obat bawaan
resources/views/
├── auth/Login.blade.php               # Halaman login (premium UI)
└── dashboard.blade.php                # Single-page dashboard
```

---

## 📌 Roadmap / Pengembangan Selanjutnya

- [ ] Laporan bulanan PDF (Invoice PDF export)
- [ ] Integrasi Payment Gateway (Midtrans / Xendit)
- [ ] Notifikasi WhatsApp / Email untuk antrean pasien
- [ ] Modul HRD untuk jadwal *shift* dokter dan perawat
- [ ] Multi-tenancy untuk jaringan klinik / rumah sakit
- [ ] REST API untuk integrasi aplikasi mobile
- [ ] Audit log untuk tracking perubahan data sensitif
- [ ] Dark mode pada dashboard

---

## 🤝 Kontribusi

Kontribusi dari komunitas sangat terbuka! Silakan fork repository ini, buat *branch* fitur Anda, dan kirimkan *Pull Request*.

```bash
# Fork & clone
git clone https://github.com/<your-username>/Rumahsakit.git

# Buat branch fitur
git checkout -b fitur/nama-fitur

# Commit & push
git commit -m "feat: deskripsi fitur"
git push origin fitur/nama-fitur

# Buat Pull Request di GitHub
```

## 📄 Lisensi

Proyek ini menggunakan lisensi [MIT License](LICENSE).

---

<div align="center">

**Dibuat dengan ❤️ oleh Angger Restu Prayogo**

*MediCore Hospital System — v1.0*

</div>
