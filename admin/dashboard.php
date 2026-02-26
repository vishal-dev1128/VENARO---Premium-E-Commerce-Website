<?php

/**
 * VÉNARO Admin Panel - Dashboard
 */
session_start();
require_once '../config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

// Date filter logic
$date_filter = "";
$params = [];
if (isset($_GET['date']) && !empty($_GET['date'])) {
    $date_filter = " AND DATE(created_at) = :selected_date";
    $params['selected_date'] = $_GET['date'];
}

// Total products
$stmt = $pdo->query("SELECT COUNT(*) as count FROM products");
$stats['products'] = $stmt->fetch()['count'];

// Total orders
$sql_orders = "SELECT COUNT(*) as count FROM orders WHERE 1=1" . str_replace("created_at", "created_at", $date_filter);
$stmt = $pdo->prepare($sql_orders);
$stmt->execute($params);
$stats['orders'] = $stmt->fetch()['count'];

// Total customers
$sql_customers = "SELECT COUNT(*) as count FROM users WHERE 1=1" . str_replace("created_at", "created_at", $date_filter);
$stmt = $pdo->prepare($sql_customers);
$stmt->execute($params);
$stats['customers'] = $stmt->fetch()['count'];

// Total revenue
$sql_revenue = "SELECT COALESCE(SUM(total_amount), 0) as total FROM orders WHERE payment_status = 'Paid'" . $date_filter;
$stmt = $pdo->prepare($sql_revenue);
$stmt->execute($params);
$stats['revenue'] = $stmt->fetch()['total'];

// Pending delivery count
$sql_pending = "SELECT COUNT(*) as count FROM orders WHERE order_status IN ('Order Placed', 'Processing', 'Shipped')" . $date_filter;
$stmt = $pdo->prepare($sql_pending);
$stmt->execute($params);
$stats['pending_delivery'] = $stmt->fetch()['count'];

// Recent orders
$sql_recent = "
    SELECT o.*, u.full_name, u.email 
    FROM orders o 
    LEFT JOIN users u ON o.user_id = u.user_id 
    WHERE 1=1" . $date_filter . "
    ORDER BY o.created_at DESC 
    LIMIT 10
";
$stmt = $pdo->prepare($sql_recent);
$stmt->execute($params);
$recent_orders = $stmt->fetchAll();

