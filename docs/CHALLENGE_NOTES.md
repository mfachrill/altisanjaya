# AJS Developer Challenge — Delivery Notes

## Completed

- Public AJS company profile, commodity catalog, and product detail pages.
- Four seeded commodities that match the challenge brief, including image, grade, origin, frozen form, available quantity, and MOQ.
- Session-based buyer login, dashboard, catalog, stock availability, request cart, order history, and order detail.
- Request Order workflow with MOQ and available-stock validation.
- Admin workspace for reviewing requests, confirming or rejecting them, and creating, editing, deleting, searching, filtering, and updating product stock.
- Buyer-to-admin demo flow: buyer requests 300 KG Cakalang, admin reviews it, and confirmation reduces stock from 850 KG to 550 KG.
- Indonesian/English public website switcher, responsive public pages, and responsive buyer/admin workspaces.

## Deliberately Out of Scope

- Payment, checkout, prices, payment gateway, and shipping booking. A Request Order is a procurement request, not a completed transaction.
- Public registration, password reset, complex permissions, ERP integration, real-time warehouse synchronization, and WhatsApp API.
- Public deployment and video delivery are outside the application runtime. The project is ready to run locally with the documented setup steps and seeded demo accounts.

## Technical Decisions

- **Laravel + Blade + Tailwind + MySQL:** one conventional web application keeps authentication, routing, validation, templates, and database access understandable for an MVP.
- **Eloquent relationships:** `User → Orders → OrderItems → Product` express the procurement data model directly.
- **Session cart:** appropriate for a simple request workflow; no separate cart table or payment state is needed.
- **Confirm-time stock deduction:** stock is validated when a buyer submits a request and checked again inside a database transaction when an admin confirms it. This prevents a request from being treated as a final transaction and protects against conflicting confirmations.
- **Two simple roles:** buyer and admin are enforced by middleware rather than a complex permission system.
- **Database-backed products:** stock and product details are updated through the admin workspace, not by changing source code.
- **AI-assisted delivery:** the initial visual exploration came from Lovable; Laravel implementation, iterative UI work, testing, and selected operational imagery were assisted by Codex and image generation. All application flow, validation, and business rules remain reviewable in the source code.
- **Prompt record:** see `AI_PROMPTS.md` for the development timeline, AI tools used, and the prompts that guided the implementation.

## Verification

Run from `laravel/`:

```sh
php artisan migrate --seed
php artisan test
npm run build
php artisan serve --port=8001
```

Demo accounts: `buyer@ajs.test` / `password` and `admin@ajs.test` / `password`.
