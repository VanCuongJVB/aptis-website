# Aptis Lite Overlay (Laravel 11)

This is a **minimal overlay** to clone an Aptis-like Reading & Listening quiz
experience for internal students with whitelist + access window, and a simple admin.

## Quick Start

1) Create a fresh Laravel 11 project:
```bash
composer create-project laravel/laravel:^11 aptis-lite
cd aptis-lite
```

2) Install Breeze (Blade) for auth & Tailwind:
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run build
```

3) Copy **all files** from this overlay into your Laravel project root (overwrite if prompted).

4) Configure DB in `.env`, then run migrations & seed:
```bash
php artisan migrate
php artisan db:seed --class=StarterSeeder
```

5) Serve:
```bash
php artisan serve
```

**Admin login:** `admin@example.com` / password: `password` (change ASAP).

## What you get

- Student side: login, list published quizzes, do Reading/Listening quizzes with a global timer.
- Admin: manage quizzes & questions/options, publish/unpublish, import students via CSV (email, access_start, access_end, name optional).
- Whitelist + access window check for students.

> This overlay favors **simplicity** (no extra packages).
> CSV import is basic (use a small file). You can later switch to maatwebsite/excel if needed.
