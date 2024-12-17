<?php
session_start();
require 'config.php';

// Validasi akses
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: order.php');
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: order.php');
    exit();
}

$order = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alamat = $_POST['alamat'];
    $stmt = $conn->prepare("UPDATE orders SET alamat = ? WHERE id = ?");
    $stmt->bind_param("si", $alamat, $id);
    $stmt->execute();

    header('Location: order.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Pesanan</title>
</head>

<body>
    <h2>Edit Pesanan</h2>
    <form method="POST">
        <label>Alamat Pengiriman:</label><br>
        <textarea name="alamat" rows="4" cols="50"><?php echo htmlspecialchars($order['alamat']); ?></textarea><br><br>
        <button type="submit">Perbarui</button>
    </form>
</body>

</html>
