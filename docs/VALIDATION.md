# Validation results

Validated locally on 6 October 2026.

## Application
- Laravel 12.69.3, PHP 8.2.12 (XAMPP).
- MySQL driver connected to the local XAMPP MariaDB 10.4.32 service.
- Dedicated demo database: `ajs_challenge`.
- Dedicated disposable test database: `ajs_challenge_test`.
- Demo application running at `http://127.0.0.1:8001`.
- The repository contains the Laravel rebuild as the only application source; the pre-migration audit is preserved in `docs/MIGRATION_AUDIT.md`.

## Checks passed
- `composer validate --no-check-publish`.
- MySQL migration and seeding of two demo accounts and four commodities.
- `php artisan test --testsuite=Unit,Feature`: **24 tests, 187 assertions**, SQLite in memory.
- `php artisan view:cache`: all Blade views compile.
- `php artisan route:list --except-vendor`: 22 application routes.
- `npm run build`: CSS 41.60 KB, vanilla JavaScript 0.88 KB before gzip.
- All sixteen migrated image hashes match the source assets.
- Eleven profile sections in the original order.
- Frontend dependencies: Tailwind CSS, its Vite integration, Vite and Laravel Vite plugin. No React/Vue/TanStack runtime.

## Automated workflow coverage
Authentication and intended destinations; failed-login throttling; role authorization and order ownership; required/numeric/decimal quantities; MOQ and available stock; unavailable products; replacing/removing cart quantities; empty and stale carts; duplicate submissions; order and item creation; no stock deduction at submission; confirmation and rejection; repeated decisions; competing requests; atomic failure across multiple commodities; zero-stock availability; admin stock input; empty states; repeatable seeding without resetting stock.

## Real browser checks
Chrome exercised the actual HTML forms, cookies, CSRF tokens, redirects and session cart against the isolated test server:

1. Open profile and commodity catalog.
2. Open Cakalang / Skipjack Tuna.
3. Log in as buyer and return to the chosen commodity.
4. Enter 300 KG, add to cart and submit.
5. See the request confirmation and order history.
6. Log out, log in as admin, view the new 300 KG request.
7. Confirm it and observe 550 KG remaining from 850 KG.
8. Manually update stock to 600 KG and verify the result.

Checked home, catalog, product, cart, buyer confirmation/history, admin dashboard/list/detail and stock pages at relevant 375px mobile, 768px tablet and 1440px desktop widths. No document horizontal overflow on the checked pages, no JavaScript exceptions, and no local HTTP errors were recorded. Mobile menu open/close was verified.

Local screenshots and the browser result JSON are in `laravel/storage/app/qa/` (ignored runtime artifacts). Desktop profile, mobile product/cart and confirmed admin request screenshots were visually inspected.

## Demo data isolation
Browser activity used the test database. The demo database retains **850 KG Cakalang, 1,200 KG Deho, 350 KG Tuna Fillet and 180 KG Kerapu**, with no test orders.

## Practical limits
The local database verification used MariaDB through Laravel's MySQL driver, not an Oracle MySQL installation. The app uses standard MySQL-compatible migrations and Eloquent transactions. Automated competing-request coverage tests confirmation ordering and rollback; it is not a load or multi-server concurrency benchmark. Fonts retain the original Google Fonts dependency with local system fallbacks; all imagery is local.

The original Lovable source was audited before migration and is represented by the migration notes and preserved AJS assets. Run application commands inside `laravel/`.
