# LMS Boilerplate with Laravel Filament CMS

This repository provides a **boilerplate** for a multi-panel LMS with a Laravel + Filament-based block CMS and Blade templates.

⚠️ Note: This is a boilerplate, not a complete project.

---

## 🚀 Features
- Laravel 12+ framework
- Filament admin panel for content management
- Block-based CMS with Blade templates
- Storage for block-specific assets (images, files, JS, CSS)
- Example layout for frontend with block rendering

---

## 🛠️ Installation

Follow the steps below to set up the project.

### 1. Clone the repository
```bash
git clone https://github.com/ArslanJazib/laravel-filament-block-based-cms-blade.git
cd laravel-filament-block-based-cms-blade
```

### 2. Install dependencies
```bash
composer install
npm install && npm run dev
```

### 3. Configure environment
Copy `.env.example` to `.env` and update database and storage settings.
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Run migrations and seeders
```bash
php artisan migrate --seed
```

### 5. Storage symlink
Ensure block assets (images, files) are accessible:
```bash
php artisan storage:link
```

This will make files stored in `storage/app/public` available under `/storage`.

---

## 📂 File Storage Conventions
- Block images → `storage/blocks/{block_slug}/images/`
- Block files → `storage/blocks/{block_slug}/files/`
- Access via `asset("storage/blocks/{block_slug}/images/filename.jpg")`

---

## ▶️ Running the Application
Start the local server:
```bash
php artisan serve
```

The app will be available at:
```
http://127.0.0.1:8000
```

---

## 📑 Notes
- Update `public/css/blocks/{block_slug}/{block_slug}.css` for block-specific styles.
- Update `public/js/blocks/{block_slug}/{block_slug}.js` for block-specific scripts.
- Submenus in header menus are supported as dropdowns.

---

## 📜 License
This boilerplate is open-source and available for customization.
