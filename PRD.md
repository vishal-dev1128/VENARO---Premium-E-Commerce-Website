# VÉNARO — Product Requirements Document
## *Redefining Modern Menswear* · Version 2.0 · January 2026

---

| | |
| :--- | :--- |
| **Product** | VÉNARO — Men's Fashion Platform |
| **Developer** | Vishal Pawar |
| **Date** | January 2026 |
| **Version** | 1.0 |
| **Status** | Live (Phase 1–5 Complete) |
| **Access** | Internal Use Only |

---

## 1. Executive Summary

### 1.1 Product Vision

VÉNARO is an ultra-premium, mobile-first men's fashion eCommerce platform engineered to deliver a seamless, **native app-grade experience** across all devices. The platform embodies the brand's singular commitment — *"Redefining Modern Fashion"* — through cinematic aesthetics, frictionless commerce, and uncompromising craftsmanship at every touchpoint.

### 1.2 Business Objectives

> [!NOTE]
> Strategic pillars that define the VÉNARO platform mission.

- Establish VÉNARO as the definitive premium digital destination for men's apparel in India.
- Achieve a 70% mobile-to-desktop conversion parity within the first six months of launch.
- Sustain sub-2-second page load times at 10,000+ concurrent users.
- Enable scalable catalog operations supporting 100,000+ SKUs and 50,000+ monthly orders.
- Build lasting brand loyalty through personalized post-purchase engagement.

### 1.3 Success Metrics

| Metric | Mobile Target | Desktop Target |
| :--- | :--- | :--- |
| **Conversion Rate** | 3.5%+ | 4.5%+ |
| **Average Order Value** | ₹1,500+ | ₹1,500+ |
| **Cart Abandonment** | < 65% | < 65% |
| **Page Load Time** | < 2s | < 1.5s |
| **Customer Satisfaction** | 4.5★+ | 4.5★+ |
| **Repeat Purchase Rate** | 35%+ (90 days) | 35%+ (90 days) |

---

## 2. Product Overview

### 2.1 Scope & Focus

> [!IMPORTANT]
> VÉNARO is an **exclusively men's** fashion platform. The product catalog, visuals, copy, and brand identity are designed for and dedicated to male clientele only.

**Permitted Categories:**
- T-Shirts
- Sweatshirts
- Hoodies
- Sweatpants
- Varsity Jackets

### 2.2 Target Audience

| Segment | Profile |
| :--- | :--- |
| **Primary** | Style-conscious Indian men (18–35), Urban professionals, Quality-first consumers. |
| **Secondary** | Gift buyers purchasing for men, Brand enthusiasts and collectors. |

### 2.3 Core Value Propositions

- **Signature Quality** — Supima cotton, GSM-graded heavyweight fabrics, and sustainable materials meeting the highest craftsmanship standards.
- **The Perfect Silhouette** — Precision fit options across Relaxed, Oversized, and Essential cuts, paired with detailed size guides.
- **Mobile-First Excellence** — A fluid, high-performance interface that rivals native application speed and responsiveness.
- **Frictionless Commerce** — Intelligent cart persistence, streamlined multi-step checkout, and seamless post-purchase experience.
- **Absolute Transparency** — Real-time order tracking, printable invoices, and dedicated support for the elite customer.

---

## 3. Technical Architecture

### 3.1 Technology Stack

```
┌─────────────────────────────────────────────────┐
│               FRONTEND LAYER                    │
│   PHP-rendered HTML · Custom CSS · Vanilla JS   │
│   MDBootstrap 5 · Material Design Icons         │
│   Playfair Display · Montserrat · Bodoni Moda   │
├─────────────────────────────────────────────────┤
│               BACKEND LAYER                     │
│   PHP 8.1+ (OOP/Procedural Hybrid)             │
│   Native PHP Sessions · AJAX API Endpoints      │
├─────────────────────────────────────────────────┤
│               DATA LAYER                        │
│   MySQL 8.0 / MariaDB · PDO (Prepared Stmts)   │
│   Database: venaro_db · 23 Normalized Tables    │
├─────────────────────────────────────────────────┤
│               SECURITY LAYER                    │
│   Bcrypt (Cost 12) · CSRF Tokens               │
│   HTTPOnly/SameSite Cookies · XSS Encoding     │
└─────────────────────────────────────────────────┘
```

