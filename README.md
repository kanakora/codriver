# Kanakora (Codriver Platform)

A content-driven driving education platform built with Laravel 12, Inertia.js v2, Vue 3, and Tailwind CSS v4. Admins manage lessons, classrooms, categories, and users, while students browse published learning content. The public site also promotes driving-related services such as classes, insurance, NTSA services, and vehicle resources.

## Highlights

- **Public website** — landing page with hero, service categories, pricing, and contact form.
- **Authentication** — Laravel Fortify with login, registration, password reset, email verification, and two-factor authentication.
- **Role-based access control** — powered by `spatie/laravel-permission` with `admin` and `student` roles.
- **Admin dashboard** — manage lessons, classrooms, categories, users, and roles.
- **Lesson management** — text, PDF, video, and external link content with draft/published states, scheduling, and revisions.
- **Content revisions** — upload history and restore previous versions of lesson content.
- **User administration** — create users, edit details, assign roles, and send password reset links.
- **Settings** — profile, password, appearance, and two-factor authentication pages.
- **Dark mode** — system-aware light/dark theme.

## Tech Stack

| Layer | Technology |
| --- | --- |
| Backend | PHP 8.2+, Laravel 12 |
| Auth | Laravel Fortify |
| Frontend | Vue 3, Inertia.js v2 |
| Styling | Tailwind CSS v4 |
| Build | Vite 7 |
| RBAC | spatie/laravel-permission |
| Slugs | spatie/laravel-sluggable |
| Routing helper | Ziggy |
| Testing | Pest 4 |
| Formatting | Laravel Pint, Prettier |

## Requirements

- PHP **8.2+** with the usual Laravel extensions (`pdo`, `mbstring`, `openssl`, `fileinfo`, etc.)
- [Composer](https://getcomposer.org/)
- Node.js **18+** (npm) or [Bun](https://bun.sh/)
- A database — SQLite works out of the box, or MySQL/PostgreSQL

## Installation

1. **Clone the repository**

   ```bash
   git clone <repository-url> kanakora
   cd kanakora
   ```

2. **Install PHP dependencies**

   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**

   ```bash
   npm install
   # or: bun install
   ```

4. **Create the environment file and application key**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure the database**

   SQLite (default, no extra setup):

   ```env
   DB_CONNECTION=sqlite
   ```

   Then create the database file:

   ```bash
   touch database/database.sqlite
   ```

   On Windows (PowerShell):

   ```powershell
   New-Item -ItemType File -Path database/database.sqlite -Force
   ```

   MySQL example:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kanakora
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run migrations and seed the database**

   ```bash
   php artisan migrate --seed
   ```

   The seeder creates roles, permissions, an admin account, and sample users.

7. **Build or run the frontend**

   Development:

   ```bash
   npm run dev
   ```

   Production build:

   ```bash
   npm run build
   ```

8. **Start the application**

   ```bash
   php artisan serve
   ```

   Or run the full development stack (server, queue worker, and Vite) with:

   ```bash
   composer run dev
   ```

   The app is available at `http://localhost:8000`.

## Default Admin Account

The database seeder creates the following account:

| Field | Value |
| --- | --- |
| Email | `kanakora.co@gmail.com` |
| Password | `password` |

> Change this password immediately in any non-local environment.

## Available Roles

- **Admin** — full access to content, categories, classrooms, users, and roles.
- **Student** — read-only access to published lessons and classrooms.

## Useful Commands

| Command | Description |
| --- | --- |
| `composer run dev` | Run server, queue listener, and Vite together |
| `php artisan migrate --seed` | Migrate and seed the database |
| `npm run build` | Build production assets |
| `npm run dev` | Start the Vite dev server |
| `composer lint` | Format PHP with Laravel Pint |
| `npm run format` | Format frontend files with Prettier |
| `composer test` | Run lint checks and the Pest test suite |
| `php artisan test --compact` | Run the test suite |

## Testing

```bash
php artisan test --compact
```

Tests are written with Pest. Feature tests live in `tests/Feature`, unit tests in `tests/Unit`.

## Project Structure

```
app/
├── Actions/             Single-purpose action classes
├── Concerns/            Shared validation traits
├── Console/             Artisan commands
├── Enums/               UserRole enum
├── Http/
│   ├── Controllers/     Admin, student, and public controllers
│   ├── Middleware/      Inertia and request middleware
│   └── Requests/        Form request validation
├── Mail/                Mailables
├── Models/              User, Lesson, ClassRoom, Category, ContentRevision
├── Policies/            Authorization policies
└── Providers/           Service providers

database/
├── factories/           Model factories
├── migrations/          Schema definitions
└── seeders/             Roles, permissions, and admin user

resources/js/
├── components/          Shared and UI components
├── composables/         Vue composables
├── layouts/             App and auth layouts
├── lib/                 Helpers and utilities
└── pages/               Inertia pages (Admin, Student, Auth, Settings)

routes/
├── web.php              Public, admin, and student routes
└── settings.php         Account settings routes
```

## License

This project is proprietary. All rights reserved.
