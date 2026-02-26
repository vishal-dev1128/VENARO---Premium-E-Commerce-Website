<?php
require_once 'config.php';

$page_title = 'About Us';
include 'includes/header.php';
?>

<div class="container my-5">
    <!-- Hero Section -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h1 class="display-4 font-brand mb-3 fw-bold">Redefining Modern Luxury</h1>
            <p class="lead text-muted mb-4">VÉNARO is more than just a clothing brand; it's a statement of elegance, quality, and timeless style.</p>
            <p>Founded in 2026, VÉNARO was born from a desire to create apparel that bridges the gap between high-end fashion and everyday comfort. We believe that true luxury lies in the details—the fabric, the fit, and the finish.</p>
        </div>
        <div class="col-lg-6">
            <img src="<?php echo ASSETS_URL; ?>/images/about-production.jpg" alt="About Venaro" class="img-fluid rounded shadow-sm" style="object-fit:cover; aspect-ratio:4/3;">
        </div>
    </div>

    <!-- Our Values -->
    <div class="row mb-5 text-center">
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm p-4">
                <div class="card-body">
                    <i class="material-icons text-primary mb-3" style="font-size: 48px;">diamond</i>
                    <h4 class="font-brand">Premium Quality</h4>
                    <p class="text-muted">We source only the finest materials, including 100% Supima Cotton, to ensure our garments stand the test of time.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm p-4">
                <div class="card-body">
                    <i class="material-icons text-primary mb-3" style="font-size: 48px;">palette</i>
                    <h4 class="font-brand">Minimalist Design</h4>
                    <p class="text-muted">Our designs are clean, sophisticated, and versatile, allowing you to express your style effortlessy.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm p-4">
                <div class="card-body">
                    <i class="material-icons text-primary mb-3" style="font-size: 48px;">public</i>
                    <h4 class="font-brand">Sustainable Future</h4>
                    <p class="text-muted">We are committed to ethical manufacturing practices and working towards a more sustainable fashion industry.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Story Section -->
    <div class="row align-items-center">
        <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
            <h2 class="font-brand mb-3">The Production Process</h2>
            <p class="text-muted mb-3">Every piece of VÉNARO clothing goes through a rigorous quality control process. From the initial sketch to the final stitch, our team of expert artisans ensures perfection.</p>
            <p class="text-muted">We work closely with our manufacturing partners to maintain high standards of craftsmanship while ensuring fair labor practices. When you wear VÉNARO, you wear a product of passion and integrity.</p>
        </div>
        <div class="col-lg-6 order-lg-1">
            <img src="<?php echo ASSETS_URL; ?>/images/about-hero.jpg" alt="Production Process" class="img-fluid rounded shadow-sm" style="object-fit:cover; aspect-ratio:4/3;">
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>