| Layer | Technologies |
| :--- | :--- |
| **Frontend** | PHP-rendered HTML, Custom CSS, MDBootstrap 5.x, Vanilla JS, AJAX |
| **Backend** | PHP 8.1+, OOP/Procedural Hybrid, Native Session Management |
| **Database** | MySQL 8.0 / MariaDB · `venaro_db` · 23 normalized tables |
| **Typography** | Playfair Display (brand), Montserrat (labels), Bodoni Moda (headings), Inter (body) |
| **Icons** | Material Design Icons |
| **Payments** | Razorpay Standard Checkout (UPI, Cards, NetBanking, COD) |
| **Currency** | INR — `Rs.` symbol, configurable via `config.php` |
| **Security** | PDO Prepared Statements, Bcrypt cost-12, CSRF, HTTPOnly Cookies |

### 3.2 Performance & Optimization

> [!TIP]
> Every millisecond is engineered for the elite customer's time.

- **Asset Loading** — Lazy loading on all product and category images for critical-path optimization.
- **AJAX Interactions** — Cart, wishlist, and newsletter updates execute without full page reloads.
- **Session Duality** — Robust cart and session persistence for both authenticated users (DB-backed) and guests (session-backed).
- **Image Pipeline** — WebP-ready upload pipeline with JPEG/PNG/WebP support and 5MB file cap.

### 3.3 Security Framework

> [!CAUTION]
> All security implementations are mandatory and non-negotiable for elite client data protection.

- **SQL Injection** — PDO prepared statements used on every database query without exception.
- **XSS Prevention** — All output encoded with `htmlspecialchars()`.
- **CSRF Protection** — Token-based validation on all state-changing POST operations.
- **Password Security** — Bcrypt hashing at cost factor 12; brute-force lockout after 5 failed attempts per 15 minutes.
- **Session Hardening** — HTTPOnly, SameSite `Lax` cookies; 30-minute session lifecycle.
- **File Upload Safety** — MIME-type validation, size enforcement, and path traversal prevention.

---

## 4. Functional Requirements

### 4.1 User Authentication & Account Management

#### 4.1.1 Registration & Login

**User Registration (FR-AUTH-001)**

| Field | Requirement | Validation |
| :--- | :--- | :--- |
| **Full Name** | 2–50 characters | Letters and spaces only |
| **Email Address** | RFC 5322 compliant | Unique in system, real-time format check |
| **Password** | Minimum 8 characters | Must include uppercase, lowercase, and a number |
| **Terms & Conditions** | Mandatory | Checkbox acceptance required before submission |

> [!IMPORTANT]
> Real-time password strength indicator (Weak / Medium / Strong) is displayed during registration.

**User Login (FR-AUTH-002)**

| Feature | Description |
| :--- | :--- |
| **Remember Me** | 30-day persistent session via secure cookies |
| **Brute Force Protection** | 5 failed attempts trigger a 15-minute lockout |
| **Error Messages** | Generic — prevents email enumeration |
| **Deep Linking** | User is redirected to the originally requested URL post-login |

**Password Recovery (FR-AUTH-003)**

- SHA-256 secure token (32 characters), valid for 60 minutes.
- Single-use — token invalidated immediately upon successful reset.
- Rate-limited to 1 reset email per 5 minutes per account.

---

#### 4.1.2 User Profile Management (FR-PROFILE-001)

| Category | Editable Fields | Requirements |
| :--- | :--- | :--- |
| **Personal Info** | Name, Phone, Date of Birth, Gender | Phone in `+country code` format |
| **Security** | Email, Password | Current password required for changes |
| **Profile Photo** | Avatar upload | Max 2MB, JPG/PNG/WebP, auto-resized |
| **Notifications** | Email/SMS preferences | Granular marketing and order update controls |

**Address Book (FR-PROFILE-002)**

- Up to 10 saved shipping addresses per user.
- Default address clearly marked and prioritized at checkout.
- Real-time PIN code format validation.

---

### 4.2 Homepage & Hero Experience

#### 4.2.1 Hero Section (FR-LAND-001)

> [!TIP]
> The homepage hero delivers the brand's first and most critical impression — it must feel cinematic and elite.

- **Full-Screen Hero** — 95vh height, white luxury background with blurred `VÉNARO` watermark overlay rendering at 25vw in brand typography.
- **Brand Statement** — `VÉNARO` in bold, `PREMIUM APPAREL` in Montserrat uppercase tracking.
- **Primary CTA** — `SHOP NOW` button, flat dark, razor-sharp edges, uppercase Montserrat.
- **Animations** — MDB fade-in-down for heading, fade-in for tagline, fade-in-up for CTA with staggered delays.

