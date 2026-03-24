# PHP_Laravel12_DB_Auditor

## Project Description

**PHP_Laravel12_DB_Auditor** is a Laravel 12 application that demonstrates how to integrate the [laravel-db-auditor](https://github.com/vcian/laravel-db-auditor) package by **Vcian (ViitorCloud)**.

This package audits your **MySQL / SQLite / PostgreSQL** database and provides insights into database standards, missing constraints (Primary Key, Foreign Key, Unique, Index), and column naming standards — all accessible via both **CLI (Artisan commands)** and a **Web UI** at `/laravel-db-auditor`.

This project is **beginner-friendly** and helps understand how to use the DB Auditor package to maintain a clean, well-structured database during Laravel development.

---

## Features

- 🔍 Audit database tables for missing constraints (Primary Key, Foreign Key, Unique, Index)
- 📋 Check column naming standards across all tables
- ➕ Add missing constraints directly from CLI — no manual SQL needed
- 🌐 Web UI Dashboard at `/laravel-db-auditor` to view audit results visually
- 📦 Track migration history with the `db:track` command
- ⏭️ Skip specific tables from auditing via config file
- 🗄️ Supports MySQL, SQLite, and PostgreSQL

---

## Technologies Used

| Technology | Purpose |
|---|---|
| PHP 8.1+ | Backend Language |
| Laravel 12 | PHP Framework |
| MySQL | Database |
| laravel-db-auditor | Database Audit Package by Vcian |
| Blade Templates | Web UI Views |
| Tailwind CSS | Web UI Styling |

---

## How It Works

```
Laravel project  →  Install DB Auditor  →  Run audit commands  →  Fix database issues! 🎉
```

1. Install the `vcian/laravel-db-auditor` package via Composer.
2. Publish the config file to configure which tables to skip.
3. Create your database tables (migrations).
4. Run `php artisan db:audit` to scan your database.
5. View results in CLI or visit `http://127.0.0.1:8000/laravel-db-auditor` for the Web UI.

---

## Installation Steps

---

### STEP 1: Create Laravel 12 Project

Open terminal / CMD and run:

```bash
composer create-project laravel/laravel PHP_Laravel12_DB_Auditor "12.*"
```

Go inside the project folder:

```bash
cd PHP_Laravel12_DB_Auditor
```

> This installs a fresh Laravel 12 project and moves into the project folder.

---

### STEP 2: Database Setup

Update `.env` with your database details:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:your_generated_key_here
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=php_laravel12_db_auditor
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

VITE_APP_NAME="${APP_NAME}"
```

Create database in MySQL / phpMyAdmin:

```
Database name: php_laravel12_db_auditor
```

Then run:

```bash
php artisan migrate
```

> Connects Laravel with MySQL and creates the default tables.

---

### STEP 3: Install the DB Auditor Package

```bash
composer require --dev vcian/laravel-db-auditor
```

> Installs the `laravel-db-auditor` package as a development dependency.

---

### STEP 4: Publish the Config File

```bash
php artisan vendor:publish --tag=db-auditor-config
```

This creates: `config/db-auditor.php`

Open: `config/db-auditor.php`

```php
<?php
// config for Vcian/LaravelDbAuditor

return [
    /*
    |--------------------------------------------------------------------------
    | Skip Tables
    |--------------------------------------------------------------------------
    |
    | Specify the tables that you want to skip during auditing.
    |
    */

    'skip_tables' => [
        'cache',
        'sqlite_sequence',
        'migrations',
        'migrations_history',
        'sessions',
        'password_resets',
        'failed_jobs',
        'jobs',
        'queue_job',
        'queue_failed_jobs',
    ]
];
```

> This config file lets you define which tables should be skipped during the audit process.
> Laravel system tables like `migrations`, `sessions`, `jobs` etc. are skipped by default.

---

### STEP 5: Create a Migration (Example - Products Table)

Run:

```bash
php artisan make:migration create_products_table
```

Open: `database/migrations/xxxx_create_products_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer('p_id');   // ← intentionally missing primary key constraint
            $table->string('title');   // ← intentionally missing constraints
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
```

Then run:

```bash
php artisan migrate
```

> This creates a `products` table **intentionally without proper constraints** so the DB Auditor can detect and report the missing standards.

---

### STEP 6: Run the Audit (CLI)

#### Option A — Interactive Audit (Recommended)

```bash
php artisan db:audit
```

> This command presents an interactive menu where you can choose to:
> - Check database standards (column naming)
> - Check constraints (Primary, Foreign, Unique, Index)
> - Add missing constraints directly from the CLI

#### Option B — Check Standards Only

```bash
php artisan db:standard
```

> Lists all tables and columns that do not follow proper naming standards.

#### Option C — Check Constraints Only

```bash
php artisan db:constraint
```

> Lists all tables showing their existing constraints (Primary Key, Foreign Key, Unique, Index).
> Also provides an option to add missing constraints directly.

#### Option D — Track Migration History

```bash
php artisan db:track
```

> Shows migration history including: table name, fields created, creation date, and the Git username of who created it.

---

### STEP 7: Access the Web UI

Start the development server:

```bash
php artisan serve
```

Open in browser:

```
http://127.0.0.1:8000/laravel-db-auditor
```

> The Web UI dashboard shows a visual overview of your database audit results including table-wise constraint status, standards violations, and foreign key relationships.

---

## Available Artisan Commands

| Command | Purpose |
|---|---|
| `php artisan db:audit` | Interactive audit — choose standards or constraints check |
| `php artisan db:standard` | Check column naming standards for all tables |
| `php artisan db:constraint` | Check and add constraints for all tables |
| `php artisan db:track` | View migration history with fields and Git author |

---

## Web UI Routes (Auto-Registered by Package)

| Method | URL | Purpose |
|---|---|---|
| `GET` | `/laravel-db-auditor` | Main audit dashboard |
| `GET` | `api/getAudit` | Get full audit data (JSON) |
| `GET` | `api/getTableData/{table}` | Get data for a specific table |
| `GET` | `api/gettableconstraint/{table}` | Get constraints for a specific table |
| `GET` | `api/foreign-key-table` | Get foreign key relationships |

> All these routes are automatically registered by the package when you install it. No manual route setup is needed.

---

## Expected Output

### CLI Audit Output Example:

```
+----------+---------+-------+--------+-------+
| Table    | Primary | Index | Unique | Foreign |
+----------+---------+-------+--------+-------+
| products |   ✗     |   ✗   |   ✗    |   ✗   |
| users    |   ✓     |   ✓   |   ✓    |   ✗   |
+----------+---------+-------+--------+-------+
```

### Web UI:

| URL | What You See |
|---|---|
| `http://127.0.0.1:8000/laravel-db-auditor` | Full audit dashboard with table list and constraint status |

---

<img width="1319" height="705" alt="Screenshot 2026-03-24 134550" src="https://github.com/user-attachments/assets/44b35cc5-ed89-4e38-9e92-48f53cd68f0e" />
<img width="1315" height="698" alt="Screenshot 2026-03-24 134813" src="https://github.com/user-attachments/assets/b24cb7b3-ecaa-4fd1-9d18-ddf2914a6f4b" />
<img width="1317" height="708" alt="Screenshot 2026-03-24 135204" src="https://github.com/user-attachments/assets/2067c4b5-232a-4b16-9561-893dd7917c10" />
<img width="1297" height="678" alt="Screenshot 2026-03-24 135421" src="https://github.com/user-attachments/assets/00b0fdb3-93af-4a65-adf4-e226caf9e408" />
<img width="1300" height="716" alt="Screenshot 2026-03-24 135701" src="https://github.com/user-attachments/assets/3f634b08-5dd4-4ad5-b307-582d16986d3f" />
<img width="1919" height="858" alt="Screenshot 2026-03-24 140657" src="https://github.com/user-attachments/assets/361cefe4-2ade-4358-b19f-1ec6f04d073d" />
<img width="1897" height="873" alt="Screenshot 2026-03-24 140709" src="https://github.com/user-attachments/assets/150083f5-0191-4261-9ab6-2a1845c20133" />
<img width="1918" height="846" alt="Screenshot 2026-03-24 140724" src="https://github.com/user-attachments/assets/e948f5ae-d0c6-4673-8cd9-781dd1bf9935" />


## Project Folder Structure

```
PHP_Laravel12_DB_Auditor/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   └── Models/
│
├── bootstrap/
│   └── app.php
│
├── config/
│   ├── db-auditor.php             ← Published config (skip_tables list)
│   ├── database.php
│   └── ...
│
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   └── xxxx_create_products_table.php  ← Custom migration (example table)
│   │
│   └── database.sqlite
│
├── public/
│   ├── auditor/
│   │   └── icon/                  ← Web UI icons (auto-published by package)
│   │       ├── add.svg
│   │       ├── check.svg
│   │       ├── close.svg
│   │       └── ...
│   └── index.php
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│
├── routes/
│   └── web.php
│
├── vendor/
│   └── vcian/
│       └── laravel-db-auditor/    ← Installed package
│
├── .env                           ← DB connection + App config
├── artisan
├── composer.json
└── README.md
```

---

## Useful Commands Summary

| Command | Purpose |
|---|---|
| `composer require --dev vcian/laravel-db-auditor` | Install the DB Auditor package |
| `php artisan vendor:publish --tag=db-auditor-config` | Publish the config file |
| `php artisan migrate` | Run all migrations |
| `php artisan db:audit` | Run interactive database audit |
| `php artisan db:standard` | Check column naming standards |
| `php artisan db:constraint` | Check and fix table constraints |
| `php artisan db:track` | View migration history |
| `php artisan serve` | Start local development server |

---
