
# SUKOATI-ADMIN

SUKOATI-ADMIN adalah dashboard starter yang dibangun dengan menggunakan stack V.I.L.T (Vue Inertia.js Laravel Tailwind). Aplikasi ini memungkinkan pengguna untuk mengelola menu berdasarkan role / permission, mengelola database dan form builder dari dashboard sukoati-admin. Dengan fitur Form Builder anda dapat membuat CRUD data master lebih cepat.

## Instalasi

Langkah-langkah untuk menginstal proyek ini di lingkungan pengembangan Anda:

1. Clone repositori ini ke dalam direktori lokal Anda.
```shell
    git clone https://github.com/ikyprima/sukoati-admin.git
    #masuk ke direktori
    cd sukoati-admin
```
2. Instal dependensi PHP dengan Composer.
```shell
    composer install
```
3. Instal dependensi JavaScript dengan NPM atau Yarn.
```shell
    npm install
    # atau
    yarn install
```
4. Membuat file .env  atau bisa salin .env.example menjadi .env
kemudian sesuaikan konfigurasi database anda.
```shell
    cp .env.example .env
    #generate key aplikasi
    php artisan key:generate
```
5. Migrasi database
``` shell
    php artisan migrate
```
6. Persiapan User dan konfigurasi Sukoati-Admin
```shell
    php artisan sukoati:install
```
## Lisensi

Proyek ini dilisensakan di bawah [MIT license](https://opensource.org/licenses/MIT).
