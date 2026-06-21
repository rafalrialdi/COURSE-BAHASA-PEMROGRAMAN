# 💻 Pemrograman — Platform Belajar Coding Bareng Kakak Tingkat

Website pelatihan pemrograman untuk mahasiswa **Universitas Pamulang (UNPAM)**. Platform ini menghubungkan mahasiswa yang ingin belajar coding dengan kakak tingkat yang siap membimbing, lengkap dengan sistem autentikasi, manajemen materi per kelas, jadwal belajar, forum diskusi, serta panel admin & tutor.

## ✨ Fitur

- 🔐 **Autentikasi** — Register & Login dengan password ter-hash (`password_hash`), proteksi via prepared statements
- 👥 **Role-based access** — 3 peran pengguna: `user`, `tutor`, `admin`, masing-masing dengan akses berbeda
- 📚 **Kelas Pemrograman** — Materi C++, Python, Java, dan JavaScript
- 🗓️ **Jadwal & Materi** — Tabel jadwal per kelas, lengkap dengan link download materi
- 💬 **Forum Diskusi** — Mahasiswa bisa posting, like, dan komentar
- 🛠️ **Panel Tutor** — Tutor dapat menambah, mengedit, dan menghapus materi kelas yang diampu
- 📊 **Panel Admin** — Dashboard statistik (grafik jumlah user & materi), kelola seluruh user dan materi

## 🧱 Tech Stack

| Layer      | Teknologi                          |
|------------|-------------------------------------|
| Backend    | PHP (native, mysqli + prepared statements) |
| Database   | MySQL / MariaDB                     |
| Frontend   | HTML, CSS (custom, tanpa framework) |
| Library    | Chart.js (statistik dashboard admin)|
| Server Lokal | XAMPP (Apache + MySQL)            |

## 📁 Struktur Folder

```
websiteku/
├── web.php / web.css              # Landing page
├── login.php / register.php       # Halaman autentikasi
├── proses_login.php               # Handler proses login
├── proses_register.php            # Handler proses register
├── logout.php                     # Proses logout
├── board.php                      # Halaman ajakan jadi tutor
├── board2.php                     # Halaman kelas (C++, Python, Java, JS)
├── board3.php                     # Halaman jadwal & materi
├── board4.php                     # Forum diskusi
├── allboard.php                   # Navbar reusable untuk halaman board
│
├── admin/                         # Panel khusus admin
│   ├── admin_auth.php             # Guard akses (role admin)
│   ├── admin_navbar.php
│   ├── dashboard.php              # Statistik & grafik
│   ├── kelola_user.php            # CRUD & ubah role user
│   ├── kelola_materi.php
│   └── proses_materi.php
│
├── tutor/                         # Panel khusus tutor
│   ├── tutor_auth.php             # Guard akses (role tutor)
│   ├── tutor_navbar.php
│   ├── kelola_materi.php
│   └── proses_materi.php
│
└── materi/                        # File materi (PDF) untuk didownload
```

## 🗄️ Struktur Database

Database: `websiteku`

**Tabel `users`**
| Kolom    | Tipe         | Keterangan                  |
|----------|--------------|------------------------------|
| id       | INT, AI, PK  |                              |
| username | VARCHAR      | unik                         |
| password | VARCHAR      | ter-hash (bcrypt)            |
| nomor    | VARCHAR      |                              |
| email    | VARCHAR      |                              |
| role     | ENUM/VARCHAR | `user`, `tutor`, `admin`     |

**Tabel `materi`**
| Kolom    | Tipe    | Keterangan                          |
|----------|---------|--------------------------------------|
| id       | INT, AI, PK |                                  |
| kategori | VARCHAR | `C++`, `Python`, `Java`, `JavaScript`|
| nama     | VARCHAR | nama tutor/pengajar                 |
| tanggal  | DATE    |                                      |
| jadwal   | VARCHAR | sesi waktu                          |
| materi   | VARCHAR | topik materi                        |
| gambar   | VARCHAR | link download materi (opsional)     |
| status   | VARCHAR | status sesi                         |

## 🚀 Instalasi Lokal (XAMPP)

1. **Clone repository ini** ke dalam folder `htdocs`:
   ```bash
   cd C:\xampp\htdocs
   git clone https://github.com/USERNAME/NAMA-REPO.git websiteku
   ```
2. **Jalankan Apache & MySQL** lewat XAMPP Control Panel.
3. **Buat database** bernama `websiteku` lewat phpMyAdmin, lalu import file `database/database.sql` untuk membuat tabel beserta data contoh.
4. Buka di browser:
   ```
   http://localhost/websiteku/web.php
   ```

### 🔑 Akun Demo

Database contoh sudah berisi 1 akun untuk masing-masing role, siap dipakai untuk testing:

| Role  | Username | Password   |
|-------|----------|------------|
| Admin | `admin`  | `admin123` |
| Tutor | `tutor1` | `tutor123` |
| User  | `user1`  | `user123`  |

## 👤 Tim Pengembang

| Nama | Peran |
|------|-------|
| Rafal Rialdi | Developer |
| Rezki Fajar Pratama | Developer |
| Faruqh Fatihul Ikwan | Developer |
| Rehan Al Amin | Developer |

---

> Dibuat sebagai proyek pelatihan pemrograman, Universitas Pamulang © 2026
