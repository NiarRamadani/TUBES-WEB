<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Coffee Shop</title>
    <link rel="stylesheet" href="style1.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header>
        <nav>
            <div class="logo">ESPRESSO</div>
            <ul class="menu">
                <li><a href="#">Home</a></li>
                <li><a href="#">Menu</a></li>
                <li><a href="#">Locations</a></li>
                <li><a href="#">Delivery</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <!-- Tombol Login -->
            <div class="login-btn">
                <a href="login.php">Login</a>
            </div>
        </nav>
        <div class="hero">
            <h1>Where Every Cup is Crafted with Love</h1>
            <p>Discover the aroma of freshly brewed coffee, just for <strong>Rs. 399</strong></p>
            <!-- Tombol Order Now -->
            <a href="order.php" class="btn-order">Order Now</a>
        </div>
    </header>

    <!-- Services Section -->
    <section class="services">
        <div class="service-item">
            <img src="Gambar/Coffee.jpg" alt="Coffee">
            <h2>Coffee</h2>
            <p>Rich, aromatic, and crafted to perfection for every coffee enthusiast.</p>
        </div>
        <div class="service-item">
            <img src="Gambar/dessert.jpg" alt="Desserts">
            <h2>Desserts</h2>
            <p>Sweeten your day with our fresh, handcrafted desserts and pastries.</p>
        </div>
        <div class="service-item">
            <img src="Gambar/specials.jpg" alt="Specials">
            <h2>Specials</h2>
            <p>Try our exclusive specials – unique blends and savory bites you can’t resist.</p>
        </div>
    </section>

    <!-- Delivery Section -->
    <section class="delivery">
        <h2>Delivery at Your Doorstep</h2>
        <p>Can’t drop by? We’ll bring your favorite coffee and meals to your door, hot and fresh!</p>
        <!-- Tombol Order Now -->
        <a href="order.php" class="btn-delivery">Order Now</a>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <p>&copy; 2024 Espresso Coffee House. All Rights Reserved.</p>
            <p>Follow us: 
                <a href="#">Facebook</a> | <a href="#">Instagram</a>
            </p>
        </div>
    </footer>
</body>
</html>