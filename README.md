# VÉNARO — Men's Fashion eCommerce Platform

> *Redefining Modern Fashion* — A full-stack PHP eCommerce platform built exclusively for men's luxury apparel, featuring a cinematic frontend experience and a comprehensive Shopify-style admin panel.

**Developer:** Vishal Pawar &nbsp;|&nbsp; **Version:** 2.0 &nbsp;|&nbsp; **Date:** February 2026

---

## ⚡ Quick Start

### Prerequisites
- **XAMPP** — Apache + MySQL/MariaDB + PHP 8.1+
- A modern browser (Chrome, Firefox, Edge, Safari)

### Setup in 5 Steps

**1. Place the Project**
```
C:\xampp\htdocs\new-venaro\
```

**2. Import the Database**
1. Start XAMPP — ensure **Apache** and **MySQL** are running
2. Open phpMyAdmin: `http://localhost/phpmyadmin`
3. Import: `database/venaro_schema.sql`

**3. Configure**

Open `config.php` and verify/update:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');          // default XAMPP has no password
define('DB_NAME', 'venaro_db');
```

**4. Create Upload Directories**
```
uploads/
├── products/       ← product images
├── categories/     ← category images
├── collections/    ← collection images
└── profiles/       ← user profile photos
```
Ensure `uploads/` is **writable** by Apache.

**5. Open in Browser**
| Access | URL |
| :--- | :--- |
| **Frontend** | `http://localhost/new-venaro/` |
| **Admin Panel** | `http://localhost/new-venaro/admin/` |

### Default Admin Login
| Field | Value |
| :--- | :--- |
| Email | `admin@venaro.com` |
| Password | `Admin@123` |

---

## 📁 Project Structure

```
new-venaro/
│
├── admin/                          # Admin Panel
│   ├── index.php                   # Admin login
│   ├── dashboard.php               # KPI cards + recent orders
│   ├── products.php                # Product listing
│   ├── product-add.php             # Add product (variants, SEO, media)
│   ├── product-edit.php            # Edit product
│   ├── categories.php              # Category CRUD (hierarchical)
│   ├── collections.php             # Collection CRUD
│   ├── coupons.php                 # Coupon/discount management
│   ├── orders.php                  # Order listing + filters
│   ├── order-detail.php            # Order detail + status updates
│   ├── customers.php               # Customer management
│   ├── reviews.php                 # Review moderation
│   ├── settings.php                # Site configuration
│   ├── messages.php                # Contact message inbox
│   └── includes/                   # Admin header / sidebar
│
├── api/                            # AJAX Endpoints
│   ├── cart-add.php                # Add to cart (variant-aware)
│   ├── wishlist-toggle.php         # Wishlist toggle
│   └── newsletter-subscribe.php    # Email subscription
│
├── includes/                       # Shared PHP Components
│   ├── header.php                  # Nav, cart badge, search
│   └── footer.php                  # Footer links, social, newsletter
│
├── assets/
│   └── css/
│       └── style.css               # Main stylesheet (4000+ lines)
│
├── database/
│   └── venaro_schema.sql           # Full schema — 23 tables
│
├── uploads/                        # Dynamic media (gitignored)
│
├── config.php                      # Global config, DB, helpers
│
├── ── Customer Pages ────────────────────────────────────────────
├── index.php                       # Homepage
├── shop.php                        # Catalog with filters & search
├── product-detail.php              # Product page (gallery, variants)
├── cart.php                        # Shopping cart
├── checkout.php                    # Checkout flow
├── place_order.php                 # Order processing
├── order-success.php               # Order confirmation + confetti
├── orders.php                      # Order history
├── cancel_order.php                # Self-service cancellation
├── invoice.php                     # Print-ready invoice
├── wishlist.php                    # Saved items
├── track-order.php                 # Guest + member order tracking
├── profile.php                     # Account management
├── login.php                       # User login
├── register.php                    # User registration
├── forgot-password.php             # Password recovery
│
├── ── Info & Legal Pages ───────────────────────────────────────
├── about.php
├── contact.php
├── faq.php
├── privacy-policy.php
├── terms.php
├── shipping-returns.php
│
├── PRD.md                          # Product Requirements Document
├── README.md                       # This file
└── SETUP_INSTRUCTIONS.md           # Detailed setup guide
```

---

## 📸 Visual Showcase

### Home Page
![Home Page](docs/screenshots/home-page.png)

### Category Exploration
![Category Page](docs/screenshots/category-page.png)

### Product Detail
![Product Page](docs/screenshots/product-page.png)

### About Us
![About Page](docs/screenshots/about-page.png)

### Contact & Support
![Contact Page](docs/screenshots/contact-page.png)

