<div align="center">

# 🏥 MediCore Hospital System

**Sistem Manajemen Rumah Sakit Berbasis Web Modern**

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-3.x-38B2AC?logo=tailwind-css)](https://tailwindcss.com)

</div>

---

## 📋 Deskripsi

MediCore adalah sistem informasi manajemen rumah sakit berskala penuh yang dirancang untuk mengelola seluruh operasional klinik dan rumah sakit secara efisien. Sistem ini menyediakan antarmuka modern yang sangat *user-friendly* dengan implementasi *Role-Based Access Control* (RBAC) yang memisahkan fitur berdasarkan akses Admin, Dokter, Kasir, dan Apoteker.

---

## ✨ Fitur Utama

### 🔐 Role-Based Access Control (RBAC)
- Akses tersentralisasi dengan pemisahan peran: **Admin**, **Dokter**, **Kasir**, dan **Apoteker**.
- Menu dan navigasi disesuaikan secara dinamis berdasarkan wewenang pengguna.

### 🧑‍⚕️ Manajemen Pasien & Rekam Medis
- Pendaftaran pasien baru dengan nomor rekam medis otomatis.
- Data komprehensif: identitas, jaminan kesehatan (BPJS/Asuransi/Umum), dan kontak.
- Histori rekam medis terpadu per pasien.

### 🚶 Sistem Antrean Rawat Jalan Otomatis
- Pembuatan **nomor antrean cerdas** secara otomatis saat registrasi rawat jalan.
- Nomor antrean menyesuaikan dengan poliklinik tujuan dan urutan per hari.
- Status progresif: Menunggu → Diperiksa → Selesai.

### 🛏️ Manajemen Rawat Inap & Ruangan
- Pendaftaran pasien rawat inap beserta alokasi ruangan/bed.
- Monitoring kapasitas, ketersediaan *bed*, dan tarif per ruangan (VVIP, VIP, ICU, Umum).
- Status rawat inap: Menunggu → Dirawat → Selesai.

### 💊 Farmasi & E-Resep
- Manajemen stok obat dengan peringatan stok menipis (*low stock warning*).
- Pembuatan E-Resep oleh dokter yang langsung terhubung dengan apotek.
- Pengurangan stok otomatis saat resep ditebus, dan pembatalan otomatis saat resep dibatalkan.

### 💳 Keuangan & Integrasi Pembayaran
- Pembuatan tagihan (Invoice) terintegrasi dengan kunjungan.
- Dukungan metode pembayaran beragam: **Tunai**, **Transfer Bank**, **Asuransi / BPJS**, dan **Kartu Kredit/Debit**.
- Fitur bayar **Sebagian (Parsial)** maupun **Lunas**, beserta riwayat status cicilan.

### 📊 Laporan & Analytics Dashboard
- Visualisasi data kunjungan dan pendapatan rumah sakit secara *real-time*.
- Ekspor **Laporan Keuangan** dan **Data Pasien** ke format CSV / Excel dengan satu klik.
- Fitur ringkasan indikator kinerja rumah sakit (Total Pasien, Kunjungan Hari Ini, Pendapatan).

---

## 🛠️ Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| Backend | **Laravel 13.x** (PHP 8.2+) |
| Database | MySQL 8.0 |
| Frontend | Blade Templating + Tailwind CSS |
| Icons | SVG Inline |
| Fonts | Sora, Space Mono |
| Architecture | Thin Routes, Fat Controllers |

---

## 🚀 Instalasi & Setup

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL / MariaDB

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/username/rumahsakit.git
cd rumahsakit

# 2. Install dependency PHP
composer install

# 3. Copy environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Konfigurasi database di .env
DB_DATABASE=rumahsakit
DB_USERNAME=root
DB_PASSWORD=password

# 6. Jalankan migration dan seeder (Wajib untuk membuat akun demo)
php artisan migrate --seed

# 7. Jalankan server development
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

### Akun Demo (Role Based)
Gunakan salah satu kredensial berikut untuk menguji sistem:

| Role | Email | Password |
|------|-------|----------|
| **Administrator** | admin@medicore.hospital | password |
| **Dokter** | dokter@medicore.hospital | password |
| **Kasir** | kasir@medicore.hospital | password |
| **Apoteker** | apoteker@medicore.hospital | password |

---

## 📁 Struktur Database

```
users                    → Akun sistem & peran (RBAC)
patients                 → Identitas rekam medis
doctors                  → Tenaga medis & SIP
polikliniks              → Layanan medis
rooms                    → Fasilitas rawat inap
medicines                → Inventaris farmasi
prescriptions            → E-Resep
prescription_items       → Detail resep per obat
admissions               → Pendaftaran & Antrean
medical_records          → Histori klinis
invoices                 → Tagihan & Metode Pembayaran
```

---

## 📌 TODO / Pengembangan Selanjutnya

- [ ] Laporan bulanan PDF (Invoice PDF export)
- [ ] Integrasi Payment Gateway (Midtrans/Xendit)
- [ ] Notifikasi WhatsApp / Email untuk antrean pasien
- [ ] Modul HRD untuk jadwal *shift* dokter dan perawat

---

## 🤝 Kontribusi

Kontribusi dari komunitas sangat terbuka! Silakan fork repository ini, buat *branch* fitur Anda, dan kirimkan *Pull Request*.

## 📄 Lisensi

Proyek ini menggunakan lisensi [MIT License](LICENSE).

---

<div align="center">
<b>Dibuat oleh Angger Restu Prayogo</b>
</div>