#### 4.2.2 Category Showcase (FR-LAND-002)

- Responsive grid: 2 columns mobile → 3 columns tablet → 4 columns desktop.
- Luxury editorial card design (`v-cat-card`) with:
  - 3:4 aspect ratio, dark overlay gradient.
  - Hover: `scale(1.09)` zoom + brightness dim.
  - Animated CTA label with expanding underline on hover.
  - Category name in Playfair Display serif.

#### 4.2.3 New Arrivals (FR-LAND-003)

- 8 products fetched randomly from active catalog.
- Product cards with wishlist heart (authenticated users), discount badges, hover effects.
- `VIEW ALL PRODUCTS` CTA links to shop.

#### 4.2.4 Brand Values (FR-LAND-004)

Three-column dark section (`#111` background) featuring:
- **Premium Quality** — 100% Supima cotton and sustainable materials.
- **Perfect Fit** — Multiple fit options with size guides.
- **Sustainably Made** — Eco-friendly and ethical manufacturing.

#### 4.2.5 Newsletter (FR-LAND-005)

- Inline email subscription form with AJAX submit via `/api/newsletter-subscribe.php`.
- Minimalist border-only design. No promotional pop-ups on load.

---

### 4.3 Product Catalog & Discovery

#### 4.3.1 Shop Page (FR-SHOP-001)

> [!NOTE]
> Balances editorial aesthetics with high-performance filtering — never sacrificing either.

- **Filters** — Category (hierarchical), Collection, Price Range, Size, Color — all AJAX-driven with zero page reloads.
- **Sorting** — 5 options: Newest, Price Low→High, High→Low, Name A–Z, Z–A.
- **Pagination** — 24 products per page (`PRODUCTS_PER_PAGE` constant).
- **Layout** — Responsive grid: 2-col mobile, 3-col tablet, 4-col desktop.
- **Search** — MySQL FULLTEXT search across product name and description.

#### 4.3.2 Product Detail Page (FR-PRODUCT-001)

| Section | Elements | Notes |
| :--- | :--- | :--- |
| **Gallery** | Multi-image carousel with vertical thumbnails | Lazy-loaded, WebP-compatible |
| **Title & Info** | H1 title, SKU, star rating, pricing | Luxury Bodoni Moda typography |
| **Selectors** | Size swatches, Color swatches | Real-time stock check per variant |
| **Actions** | Add to Cart + Buy Now | AJAX cart add, variant-aware |
| **Details** | Fabric, GSM weight, Care instructions | Editorial product description |
| **Reviews** | Star ratings with verified buyer labels | Moderated via admin panel |

**Size Guide (FR-PRODUCT-002)**

| Size | Chest (in) | Length (in) | Fit |
| :--- | :--- | :--- | :--- |
| XS–S | 36–38 | 25–26 | Regular / Slim |
| M–L | 40–42 | 27–28 | Relaxed |
| XL–3XL | 44–48 | 29–31 | Oversized |

---

### 4.4 Shopping Cart & Checkout

#### 4.4.1 Shopping Cart (FR-CART-001)

| Feature | Description |
| :--- | :--- |
| **Persistence** | DB-linked for authenticated users; session-based for guests |
| **AJAX Updates** | Quantity changes and removals without page refresh |
| **Free Shipping Bar** | Dynamic indicator — free shipping above ₹999 (`FREE_SHIPPING_THRESHOLD`) |
| **Variant Awareness** | Cart items retain selected size and color information |

#### 4.4.2 Checkout (FR-CHECKOUT-001)

- Multi-step flow: Address Entry → Order Review → Payment → Confirmation.
- **Payment Options**: Razorpay Standard (UPI, Cards, NetBanking) + COD (₹50 surcharge, max ₹5,000 order).
- Default and saved addresses auto-populated for returning customers.
- Full order review with product images, quantities, and pricing breakdown before payment.

#### 4.4.3 Order Confirmation (FR-ORDER-001)

- Celebratory confetti animation on the success page.
- Full order summary with order number (`VEN-YYYYMMDD-XXXXXX` format).
- Invoice print link available immediately post-purchase.

---

### 4.5 Order Management & Tracking

#### 4.5.1 Order Lifecycle (FR-ORDERS-001)

