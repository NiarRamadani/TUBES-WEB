<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboardStyle.css">
</head>

<body>
    <!-- Bagian Header Dashboard -->
    <header class="dashboard-header">
        <h1>Selamat Datang di Dashboard</h1>
        <div class="dashboard-nav">
            <a href="admin.php">Kelola Menu</a>
            <a href="user.php">Daftar Menu</a>
            <a href="order.php">Pesanan</a> <!-- Tautan ke halaman pemesanan -->
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <div class="content">
        <p>Gunakan menu di atas untuk mengakses berbagai fitur.</p>
    </div>

    <!-- Tambahkan Footer -->
    <footer class="footer">
        &copy; <?php echo date('Y'); ?> Dashboard. All Rights Reserved.
    </footer>

</body>

</html>
