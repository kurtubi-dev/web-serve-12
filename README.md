<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
# Web Service Single Sign-On (SSO) Terpadu Dinas PUPR Kabupaten Subang

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
Proyek **Web Service Single Sign-On (SSO)** resmi untuk lingkungan **Dinas Pekerjaan Umum dan Penataan Ruang (PUPR) Kabupaten Subang**. Sistem ini berfungsi sebagai *Identity Provider (IdP)* dan gerbang otentikasi satu pintu (Single Sign-On) yang menghubungkan seluruh aplikasi sektoral internal: **Bina Marga**, **Sumber Daya Air (SDA)**, **Cipta Karya**, **Tata Ruang**, hingga **Jasa Konstruksi**.

## About Laravel
---

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:
## 🏛️ Aplikasi-Aplikasi Klien Terintegrasi

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).
| No | Aplikasi | Sektor / Bidang | Client ID | Protokol |
|---|---|---|---|---|
| 1 | **SIM-JALAN Subang** | Bidang Bina Marga | `pupr_simjalan_subang_2026` | Web SSO / OAuth2 |
| 2 | **SI-IRIGASI Subang** | Bidang Sumber Daya Air (SDA) | `pupr_siirigasi_subang_2026` | Web SSO / REST API |
| 3 | **SIMBG Subang** | Bidang Cipta Karya | `pupr_simbg_subang_2026` | Web SSO / OAuth2 |
| 4 | **SI-TARU Subang** | Bidang Tata Ruang | `pupr_sitaru_subang_2026` | Web SSO / OAuth2 |
| 5 | **E-KINERJA PUPR** | Sekretariat & Kepegawaian | `pupr_ekinerja_subang_2026` | Web SSO / REST API |
| 6 | **SIPJAKI Subang** | Bidang Jasa Konstruksi | `pupr_sipjaki_subang_2026` | Web SSO / REST API |

Laravel is accessible, powerful, and provides tools required for large, robust applications.
---

## Learning Laravel
## 🔑 Akun Uji Coba Demo (Seeder)

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.
Seluruh akun default menggunakan kata sandi: `password`

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.
| Nama Pegawai | NIP | Email Dinas | Jabatan / Bidang | Role SSO |
|---|---|---|---|---|
| **Administrator IT** | `198501012010011001` | `admin.it@pupr.subang.go.id` | Pranata Komputer Ahli Muda (IT) | `superadmin` |
| **Ir. H. Deden Hendrawan, M.Si.** | `197203151998031004` | `kadis@pupr.subang.go.id` | Kepala Dinas PUPR Subang | `superadmin` |
| **Ahmad Fauzi, S.T., M.T.** | `197805202005011008` | `kabid.binamarga@pupr.subang.go.id` | Kepala Bidang Bina Marga | `admin_bidang` |
| **Bambang Sudarmono, S.T.** | `198007122006041009` | `kabid.sda@pupr.subang.go.id` | Kepala Bidang Sumber Daya Air | `admin_bidang` |
| **Siti Nurhaliza, S.T., M.Sc.** | `198209252008012015` | `kabid.ciptakarya@pupr.subang.go.id` | Kepala Bidang Cipta Karya | `admin_bidang` |
| **Rendi Pratama, S.T., M.P.W.K.** | `198304182009021003` | `kabid.tataruang@pupr.subang.go.id` | Kepala Bidang Penataan Ruang | `admin_bidang` |
| **Yudi Permana, S.T.** | `199208112019031006` | `yudi.permana@pupr.subang.go.id` | Pengawas Jalan dan Jembatan | `pengawas_lapangan` |

## Laravel Sponsors
---

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).
## 🚀 Menjalankan Server SSO

### Premium Partners
```bash
# 1. Jalankan migrasi dan seeder data awal
php artisan migrate --seed

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**
# 2. Jalankan server lokal
php artisan serve
```

## Contributing
Akses portal melalui browser di:
- **Portal Satu Pintu SSO**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Halaman Login Pegawai**: [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)
- **Dokumentasi API Terpadu**: [http://127.0.0.1:8000/docs](http://127.0.0.1:8000/docs)

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).
---

## Code of Conduct
## 📡 Daftar Endpoint Web Service (REST API)

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).
### 1. Direct API Login
- **URL**: `POST /api/v1/sso/login`
- **Body**:
  ```json
  {
    "identifier": "198501012010011001",
    "password": "password",
    "client_id": "pupr_simjalan_subang_2026"
  }
  ```
- **Response**: Mengembalikan Bearer Token dan data profil pegawai lengkap.

## Security Vulnerabilities
### 2. Token Exchange (OAuth2 Code)
- **URL**: `POST /api/v1/sso/token`
- **Body**:
  ```json
  {
    "grant_type": "authorization_code",
    "client_id": "pupr_simjalan_subang_2026",
    "client_secret": "sec_simjalan_subang_9f83a48e71b29a10",
    "code": "auth_code_dari_redirect"
  }
  ```

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.
### 3. Verifikasi Token
- **URL**: `POST /api/v1/sso/verify-token`
- **Header**: `Authorization: Bearer <token>`
- **Response**: Memastikan keabsahan token dan status keaktifan ASN di database Dinas PUPR Subang.

## License
### 4. Profil Pegawai Login
- **URL**: `GET /api/v1/sso/me`
- **Header**: `Authorization: Bearer <token>`

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
### 5. Pencarian Data Pegawai & Unit Kerja
- **URL**: `GET /api/v1/sso/pegawai?bidang=Bina Marga`
- **URL**: `GET /api/v1/sso/bidang-list`

---

## 💻 Contoh Integrasi Aplikasi Klien
File SDK contoh telah disediakan di `examples/SsoClientSample.php`.
Aplikasi klien hanya perlu mengarahkan pengguna ke:
```
http://127.0.0.1:8000/sso/authorize?client_id=pupr_simjalan_subang_2026&redirect_uri=http://simjalan.subang.go.id/auth/callback
```
Dan menukarkan kode otorisasi via endpoint `/api/v1/sso/token`.