| Phase | Status | Customer Interaction |
| :--- | :--- | :--- |
| **New** | Processing | Modification eligible within 24 hours |
| **Transit** | Shipped | Tracking number and carrier displayed |
| **Final** | Delivered | 30-day return/exchange window opens |
| **Exception** | Cancelled / Returned | Refund initiated, inventory restocked |

> [!TIP]
> **Guest Tracking** — Non-members can track orders using their Order ID and registered email/phone from the `/track-order.php` page.

- **Order History** — Paginated list with product images, status badges, and invoice links.
- **Cancellation** — Self-service cancel via `/cancel_order.php` before dispatch.
- **Invoice** — Print-ready, fully formatted invoice page at `/invoice.php`.

---

### 4.6 Wishlist

- AJAX-powered toggle — add/remove without page reload.
- Dedicated wishlist page at `/wishlist.php` with product cards and quick-add-to-cart.
- Restricted to authenticated users only (prompts login for guests).

---

### 4.7 Customer Support

#### 4.7.1 Support Infrastructure (FR-SUPPORT-001)

- **Contact Form** — `/contact.php` with categorized message submission to admin panel.
- **FAQ Page** — `/faq.php` with accordion-style categories (Shipping, Returns, Sizing, Payments, etc.).
- **Support Tickets** — Created via contact form; managed in admin with priority and status tracking.
- **Response SLA** — 24–48 hour target with automated ticket reference number generation.

---

### 4.8 Admin Dashboard

#### 4.8.1 Authentication & Security (FR-ADMIN-001)

| Asset | Requirement |
| :--- | :--- |
| **Login** | Dedicated `/admin/index.php` — sessions expire after 30 minutes of inactivity |
| **Brute Force** | 5 failed attempts trigger a lockout |
| **Separation** | `admin_id` session key is fully isolated from frontend user sessions |

---

#### 4.8.2 Dashboard (FR-ADMIN-DASH-001)

- **4 KPI Cards** — Total Products, Total Orders, Total Customers, Total Revenue.
- **Recent Orders Table** — Latest 10 orders with status, customer, and amount.
- **Quick Navigation** — Sidebar links to all admin modules.

---

#### 4.8.3 Product & Inventory Management (FR-ADMIN-PRODUCT-001)

- **Product Listing** — Grid/Table toggle with search, pagination (50/page), and category filter.
- **Shopify-Style Product Editor** — Tabbed interface for:
  - **Essentials**: Title, description, category, collections, pricing (regular + sale), SKU, GSM, fabric, care instructions.
  - **Variants**: Size × Color matrix — auto-generate all combinations, assign individual stock and pricing per variant.
  - **Media**: Multi-image drag-and-drop upload, primary image designation.
  - **SEO**: Meta title, meta description, URL slug, live search engine listing preview.
- **Auto-SKU** — Generated from product name + size + color.
- **Status** — Active / Draft toggle per product.
- **Save Product Button** — Persistent in Quick Navigation sidebar for fast access without scrolling.

---

#### 4.8.4 Category Management (FR-ADMIN-CAT-001)

- Full CRUD: Create, Read, Update, Delete categories.
- Hierarchical support — parent/child category relationships.
- Slug auto-generation with duplicate detection (appends `-1`, `-2`, etc.).
- Category image upload with display order management.

---

#### 4.8.5 Collection Management (FR-ADMIN-COL-001)

- CRUD for marketing collections (Seasonal, New Arrival, Featured, etc.).
- Featured toggle to pin collections to homepage.
- Products are linked to collections via many-to-many relationship.

---

#### 4.8.6 Order Management (FR-ADMIN-ORDER-001)

| Task | Capability |
| :--- | :--- |
| **Status Control** | Dropdown — Processing, Shipped, Delivered, Cancelled |
| **Order Detail** | Full itemized view with customer info, address, and product images |
| **Tracking** | Editable tracking number field per order |
| **Invoice** | Print-ready invoice accessible from admin order detail |

> [!IMPORTANT]
> Order status changes must be logged in `order_status_history` table with a timestamp for full audit traceability.

---

#### 4.8.7 Customer Management (FR-ADMIN-CUST-001)

- Full customer list with registration date, order count, and total spend.
- Individual customer detail with order history.
- Block/Unblock customer access.

---

#### 4.8.8 Coupon Engine (FR-ADMIN-COUPON-001)

