<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

require 'config.php';

// Ambil daftar pesanan dari database dengan informasi harga
$username = $_SESSION['username'];
$result = $conn->query("SELECT o.*, m.nama_menu, m.harga FROM orders o JOIN menu m ON o.menu_id = m.id WHERE o.username = '$username'");

// Tangani penyimpanan pesanan baru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_id = $_POST['menu_id'];
    $alamat = $_POST['alamat'];

    $stmt = $conn->prepare("INSERT INTO orders (username, menu_id, alamat) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $_SESSION['username'], $menu_id, $alamat);
    $stmt->execute();

    header('Location: order.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pesanan Anda - Coffee Shop</title>
    <link rel="stylesheet" href="style4.css">
</head>

<body>
    <header class="dashboard-header">
        <h1>Daftar Pesanan Anda</h1>
    </header>

    <!-- Formulir untuk membuat pesanan baru -->
    <div class="content">
        <h2>Buat Pesanan Baru</h2>
        <form method="POST">
            <label for="menu_id">Pilih Menu:</label>
            <select name="menu_id" required>
                <option value="">-- Pilih Menu --</option>
                <?php
                // Ambil semua menu dari database
                $menu_result = $conn->query("SELECT * FROM menu");
                while ($menu = $menu_result->fetch_assoc()) {
                    echo "<option value='{$menu['id']}'>{$menu['nama_menu']}</option>";
                }
                ?>
            </select>
            <br><br>
            <label for="alamat">Alamat Pengiriman:</label><br>
            <textarea name="alamat" rows="3" required></textarea><br><br>
            <button type="submit" class="btn-submit">Kirim Pesanan</button>
        </form>
        <br><br>

        <!-- Tabel untuk menampilkan daftar pesanan pelanggan -->
        <h2>Daftar Pesanan Anda</h2>
        <table>
            <tr>
                <th>No</th>
                <th>Menu</th>
                <th>Harga</th>
                <th>Alamat</th>
                <th>Tanggal Pemesanan</th>
                <th>Jumlah Pesanan</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
            <?php $no = 1; while ($order = $result->fetch_assoc()): ?>
                <?php 
                $total_harga = $order['harga']; // Jika jumlah pesanan hanya 1, langsung gunakan harga menu
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($order['nama_menu']); ?></td>
                    <td>Rp <?php echo number_format($order['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($order['alamat']); ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td>1</td>
                    <td>Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></td>
                    <td>
                        <a href="update_order.php?id=<?php echo $order['id']; ?>" class="btn-update">Edit</a>
                        <a href="delete_order.php?id=<?php echo $order['id']; ?>" class="btn-delete"
                           onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <footer class="footer">
        &copy; <?php echo date('Y'); ?> Dashboard. All Rights Reserved.
    </footer>
</body>

</html>
