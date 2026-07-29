# Panduan Pembuatan Website (Laravel) — Mulai dari Awal

Panduan ini menjelaskan langkah-langkah membuat website berbasis Laravel dari awal hingga siap dideploy. Ikuti langkah secara berurutan.

## Prasyarat
- PHP 8.1+ terpasang
- Composer terpasang
- Node.js & npm terpasang
- Database (MySQL / MariaDB / PostgreSQL) tersedia
- Git (opsional) untuk version control

## 1. Inisialisasi Proyek
1. Buat project baru dengan Composer:

```bash
composer create-project laravel/laravel nama-proyek
cd nama-proyek
```

2. Inisialisasi Git (opsional):

```bash
git init
git add .
git commit -m "Initial commit"
```

## 2. Konfigurasi Lingkungan dan Database
1. Salin file contoh lingkungan dan generate app key:

```bash
cp .env.example .env
php artisan key:generate
```

2. Edit `.env` untuk mengatur koneksi database:
- `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

3. (Opsional) atur `APP_URL` dan pengaturan email/queue/redis sesuai kebutuhan.

## 3. Install Dependensi
1. Install dependensi PHP:

```bash
composer install
```

2. Install dependensi frontend:

```bash
npm install
```

3. Build assets untuk development:

```bash
npm run dev
```

## 4. Setup Otentikasi
Pilih salah satu scaffolding otentikasi:

- Laravel Breeze (ringan):

```bash
composer require laravel/breeze --dev
php artisan breeze:install
npm install && npm run dev
php artisan migrate
```

- Laravel Jetstream (fitur lengkap):

```bash
composer require laravel/jetstream
php artisan jetstream:install livewire
npm install && npm run dev
php artisan migrate
```

Atau implementasi manual sesuai kebutuhan.

## 5. Buat Model, Migration, Controller, dan Route Utama
1. Contoh membuat resource `Employee`:

```bash
php artisan make:model Employee -mcr
```
- `-mcr` membuat migration, controller resource, dan model.

2. Edit migration di `database/migrations/...` lalu jalankan migrasi:

```bash
php artisan migrate
```

3. Tambah route resource di `routes/web.php`:

```php
Route::resource('employees', EmployeeController::class);
```

4. Buat view di `resources/views/employees/` dan isi controller untuk CRUD.

## 6. Seed Database
1. Buat seeder:

```bash
php artisan make:seeder HumanResourcesSeeder
```

2. Implementasikan seeder di `database/seeders/HumanResourcesSeeder.php`, lalu jalankan:

```bash
php artisan db:seed --class=HumanResourcesSeeder
```

Atau jalankan semua seeder:

```bash
php artisan db:seed
```

## 7. Bangun Frontend dan Assets
1. Gunakan Tailwind CSS (atau framework pilihan):

```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

2. Konfigurasi `tailwind.config.js` dan import di `resources/css/app.css`.
3. Build untuk production sebelum deploy:

```bash
npm run build
```

## 8. Menulis & Menjalankan Test
1. Gunakan Pest atau PHPUnit. Contoh menjalankan Pest:

```bash
./vendor/bin/pest
```

2. Menjalankan PHPUnit:

```bash
vendor/bin/phpunit
```

Tambahkan test feature/unit di `tests/Feature` dan `tests/Unit`.

## 9. Konfigurasi Queue, Scheduler, dan Storage
- Set up supervisor/systemd untuk queue worker di server produksi.
- Konfigurasi `cron` untuk scheduler: `* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1`.
- Jalankan `php artisan storage:link` untuk menyinkronkan storage.

## 10. Build & Deploy ke Produksi
Pilihan deployment:
- Vercel / DigitalOcean App Platform / Laravel Forge
- Manual: push ke server, jalankan `composer install --no-dev`, `php artisan migrate --force`, `npm run build`.

Contoh langkah deploy manual:

```bash
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
npm ci
npm run build
```

## 11. Monitoring & Maintenance
- Pantau logs di `storage/logs/laravel.log`.
- Setup backups database dan file.
- Terapkan SSL, rate-limiting, dan monitoring (Sentry, NewRelic, dsb.).

## File & Struktur Penting
- `routes/web.php` — definisi route web
- `app/Http/Controllers` — controller
- `app/Models` — model
- `resources/views` — blade templates
- `database/migrations` — skema database
- `database/seeders` — data awal

## Tips Praktis
- Gunakan environment khusus (local/staging/production).
- Automasi deployment dengan CI/CD.
- Gunakan feature branch dan code review.

---

Jika Anda ingin, saya bisa:
- Menyesuaikan panduan ini ke struktur proyek Anda saat ini dan menambahkan perintah spesifik.
- Menjalankan migrasi, seed, atau build di lingkungan lokal Anda.

