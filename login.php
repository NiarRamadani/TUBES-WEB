<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Enkripsi sederhana

    $result = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error))
            echo "<p style='color:red'>$error</p>"; ?>
        <form name="loginForm" method="POST" onsubmit="return validateLoginForm()">
            <label>Username</label>
            <input type="text" name="username" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>

    </div>

    <script>
        function validateLoginForm() {
            const username = document.forms["loginForm"]["username"].value.trim();
            const password = document.forms["loginForm"]["password"].value.trim();

            if (username === "" || password === "") {
                alert("Username dan Password wajib diisi!");
                return false; // Mencegah pengiriman formulir
            }
            return true;
        }
    </script>
    
    <div id="toast"></div>


</body>

</html>