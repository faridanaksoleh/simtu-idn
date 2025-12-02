```markdown
# 🕌 SIMTU - Sistem Monitoring Tabungan Umrah Mahasiswa
**Aplikasi Manajemen Tabungan Umrah Berbasis Web untuk Politeknik IDN**

Aplikasi berbasis web untuk membantu mahasiswa Politeknik IDN dalam mengelola tabungan Umrah secara terstruktur, transparan, dan terintegrasi.

## ✨ Fitur Utama

### 👥 Manajemen Pengguna
- Autentikasi Multi-Role (Admin, Koordinator, Mahasiswa)
- Manajemen Profil Pengguna
- Hak Akses Berdasarkan Role

### 💰 Manajemen Transaksi
- Pencatatan Transaksi Setoran
- Upload Bukti Pembayaran
- Approval/Reject Transaksi oleh Admin
- Riwayat Transaksi dengan Filter & Pencarian

### 🎯 Target Tabungan
- Target Tabungan Personal
- Progress Otomatis dengan Visualisasi
- Pengingat Target

### 📊 Dashboard & Laporan
- Dashboard Statistik & Grafik (ApexCharts)
- Export Laporan ke PDF/Excel
- Notifikasi Sistem

## 🛠️ Teknologi Stack

| Kategori | Teknologi | Versi |
|----------|-----------|-------|
| **Backend** | Laravel | 12 |
| **Frontend** | Livewire | 3 |
| **UI/UX** | Bootstrap 5 + NiceAdmin | - |
| **Database** | MySQL | 5.7+ |
| **Visualisasi** | ApexCharts | - |
| **Development** | PHP | 8.2+ |

## 🚀 Instalasi & Setup

### Prasyarat
- PHP 8.2+
- Composer
- MySQL 5.7+
- Node.js 18+

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/faridanaksoleh/simtu-idn.git
   cd simtu-idn
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   ```bash
   cp .env.example .env
   ```
   Edit file `.env` dan sesuaikan:
   ```env
   DB_DATABASE=simtu-idn
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Key & Database**
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   ```

5. **Jalankan Server**
   ```bash
   php artisan serve
   ```
   Akses: **http://localhost:8000**

## 📁 Struktur Proyek
```
simtu-idn/
├── app/
│   ├── Http/Controllers/
│   ├── Livewire/
│   ├── Models/
│   └── View/Components/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   └── css/js/
└── public/
```

## 🧪 Testing
```bash
php artisan test
```

## 🚀 Deployment (Production)
1. Set `APP_ENV=production` dan `APP_DEBUG=false` di `.env`
2. `php artisan optimize`
3. `php artisan config:clear`

## 🤝 Berkontribusi
1. Fork repository
2. Buat branch baru (`git checkout -b feature/NamaFitur`)
3. Commit perubahan (`git commit -m 'Tambahkan fitur'`)
4. Push ke branch (`git push origin feature/NamaFitur`)
5. Buat Pull Request

## 📚 Dokumentasi
- [Laravel Docs](https://laravel.com/docs)
- [Livewire Docs](https://livewire.laravel.com/docs)
- [Bootstrap 5 Docs](https://getbootstrap.com/docs/5.0)
- [ApexCharts Docs](https://apexcharts.com/docs)

## 📄 Lisensi
MIT License

## 👥 Kontak
- **Developer**: Muhamad Faridz Akhsan
- **Email**: itspuyd@gmail.com
- **Institusi**: Politeknik IDN
```
