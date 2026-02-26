<?php
require_once 'config.php';

// Check login
if (!is_logged_in()) {
    header('Location: login.php?redirect=profile.php');
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

$page_title = 'My Profile';
include 'includes/header.php';
?>

<div class="container my-5">
    <div class="row">
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
                <a href="profile.php" class="list-group-item list-group-item-action active border-0 profile-nav-item" style="background-color: var(--jet-black); color: var(--white);">
                    <i class="material-icons" style="font-size: 18px; vertical-align: middle;">person</i> My Profile
                </a>
                <a href="orders.php" class="list-group-item list-group-item-action border-0 profile-nav-item">
                    <i class="material-icons" style="font-size: 18px; vertical-align: middle;">shopping_bag</i> My Orders
                </a>
                <a href="<?php echo SITE_URL; ?>/wishlist.php" class="list-group-item list-group-item-action border-0 profile-nav-item">
                    <i class="material-icons" style="font-size: 18px; vertical-align: middle;">favorite</i> Wishlist
                </a>
            </div>
        </div>

        <div class="col-lg-9">
            <h2 class="mb-4" style="font-family: var(--font-brand); font-weight: 700; color: var(--jet-black); font-size: 32px;">Order History</h2>

            <?php if (empty($orders)): ?>
                <div class="card order-card">
                    <div class="card-body text-center py-5">
                        <i class="material-icons text-muted mb-3" style="font-size: 64px; color: var(--gray-400);">history</i>
                        <h5 style="font-weight: 600; color: var(--deep-black);">No orders yet</h5>
                        <p class="text-muted mb-4">You haven't placed any orders yet.</p>
                        <a href="shop.php" class="btn btn-premium">Start Shopping</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($orders as $order): ?>
                        <div class="col-12">
                            <div class="card order-card">
                                <div class="card-header order-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div>
                                        <span class="fw-bold me-3" style="font-size: 15px; color: var(--jet-black);"><?php echo htmlspecialchars($order['order_number']); ?></span>
                                        <small class="text-muted" style="font-size: 13px;"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></small>
                                    </div>
                                    <div>
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
                                        <span class="badge bg-<?php echo $cls; ?> me-2 status-badge"><?php echo htmlspecialchars($order['order_status']); ?></span>
                                        <span class="fw-bold me-3" style="font-size: 16px; color: var(--jet-black);"><?php echo format_price($order['total_amount']); ?></span>

                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" id="invoiceOptions<?php echo $order['order_id']; ?>" data-mdb-toggle="dropdown" aria-expanded="false" style="border-radius: 4px; font-weight: 600;">
                                                Invoice
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="invoiceOptions<?php echo $order['order_id']; ?>">
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
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php
                                    // Fetch items for this order
                                    $stmt_items = $pdo->prepare("
                                        SELECT oi.*, 
                                               (SELECT image_url FROM product_images WHERE product_id = oi.product_id AND is_primary = TRUE LIMIT 1) as product_image
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
                                                    <tr>
                                                        <td style="width: 60px;">
                                                            <?php
                                                            $item_img = !empty($item['product_image']) ? UPLOADS_URL . '/products/' . $item['product_image'] : UPLOADS_URL . '/products/default.jpg';
                                                            ?>
                                                            <img src="<?php echo $item_img; ?>"
                                                                alt="" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                                        </td>
                                                        <td>
                                                            <div class="fw-bold"><?php echo htmlspecialchars($item['product_name']); ?></div>
                                                            <small class="text-muted">Qty: <?php echo $item['quantity']; ?></small>
                                                        </td>
                                                        <td class="text-end"><?php echo format_price($item['subtotal']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-3 text-end d-flex justify-content-end align-items-center gap-2">
                                        <?php if (in_array($order['order_status'], ['Order Placed', 'Processing'])): ?>
                                            <button type="button" class="btn btn-outline-danger btn-sm cancel-order-btn" data-order-id="<?php echo $order['order_id']; ?>" style="border-radius: 4px;">
                                                Cancel Order
                                            </button>
                                        <?php endif; ?>
                                        <a href="track-order.php?order_id=<?php echo $order['order_number']; ?>" class="btn btn-premium btn-sm">TRACK ORDER</a>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cancelButtons = document.querySelectorAll('.cancel-order-btn');

        cancelButtons.forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');

                Swal.fire({
                    title: 'Cancel Order?',
                    text: "Are you sure you want to cancel this order? This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Cancel Order',
                    cancelButtonText: 'No, Keep Order'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait while we cancel your order.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        fetch('api/cancel-order.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    order_id: orderId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire(
                                        'Cancelled!',
                                        'Your order has been successfully cancelled.',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Failed',
                                        data.message || 'Unable to cancel order at this time.',
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'Error',
                                    'An unexpected connection error occurred.',
                                    'error'
                                );
                            });
                    }
                });
            });
        });
    });
</script>

<?php include 'includes/footer.php'; ?>