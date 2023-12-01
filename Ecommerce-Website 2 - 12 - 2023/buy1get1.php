<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Website</title>
    <link rel="icon" href="img/logo.png">
    <script src="https://kit.fontawesome.com/453f139144.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Assets/css/index.css">
    <link rel="stylesheet" href="Assets/css/shop.css">
    <link rel="stylesheet" href="Assets/css/buy1get1.css">
</head>

<body>

<section id="header">
        <a href="index.php" class="logo-container"><h4 style="font-size: 33px; font-family: 'Dancing Script', cursive; color: #088178;" class="logo">Prime Menswear<i class="fa-solid fa-shirt" style="font-size: 20px; color: #088178;"></i></h4></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="wishlist.php">Wishlist</a></li>
                <li><a href="accessories.php">Accessories</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="about.php">About</a></li>
                <li><b><a class="active" href="buy1get1.php" class="sale">Sale</a></b></li>
                <li id="lg-bag"><a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
                <li id="lg"><a href="login.php"><i class="fa-solid fa-user"></i></a></li>
                <a href="#" id="close"><i class="fa-solid fa-square-xmark"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="login.php"><i class="fa-solid fa-user"></i></a>
            <a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a>
            <i id="bar" class="fa-solid fa-bars"></i>
        </div>
    </section>

    <section id="page-header">
        <h2>#Crazy_Deals</h2>
        <p>Buy 1 Get 1 Free</p>
        
    </section>

    <section id="product1" class="section-p1">
        <h2>Get <span style="color: #ff523b;">50% Off</span> Only Today</h2>
        <p>Get Upto 50% Off on Selected Products</p>
        <div class="pro-container">
            <?php 
                include "config/db_config.php";
                include "getProducts.php";

                $sql = "SELECT ProductId, ProductBrand, Description, Price, Image, Rating FROM product WHERE ProductId % 2 = 1";
                getProducts($conn, $sql, false);
            ?>
        </div>
    </section>

    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Sign Up For Newsletters</h4>
            <p>Get E-mail updates about our latest shop and <span>special offers.</span></p>
        </div>
        <div class="form">
            <input type="text" placeholder="Your email address">
            <button class="normal">Sign Up</button>
        </div>
    </section>

    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="img/logo.png" alt="">
            <h4>Contact</h4>
            <p><strong>Address:</strong> Cairo, Egypt</p>
            <p><strong>Phone:</strong> +01 234 567 890 / (+20) 01 2345 6789</p>
            <p><strong>Hours:</strong> 10:00 - 18:00, Sat - Thu</p>
            <div class="follow">
                <h4>Follow Us</h4>
                <div class="icon">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-pinterest-p"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <h4>About</h4>
            <a href="#">About Us</a>
            <a href="#">Delivery Information</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Contact Us</a>
        </div>

        <div class="col">
            <h4>My Account</h4>
            <a href="login.php ">Sign In</a>
            <a href="cart.php">View Cart</a>   
            <a href="#">My Wishlist</a>
            <a href="#">Track My Order</a>
            <a href="#">Help</a>
        </div>

        <div class="col install">
            <h4>Install App</h4>
            <p>From App Store or Google Play</p>
            <div class="row">
                <img src="img/pay/app.jpg" alt="">
                <img src="img/pay/play.jpg" alt="">
            </div>
            <p>Secured Payment Gateways</p>
            <img src="img/pay/pay.png" alt="">
        </div>

        <div class="copyright">
            <p>&copy; 2023 Ecommerce Website. All rights reserved.</p>
    </footer>

    <script src="Assets/js/script.js"></script>
</body>

</html>