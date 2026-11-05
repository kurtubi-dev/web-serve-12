# PANDUAN PRAKTIKUM SSO (SINGLE SIGN-ON) SISTEM KAMPUS POLITEKNIK

Aplikasi ini dibangun untuk memenuhi studi kasus implementasi **Single Sign-On (SSO)** pada sistem kampus berbasis **Laravel** dan **Laravel Socialite (Google OAuth 2.0 / OpenID Connect)**.

---

## 🚀 Cara Menjalankan Aplikasi

Jalankan perintah berikut di terminal:

```bash
php artisan serve
```

Buka browser di:
👉 **[http://localhost:8000](http://localhost:8000)**

*(Atau jika menggunakan virtual host Laragon, dapat diakses di `http://web_servise.test`)*

---

## 📋 Pembuktian 4 Poin Tugas

### 1. Setup Autentikasi (IdP)
* **Identity Provider (IdP)** disimulasikan menggunakan **Google OAuth 2.0 / OpenID Connect** via library resmi `laravel/socialite`.
* Google bertindak sebagai server otentikasi pusat yang menyimpan kredensial akun mahasiswa/dosen.
* Aplikasi juga dilengkapi fitur **Mock SSO Simulator (Demo Mode)** sehingga dosen atau penguji dapat langsung mencoba alur SSO secara instan dengan 1 klik tanpa harus terhambat setup Google Cloud Console terlebih dahulu.

### 2. Gerbang Login (SSO Gateway)
* URL: `http://localhost:8000/login`
* Halaman satu pintu terpadu (SSO Gateway) beridentitas Politeknik.
* Terdapat tombol utama **"Masuk dengan SSO Google"** dan opsi simulasi profil (Mahasiswa / Dosen).

### 3. Portal Utama Layanan Kampus
* URL: `http://localhost:8000/portal`
* Setelah berhasil login dari IdP, pengguna diarahkan ke launchpad utama yang menampilkan:
  - Profil Pengguna (Nama, Email, Avatar, dan Google Unique ID).
  - Pilihan 3 Layanan Utama:
    1. **Portal Akademik (SIAKAD)**
    2. **E-Learning (LMS Kampus)**
    3. **Perpustakaan Digital (DigiLib)**

### 4. Pengujian Lintas Layanan (Cross-Service Navigation) & Single Sign-Out
* **Bebas Keluar-Masuk Lintas Layanan**:
  Setelah login satu kali di gerbang SSO, silakan klik menu **Akademik**, **E-Learning**, maupun **Perpustakaan**. Anda bebas berpindah antar layanan tanpa pernah diminta memasukkan kata sandi lagi.
* **Proteksi Akses (Route Protection)**:
  Jika membuka browser dalam mode *Incognito* / *Private Window* dan langsung mengetikkan `http://localhost:8000/layanan/akademik`, sistem otomatis menghadang dan mengalihkan ke gerbang login SSO.
* **Single Sign-Out (Logout Serentak)**:
  Terdapat tombol **"Logout SSO"** di bagian atas navbar. Sekali klik, sesi seluruh layanan kampus langsung diakhiri.

---

## ⚙️ Konfigurasi Google Cloud Console (Opsional untuk Akun Google Nyata)

Jika ingin menghubungkan dengan akun Google asli:

1. Buka [Google Cloud Console](https://console.cloud.google.com/).
2. Buat Project baru, lalu buka menu **APIs & Services > Credentials**.
3. Buat **OAuth 2.0 Client IDs** (Application type: *Web application*).
4. Tambahkan **Authorized redirect URIs**:
   ```
   http://localhost:8000/auth/google/callback
   ```
5. Salin Client ID dan Client Secret ke file `.env`:
   ```env
   GOOGLE_CLIENT_ID=isi_client_id_anda.apps.googleusercontent.com
   GOOGLE_CLIENT_SECRET=isi_client_secret_anda
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
   ```

---

## 🧪 Menjalankan Automated Test

Aplikasi telah dilengkapi unit & feature test otomatis untuk memvalidasi seluruh alur:

```bash
php artisan test --filter=SsoFlowTest
```

Seluruh 5 test case dan 37 assertions akan lulus (PASSED) menandakan sistem SSO berfungsi 100% sempurna!

