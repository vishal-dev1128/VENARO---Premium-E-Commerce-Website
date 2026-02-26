<?php
require_once 'config.php';

// Check login
if (!is_logged_in()) {
    header('Location: login.php?redirect=wishlist.php');
    exit();
}

$user_id = get_current_user_id();

// Handle Actions
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $product_id = $_GET['product_id'] ?? null;

    if ($action === 'remove' && $product_id) {
        $stmt = $pdo->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        $_SESSION['success'] = "Removed from wishlist";
    } elseif ($action === 'add' && $product_id) {
        // Check if already in wishlist
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM wishlist WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        if ($stmt->fetchColumn() == 0) {
            $stmt = $pdo->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $product_id]);
            $_SESSION['success'] = "Added to wishlist";
        }
    }
    header('Location: wishlist.php');
    exit();
}

// Fetch Wishlist Items
$stmt = $pdo->prepare("
    SELECT w.*, p.product_name, p.regular_price, p.sale_price, p.sku,
           (SELECT image_url FROM product_images WHERE product_id = p.product_id AND is_primary = TRUE LIMIT 1) as image
    FROM wishlist w
    JOIN products p ON w.product_id = p.product_id
    WHERE w.user_id = ?
");
$stmt->execute([$user_id]);
$wishlist_items = $stmt->fetchAll();

$page_title = 'My Wishlist';
include 'includes/header.php';
?>

<div class="container my-5">
    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-lg-3 mb-4">
            <div class="card profile-sidebar-card">
                <div class="card-body text-center py-4">
                    <div class="mb-3">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 90px; height: 90px; box-shadow: var(--shadow-sm);">
                            <i class="material-icons" style="font-size: 44px; color: var(--gray-600);">person</i>
                        </div>
                    </div>
                    <h5 class="mb-1" style="font-weight: 600; color: var(--jet-black);"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h5>
                    <p class="text-muted small mb-4" style="font-size: 13px;"><?php echo htmlspecialchars($_SESSION['user_email']); ?></p>

                    <div class="d-grid gap-2">
                        <a href="logout.php" class="btn btn-outline-danger btn-sm" style="padding: 10px; font-weight: 600; letter-spacing: 0.5px; border-radius: 4px;">Sign Out</a>
                    </div>
                </div>
            </div>

            <div class="list-group mt-4" style="box-shadow: var(--shadow-sm); border-radius: 6px; overflow: hidden;">
                <a href="profile.php" class="list-group-item list-group-item-action border-0 profile-nav-item">
                    <i class="material-icons" style="font-size: 18px; vertical-align: middle;">person</i> My Profile
                </a>
                <a href="orders.php" class="list-group-item list-group-item-action border-0 profile-nav-item">
                    <i class="material-icons" style="font-size: 18px; vertical-align: middle;">shopping_bag</i> My Orders
                </a>
                <a href="wishlist.php" class="list-group-item list-group-item-action active border-0 profile-nav-item" style="background-color: var(--jet-black); color: var(--white);">
                    <i class="material-icons" style="font-size: 18px; vertical-align: middle;">favorite</i> Wishlist
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <h2 class="mb-4" style="font-family: var(--font-brand); font-weight: 700; color: var(--jet-black); font-size: 32px;">My Wishlist</h2>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['success'];
                    unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (empty($wishlist_items)): ?>
                <div class="text-center py-5">
                    <i class="material-icons mb-3 text-muted" style="font-size: 64px;">favorite_border</i>
                    <h3>Your wishlist is empty</h3>
                    <p class="text-muted mb-4">You haven't added any items to your wishlist yet.</p>
                    <a href="shop.php" class="btn btn-premium px-5">Explore Shop</a>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($wishlist_items as $item): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                                <div class="position-relative">
                                    <a href="product-detail.php?id=<?php echo $item['product_id']; ?>">
                                        <img src="<?php echo UPLOADS_URL . '/products/' . ($item['image'] ?? 'default.jpg'); ?>"
                                            alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                                            class="card-img-top" style="height: 250px; object-fit: cover;">
                                    </a>
                                    <a href="wishlist.php?action=remove&product_id=<?php echo $item['product_id']; ?>"
                                        class="btn btn-light btn-sm position-absolute top-0 end-0 m-2 rounded-circle"
                                        style="width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                        <i class="material-icons text-danger" style="font-size: 18px;">close</i>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">
                                        <a href="product-detail.php?id=<?php echo $item['product_id']; ?>" class="text-dark text-decoration-none">
                                            <?php echo htmlspecialchars($item['product_name']); ?>
                                        </a>
                                    </h6>
                                    <p class="text-muted small mb-2">SKU: <?php echo htmlspecialchars($item['sku']); ?></p>
                                    <div class="product-price mb-3">
                                        <?php if ($item['sale_price']): ?>
                                            <span class="price-current"><?php echo format_price($item['sale_price']); ?></span>
                                            <span class="product-price-original ms-2"><?php echo format_price($item['regular_price']); ?></span>
                                        <?php else: ?>
                                            <span class="price-current"><?php echo format_price($item['regular_price']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-grid">
                                        <form action="cart.php" method="POST">
                                            <input type="hidden" name="action" value="add">
                                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-dark btn-sm w-100">Add to Bag</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>