| Type | Description |
| :--- | :--- |
| **Percentage** | e.g., 20% off total order |
| **Flat** | e.g., ₹200 off |
| **Free Shipping** | Waives shipping charge |

- Usage limits, per-user limits, and expiry date supported.

---

#### 4.8.9 Review Moderation (FR-ADMIN-REVIEW-001)

- All customer reviews are held pending admin approval before going live.
- Admin can Approve or Reject each review from `/admin/reviews.php`.

---

#### 4.8.10 Site Settings (FR-ADMIN-SETTINGS-001)

- SMTP configuration, payment gateway keys (Razorpay), site name and tagline.
- Maintenance mode toggle.

---

## 5. Database Schema

### 5.1 Overview

The platform operates on a **23-table normalized MySQL schema** (`venaro_db`) with InnoDB engine, foreign key constraints, and optimized indexes for transactional performance.

### 5.2 Core Tables

| Table | Purpose |
| :--- | :--- |
| `users` | Customer accounts — credentials, profile, roles |
| `addresses` | Shipping & billing addresses per user |
| `admin_users` | Admin panel users with role separation |
| `categories` | Product categories with hierarchical parent/child support |
| `collections` | Marketing collections (Seasonal, Featured, etc.) |
| `products` | Core product catalog — pricing, SKU, fabric, GSM, SEO fields |
| `product_categories` | Many-to-many: Products ↔ Categories |
| `product_collections` | Many-to-many: Products ↔ Collections |
| `product_variants` | Size/color variants with individual stock and pricing |
| `product_images` | Product image gallery (supports multiple images per product) |
| `cart` | Cart persistence — DB-backed for users, session for guests |
| `wishlist` | User wishlists |
| `orders` | Order records — totals, payment method, status, tracking |
| `order_items` | Line items per order — product snapshot at time of purchase |
| `order_status_history` | Full status change audit log with timestamps |
| `coupons` | Discount codes — percentage, flat, free shipping |
| `coupon_usage` | Per-user coupon redemption tracking |
| `reviews` | Product reviews with star rating and moderation status |
| `support_tickets` | Customer support tickets with priority and status |
| `ticket_messages` | Threaded messages per support ticket |
| `newsletter_subscribers` | Email subscription list |
| `settings` | Site-wide key-value configuration store |
| `faqs` | FAQ entries organized by category |

### 5.3 Key Relationships

- **One-to-Many**: Users → Addresses, Orders, Reviews, Support Tickets
- **One-to-Many**: Products → Variants, Images
- **Many-to-Many**: Products ↔ Categories, Products ↔ Collections
- **One-to-Many**: Orders → Order Items, Status History

---

## 6. Non-Functional Requirements

### 6.1 Performance

| Metric | Target | Strategy |
| :--- | :--- | :--- |
| **Page Load Time** | < 2s (mobile), < 1.5s (desktop) | Lazy loading, WebP images, AJAX updates |
| **Concurrent Users** | 10,000+ | Stateless-ready session architecture |
| **Database** | < 200ms query time | Prepared statements, normalized indexes |
| **Uptime** | 99.9% | XAMPP local → future cloud hosting |

### 6.2 Security

| Control | Implementation |
| :--- | :--- |
| **Password Hashing** | Bcrypt, cost factor 12 |
| **SQL Injection** | PDO prepared statements throughout |
| **XSS** | `htmlspecialchars()` on all output |
| **CSRF** | Token validation on all POST forms |
| **Session** | HTTPOnly, SameSite=Lax, 30-minute lifetime |
| **File Uploads** | MIME validation, 5MB cap, path traversal prevention |
| **Login Security** | 5-attempt lockout per 15 minutes |

### 6.3 Scalability

- Modular PHP architecture allows separation into microservices as traffic grows.
- Database schema designed for horizontal read scaling (future master-slave replication).
- Filesystem media storage designed for CDN offload (Cloudflare/AWS S3).

---

## 7. Visual Design & User Experience

### 7.1 Design Identity

> [!NOTE]
> Every design decision must pass a single test: *"Does this feel celebrity-level expensive?"* If not — it is rejected.

| Property | Standard |
| :--- | :--- |
| **Color Philosophy** | Dark luxury palette — `#000` hero, `#111` sections, `#f8f8f8` soft panels, `#fff` base |
| **Typography — Brand** | Playfair Display (serif) for category names; Bodoni Moda for page headings |
| **Typography — UI** | Montserrat (uppercase labels, CTAs, navigation); Inter (body copy) |
| **Button Style** | Sharp-edged (`border-radius: 0`), dark fills, letter-spaced uppercase labels |
| **Grid** | 8px spacing system, container max-width 1440px |
| **Animations** | Smooth cubic-bezier transitions — no flashy or cartoonish motion |

