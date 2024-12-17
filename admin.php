<?php
session_start();
require 'config.php';

// Periksa apakah pengguna memiliki peran sebagai admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit();
}

// Tambah Menu
if (isset($_POST['add_menu'])) {
    $nama_menu = $_POST['nama_menu'];
    $deskripsi_menu = $_POST['deskripsi_menu'];
    $harga = $_POST['harga'];
    
    $stmt = $conn->prepare("INSERT INTO menu (nama_menu, deskripsi_menu, harga) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $nama_menu, $deskripsi_menu, $harga);
    $stmt->execute();
    
    echo "<script>alert('Menu berhasil ditambahkan!');</script>";
}

// Hapus Menu
if (isset($_GET['delete_menu'])) {
    $id = $_GET['delete_menu'];

    // Hapus semua data terkait di tabel orders
    $stmt = $conn->prepare("DELETE FROM orders WHERE menu_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Hapus menu dari tabel menu
    $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    echo "<script>alert('Menu dan pesanan terkait berhasil dihapus!');</script>";
    header('Location: admin.php');
    exit();
}


// Ambil semua menu
$menu_result = $conn->query("SELECT * FROM menu");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard - Kelola Menu</title>
    
    <!-- Import Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- CSS Styling -->
    <style>
        /* Umum */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f1e0; 
            color: #333;
        }

        h2,
        h3 {
            color: #6a4c3b;
            text-align: center;
            padding: 10px 0;
        }

        a {
            text-decoration: none;
            color: #6a4c3b;
            transition: color 0.2s ease;
        }

        a:hover {
            color: #8c6f5a;
        }

        button {
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            background-color: #8c6f5a;
            color: white;
            border-radius: 5px;
            transition: all 0.2s ease;
        }

        button:hover {
            background-color: #6a4c3b;
        }

        hr {
            border: 1px solid #8c6f5a;
            margin: 20px auto;
            width: 80%;
        }

        /* Responsif */
        @media (max-width: 768px) {
            table {
                width: 100%;
                font-size: 14px;
            }

            form input,
            textarea {
                width: 90%;
            }
        }

        @media (max-width: 480px) {
            form input,
            textarea {
                width: 100%;
            }
        }

        /* Gaya Form Tambah Menu */
        .form-container {
            background-color: #fff8e1;
            border: 1px solid #6a4c3b;
            border-radius: 10px;
            padding: 20px;
            margin: 20px auto;
            width: 50%;
            box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.1);
        }

        input,
        textarea {
            margin-bottom: 15px;
            padding: 10px;
            width: 100%;
            border: 1px solid #6a4c3b;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Tabel */
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            background: #fff;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #6a4c3b;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #8c6f5a;
            color: white;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f0e6d6;
        }

        /* Tombol Kembali */
        .back-btn {
            display: inline-block;
            text-decoration: none;
            background-color: #6a4c3b;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #8c6f5a;
        }
    </style>

    <script>
        // Validasi formulir untuk Tambah Menu
        function validateMenuForm() {
            const namaMenu = document.forms["menuForm"]["nama_menu"].value.trim();
            const deskripsiMenu = document.forms["menuForm"]["deskripsi_menu"].value.trim();
            const harga = document.forms["menuForm"]["harga"].value.trim();
            
            if (namaMenu === "") {
                alert("Nama menu tidak boleh kosong!");
                return false;
            }
            if (deskripsiMenu === "") {
                alert("Deskripsi menu tidak boleh kosong!");
                return false;
            }
            if (harga === "" || isNaN(harga) || parseFloat(harga) <= 0) {
                alert("Harga harus berupa angka positif!");
                return false;
            }
            
            return true;
        }

        // Konfirmasi sebelum menghapus menu
        function confirmDeleteMenu() {
            return confirm("Apakah Anda yakin ingin menghapus menu ini?");
        }
    </script>
</head>
<body>
    <h2>Admin Dashboard - Kelola Menu</h2>
    
    <div class="form-container">
        <h3>Tambah Menu Baru</h3>
        <form name="menuForm" method="POST" onsubmit="return validateMenuForm()">
            <input type="text" name="nama_menu" placeholder="Nama Menu" required><br>
            <textarea name="deskripsi_menu" placeholder="Deskripsi Menu" required></textarea><br>
            <input type="number" name="harga" placeholder="Harga" step="0.01" required><br>
            <button type="submit" name="add_menu">Tambah Menu</button>
        </form>
    </div>

    <hr>
    
    <h3>Daftar Menu</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Menu</th>
            <th>Deskripsi Menu</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $menu_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['nama_menu']); ?></td>
                <td><?php echo htmlspecialchars($row['deskripsi_menu']); ?></td>
                <td><?php echo "Rp " . number_format($row['harga'], 2); ?></td>
                <td>
                    <a href="?delete_menu=<?php echo $row['id']; ?>" onclick="return confirmDeleteMenu()">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div style="text-align: center; margin: 20px;">
        <a href="dashboard.php" class="back-btn">Kembali ke Dashboard</a>
    </div>
</body>
</html>
