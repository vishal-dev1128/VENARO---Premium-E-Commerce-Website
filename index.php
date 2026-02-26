<?php
require_once 'config.php';

$page_title = 'Home';
$meta_description = 'VÉNARO — Premium Quality Menswear. Discover our exclusive collection of luxury clothing including t-shirts, hoodies, sweatpants, and varsity jackets.';

// Fetch only top-level (parent) categories for homepage display
$stmt = $pdo->query("SELECT * FROM categories WHERE parent_id IS NULL ORDER BY COALESCE(display_order, 9999) ASC, category_name ASC");
$categories = $stmt->fetchAll();

// Fetch random products from all categories for New Arrivals
$stmt = $pdo->query("
    SELECT p.*, 
           (SELECT image_url FROM product_images WHERE product_id = p.product_id LIMIT 1) as primary_image
    FROM products p
    WHERE p.status = 'active'
    ORDER BY RAND()
    LIMIT 8
");
$trending_products = $stmt->fetchAll();

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section position-relative overflow-hidden d-flex align-items-center justify-content-center" style="height: 95vh; min-height: 600px; background-color: #ffffff; width: 100%;">
    <!-- Blurred Background Text -->
    <div class="position-absolute w-100 text-center" style="top: 35%; left: 50%; transform: translate(-50%, -50%); z-index: 1; pointer-events: none; user-select: none;">
        <span style="font-family: var(--font-brand); font-size: 25vw; color: #000; opacity: 0.15; filter: blur(4px); display: block; line-height: 1; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1), 0 4px 8px rgba(0, 0, 0, 0.08);">VÉNARO</span>
    </div>

    <!-- Foreground Content -->
    <div class="hero-content text-center position-relative" style="z-index: 2;">
        <h1 class="hero-title mb-3" style="font-family: var(--font-brand); font-size: 4.5rem; font-weight: 700; color: #000; letter-spacing: 2px; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.08), 0 4px 8px rgba(0, 0, 0, 0.05);" data-mdb-animation="fade-in-down">VÉNARO</h1>

        <p class="text-uppercase mb-4" style="font-family: 'Montserrat', sans-serif; font-size: 0.75rem; letter-spacing: 3px; color: #444; font-weight: 600;" data-mdb-animation="fade-in" data-mdb-animation-delay="300">
            PREMIUM APPAREL
        </p>

        <div data-mdb-animation="fade-in-up" data-mdb-animation-delay="500">
            <a href="<?php echo SITE_URL; ?>/shop.php" class="btn btn-dark rounded-0 px-5 py-3" style="font-family: 'Montserrat', sans-serif; font-size: 0.75rem; letter-spacing: 2px; font-weight: 700; padding-left: 2.5rem !important; padding-right: 2.5rem !important;">
                SHOP NOW
            </a>
        </div>
    </div>
</section>

<!-- Shop by Category Section -->
<?php if (!empty($categories)): ?>
    <section style="padding: 80px 0; background: #fff;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Shop by Category</h2>
                <p class="section-subtitle">Explore our premium collections</p>
            </div>

            <div class="row g-2">
                <?php foreach ($categories as $index => $category): ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="<?php echo SITE_URL; ?>/shop.php?category=<?php echo $category['slug']; ?>" class="v-cat-card">
                            <?php if (!empty($category['image'])): ?>
                                <img src="<?php echo UPLOADS_URL . '/categories/' . $category['image']; ?>"
                                    alt="<?php echo htmlspecialchars($category['category_name']); ?>"
                                    loading="lazy">
                            <?php else: ?>
                                <div style="width:100%;height:100%;background:#1a1a1a;display:flex;align-items:center;justify-content:center;position:absolute;inset:0;">
                                    <i class="material-icons" style="font-size:40px;color:#333;">category</i>
                                </div>
                            <?php endif; ?>
                            <div class="v-cat-card__overlay">
                                <h3 class="v-cat-card__name"><?php echo htmlspecialchars($category['category_name']); ?></h3>
                                <span class="v-cat-card__cta">Shop Now</span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Featured Products -->
<?php if (!empty($trending_products)): ?>
    <section style="padding: 80px 0; background: #f8f8f8;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">New Arrivals</h2>
                <p class="section-subtitle">Fresh styles just dropped</p>
            </div>

            <div class="row g-3">
                <?php foreach ($trending_products as $product): ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-card">
                            <div class="product-image-wrapper">
                                <a href="<?php echo SITE_URL; ?>/product-detail.php?id=<?php echo $product['product_id']; ?>">
                                    <img src="<?php echo UPLOADS_URL . '/products/' . ($product['primary_image'] ?? 'default.jpg'); ?>"
                                        alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                                        class="product-image"
                                        loading="lazy">
                                </a>
                                <?php if (is_logged_in()): ?>
                                    <button class="wishlist-btn" data-product-id="<?php echo $product['product_id']; ?>" title="Add to wishlist">
                                        <i class="material-icons">favorite_border</i>
                                    </button>
                                <?php endif; ?>
                            </div>
                            <div class="product-info">
                                <a href="<?php echo SITE_URL; ?>/product-detail.php?id=<?php echo $product['product_id']; ?>" class="text-decoration-none">
                                    <h5 class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                                </a>
                                <div class="product-price">
                                    <?php if ($product['sale_price']): ?>
                                        <span class="price-current"><?php echo format_price($product['sale_price']); ?></span>
                                        <span class="product-price-original"><?php echo format_price($product['regular_price']); ?></span>
                                    <?php else: ?>
                                        <span class="price-current"><?php echo format_price($product['regular_price']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-5">
                <a href="<?php echo SITE_URL; ?>/shop.php" class="btn btn-dark rounded-0 px-5 py-3" style="font-family: 'Montserrat', sans-serif; font-size: 0.7rem; letter-spacing: 2px; font-weight: 700;">
                    VIEW ALL PRODUCTS
                </a>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Brand Values -->
<section style="padding: 80px 0; background: #111;">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4 text-center">
                <i class="material-icons mb-3" style="font-size: 36px; color: #fff;">verified</i>
                <h5 style="font-family: var(--font-brand); font-size: 18px; color: #fff; margin-bottom: 12px;">Premium Quality</h5>
                <p style="color: rgba(255,255,255,0.5); font-size: 13px; line-height: 1.8; max-width: 220px; margin: 0 auto;">100% Supima cotton and sustainable materials for unmatched comfort.</p>
            </div>
            <div class="col-md-4 text-center">
                <i class="material-icons mb-3" style="font-size: 36px; color: #fff;">straighten</i>
                <h5 style="font-family: var(--font-brand); font-size: 18px; color: #fff; margin-bottom: 12px;">Perfect Fit</h5>
                <p style="color: rgba(255,255,255,0.5); font-size: 13px; line-height: 1.8; max-width: 220px; margin: 0 auto;">Multiple fit options with size guides to find your perfect silhouette.</p>
            </div>
            <div class="col-md-4 text-center">
                <i class="material-icons mb-3" style="font-size: 36px; color: #fff;">eco</i>
                <h5 style="font-family: var(--font-brand); font-size: 18px; color: #fff; margin-bottom: 12px;">Sustainably Made</h5>
                <p style="color: rgba(255,255,255,0.5); font-size: 13px; line-height: 1.8; max-width: 220px; margin: 0 auto;">Responsibly made with eco-friendly practices and ethical manufacturing.</p>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section style="padding: 80px 0; background: #fff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h2 class="section-title mb-3">Stay in the Loop</h2>
                <p style="color: #888; font-size: 14px; margin-bottom: 32px;">Subscribe for exclusive offers, new arrivals and style guides.</p>
                <form action="<?php echo SITE_URL; ?>/api/newsletter-subscribe.php" method="POST" id="newsletterForm">
                    <div class="d-flex gap-0" style="border: 1px solid #ddd;">
                        <input type="email" name="email" class="form-control rounded-0 border-0" placeholder="Enter your email address" required
                            style="font-size: 13px; padding: 14px 18px;">
                        <button type="submit" class="btn btn-dark rounded-0 px-4"
                            style="font-family: 'Montserrat', sans-serif; font-size: 10px; letter-spacing: 2px; font-weight: 700; white-space: nowrap;">
                            SUBSCRIBE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Category Card CSS — Premium editorial style -->
<style>
    .v-cat-card {
        position: relative;
        display: block;
        overflow: hidden;
        text-decoration: none;
        aspect-ratio: 3/4;
        background: #111;
    }

    .v-cat-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.85s cubic-bezier(0.16, 1, 0.3, 1), filter 0.85s ease;
        filter: brightness(0.78);
    }

    .v-cat-card:hover img {
        transform: scale(1.09);
        filter: brightness(0.55);
    }

    .v-cat-card__overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.72) 0%, rgba(0, 0, 0, 0.08) 55%, transparent 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 24px 18px;
        transition: background 0.5s ease;
    }

    .v-cat-card:hover .v-cat-card__overlay {
        background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.25) 55%, transparent 100%);
    }

    .v-cat-card__name {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 600;
        color: #fff;
        margin: 0 0 12px;
        letter-spacing: 0.03em;
        transform: translateY(6px);
        transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .v-cat-card:hover .v-cat-card__name {
        transform: translateY(0);
    }

    .v-cat-card__cta {
        font-family: 'Montserrat', sans-serif;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 2.5px;
        color: #fff;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 10px;
        opacity: 0;
        transform: translateY(8px);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1) 0.05s;
    }

    .v-cat-card__cta::after {
        content: '';
        display: block;
        width: 28px;
        height: 1px;
        background: #fff;
        transition: width 0.35s ease;
    }

    .v-cat-card:hover .v-cat-card__cta {
        opacity: 1;
        transform: translateY(0);
    }

    .v-cat-card:hover .v-cat-card__cta::after {
        width: 46px;
    }
</style>

<?php include 'includes/footer.php'; ?>