### 7.2 Component Highlights

- **Category Cards (`v-cat-card`)** — 3:4 editorial portrait ratio, image zoom on hover, layered gradient overlay, animated `SHOP NOW →` CTA reveal.
- **Product Cards** — Clean minimal cards with wishlist heart, discount badge, premium price display.
- **Hero Section** — 95vh luxury white background, blurred brand watermark, staggered MDB animations.
- **Brand Values Strip** — Full-width dark section with icon + title + editorial copy, three-column layout.
- **Navigation** — Sticky header with cart badge count, wishlist link, profile dropdown, and mobile hamburger menu.

### 7.3 Responsive Breakpoints

| Breakpoint | Width | Layout |
| :--- | :--- | :--- |
| **Mobile** | < 576px | Single / 2-column |
| **Tablet** | 576px – 991px | 2 / 3-column |
| **Desktop** | 992px – 1199px | 3 / 4-column |
| **Wide** | 1200px+ | Max-width 1440px |

---

## 8. Information Architecture

### 8.1 Frontend Pages

| Page | URL | Purpose |
| :--- | :--- | :--- |
| Homepage | `/index.php` | Hero, categories, new arrivals, brand values, newsletter |
| Shop | `/shop.php` | Full catalog with filters, sorting, and pagination |
| Product Detail | `/product-detail.php?id=X` | Gallery, variants, add to cart, reviews |
| Cart | `/cart.php` | Cart management |
| Checkout | `/checkout.php` | Address + payment selection |
| Order Success | `/order-success.php` | Confirmation + confetti |
| Orders | `/orders.php` | User order history |
| Invoice | `/invoice.php?id=X` | Print-ready invoice |
| Wishlist | `/wishlist.php` | Saved items |
| Track Order | `/track-order.php` | Guest + member tracking |
| Profile | `/profile.php` | Account management |
| Login / Register | `/login.php`, `/register.php` | Authentication |
| About | `/about.php` | Brand story |
| Contact | `/contact.php` | Contact form |
| FAQ | `/faq.php` | Accordion FAQ |
| Legal | `/privacy-policy.php`, `/terms.php`, `/shipping-returns.php` | Policy pages |

### 8.2 Admin Panel

| Page | URL | Purpose |
| :--- | :--- | :--- |
| Login | `/admin/index.php` | Admin authentication |
| Dashboard | `/admin/dashboard.php` | KPIs, recent orders |
| Products | `/admin/products.php` | Product listing |
| Add Product | `/admin/product-add.php` | Full product creation |
| Edit Product | `/admin/product-edit.php` | Product editing |
| Categories | `/admin/categories.php` | Category CRUD |
| Collections | `/admin/collections.php` | Collection CRUD |
| Orders | `/admin/orders.php` | Order listing |
| Order Detail | `/admin/order-detail.php` | Order management |
| Customers | `/admin/customers.php` | Customer management |
| Coupons | `/admin/coupons.php` | Discount management |
| Reviews | `/admin/reviews.php` | Review moderation |
| Settings | `/admin/settings.php` | Site configuration |

### 8.3 API Endpoints

| Endpoint | Method | Function |
| :--- | :--- | :--- |
| `/api/cart-add.php` | POST | Add item to cart (variant-aware) |
| `/api/wishlist-toggle.php` | POST | Toggle wishlist item |
| `/api/newsletter-subscribe.php` | POST | Email subscription |

---

## 9. Project Status & Roadmap

### 9.1 Completed Phases (v1.0)

| Phase | Scope | Status |
| :--- | :--- | :--- |
| **Phase 1** | Database schema (23 tables), config, helpers, CSRF, sessions | ✅ Complete |
| **Phase 2** | User registration, login, password recovery, profile, address | ✅ Complete |
| **Phase 3** | Homepage, shop, product detail, search, category browsing | ✅ Complete |
| **Phase 4** | Cart, wishlist, checkout, orders, invoice, track order | ✅ Complete |
| **Phase 5** | Full admin panel — products, variants, orders, customers, coupons, reviews | ✅ Complete |

### 9.2 Upcoming Enhancements (Phase 6+)

