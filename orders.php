<?php
require_once 'config.php';

// Check login
if (!is_logged_in()) {
    header('Location: login.php?redirect=orders.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Fetch Orders
$stmt = $pdo->prepare("
    SELECT * FROM orders 
    WHERE user_id = ? 
    ORDER BY created_at DESC
");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();

$page_title = 'My Orders';
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
                    <h5 class="mb-1" style="font-weight: 600; color: var(--jet-black);"><?php echo htmlspecialchars($user_name); ?></h5>
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
                <a href="orders.php" class="list-group-item list-group-item-action active border-0 profile-nav-item" style="background-color: var(--jet-black); color: var(--white);">
                    <i class="material-icons" style="font-size: 18px; vertical-align: middle;">shopping_bag</i> My Orders
                </a>
                <a href="wishlist.php" class="list-group-item list-group-item-action border-0 profile-nav-item">
                    <i class="material-icons" style="font-size: 18px; vertical-align: middle;">favorite</i> Wishlist
                </a>
            </div>
        </div>

        <!-- Main Content (Orders History) -->
        <div class="col-lg-9">
            <h2 class="font-brand mb-4">Order History</h2>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <?php echo $_SESSION['success'];
                    unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <?php echo $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (empty($orders)): ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="material-icons text-muted mb-3" style="font-size: 64px;">history</i>
                        <h5>No orders yet</h5>
                        <p class="text-muted mb-4">You haven't placed any orders yet.</p>
                        <a href="shop.php" class="btn btn-dark">Start Shopping</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($orders as $order): ?>
                        <div class="col-12">
                            <div class="card border-0 shadow-sm overflow-hidden">
                                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2 border-bottom-0">
                                    <div>
                                        <span class="fw-bold me-3 premium-number">#<?php echo htmlspecialchars($order['order_number']); ?></span>
                                        <span class="order-date-text"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <?php
                                        $status_class = [
                                            'Order Placed' => 'primary',
                                            'Processing' => 'info',
                                            'Shipped' => 'warning',
                                            'Delivered' => 'success',
                                            'Cancelled' => 'danger'
                                        ];
                                        $cls = $status_class[$order['order_status']] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?php echo $cls; ?> me-3"><?php echo htmlspecialchars($order['order_status']); ?></span>
                                        <span class="premium-number me-3" style="font-size: 1.1rem;"><?php echo format_price($order['total_amount']); ?></span>

                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-sm btn-outline-dark dropdown-toggle p-1" type="button" data-mdb-toggle="dropdown">
                                                Invoice
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                                <li>
                                                    <a class="dropdown-item" href="invoice.php?id=<?php echo $order['order_id']; ?>" target="_blank">
                                                        <i class="material-icons me-2" style="font-size: 16px; vertical-align: text-bottom;">visibility</i> View Invoice
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="invoice.php?id=<?php echo $order['order_id']; ?>&print=true" target="_blank">
                                                        <i class="material-icons me-2" style="font-size: 16px; vertical-align: text-bottom;">print</i> Print Invoice
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <?php if ($order['order_status'] === 'Order Placed'): ?>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger p-1 ms-2"
                                                onclick="confirmCancellation(<?php echo $order['order_id']; ?>)">
                                                Cancel Order
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <?php
                                    // Fetch items for this order
                                    $stmt_items = $pdo->prepare("
                                        SELECT oi.*, 
                                               (SELECT image_url FROM product_images WHERE product_id = oi.product_id AND is_primary = TRUE LIMIT 1) as image
                                        FROM order_items oi
                                        WHERE oi.order_id = ?
                                    ");
                                    $stmt_items->execute([$order['order_id']]);
                                    $items = $stmt_items->fetchAll();
                                    ?>

                                    <div class="table-responsive">
                                        <table class="table table-borderless align-middle mb-0">
                                            <tbody>
                                                <?php foreach ($items as $item): ?>
                                                    <tr class="border-top">
                                                        <td style="width: 70px; padding-left: 0;">
                                                            <div class="product-img-fixed-wrapper">
                                                                <?php
                                                                $item_img = !empty($item['image']) ? UPLOADS_URL . '/products/' . $item['image'] : UPLOADS_URL . '/products/default.jpg';
                                                                ?>
                                                                <img src="<?php echo $item_img; ?>"
                                                                    alt="" class="rounded" style="width: 60px; height: 60px; object-fit: cover; border: 1px solid #eee;">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="product-name-order"><?php echo htmlspecialchars($item['product_name']); ?></div>
                                                            <div class="order-history-qty">
                                                                <span class="me-3">Size: <span class="fw-bold" style="color: #000;"><?php echo $item['size']; ?></span></span>
                                                                <span>Qty: <span class="fw-bold" style="color: #000;"><?php echo $item['quantity']; ?></span></span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end premium-number" style="padding-right: 0; font-size: 1rem;">
                                                            <?php echo format_price($item['subtotal']); ?>
                                                            <?php if ($order['order_status'] === 'Delivered' && !empty($item['product_id'])): ?>
                                                                <div class="mt-1">
                                                                    <a href="product-detail.php?id=<?php echo $item['product_id']; ?>#reviews" class="write-review-link">
                                                                        <i class="material-icons" style="font-size:14px; vertical-align:text-bottom;">rate_review</i> Write a Review
                                                                    </a>
                                                                </div>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
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

<script>
    function confirmCancellation(orderId) {
        window.location.href = 'cancel_order.php?id=' + orderId;
    }
</script>
<?php include 'includes/footer.php'; ?>