# AJS Fish Commodity Trading & Supply MVP

The runnable application is in **`laravel/`**. The Laravel rebuild is the only application source included in the repository; the original Lovable project was audited before migration and is documented in `docs/`.

## Stack
- Laravel 12 / PHP 8.2+
- Blade
- Tailwind CSS 4, compiled by Vite (no frontend framework)
- MySQL with Laravel Eloquent ORM
- Laravel session authentication; small vanilla JavaScript menu and submit behavior

## Features
- Public Company Profile: eleven original sections in PDF order
- Commodity Catalog and Product Detail
- Buyer Authentication and dashboard
- Session-based Cart
- Request Order with history and status
- Admin Order Management
- Admin Product CRUD & Stock Management

## Running Artisan from the repository root

A root-level `artisan` launcher forwards commands to `laravel/`, so you can run:

```sh
php artisan serve --port=8001
php artisan migrate --seed
```

Composer and npm commands still need to run inside `laravel/`. If you see `Could not open input file: artisan`, check that your terminal is in this repository root or its `laravel/` directory.

## Setup

Prerequisites: PHP 8.2+ with PDO MySQL, mbstring, XML, cURL, fileinfo, OpenSSL and ZIP; Composer; Node.js 22+; MySQL 8+ or a compatible local MariaDB service.

Run all application commands from `laravel/`:

```sh
cd laravel
composer install
npm install
cp .env.example .env
php artisan key:generate
```

On Windows PowerShell, use `Copy-Item .env.example .env` instead of `cp`.

Create a dedicated database using your MySQL client:
```sql
CREATE DATABASE ajs_challenge CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Configure `laravel/.env`:
```dotenv
APP_NAME="AJS Supply"
APP_URL=http://127.0.0.1:8001
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ajs_challenge
DB_USERNAME=root
DB_PASSWORD=
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

Use your own local MySQL username/password. The example matches a default local XAMPP setup. Then:
```sh
php artisan migrate --seed
npm run build
php artisan serve --port=8001
```

Open **http://127.0.0.1:8001**. For CSS/JS development, run `npm run dev` in a second terminal alongside `php artisan serve`. Vite only compiles assets; Laravel serves every page.

For XAMPP Apache, configure a virtual host whose DocumentRoot is **`laravel/public`**, with rewrite support and `AllowOverride All`. Do not expose the repository root as the application document root.

## Demo Accounts

| Role | Email | Password |
| --- | --- | --- |
| Buyer | buyer@ajs.test | password |
| Admin | admin@ajs.test | password |

Seeding creates missing records without resetting reviewed stock, accounts or order history. Demo accounts are intended for local challenge use.

## Demo Flow
1. Open the public profile and select **Request Order**.
2. Open **Cakalang / Skipjack Tuna** in the commodity catalog.
3. Select **Login to Request Order**; log in as the buyer. You return to the product.
4. Enter **300 KG** and add it to the supply cart.
5. Review the cart and select **Submit Request Order**.
6. The confirmation page shows `requested`; initial Cakalang stock remains **850 KG**.
7. Log out and sign in as the admin.
8. Open **Order requests**, then the new request.
9. Confirm it: stock becomes **550 KG**. Or reject it: stock stays **850 KG**.
10. Open **Stock management** to view or update quantities and availability.

Stock values above assume a fresh database. Run demo resets only in a disposable database; ordinary seeding intentionally does not overwrite stock.

## Business Rules
- B2B procurement for PT Altisan Jaya Sinergi; **Request Order**, never a retail purchase flow.
- Quantities use KG, with up to two decimal places.
- Each quantity must meet MOQ and must not exceed available stock.
- Products marked unavailable cannot be requested.
- Stock uses the two required statuses: **Available** and **Unavailable**. A request does not reserve stock; the stock is deducted only when an admin confirms it.
- Adding an existing cart product replaces its quantity; it does not silently accumulate.
- Cart changes and submission both validate current availability and quantity.
- Submission creates `requested` orders and related order items. It **does not reserve or deduct stock**.
- Admin can transition **Requested → Confirmed / Rejected** once.
- Confirmation rechecks every item and deducts stock in one transaction with row locks. Insufficient stock leaves the entire order requested and changes no stock.
- Rejection leaves stock unchanged. Repeated decisions cannot deduct stock twice.
- Zero stock is automatically marked unavailable after confirmation. Stock below MOQ cannot be requested.
- No payment, price, checkout, shipping booking or completed transaction is implied.
- Admin Product & Stock Management updates the product name, description, grade, form, origin, MOQ, available quantity, and availability through the database-backed interface.
- Session locks serialize concurrent cart/submission actions; successful submission clears the cart.
- Buyers can see only their own orders. Admin and buyer route groups enforce roles server-side.

## Technical Decisions

Laravel + Blade keeps routing, validation, authentication and HTML rendering in one conventional application. Eloquent expresses the relationships directly. Tailwind preserves the existing visual language without a separate SPA or client-side state layer. MySQL transactions and row locks protect stock during review.

Authentication uses Laravel's `Auth::attempt`, session regeneration, CSRF-protected forms, login throttling and invalidation on logout. There is no public registration or password-reset service in this seeded MVP.

The initial UI exploration was generated with AI/Lovable. The final application was migrated/rebuilt using Laravel for maintainability and simplicity. The original profile was translated to eleven Blade partials with the same content, layout classes, SVG icons and imagery. New procurement pages reuse the AJS palette, typography, cards and buttons. The original Manrope and Barlow Condensed Google Fonts links are retained, with sans-serif fallbacks.

The six company-profile commodity illustrations remain as source content; the four challenge products are the single Eloquent-backed inventory catalog. The profile's historical company figures are retained verbatim and are not presented as current application inventory.

## Structure
```text
laravel/
  app/Http/Controllers/{Public,Buyer,Admin}/
  app/Http/Requests/
  app/Http/Middleware/EnsureRole.php
  app/Models/{User,Product,Order,OrderItem}.php
  app/Services/SupplyRequests.php
  database/{migrations,seeders}/
  resources/views/{layouts,components,public,buyer,admin,auth}/
  resources/css/app.css
  resources/js/app.js
  public/assets/ajs/
  routes/web.php
  tests/Feature/ProcurementTest.php
```

The AJS palette is implemented in `laravel/resources/css/app.css`, and the migrated imagery is stored in `laravel/public/assets/ajs`.

## Testing
```sh
cd laravel
php artisan test --testsuite=Unit,Feature
npm run build
php artisan route:list
```

Default automated tests use an isolated SQLite in-memory database, never the demo database. They cover login, ownership, roles, MOQ/stock validation, cart replacement, stale carts, request creation, confirmation, rejection, duplicate actions, stock updates and atomic multi-product failure.

To run the same suite against MySQL, create the dedicated **`ajs_challenge_test`** database, configure its credentials in `.env.testing`, and run:
```sh
php vendor/bin/phpunit --configuration=phpunit.mysql.xml
```
This test configuration resets its test database. Never point it at your demo or production database.

See `docs/MIGRATION_AUDIT.md` for the source audit and `docs/VALIDATION.md` for validation results.
See `docs/CHALLENGE_NOTES.md` for the reviewer-facing delivery summary, scope limits, and technical decisions.
See `docs/AI_PROMPTS.md` for AI tools, the most helpful prompts, and the development timeline.