| Feature | Priority |
| :--- | :--- |
| Live Razorpay payment gateway (production keys) | High |
| Automated order confirmation + shipping email notifications | High |
| PDF invoice auto-generation and email delivery | High |
| Advanced admin analytics (charts, date-range revenue reports) | Medium |
| Coupon code validation during checkout flow | Medium |
| SEO — meta tags, sitemap.xml, robots.txt | Medium |
| PWA (Progressive Web App) capabilities | Low |
| AI-driven product recommendations | Low |
| Social login (Google OAuth) | Low |
| Loyalty / Black Tier membership program | Low |

---

## 10. Business Configuration

### 10.1 Runtime Constants (`config.php`)

| Constant | Value | Purpose |
| :--- | :--- | :--- |
| `DB_NAME` | `venaro_db` | MySQL database |
| `BCRYPT_COST` | `12` | Password hashing strength |
| `MAX_LOGIN_ATTEMPTS` | `5` | Brute-force threshold |
| `LOGIN_LOCKOUT_TIME` | `900` (15 min) | Lockout duration in seconds |
| `PRODUCTS_PER_PAGE` | `24` | Shop pagination |
| `FREE_SHIPPING_THRESHOLD` | `₹999` | Free delivery trigger |
| `DEFAULT_TAX_RATE` | `12%` | GST rate |
| `COD_MAX_AMOUNT` | `₹5,000` | Max COD-eligible order |
| `COD_CHARGE` | `₹50` | COD surcharge |
| `CURRENCY_SYMBOL` | `Rs.` | Display currency |
| `CONTACT_EMAIL` | `contact.venaro@gmail.com` | Support inbox |
| `CONTACT_PHONE` | `+91 96659 97194` | Support line |
| `INSTAGRAM_URL` | `@venaro_apparel` | Social channel |

---

## 11. Content & Brand Governance

> [!CAUTION]
> These rules are non-negotiable and must be enforced at every layer — admin panel, frontend, API, and documentation.

### 11.1 Product Rules

- ❌ **No women's products, categories, models, or copy** — this is an exclusively men's platform.
- ❌ **No categories outside the five permitted** (T-Shirts, Sweatshirts, Hoodies, Sweatpants, Varsity Jackets).
- ✅ Every product must have a designer-level luxury title, editorial-quality description, category assignment, price, and at least one image.

### 11.2 Copy Rules

| ✅ Permitted Tone | ❌ Prohibited |
| :--- | :--- |
| Luxury editorial | Emojis in product copy |
| Fabric-focused descriptions | "Best", "Cheap", "Sale", "Discount" |
| Craftsmanship narrative | Local or casual tone |
| Clean, bold product titles | Generic or placeholder titles |

### 11.3 Design Rules

| ✅ Permitted | ❌ Prohibited |
| :--- | :--- |
| Black, charcoal, off-white palette | Bright or neon colors |
| Sharp edges (`border-radius: 0`) | Heavy gradients |
| Smooth cubic-bezier animations | Cartoonish or flashy UI |
| Large editorial imagery | Pop-ups on load |
| Max 2 font families | Playful or novelty fonts |

---

## 12. Appendix

### 12.1 Key Terminology

| Term | Definition |
| :--- | :--- |
| **GSM** | Grams per Square Meter — fabric weight standard defining luxury heavyweight quality |
| **WebP** | Advanced image format for ultra-fast, high-fidelity page loads |
| **Bcrypt** | Password hashing algorithm with tunable cost factor — cost 12 used throughout |
| **PDO** | PHP Data Objects — secure database abstraction layer |
| **CSRF** | Cross-Site Request Forgery — attack vector prevented by form token validation |
| **SKU** | Stock Keeping Unit — unique variant identifier per product/size/color combination |
| **COD** | Cash on Delivery — payment option with ₹50 surcharge, capped at ₹5,000 orders |
| **Razorpay** | Primary payment gateway supporting UPI, Cards, and NetBanking |

### 12.2 Sign-off

This document defines the complete and authoritative product scope for the VÉNARO platform v1.0. All implementations, design decisions, and content must align with the **luxury menswear editorial standard** defined herein.

The platform has been built by **Vishal Pawar** as a full-stack eCommerce solution, fully operational across frontend shopping experience and backend administration as of **January 2026**.

---

**Document Version**: 2.0
**Platform Version**: 1.0
**Date**: January 2026
**Developer**: Vishal Pawar

---
*VÉNARO — Redefining Modern Fashion*
