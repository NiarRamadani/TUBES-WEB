<?php
session_start();
require 'config.php';

// Ambil semua menu dari database
$menu_result = $conn->query("SELECT * FROM menu");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Daftar Menu - Coffee Shop</title>
    <link rel="stylesheet" href="style3.css"> <!-- Pastikan tautan ini benar -->
    <script>
        function menuClickAlert(menuName) {
            alert('Anda melihat menu: ' + menuName);
        }

        function confirmBackToDashboard() {
            return confirm("Apakah Anda yakin ingin kembali ke Dashboard?");
        }
    </script>
</head>

<body>
    <h2 style="text-align: center;">Menu Coffee Shop</h2>

    <table border="1" style="width: 80%; margin: auto;">
        <tr>
            <th>Nama Menu</th>
            <th>Deskripsi Menu</th>
            <th>Harga</th>
        </tr>
        <?php while ($menu = $menu_result->fetch_assoc()): ?>
            <tr onclick="menuClickAlert('<?php echo htmlspecialchars($menu['nama_menu']); ?>')">
                <td><?php echo htmlspecialchars($menu['nama_menu']); ?></td>
                <td><?php echo htmlspecialchars($menu['deskripsi_menu']); ?></td>
                <td><?php echo "Rp " . number_format($menu['harga'], 2); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <!-- Tombol kembali ke dashboard dengan konfirmasi -->
    <div style="text-align: center;">
        <a href="dashboard.php" onclick="return confirmBackToDashboard()" style="text-decoration: none;">
            <button style="background-color: #555; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px;">
                Kembali ke Dashboard
            </button>
        </a>
    </div>
</body>
</html>