### User Authentication
![Signup & Login](docs/screenshots/signup-login-page.png)

### Admin Dashboard
![Admin Dashboard](docs/screenshots/admin-dashboard.png)

### Footer & Navigation
![Footer](docs/screenshots/footer-page.png)

---

## ✅ Features Implemented

### Phase 1 — Foundation
- [x] 23-table normalized MySQL schema (`venaro_db`) with InnoDB, FK constraints, and indexes
- [x] Centralized `config.php` — DB, SMTP, Razorpay, business rules, security constants
- [x] PDO connection with detailed diagnostic error output
- [x] Helper functions — CSRF tokens, sanitization, price formatting (`Rs.`), order number generation (`VEN-YYYYMMDD-XXXXXX`)
- [x] PHP class auto-loader

### Phase 2 — Authentication & Accounts
- [x] User registration with real-time validation and T&C acceptance
- [x] Password strength indicator (Weak / Medium / Strong)
- [x] Login with brute-force protection (5 attempts → 15-min lockout)
- [x] Remember Me (30-day persistent session)
- [x] Forgot password flow
- [x] User profile — photo upload, personal info, notification preferences
- [x] Address book management (up to 10 addresses)
- [x] Bcrypt password hashing (cost factor 12)
- [x] HTTPOnly + SameSite session cookies

### Phase 3 — Frontend & Discovery
- [x] Full-screen 95vh luxury hero — blurred brand watermark, staggered animations
- [x] Category showcase — editorial 3:4 portrait cards with hover zoom + animated CTA reveal
- [x] New Arrivals grid — 8 featured products, AJAX wishlist hearts
- [x] Brand Values strip — dark full-width section (Premium Quality, Perfect Fit, Sustainably Made)
- [x] Newsletter subscription via AJAX
- [x] Shop page — sidebar filters (category, collection, price, size, color), 5 sort options, 24/page pagination
- [x] FULLTEXT product search
- [x] Product detail — multi-image gallery, size × color swatches, variant-aware cart, reviews, size guide

### Phase 4 — Shopping Experience
- [x] AJAX cart — add, update quantity, remove (variant-aware, DB+session dual persistence)
- [x] AJAX wishlist toggle
- [x] Dedicated wishlist page
- [x] Multi-step checkout — address → review → payment
- [x] Payment options — Razorpay (UPI, Cards, NetBanking) + COD (₹50 surcharge, ₹5K cap)
- [x] Free shipping threshold — ₹999
- [x] Order success page with confetti animation
- [x] Order history with status badges, product images, invoice links
- [x] Self-service order cancellation
- [x] Print-ready invoice page
- [x] Guest & member order tracking

### Phase 5 — Admin Panel
- [x] Separate admin auth with session isolation
- [x] Dashboard — 4 KPI cards (Products, Orders, Customers, Revenue) + recent orders
- [x] Shopify-style product editor — Essentials, Variants, Media, SEO tabs
- [x] Variant matrix — Size × Color auto-generation, individual stock + SKU per variant
- [x] Multi-image drag-and-drop upload with primary designation
- [x] SEO live preview (meta title, description, slug)
- [x] Persistent "Save Product" button in sidebar Quick Navigation
- [x] Hierarchical category management (parent / child) with slug deduplication
- [x] Collection management with featured toggle
- [x] Order management — status updates, tracking number, full detail view
- [x] Customer management — list, detail, block/unblock
- [x] Coupon engine — percentage, flat amount, free shipping; usage limits + expiry
- [x] Review moderation — approve/reject before publish
- [x] Contact message inbox
- [x] Site settings — SMTP, payment keys, maintenance mode

### Info & Legal Pages
- [x] About, Contact (with form), FAQ (accordion), Privacy Policy, Terms & Conditions, Shipping & Returns

---

## 🗄️ Database — 23 Tables

| Table | Purpose |
| :--- | :--- |
| `users` | Customer accounts and credentials |
| `addresses` | Shipping & billing addresses per user |
| `admin_users` | Admin accounts with role separation |
| `categories` | Hierarchical product categories |
| `collections` | Marketing collections (Seasonal, Featured, etc.) |
| `products` | Core catalog — pricing, SKU, fabric, GSM, SEO |
| `product_categories` | Products ↔ Categories (many-to-many) |
| `product_collections` | Products ↔ Collections (many-to-many) |
| `product_variants` | Size/color variants with individual stock + pricing |
| `product_images` | Multi-image gallery per product |
| `cart` | Cart persistence — DB (users) + session (guests) |
| `wishlist` | User saved items |
| `orders` | Order records — totals, payment, status, tracking |
| `order_items` | Line items with product snapshot at purchase |
| `order_status_history` | Full audit log of all status changes |
| `coupons` | Discount codes — percentage, flat, free shipping |
| `coupon_usage` | Per-user redemption tracking |
| `reviews` | Product reviews with moderation status |
| `support_tickets` | Customer support tickets |
| `ticket_messages` | Threaded ticket conversation |
| `newsletter_subscribers` | Email subscription list |
| `settings` | Site-wide key-value config store |
| `faqs` | FAQ entries by category |

