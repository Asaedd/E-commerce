<?php
include_once 'Controllers/dbController.php';
    session_start();
    //echo "بسم الله";
    $db = new dbController();
    $db->openConnection();

    // $query = "  SELECT ProductId, ProductBrand, Description, Price, Rating, product.CategoryId, CategoryName
    $query = "  SELECT *
                FROM product
                RIGHT JOIN category ON product.CategoryId = category.CategoryId;";
    $result = $db->select($query);
    // print_r($result);
    $product_char = array(); // initialize array
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
        $product_char[$i]["CategoryName"] = $result[$i]["CategoryName"];
    }     
    // echo $buttonClicked;
    // print_r($product_char);
    // print_r($totalProductIds);
    // print_r($result);
    // echo '<img src="data:image/jpeg;base64,' . base64_encode($product_char["Image"]) . '">';
    //___________________________________________________________________

$counter = 0;

//>دا عشان اخر 4 منتجات مش هيقروا رقم 1 او 2 او 3 او 4 فهشوف هما هيقروا ايه واحطه فيها
$smallImagesArray = array();
//دا عشان اسيف ارقام المنتجات اللي خدتها عشان لما ادوس سواء نيكست او سيي
$smallImagesArray1 = array();
if (isset($_GET['buttonClicked'])) {
    $buttonClicked = $_GET['buttonClicked'];
    $totalProductIds++;
        for ($i = 0; $i < 4; $i++)
        {
            if(($buttonClicked+$i)%$totalProductIds != 0)
            {
            $smallImages[$i] = "f" . (($buttonClicked+$i)%$totalProductIds) . ".jpg";
            $smallImagesArray1[$counter] = (($buttonClicked+$i)%$totalProductIds);
            $smallImagesArray[$counter] = $i;
            $counter++;
            }
            else
                continue;
        } 
        if($counter < 4)
        {
            $smallImages[$i] = "f" . ((($buttonClicked+$i)%$totalProductIds)) . ".jpg";
            $smallImagesArray1[$counter] = (($buttonClicked+$i)%$totalProductIds);
            $smallImagesArray[$counter] = $i;
        }
        // print_r($smallImages);
        // print_r($smallImagesArray);  
        // print_r($smallImagesArray1); 
}
else {
    $_SESSION['mainImage'] = "f1.jpg";   
}
    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Website</title>
    <link rel="icon" href="img/logo.png">
    <script src="https://kit.fontawesome.com/453f139144.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Assets/css/index.css">
    <link rel="stylesheet" href="Assets/css/sproduct.css">
    <link rel="stylesheet" href="Assets/css/shop.css">
</head>

<body>
    <section id="header">
        <a href="#"><img src="img/logo.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a class="active" href="shop.php">Shop</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li id="lg-bag"><a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
                <a href="#" id="close"><i class="fa-solid fa-square-xmark"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a>
            <i id="bar" class="fa-solid fa-bars"></i>
        </div>
    </section>

    <section id="prodetails" class="section-p1"> 
    <div class="single-pro-image">
    <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($product_char[$buttonClicked - 1 ]["Image"]) . '" width="100%" alt="">'; ?>
        <div class="small-img-group">
                <div class="small-img-col">
                <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($product_char[$smallImagesArray1[0] - 1]["Image"]) . '" width="100%" alt="">'; ?>
                </div>
                <div class="small-img-col">
                <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($product_char[$smallImagesArray1[1] - 1 ]["Image"]) . '" width="100%" alt="">'; ?>
                </div>
                <div class="small-img-col">
                <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($product_char[$smallImagesArray1[2] - 1 ]["Image"]) . '" width="100%" alt="">'; ?>
                </div>
                <div class="small-img-col">
                <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($product_char[$smallImagesArray1[3] - 1 ]["Image"]) . '" width="100%" alt="">'; ?>
                </div>
                <button id="myButton" class="small-img-col-1"> ></button>
                <script>
                    document.getElementById('myButton').addEventListener('click', function () {
                        <?php
                        $x = $smallImagesArray1[1];
                        ?>
                        window.location.href = 'sproduct.php?buttonClicked=<?php echo $x; ?>';
                    });
                </script>
            </div>
    </div>
    
        <div class="single-pro-details">
            <h6>Home / <?php echo  $product_char[$buttonClicked -1 ]["CategoryName"]; ?></h6>
            <h4><?php echo $product_char[$buttonClicked -1 ]["ProductBrand"]; ?></h4>
            <h2><?php echo $product_char[$buttonClicked -1 ]["Price"]; ?></h2>
            <select>
                <option>Select Size</option>
                <option>Small</option>
                <option>Large</option>
                <option>XL</option>
                <option>XXL</option>
            </select>
            <input type="number" value="1" min="1">
            <button class="normal">Add To Cart</button>
            <h4>Product Details</h4>
            <span><?php echo $product_char[$buttonClicked -1 ]["Description"]; ?>
            </span>
        </div>
    </section>

    <section id="product1" class="section-p1">
        <h2>New Arrivals</h2>
        <p>Summer Collection New Modern Design</p>
        <div class="pro-container">
            <?php
            $z = 0;
            while ($z < 4) {
                echo '<div class="pro">';
                $productId = $z + 1;
                echo '<a href="sproduct.php?buttonClicked=' . $productId . '">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($product_char[$z]["Image"]) . '" width="100%" alt="">';
                echo '</a>';
                echo '<div class="des">';
                echo '<span>' . $product_char[$z]["ProductBrand"] . '</span>';
                echo '<h5>'. $product_char[$z]["CategoryName"] .'</h5>';
                for ($y = 1; $y <= $product_char[$z]["Rating"]; $y++) {
                    echo '<i class="fas fa-star"></i>';
                }
                echo '<h4>' . $product_char[$z]["Price"] . '</h4>';
                echo '</div>';
                echo '<a href="#"><i class="fa-solid fa-cart-plus"></i></a>';
                echo '</div>';
                $z++;
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
            <a href="#">Sign In</a>
            <a href="#">View Cart</a>
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

    <script>
        var MainImg = document.getElementById("MainImg");
        var smallimg = document.getElementsByClassName("small-img");
        smallimg[0].onclick = function() {
            MainImg.src = smallimg[0].src;
        }
        smallimg[1].onclick = function() {
            MainImg.src = smallimg[1].src;
        }
        smallimg[2].onclick = function() {
            MainImg.src = smallimg[2].src;
        }
        smallimg[3].onclick = function() {
            MainImg.src = smallimg[3].src;
        }
    </script>

    <script src="Assets/js/script.js"></script>
</body>

</html>