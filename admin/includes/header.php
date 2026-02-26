<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Admin'; ?> - VÉNARO Admin</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom Admin CSS -->
    <link href="assets/css/admin-custom.css" rel="stylesheet">

    <style>
        /* Fallback for sidebar if CSS fails to load */
        .sidebar {
            min-width: 200px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand-wrapper">
                <div class="sidebar-logo">V</div>
                <div class="sidebar-title">VÉNARO</div>
            </div>
        </div>

        <div class="sidebar-nav">
            <div class="nav-group-title">MAIN</div>
            <a href="dashboard.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="material-icons">home</i>
                <span>Dashboard</span>
            </a>

            <div class="nav-group-title">PRODUCT & STOCK</div>
            <a href="products.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'products.php' || basename($_SERVER['PHP_SELF']) == 'product-add.php' || basename($_SERVER['PHP_SELF']) == 'product-edit.php' ? 'active' : ''; ?>">
                <i class="material-icons">inventory_2</i>
                <span>Products</span>
            </a>
            <a href="categories.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'active' : ''; ?>">
                <i class="material-icons">category</i>
                <span>Categories</span>
            </a>


            <div class="nav-group-title">SALES & ORDERS</div>
            <a href="orders.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'orders.php' || basename($_SERVER['PHP_SELF']) == 'order-detail.php' ? 'active' : ''; ?>">
                <i class="material-icons">shopping_cart</i>
                <span>Orders</span>
            </a>
            <a href="coupons.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'coupons.php' ? 'active' : ''; ?>">
                <i class="material-icons">local_offer</i>
                <span>Coupons</span>
            </a>

            <div class="nav-group-title">PEOPLE</div>
            <a href="customers.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'customers.php' ? 'active' : ''; ?>">
                <i class="material-icons">people</i>
                <span>Customers</span>
            </a>
            <a href="reviews.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'reviews.php' ? 'active' : ''; ?>">
                <i class="material-icons">rate_review</i>
                <span>Reviews</span>
            </a>
            <?php
            $msg_unread = (int) $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn();
            ?>
            <a href="messages.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'messages.php' ? 'active' : ''; ?>" style="position:relative;">
                <i class="material-icons">mail_outline</i>
                <span>Messages</span>
                <?php if ($msg_unread > 0): ?>
                    <span style="margin-left:auto;background:#F97316;color:#fff;font-size:10px;font-weight:700;border-radius:10px;padding:1px 7px;"><?php echo $msg_unread; ?></span>
                <?php endif; ?>
            </a>

            <div class="nav-group-title">SETTINGS</div>
            <a href="settings.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
                <i class="material-icons">settings</i>
                <span>Settings</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="top-bar-left">
                <h1 class="top-bar-title"><?php echo $page_title ?? 'Dashboard'; ?></h1>
            </div>
            <div class="top-bar-right">
                <!-- Search Box -->
                <form action="products.php" method="GET" class="search-box">
                    <i class="material-icons">search</i>
                    <input type="text" name="q" placeholder="Search products..." value="<?php echo $_GET['q'] ?? ''; ?>">
                </form>

                <!-- Date Selector -->
                <div class="date-selector" onclick="this.querySelector('input').showPicker()">
                    <i class="material-icons" style="font-size: 18px;">calendar_today</i>
                    <span><?php echo isset($_GET['date']) ? date('M d, Y', strtotime($_GET['date'])) : 'Select Date'; ?></span>
                    <input type="date" value="<?php echo $_GET['date'] ?? ''; ?>" onchange="window.location.href='dashboard.php?date=' + this.value">
                </div>

                <!-- Notifications (Linked to Orders) -->
                <?php
                // Dynamic Notification Count (Pending Orders)
                $notif_stmt = $pdo->query("SELECT COUNT(*) FROM orders WHERE order_status = 'Order Placed'");
                $notif_count = $notif_stmt->fetchColumn();
                ?>
                <a href="orders.php" class="icon-btn" title="Pending Orders">
                    <i class="material-icons">notifications_none</i>
                    <?php if ($notif_count > 0): ?>
                        <span class="badge"><?php echo $notif_count; ?></span>
                    <?php endif; ?>
                </a>

                <!-- Messages (Contact Form) -->
                <a href="messages.php" class="icon-btn" title="Contact Messages">
                    <i class="material-icons">chat_bubble_outline</i>
                    <?php if ($msg_unread > 0): ?>
                        <span class="badge"><?php echo $msg_unread; ?></span>
                    <?php endif; ?>
                </a>

                <!-- Admin Profile (Linked to Settings) -->
                <a href="settings.php" class="admin-profile" title="Admin Settings" style="text-decoration: none; color: inherit;">
                    <div class="admin-avatar">
                        <?php echo strtoupper(substr($_SESSION['admin_name'] ?? 'S', 0, 1)); ?>
                    </div>
                </a>

                <!-- Logout -->
                <a href="logout.php" class="icon-btn" title="Logout" style="text-decoration: none; color: inherit;">
                    <i class="material-icons">power_settings_new</i>
                </a>
            </div>
        </div>

        <!-- Page Content -->