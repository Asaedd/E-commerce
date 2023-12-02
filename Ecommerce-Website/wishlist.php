<?php
    ob_start();
    session_start();
    include_once 'Controllers/dbController.php';
    
    $db = new dbController();
    $db->openConnection();

    $flag = false;

    if (!isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = array();
    }

    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        if (!in_array($product_id, $_SESSION['wishlist'])) {
            $_SESSION['wishlist'][] = $product_id;
        }
    }

    if (!empty($_SESSION['wishlist'])) {
        $wishlistIds = array_map('intval', $_SESSION['wishlist']);
        $wishlistCondition = !empty($wishlistIds) ? " product.ProductId IN (" . implode(',', $wishlistIds) . ")" : "";
        
        $query = "  SELECT *
                    FROM product
                    LEFT JOIN category ON product.CategoryId = category.CategoryId
                    LEFT JOIN colors ON product.ColorId = colors.ColorId
                    WHERE $wishlistCondition;";
        $result = $db->select($query);
    
        $Categories = array_unique(array_column($result, 'CategoryName'));
        $Brands = array_unique(array_column($result, 'ProductBrand'));
        $Colors = array_unique(array_column($result, 'cName'));
    
        $product_char = array();
        $totalProductIds = count(array_unique(array_column($result, 'ProductId')));
        for($i = 0 ; $i < $totalProductIds ; $i++)
        {
            $product_char[$i]["ProductId"] = $result[$i]["ProductId"];
            $product_char[$i]["ProductBrand"] = $result[$i]["ProductBrand"];
            $product_char[$i]["Description"] = $result[$i]["Description"];
            $product_char[$i]["Price"] = $result[$i]["Price"];
            $product_char[$i]["Image"] = $result[$i]["Image"];
            $product_char[$i]["Rating"] = $result[$i]["Rating"];
            $product_char[$i]["CategoryId"] = $result[$i]["CategoryId"];
            $product_char[$i]["ColorId"] = $result[$i]["ColorId"];
        }

        $flag = true;
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop-Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playpen+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/453f139144.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Assets/css/index.css">
    <link rel="stylesheet" href="Assets/css/shop.css">
    <link rel="stylesheet" href="Assets/css/wishlist.css">
</head>

<body>
    <section id="header">
    <a href="index.php" class="logo-container"><h4 style="font-size: 33px; font-family: 'Dancing Script', cursive; color: #072763;" class="logo">Prime Menswear<i class="fa-solid fa-shirt" style="font-size: 20px; color: #072763;"></i></h4></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="wishlist.php" class="active">Wishlist</a></li>
                <li><a href="accessories.php">Accessories</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="about.php">About</a></li>
                <li><b><a href="buy1get1.php" class="sale">Sale</a></b></li>
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

    <section id="features">
        <div class="feature-container">
            <div class="feature">
                <h6>Fast Shipping</h6>
            </div>
            <div class="feature">
                <h6>Quality Products</h6>
            </div>
            <div class="feature">
                <h6>24/7 Customer Support</h6>
            </div>
        </div>
    </section>

    <section id="product" class="section-p1">
    <section id="fav">
        <h4 style="color: #072763; text-align: left">#My Favorites</h4><hr><br>
        <?php 
            if (!$flag) {
                echo '<h6>No products found in your wishlist.</h6>';
                echo '<h5 style="text-decoration: underline; color: #072763"><a href="shop.php">Continue Shopping</a></h5>';
            }
        ?>
    </section>
        <div class="proo-container">
            <?php
                if ($flag) {
                    $buttonClicked = isset($_GET['buttonClicked']) ? $_GET['buttonClicked'] : 1;
                    $startIndex = ($buttonClicked - 1);
    
                    for ($j = $startIndex; $j < $totalProductIds; $j++) {
                        echo '<div class="proo">';
                        echo '<a href="sproduct.php?buttonClicked=' . $product_char[$j]["ProductId"] . '">';
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($product_char[$j]["Image"]) . '" width="100%" alt="">';
                        echo '<div class="dess">';
                        echo '<span>' . $product_char[$j]["ProductBrand"] . '</span>';
                        echo '<h5>'. substr($product_char[$j]["Description"], 0, 48)  . "..." .'</h5>';
                        for ($y = 1; $y <= $product_char[$j]["Rating"]; $y++) {
                            echo '<i class="fas fa-star"></i>';
                        }
                        echo '<h4>$ ' . $product_char[$j]["Price"] . '</h4>';
                        echo '</a>';
                        echo '</div>';
                        echo '<a href="?remove=' . $product_char[$j]["ProductId"] . '&buttonClicked=' . $product_char[$j]["ProductId"] . '"><i class="fa-solid fa-trash-can"></i></a>';
                        echo '</div>';
                    }
    
                    if (isset($_GET['remove'])) {
                        $idToDelete = $_GET['remove'];
                        $index = array_search($idToDelete, $_SESSION['wishlist']);
    
                        if ($index !== false) {
                            unset($_SESSION['wishlist'][$index]); 
                            header("Location: wishlist.php");
                            exit();
                        }
                    }
                } 
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
            <h2 class="logo" style="font-family: 'Dancing Script', cursive; color: #072763">Prime Menswear<i class="fa-solid fa-shirt" style=" font-size: 20px;"></i></h2>
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
            <a href="about.php">About Us</a>
            <a href="">Delivery Information</a>
            <a href="">Privacy Policy</a>
            <a href="">Terms & Conditions</a>
            <a href="contact.php">Contact Us</a>
        </div>

        <div class="col">
            <h4>My Account</h4>
            <a href="login.php">Sign In</a>
            <a href="cart.php">View Cart</a>
            <a href="wishlist.php">My Wishlist</a>
            <a href="">Track My Order</a>
            <a href="">Help</a>
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
        </div>
    </footer>

    <script src="Assets/js/script.js"></script>
    <script src="Assets/js/filterSort.js></script>
</body>
</html>