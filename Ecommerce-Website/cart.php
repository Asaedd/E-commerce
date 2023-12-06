<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart-Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playpen+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/453f139144.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Assets/css/index.css">
    <link rel="stylesheet" href="Assets/css/shop.css">
    <link rel="stylesheet" href="Assets/css/cart.css">
</head>

<body>
    <section id="header">
    <a href="index.php" class="logo-container"><h4 style="font-size: 33px; font-family: 'Dancing Script', cursive; color: #072763;" class="logo">Prime Menswear<i class="fa-solid fa-shirt" style="font-size: 20px; color: #072763;"></i></h4></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="wishlist.php">Wishlist</a></li>
                <li><a href="accessories.php">Accessories</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="about.php">About</a></li>
                <li><b><a href="buy1get1.php" class="sale">Sale</a></b></li>
                <li id="lg-bag"><a href="cart.php" class="active"><i class="fa-solid fa-bag-shopping"></i></a></li>

                <?php
                if (!empty($_SESSION['CustomerId'])) {
                    echo '<li id="lg"><a href="view&update.php"><i class="fa-solid fa-user"></i></a></li>';
                    echo '<li id="lg"><a href="logout.php"><i class="fa-solid fa-sign-out-alt"></i></a></li>';
                    echo '</form>';
                } else {
                    echo '<li id="lg"><a href="login.php"><i class="fa-solid fa-sign-in-alt"></i></a></li>';
                }
                ?>

                <a href="#" id="close"><i class="fa-solid fa-square-xmark"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="login.php"><i class="fa-solid fa-user"></i></a>
            <a href="cart.php" class="active"><i class="fa-solid fa-bag-shopping"></i></a>
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

    <section id="page-header" class="contact-header">
        <h2>#Cart</h2>
        <p>Add you coupon code & SAVE UPTO 70!</p>
    </section>
    
    <section id="cart" class="section-p1">
        <table width="100%">
            <thead>
                <tr>
                    <td></td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>Size</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Subtotal</td>
                </tr>
            </thead>
            <tbody>
            <tr>
            <?php
                ob_start();
                include ("config/db_config.php");

                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = array();
                }

                if (!isset($_SESSION['quantity'])) {
                    $_SESSION['quantity'] = array();
                }

                if (isset($_GET['update']) && isset($_GET['quantity'])) {
                    $updateIdentifier = $_GET['update'];
                    $newQuantity = $_GET['quantity'];
                
                    list($product_id, $size) = explode('_', $updateIdentifier);
                
                    $uniqueIdentifier = $product_id . '_' . $size;
                
                    $_SESSION['quantity'][$uniqueIdentifier] = $newQuantity;
                
                    header("Location: cart.php");
                    exit();
                }
                
                if (isset($_GET['token']) && isset($_GET['product_id'])) {
                    $product_id = $_GET['product_id'];
                    $token = $_GET['token'];
                    $quantity = $_GET['quantity'];
                
                    if (isset($_SESSION['tokens'][$product_id]) && $_SESSION['tokens'][$product_id] == $token) {
                        unset($_SESSION['tokens'][$product_id]);

                        $uniqueIdentifier = $product_id . '_' . $_GET['size'];

                        if (!in_array($uniqueIdentifier, $_SESSION['cart'])) {
                            $_SESSION['cart'][] = $uniqueIdentifier;
                            $_SESSION['quantity'][$uniqueIdentifier] = $quantity;
                        } else {
                            $_SESSION['quantity'][$uniqueIdentifier] += $quantity;
                        }
                    } else {
                        header("Location: cart.php");
                        exit();
                    }
                }
                
                if (isset($_SESSION['cart'])) {
                    if (!empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $identifier) {
                            list($product_id, $size) = explode('_', $identifier);
                
                            $sql = "SELECT Image, Description, Price FROM product WHERE product.ProductId = " . $product_id;
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                
                            $imageData = $row['Image'];
                            $description = $row['Description'];
                            $price = $row['Price']; 
                
                            echo '<tr>'; 
                            echo '<td><a style="text-decoration: none; color: #ff523b; hover: color: white" href="?remove=' . $product_id . '_' . $size . '"><i class="far fa-times-circle"></i> Remove</a></td>';
                            echo '<td><img src="data:image/jpeg;base64,' . base64_encode($imageData) . '"></td>';
                            echo '<td>' . substr($description, 0, 27) . '...' . '</td>';
                            echo '<td>' . $size . '</td>';
                            echo '<td>$' . $price . '</td>';
                            echo '<td><input type="number" id="quantity_' . $product_id . '" value="' . $_SESSION['quantity'][$identifier] . '" min="1" oninput="calculateTotal(' . $product_id . ', ' . $price . ')" onchange="updateQuantity(' . $product_id . ', \'' . $size . '\', this.value)"></td>';
                            echo '<td id="subtotal-value_' . $product_id . '">$' . $price * $_SESSION['quantity'][$identifier] . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="7">Cart is Empty</td></tr>';
                        echo '<tr><td colspan="7"><a style="color: black;" href="index.php">Back To Home</a></td></tr>';
                    }
                }
                
                if (isset($_GET['remove'])) {
                    $idToDelete = $_GET['remove'];
                    $index = array_search($idToDelete, $_SESSION['cart']);

                    if ($index !== false) {
                        unset($_SESSION['cart'][$index]); 
                        unset($_SESSION['quantity'][$idToDelete]); 
                        header("Location: cart.php");
                        exit();
                    }
                }
            ?>
            </tr>
            </tbody>
        </table>
    </section>

    <section id="cart-add" class="section-p1">
        <div id="coupon">
            <h3 style="margin-bottom: 10px;">Apply Coupon</h3>
            <div style="display: flex;width: 100%;">
                <input type="text" placeholder="Enter Your Coupon">
                <button class="normal">Apply</button>
            </div>
        </div>
        <div id="subtotal">
            <h3>Cart Totals</h3>
            <table>
                <tr>
                    <td>Shipping</td>
                    <td>Free</td>
                </tr>
                <tr>
                    <td><b>Total</b></td>
                    <td id="cart-subtotal"><b>$ </b></td>
                </tr>
            </table>
            <?php
                if (!empty($_SESSION['cart'])) {
                    echo '<a href="checkout.php"><button class="normal">Proceed to checkout</button></a>';
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
            <!-- <img class="logo" src="img/logo.png" alt=""> -->
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
            <a href="#about.php">About Us</a>
            <a href="#">Delivery Information</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="#contact.php">Contact Us</a>
        </div>

        <div class="col">
            <h4>My Account</h4>
            <a href="#login.php">Sign In</a>
            <a href="#cart.php">View Cart</a>
            <a href="#wishlist.php">My Wishlist</a>
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
            <p>&copy; 2023 Prime MeansWear. All rights reserved.</p>
            </footer>

    <script src="Assets/js/script.js"></script>
    <script src="Assets/js/cart.js"></script>
</body>

</html>