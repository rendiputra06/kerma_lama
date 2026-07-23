# Sistem Informasi Kerja Sama (SIMKERMA) - CodeIgniter 3 HMVC

SIMKERMA (Sistem Informasi Kerja Sama) adalah aplikasi berbasis web yang dibangun dengan framework **CodeIgniter 3 HMVC (Modular Extensions)**, menggunakan template **AdminLTE v3 (Bootstrap 4)**, sistem keamanan/ACL dari **Ion Auth**, serta dilengkapi kustomisasi CRUD Generator dari **Harviacode**.

Aplikasi ini disesuaikan untuk manajemen dokumen kerja sama (MOU/MOA/IA) pada Universitas Abdurrab.

---

## ⚡ Cara Menjalankan Project dengan Docker

Cara tercepat dan paling direkomendasikan untuk menjalankan project ini secara lokal adalah menggunakan **Docker Compose**. Dengan Docker, Anda tidak perlu menginstal PHP 7.4 secara manual di sistem operasi Anda.

### 📋 Prasyarat
Pastikan Anda sudah menginstal:
*   [Docker](https://docs.docker.com/get-docker/)
*   [Docker Compose](https://docs.docker.com/compose/install/)

### 🚀 Langkah-Langkah Menjalankan
1.  **Clone Repositori**
    Clone project ini ke komputer lokal Anda.

2.  **Siapkan Konfigurasi Lingkungan (.env) & Database**
    Salin berkas konfigurasi `.env.example` ke `.env` (silakan sesuaikan nilainya jika diperlukan):
    ```bash
    cp .env.example .env
    ```
    Kemudian, salin berkas konfigurasi database CodeIgniter khusus Docker:
    ```bash
    cp application/config/database.php.docker application/config/database.php
    ```


3.  **Jalankan Container Docker**
    Di terminal pada direktori root project, jalankan perintah berikut:
    ```bash
    docker compose up -d --build
    ```
    *Catatan: Docker secara otomatis akan membangun container web (PHP 7.4 + Apache) dan container database (MariaDB 10.5). Berkas basis data `u586555303_kerma.sql` akan diimpor secara otomatis saat container database pertama kali dibuat.*

4.  **Akses Aplikasi**
    Buka browser Anda dan akses:
    *   **Aplikasi Web**: [http://localhost:8010](http://localhost:8010)
    *   **Database (MariaDB)**: Port `3307` (Username: `root`, Password: `root`)

---

## 🔑 Akses Login Default

Gunakan kredensial berikut untuk masuk ke dashboard admin:
*   **Email/Username**: `sutaji@univrab.ac.id` atau `admin`
*   **Password**: `password`

---

## 📂 Struktur Penting & Direktori Upload
Berkas unggahan diabaikan oleh Git. Container Docker secara otomatis membuat folder-folder ini pada saat build. Jika Anda menjalankannya di luar Docker, pastikan folder berikut dibuat secara manual di root project dan memiliki izin tulis (`chmod 777`):
*   `uploads/kerma/` (untuk dokumen kerja sama)
*   `uploads/panduan/` (untuk dokumen panduan)
*   `uploads/kegiatan/` (untuk dokumentasi kegiatan)
*   `uploads/penerapan/` (untuk berkas implementasi)

---

## 🛠️ Informasi Teknis & Fitur
1.  **Framework**: CodeIgniter v3.1.x (HMVC support php v7.4).
2.  **UI/UX**: AdminLTE v3 + Bootstrap v4 + Select2.
3.  **ACL**: Ion Auth (Manajemen user, group, dan izin akses).
4.  **CRUD Generator**: Harviacode (Output otomatis disimpan di `./application/modules/`).
5.  **Dual Database**:
    *   `default`: Menghubungkan ke container MariaDB lokal.
    *   `siakad`: Menghubungkan ke database akademik eksternal (`45.64.255.105`). *Catatan: Jika koneksi eksternal ini gagal/timeout saat di lokal, harap sesuaikan atau mock pemanggilannya di `Siakad_model.php`.*
