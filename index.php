<?php
require_once 'config.php';

// Sample user data (in real app, this would come from database)
$user = [
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'avatar' => 'https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?w=150&h=150&fit=crop&crop=face',
    'role' => 'Administrator'
];

// Sample stats data
$stats = [
    'users' => 1250,
    'orders' => 856,
    'revenue' => 45680,
    'growth' => 12.5
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?> - Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="app-container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <div class="header-left">
                    <button class="menu-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="app-title"><?= APP_NAME ?></h1>
                </div>
                <div class="header-right">
                    <div class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
                    <div class="user-profile" onclick="toggleProfileMenu()">
                        <img src="<?= $user['avatar'] ?>" alt="Profile" class="profile-avatar">
                        <span class="profile-name"><?= $user['name'] ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <nav class="sidebar-nav">
                <a href="index.php" class="nav-item active">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="users.php" class="nav-item">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
                <a href="orders.php" class="nav-item">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
                <a href="analytics.php" class="nav-item">
                    <i class="fas fa-chart-bar"></i>
                    <span>Analytics</span>
                </a>
                <a href="settings.php" class="nav-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Welcome Section -->
            <section class="welcome-section">
                <div class="welcome-card">
                    <div class="welcome-text">
                        <h2>Selamat Datang, <?= $user['name'] ?>!</h2>
                        <p>Berikut ringkasan aktivitas hari ini</p>
                    </div>
                    <div class="welcome-actions">
                        <button class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Tambah Baru
                        </button>
                    </div>
                </div>
            </section>

            <!-- Stats Cards -->
            <section class="stats-section">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon users">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?= number_format($stats['users']) ?></h3>
                            <p>Total Users</p>
                            <span class="stat-trend positive">
                                <i class="fas fa-arrow-up"></i> +<?= $stats['growth'] ?>%
                            </span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon orders">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?= number_format($stats['orders']) ?></h3>
                            <p>Total Orders</p>
                            <span class="stat-trend positive">
                                <i class="fas fa-arrow-up"></i> +8.2%
                            </span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon revenue">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-content">
                            <h3>$<?= number_format($stats['revenue']) ?></h3>
                            <p>Revenue</p>
                            <span class="stat-trend positive">
                                <i class="fas fa-arrow-up"></i> +15.3%
                            </span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon growth">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?= $stats['growth'] ?>%</h3>
                            <p>Growth Rate</p>
                            <span class="stat-trend positive">
                                <i class="fas fa-arrow-up"></i> +2.1%
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Quick Actions -->
            <section class="actions-section">
                <h3>Quick Actions</h3>
                <div class="actions-grid">
                    <div class="action-card">
                        <i class="fas fa-user-plus"></i>
                        <h4>Add User</h4>
                        <p>Create new user account</p>
                    </div>
                    <div class="action-card">
                        <i class="fas fa-file-alt"></i>
                        <h4>New Report</h4>
                        <p>Generate analytics report</p>
                    </div>
                    <div class="action-card">
                        <i class="fas fa-envelope"></i>
                        <h4>Send Message</h4>
                        <p>Broadcast to all users</p>
                    </div>
                    <div class="action-card">
                        <i class="fas fa-backup"></i>
                        <h4>Backup Data</h4>
                        <p>Create system backup</p>
                    </div>
                </div>
            </section>

            <!-- Recent Activity -->
            <section class="activity-section">
                <div class="section-header">
                    <h3>Recent Activity</h3>
                    <a href="#" class="view-all">View All</a>
                </div>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-content">
                            <p><strong>New user registered:</strong> Alice Johnson</p>
                            <span class="activity-time">2 minutes ago</span>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="activity-content">
                            <p><strong>New order received:</strong> Order #12345</p>
                            <span class="activity-time">5 minutes ago</span>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-avatar">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="activity-content">
                            <p><strong>Payment received:</strong> $250.00</p>
                            <span class="activity-time">10 minutes ago</span>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="index.php" class="bottom-nav-item active">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="users.php" class="bottom-nav-item">
            <i class="fas fa-users"></i>
            <span>Users</span>
        </a>
        <a href="orders.php" class="bottom-nav-item">
            <i class="fas fa-shopping-cart"></i>
            <span>Orders</span>
        </a>
        <a href="analytics.php" class="bottom-nav-item">
            <i class="fas fa-chart-bar"></i>
            <span>Analytics</span>
        </a>
        <a href="profile.php" class="bottom-nav-item">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>
    </nav>

    <script src="assets/js/script.js"></script>
</body>
</html>