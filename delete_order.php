<?php
session_start();
require 'config.php';

// Validasi akses
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header('Location: order.php');
exit();
