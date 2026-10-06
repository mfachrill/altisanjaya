# Migration audit

## Source inspected before application changes
The root was a clean Git working tree at audit start. Read the route tree, root shell, index route, server/start/router, styles, package manifest, UI button, routing test, README, project guidance, and the full asset/component file inventory.

- Public page: `src/routes/index.tsx` at `/`; no existing catalog, login, buyer, admin, database or procurement implementation.
- Root layout: metadata, stylesheet, fonts, error/not-found boundaries and TanStack provider plumbing in `src/routes/__root.tsx`.
- Presentation helpers: local Brand and SectionHead functions; lucide SVG icons; a shared Button only used for the mobile menu.
- The remaining `src/components/ui` files are generated shadcn/Radix UI scaffolding, not used by the profile.
- Application state: a single React `useState` controlling the mobile navigation. No data fetching, prices, inventory or transactional logic.
- Router/Query/Start/server middleware and Lovable error reporting belong to the old runtime and are not needed in Laravel.

## Visual contract retained
- One scrolling index, eleven sections: Cover; Who We Are; Our Business Evolution; What We Do; Our Core Commodities; Our Sourcing Network; Cold-Chain & Storage Access; From Source to Delivery; Business Traction; Why AJS; Let's Build a Supply Partnership.
- Display font Barlow Condensed, body Manrope; uppercase condensed headings, small spaced kickers, gold rules and large section padding.
- Semantic OKLCH colors: navy deep, ocean blue, primary blue, warm gold, pale sky, paper and muted text.
- Alternating sky/paper sections, split editorial text/image compositions, full-bleed gradient cover/contact, source timeline, grid cards and commodity image overlays.
- Six original profile commodity cards: Cakalang, Deho, Tuna Fillet, Dori Fillet, Kerapu, Kakatua.
- Existing source claims, company history, sourcing regions, capacity qualifiers, historical transaction snapshots and contact details retained. No new corporate metrics.
- Sticky navigation and anchor scrolling; responsive breakpoint grids, clamped text sizing and original image crops.
- Subtle CSS hover lift/zoom/transitions and reduced-motion support. No timeline/video animation framework is involved.

## Assets
All sixteen JPEG files are locally extracted source imagery: cover, who, evolution, operations, sourcing, storage, process, traction, why, contact, cakalang, deho, tuna, dori, kerapu, kakatua. Copied to Laravel's public assets without changing source files or introducing external image dependencies.

## Migration approach
Build in `laravel/`, preserving the original source/build configuration at the root. The profile's static JSX output was transferred to eleven readable Blade partials; no React code or package is required to build or run Laravel. Static icons are inline SVG. Navigation uses a small vanilla JavaScript toggle.

Laravel introduces relational inventory and requests, role middleware, session authentication, server validation and shared Blade components. New routes serve the required application workflows while the company profile itself stays a single scrolling page.

The original project can still be inspected separately. No published history is rewritten and no Git push is performed.
