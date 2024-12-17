<?php
$host = "localhost";
$user = "root";
$password = "";
$db_name = "coffee_shop";

$conn = new mysqli($host, $user, $password, $db_name);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>