// Order status counts
$stmt = $pdo->query("
    SELECT order_status, COUNT(*) as count 
    FROM orders 
    GROUP BY order_status
");
$order_stats = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// Last 7 days daily revenue for chart
$chart_labels = [];
$chart_data   = [];
for ($i = 6; $i >= 0; $i--) {
    $date_label = date('M d', strtotime("-{$i} days"));
    $date_val   = date('Y-m-d', strtotime("-{$i} days"));
    $chart_labels[] = $date_label;
    // Include all orders regardless of payment_status so chart shows data
    $stmt = $pdo->prepare("SELECT COALESCE(SUM(total_amount), 0) FROM orders WHERE DATE(created_at) = ?");
    $stmt->execute([$date_val]);
    $chart_data[] = (float)$stmt->fetchColumn();
}

$page_title = 'Dashboard';
include 'includes/header.php';
?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Overview</h1>
            <p class="admin-page-subtitle">Welcome back, admin. Here's what's happening with your store today.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="product-add.php" class="btn btn-primary btn-sm">
                <i class="material-icons" style="font-size: 18px;">add</i>
                Add Product
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="stat-card-modern">
                <div class="stat-icon-wrapper">
                    <i class="material-icons">payments</i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-subtitle">Last 30 days</div>
                    <div class="stat-value"><?php echo format_price($stats['revenue']); ?></div>
                    <div class="stat-trend up">
                        <i class="material-icons" style="font-size: 14px;">trending_up</i>
                        11%
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-card-modern">
                <div class="stat-icon-wrapper">
                    <i class="material-icons">shopping_bag</i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Orders</div>
                    <div class="stat-subtitle">Last 30 days</div>
                    <div class="stat-value"><?php echo number_format($stats['orders']); ?></div>
                    <div class="stat-trend up">
                        <i class="material-icons" style="font-size: 14px;">trending_up</i>
                        11%
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-card-modern">
                <div class="stat-icon-wrapper">
                    <i class="material-icons">group</i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Customers</div>
                    <div class="stat-subtitle">Last 30 days</div>
                    <div class="stat-value"><?php echo number_format($stats['customers']); ?></div>
                    <div class="stat-trend up">
                        <i class="material-icons" style="font-size: 14px;">trending_up</i>
                        19%
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-card-modern">
                <div class="stat-icon-wrapper">
                    <i class="material-icons">local_shipping</i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Pending Delivery</div>
                    <div class="stat-subtitle">Last 30 days</div>
                    <div class="stat-value"><?php echo number_format($stats['pending_delivery']); ?></div>
                    <div class="stat-trend neutral">
                        <i class="material-icons" style="font-size: 14px;">remove</i>
                        0%
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h6 class="modern-card-title">Sales Analytics</h6>
                    <select class="form-control" style="width: auto; padding: 6px 12px; font-size: 13px;">
                        <option>Jul 2023</option>
                        <option>Jun 2023</option>
                        <option>May 2023</option>
                    </select>
                </div>
                <div class="modern-card-body">
                    <!-- Sales Metrics -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div style="padding: 16px; background: rgba(249, 115, 22, 0.08); border-radius: 8px;">
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 4px;">Income</div>
                                <div style="font-size: 20px; font-weight: 700; color: #2c3e50;">23,262.00</div>
                                <div style="font-size: 12px; color: #F97316; font-weight: 600; margin-top: 4px;">
                                    <i class="material-icons" style="font-size: 14px; vertical-align: middle;">trending_up</i> +30%
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="padding: 16px; background: rgba(243, 156, 18, 0.08); border-radius: 8px;">
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 4px;">Expenses</div>
                                <div style="font-size: 20px; font-weight: 700; color: #2c3e50;">11,135.00</div>
                                <div style="font-size: 12px; color: #f39c12; font-weight: 600; margin-top: 4px;">
                                    <i class="material-icons" style="font-size: 14px; vertical-align: middle;">trending_down</i> +10%
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="padding: 16px; background: rgba(52, 152, 219, 0.08); border-radius: 8px;">
                                <div style="font-size: 12px; color: #6c757d; margin-bottom: 4px;">Balance</div>
                                <div style="font-size: 20px; font-weight: 700; color: #2c3e50;">48,135.00</div>
                                <div style="font-size: 12px; color: #3498db; font-weight: 600; margin-top: 4px;">
                                    <i class="material-icons" style="font-size: 14px; vertical-align: middle;">trending_up</i> +61%
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Chart -->
                    <div class="chart-container" style="position: relative; height: 280px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h6 class="modern-card-title">Order Statistics</h6>
                </div>
                <div class="modern-card-body">
                    <?php
                    $status_colors = [
                        'Order Placed' => '#F97316',
                        'Processing' => '#3498db',
                        'Shipped' => '#f39c12',
                        'Delivered' => '#22c55e',
                        'Cancelled' => '#95a5a6',
                        'Returned' => '#e74c3c'
                    ];
                    ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($order_stats as $status => $count): ?>
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span style="font-size: 13px; font-weight: 500; color: #666;"><?php echo $status; ?></span>
                                    <span style="font-size: 14px; font-weight: 700; color: #212121;"><?php echo $count; ?></span>
                                </div>
                                <div class="progress">
                                    <?php
                                    $percentage = ($stats['orders'] > 0) ? ($count / $stats['orders']) * 100 : 0;
                                    $color = $status_colors[$status] ?? '#999';
                                    ?>
                                    <div class="progress-bar" role="progressbar"
                                        style="width: <?php echo $percentage; ?>%; background: <?php echo $color; ?>;"
                                        aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="modern-card">
        <div class="modern-card-header">
            <h6 class="modern-card-title">Recent Orders</h6>
            <a href="orders.php" class="btn btn-outline-dark btn-sm">View All</a>
        </div>
        <div class="modern-card-body p-0">
            <?php if (empty($recent_orders)): ?>
                <div class="text-center py-5">
                    <i class="material-icons text-muted" style="font-size: 64px;">shopping_cart</i>
                    <p class="text-muted mt-3 mb-0">No orders yet</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_orders as $order): ?>
                                <tr>
                                    <td>
                                        <span style="font-family: 'Courier New', monospace; font-weight: 600; color: #F97316;">
                                            #<?php echo htmlspecialchars($order['order_number']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 500; font-size: 14px; color: #212121;">
                                            <?php echo htmlspecialchars($order['full_name'] ?? 'Guest'); ?>
                                        </div>
                                        <div style="font-size: 12px; color: #999;">
                                            <?php echo htmlspecialchars($order['email'] ?? $order['guest_email']); ?>
                                        </div>
                                    </td>
                                    <td style="font-size: 13px; color: #666;">
                                        <?php echo date('M d, Y', strtotime($order['created_at'])); ?>
                                    </td>
                                    <td style="font-weight: 700; color: #212121;">
                                        <?php echo format_price($order['total_amount']); ?>
                                    </td>
                                    <td>
                                        <?php
                                        $badge_class = [
                                            'Paid' => 'success',
                                            'Pending' => 'warning',
                                            'Failed' => 'danger',
                                            'Refunded' => 'info'
                                        ];
                                        $class = $badge_class[$order['payment_status']] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?php echo $class; ?>">
                                            <?php echo $order['payment_status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                        $status_badge = [
                                            'Order Placed' => 'primary',
                                            'Processing' => 'info',
                                            'Shipped' => 'warning',
                                            'Delivered' => 'success',
                                            'Cancelled' => 'danger',
                                            'Returned' => 'secondary'
                                        ];
                                        $class = $status_badge[$order['order_status']] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?php echo $class; ?>">
                                            <?php echo $order['order_status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="order-detail.php?id=<?php echo $order['order_id']; ?>"
                                            class="btn btn-outline-dark btn-sm">
                                            <i class="material-icons" style="font-size: 16px;">visibility</i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const labels = <?php echo json_encode($chart_labels); ?>;
        const revenue = <?php echo json_encode($chart_data); ?>;

        const canvas = document.getElementById('salesChart');
        if (!canvas) return;

        // Ensure parent has height
        canvas.style.display = 'block';
        canvas.style.width = '100%';
        canvas.style.height = '260px';

        new Chart(canvas, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue (₹)',
                    data: revenue,
                    fill: true,
                    backgroundColor: 'rgba(249, 115, 22, 0.07)',
                    borderColor: '#F97316',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#F97316',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1a1a1a',
                        titleColor: '#fff',
                        bodyColor: '#ccc',
                        padding: 12,
                        callbacks: {
                            label: (ctx) => ' ₹' + ctx.parsed.y.toLocaleString('en-IN', {
                                minimumFractionDigits: 2
                            })
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#999'
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(0,0,0,0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#999',
                            callback: (v) => '₹' + v.toLocaleString('en-IN')
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>