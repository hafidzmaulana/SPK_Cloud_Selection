# SPK Cloud Computing dengan Metode SAW (Laravel + Orchid)

Ini adalah aplikasi web Sistem Pendukung Keputusan (SPK) untuk membantu memilih layanan Cloud Computing terbaik menggunakan metode **Simple Additive Weighting (SAW)**. Aplikasi ini dibangun menggunakan **Laravel** dengan **Orchid Admin Panel** sebagai dashboard-nya.

## ✨ Fitur Utama

### 1. Manajemen Kriteria
- Tambah, ubah, dan hapus kriteria
- Set bobot kriteria (0-100)
- Tentukan tipe kriteria: `Benefit` atau `Cost`

### 2. Manajemen Alternatif (Layanan Cloud)
- Tambah, ubah, dan hapus layanan cloud
- Input nilai setiap alternatif terhadap semua kriteria

### 3. Proses SAW
- Normalisasi nilai berdasarkan tipe kriteria
- Hitung nilai akhir tiap alternatif
- Tampilkan ranking layanan terbaik berdasarkan skor

### 4. Ekspor
- Ekspor hasil ranking ke PDF *(opsional)*

## 🛠️ Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/username/nama-repo.git
cd nama-repo
```

### 2. Install Dependency
```bash
composer install
npm install && npm run build
```

### 3. Copy & Atur File `.env`
```bash
cp .env.example .env
```
Lalu edit file `.env` untuk menyesuaikan koneksi database, dll.

### 4. Generate Key & Migrasi Database
```bash
php artisan key:generate
php artisan migrate
```

### 5. Jalankan Aplikasi
```bash
php artisan serve
```

## 🔐 Login Dashboard Orchid

Setelah registrasi, login ke:
```
http://localhost:8000/admin
```

## 📦 Struktur Folder Penting

- `app/Models` - Model Laravel (Criteria, Alternative, dsb)
- `app/Orchid/Screens` - Halaman-pengelola di Orchid
- `app/Orchid/Layouts` - Layout tampilan tabel/form Orchid

## 🧠 Metode SAW

1. **Normalisasi**:
   - Benefit: `nilai / nilai maks`
   - Cost: `nilai min / nilai`

2. **Perhitungan Akhir**:
   - `skor akhir = Σ (nilai normal × bobot)`

## 📋 Lisensi

Proyek ini dirilis dengan lisensi MIT.

---
