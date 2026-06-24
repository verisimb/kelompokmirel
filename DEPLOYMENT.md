# 🚀 Panduan Deploy SPK E-Wallet ke Coolify

Dokumen ini menjelaskan langkah-langkah lengkap untuk men-deploy aplikasi Laravel SPK E-Wallet ke VPS menggunakan **Coolify**.

---

## Prasyarat

| Kebutuhan | Detail |
|-----------|--------|
| VPS | Ubuntu 22.04 / Debian 12 (min. 1 vCPU, 1GB RAM) |
| Coolify | v4.x terinstall di VPS |
| Git Repository | Project sudah di-push ke GitHub / GitLab / Gitea |
| Domain | Domain / subdomain yang mengarah ke IP VPS (opsional untuk SSL) |

---

## Bagian 1: Install Coolify di VPS (jika belum)

SSH ke VPS Anda, lalu jalankan:

```bash
curl -fsSL https://cdn.coollabs.io/coolify/install.sh | bash
```

Setelah selesai, akses Coolify di: `http://<IP-VPS>:8000`

Buat akun admin saat pertama kali login.

---

## Bagian 2: Push Project ke Git

Pastikan semua file sudah di-commit termasuk:
- `Dockerfile`
- `docker/` directory (nginx, supervisor, entrypoint)
- `composer.lock`
- `package-lock.json`

```bash
# Di terminal lokal, dari direktori project:
git add .
git commit -m "chore: add production Docker configuration"
git push origin main
```

> ⚠️ **Jangan commit file `.env`!** Semua environment variable diisi di Coolify UI.

---

## Bagian 3: Setup MySQL di Coolify

1. Login ke Coolify → **New Resource** → **Database** → **MySQL**
2. Konfigurasi:
   - **Name**: `spk-ewallet-db`
   - **MySQL Version**: `8.0`
   - **Database Name**: `spk_ewallet`
   - **Username**: `spkuser`
   - **Password**: buat password yang kuat (simpan untuk langkah berikutnya)
3. Klik **Deploy** dan tunggu hingga database siap (status: Running 🟢)
4. Salin **Internal DB URL** atau catat **hostname internal** service MySQL (biasanya berupa nama service seperti `spk-ewallet-db` atau IP internal)

---

## Bagian 4: Deploy Aplikasi Laravel

### 4.1 Tambahkan Aplikasi Baru

1. Di Coolify → **New Resource** → **Application**
2. Pilih source: **GitHub** / **GitLab** / **Gitea** (sesuai lokasi repo Anda)
3. Authorize Coolify untuk akses ke repo Anda
4. Pilih repository: `spk-E-Wallet`
5. Pilih branch: `main`

### 4.2 Konfigurasi Build

| Setting | Value |
|---------|-------|
| **Build Pack** | `Dockerfile` |
| **Dockerfile Location** | `/Dockerfile` |
| **Port** | `80` |
| **Base Directory** | `/` |

### 4.3 Konfigurasi Environment Variables

Di tab **Environment Variables**, tambahkan semua variabel berikut:

```env
APP_NAME=SPK E-Wallet
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Generate key: php artisan key:generate --show
APP_KEY=base64:XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX

DB_CONNECTION=mysql
DB_HOST=           # ← Hostname internal MySQL dari langkah 3
DB_PORT=3306
DB_DATABASE=spk_ewallet
DB_USERNAME=spkuser
DB_PASSWORD=       # ← Password MySQL dari langkah 3

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

LOG_CHANNEL=stderr
LOG_LEVEL=error

BCRYPT_ROUNDS=12
```

> 💡 **Generate APP_KEY** di terminal lokal Anda:
> ```bash
> php artisan key:generate --show
> ```
> Salin outputnya ke `APP_KEY` di Coolify.

### 4.4 Konfigurasi Domain (Opsional tapi Recommended)

1. Di tab **Domains**, masukkan domain Anda: `https://spk-ewallet.yourdomain.com`
2. Coolify akan otomatis setup **SSL via Let's Encrypt**
3. Pastikan DNS domain sudah mengarah ke IP VPS (record A)

### 4.5 Deploy!

1. Klik tombol **Deploy** (atau **Save and Deploy**)
2. Monitor log build di tab **Logs**
3. Proses build biasanya 3–8 menit (pertama kali)
4. Setelah status **Running 🟢**, akses aplikasi via domain/IP Anda

---

## Bagian 5: Seeder Data Awal (Opsional)

Jika ingin mengisi data awal (admin user, dll), jalankan seeder setelah deploy berhasil:

Di Coolify → aplikasi Anda → tab **Terminal** (atau gunakan SSH):

```bash
php artisan db:seed --class=AdminSeeder
# atau seeder penuh:
php artisan db:seed
```

---

## Troubleshooting

### Container tidak bisa start

Cek log di Coolify → **Logs**:
```
Container startup logs akan tampil di sini
```

### Error "Connection refused" ke database

Pastikan `DB_HOST` menggunakan **hostname internal** MySQL dari Coolify, bukan `127.0.0.1`.

### Error "No application encryption key"

Pastikan `APP_KEY` sudah diisi di environment variables. Generate dengan:
```bash
php artisan key:generate --show
```

### Permission denied di storage

Entrypoint script sudah handle ini otomatis. Jika masih error, cek log container dan pastikan volume storage ter-mount dengan benar.

### Build gagal di npm

Pastikan `package-lock.json` **sudah di-commit** ke repository (sudah dihapus dari `.gitignore`).

---

## Struktur File Docker yang Dibuat

```
spk-E-Wallet/
├── Dockerfile                          ← Multi-stage build (Node + Composer + PHP-FPM/Nginx)
├── docker-compose.yml                  ← Untuk testing lokal
└── docker/
    ├── entrypoint.sh                   ← Startup script (migrate, cache, permissions)
    ├── nginx/
    │   └── default.conf                ← Nginx server block untuk Laravel
    └── supervisor/
        └── supervisord.conf            ← Manage PHP-FPM + Nginx + Queue Worker
```

---

## Testing Lokal Sebelum Deploy

Untuk memverifikasi konfigurasi Docker sebelum deploy ke Coolify:

```bash
# Buat file .env.docker untuk testing
cp .env.example .env.docker
# Edit .env.docker: set DB_HOST=db, isi DB_PASSWORD, APP_KEY

# Build & jalankan
docker compose --env-file .env.docker up --build

# Akses di: http://localhost:8080
```

Untuk menghentikan:
```bash
docker compose down
```
