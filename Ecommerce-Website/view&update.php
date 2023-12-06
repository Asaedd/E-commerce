<?php 
require_once 'Models/Customer.php';
require_once 'Controllers/AuthController.php';
require_once 'config/db_config.php';
session_start();

    $db = new dbController();
    $db->openConnection();
    $CustomerId = $_SESSION['CustomerId'];
    $query = "SELECT * FROM `Customer`\n"
    . "WHERE CustomerId = '$CustomerId'";
    $result=$db->select($query);

    $orderResult = $db->select("SELECT * FROM orders WHERE CustomerId = '$CustomerId'");
?>
<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/c/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Ecommerce Website - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login-Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playpen+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/453f139144.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Assets/css/login.css">
    <link rel="stylesheet" href="Assets/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
   </head>
   
<body>

<!-- start header  -->
<div class="abs">
<section id="header">
        <a href="index.php" class="logo-container"><h4 style="font-size: 33px; font-family: 'Dancing Script', cursive; color: #072763;" class="logo">Prime Menswear<i class="fa-solid fa-shirt" style="font-size: 20px; color: #072763;"></i></h4></a>
        <div>
            <ul id="navbar">
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="wishlist.php">Wishlist</a></li>
                <li><a href="accessories.php">Accessories</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="about.php">About</a></li>
                <li><b><a href="buy1get1.php" class="sale">Sale</a></b></li>
                <li id="lg-bag"><a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a></li>

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
            <a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a>
            <i id="bar" class="fa-solid fa-bars"></i>
        </div>
    </section>
</div>
<!-- ens header  -->

<div class="container">
    <br><br>
    <input type="checkbox" id="flip">
    <div class="cover">
        <div class="front">
            <img src="img/frontImg.jpg" alt="">
            <div class="text">
                <span class="text-1">Super value deals On all products</span>
                <span class="text-2">new adventure</span>
            </div>
        </div>
    </div>

    <div class="forms">
<div class="form-content">
            <!-- Show data Form -->
            <div class="login-form">
                        <div class="title">Personal Details</div>
                <div class="info">
                    <p><strong>ID:</strong> <?php echo $result[0]["CustomerId"]; ?></p>
                    <p><strong>Username:</strong> <?php echo $result[0]["Name"]; ?></p>
                    <p><strong>Email:</strong> <?php echo $result[0]["Email"]; ?></p>
                    <p><strong>Password:</strong> <?php echo $result[0]["Password"]; ?></p>
                    <p><strong>Phone Number:</strong> <?php echo $result[0]["Phone"]; ?></p>
                    <!-- <button><a href="updateCustomerInfo.php">Edit Personal Details</a></button> -->
                </div>
                <div class="text sign-up-text">Want to edit your data? <label for="flip">Edit Personal Details</label></div>
                <div class="title">Order History</div>
                    <div class="orders-container">
                        <?php foreach ($orderResult as $order): 
                            $OrderId = $order['OrderId'];   
                            $checkquery = "SELECT * 
                            FROM orderitems
                            WHERE OrderId = '$OrderId';";
                            $checkresult = mysqli_query($conn, $checkquery);

                            if (mysqli_num_rows($checkresult) > 0) {
                        ?>
                        <div class="order">
                            <div class="order-id">
                            Order #<?php echo $order['OrderId']; ?>
                            </div>

                            <div class="order-date">
                            <?php echo $order['OrderDate']; ?>
                            </div>

                            <div class="order-total">
                            <?php echo 'Total: ' . $order['TotalAmount']; ?>  
                            </div>

                            <div class="order-status">
                            <?php echo $order['Status'] . '<br>'; ?>
                            </div>

                            <?php $orderItems = $db->select("SELECT product.ProductId, product.ProductBrand, product.Price, product.Image, orderitems.Quantity FROM product
                                JOIN orderitems ON product.ProductId = orderitems.ProductId
                                WHERE orderitems.OrderId = '" . $order['OrderId'] . "';"); ?>

                            <div class="order-details">
                            <?php foreach ($orderItems as $item) {
                                $ProductId = $item['ProductId'];
                                $OrderId = $order['OrderId'];

                                echo '<div style="display: flex;">';
                                echo $item['Quantity'] . ' x ' . $item['ProductBrand'] . '<br>';  
                                echo 'Price: $' . $item['Price']; 
                                echo '</div>';

                                echo '<img width="50" src="data:image/jpeg;base64,' . base64_encode($item['Image']) . '">';        
                                
                                echo '<a style="margin-left: 10px; text-decoration: none; color: red;" href="returnProduct.php?item_id=' . $ProductId . '&order_id=' . $OrderId . '"
                                        class="return-btn">
                                        Return This Item
                                        </a>';
                            } ?>
                            </div>
                        </div>
                        <?php } endforeach; ?>
                    </div>
                </div>
            <!-- End Show data Form -->

            <!-- Edit data Form -->
            <div class="signup-form">
                <div class="title">Edit your data</div>
                <form method="POST" action="updateCustomerInfo.php">
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-user"></i>
                            <input type="text" id="name" name="Name" placeholder="Enter your new name" >
                        </div>
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="Email" placeholder="Enter your new email" >
                        </div>
                        <div class="input-box">
                            <i class="fa-solid fa-phone"></i>
                            <input type="tel" id="phone" name="Phone" placeholder="Enter your new phone number" >
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="Password" name="Password" placeholder="Enter your password" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="new_password" name="new_password" placeholder="Enter your new password" >
                        </div>
                        <div class="button input-box">
                            <input type="submit" value="Submit">
                        </div>
                        <div class="text sign-up-text">need to see your data <a href="view&update.php">Check Personal data</a></div>
                    </div>
                </form>
            </div>
            <!-- End Edit data Form -->

        </div>
    </div>
</div>
  <script src="Assets/js/script.js"></script>
  <!-- JavaScript to show the update status message as an alert -->
  <script>
        document.addEventListener("DOMContentLoaded", function() {
            var updateMessage = document.getElementById("updateMessage").textContent;
            
            if (updateMessage) {
                alert(updateMessage);
            }
        });
    </script>
</body>
</html>