---

## 🎨 Design System

| Element | Specification |
| :--- | :--- |
| **Color Palette** | `#000` hero · `#111` dark sections · `#f8f8f8` soft panels · `#fff` base |
| **Typography — Brand** | Playfair Display (category names), Bodoni Moda (page headings) |
| **Typography — UI** | Montserrat (CTAs, labels, navigation) · Inter (body copy) |
| **Buttons** | Sharp-edged `border-radius: 0`, dark fill, uppercase Montserrat, letter-spaced |
| **Icons** | Material Design Icons |
| **Animations** | Smooth cubic-bezier — hover zoom, overlay reveal, fade-ins. No flash. |
| **Grid** | 8px spacing system · Container max-width 1440px |
| **Responsive** | Mobile-first · Breakpoints: 576 / 768 / 992 / 1200px |
| **Currency** | `Rs.` INR — configurable in `config.php` |

> [!NOTE]
> Every design decision must answer: *"Does this feel celebrity-level expensive?"* Bright colors, heavy gradients, rounded buttons, and playful fonts are unconditionally rejected.

---

## 🔐 Security

| Control | Implementation |
| :--- | :--- |
| Password Hashing | Bcrypt, cost factor 12 |
| SQL Injection | PDO prepared statements — 100% coverage |
| XSS Prevention | `htmlspecialchars()` on all output |
| CSRF Protection | Token validation on every POST form |
| Session Hardening | HTTPOnly, SameSite=Lax, 30-min lifetime |
| Brute Force | 5 failed attempts → 15-min lockout |
| File Uploads | MIME-type, 5MB cap, path traversal prevention |
| Admin Isolation | `admin_id` session key — fully separate from user sessions |

---

## ⚙️ Key Business Configuration

| Constant | Value |
| :--- | :--- |
| Free Shipping Threshold | ₹999 |
| COD Surcharge | ₹50 |
| COD Max Order | ₹5,000 |
| Tax Rate (GST) | 12% |
| Products Per Page | 24 |
| Max Login Attempts | 5 (per 15 minutes) |
| Max Image Upload | 5MB |
| Contact Email | contact.venaro@gmail.com |
| Contact Phone | +91 96659 97194 |
| Instagram | [@venaro_apparel](https://www.instagram.com/venaro_apparel/) |

---

## 🗺️ Roadmap

### Phase 6 — Operational Polish
- [ ] Live Razorpay production keys
- [ ] Order confirmation + shipping email notifications
- [ ] Automatic PDF invoice generation & email delivery
- [ ] Admin analytics charts (revenue, date-range reports)
- [ ] Coupon validation during checkout

### Phase 7 — Growth & Marketing
- [ ] SEO — meta tags, sitemap.xml, robots.txt
- [ ] Social login (Google OAuth)
- [ ] Multi-currency support (USD / INR)
- [ ] Customer-facing review submission
- [ ] Advanced search with autocomplete
- [ ] Referral + Loyalty (Black Tier) program

### Phase 8 — Scale
- [ ] PWA (Progressive Web App) capabilities
- [ ] AI-driven product recommendations
- [ ] Redis caching layer
- [ ] CDN integration (Cloudflare / AWS S3)
- [ ] Master-slave database replication

---

## 🛠️ Development Notes

### Debugging
- PHP errors: `error.log` in the project root
- Browser errors: DevTools Console (`F12`)
- DB check: `http://localhost/new-venaro/db-test.php`

### Testing Checklist
- **Auth**: Register → Login → Forgot Password → Profile edit
- **Shop**: Browse → Filter by category → Sort → Search
- **Product Detail**: Select size/color → Add to cart → Wishlist
- **Cart**: Update quantity → Remove → Proceed to checkout
- **Checkout**: Enter address → Review → Place order (COD)
- **Orders**: View history → View invoice → Track order → Cancel
- **Admin**: Login → Add product → Manage orders → Approve review

---

## 📞 Contact

| | |
| :--- | :--- |
| **Email** | contact.venaro@gmail.com |
| **Phone** | +91 96659 97194 |
| **Instagram** | [@venaro_apparel](https://www.instagram.com/venaro_apparel/) |

---

## 📄 License

Proprietary — VÉNARO Brand © 2026. All rights reserved.

---

*VÉNARO — Redefining Modern Fashion*
