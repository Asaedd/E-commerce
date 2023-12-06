<?php 
require_once 'Models/Customer.php';
require_once 'Controllers/AuthController.php';
session_start();

            $db = new dbController();
            $db->openConnection();
            if(isset($_SESSION['CustomerId']))
            {
            $CustomerId = $_SESSION['CustomerId'];
            }
            else
            {
              header("Location: login.php");
            }
            $query = "SELECT * FROM `Customer`\n"
            . "WHERE CustomerId = '$CustomerId'";
            $result=$db->select($query);
//$db->closeConnection();
?>

<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/c/CodingLabYT-->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout-Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playpen+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/453f139144.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Assets/css/index.css">
    <link rel="stylesheet" href="Assets/css/checkout.css">
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
  <!-- <div id="title">Shipping</div> -->
  <form method="post" action="">
  <div class="con"> <!--start-->
  <br><br>
    <div class="product-card">
      <div id="title">Shipping</div>

      <div id="cc">
        <div id="kady" class="forms">
          <div class="form-content">
            <div class="login-form">
              <form action="#">
                <div class="input-boxes">
                  <div class="input-box">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" value="<?php echo $result[0]['Name']; ?>"disabled>
                  </div>
                  <div class="input-box">
                    <i class="fas fa-envelope"></i>
                    <input type="text" value="<?php echo $result[0]['Email']; ?>" disabled>
                  </div>
                  <div class="input-box">
                    <i class="fa-solid fa-location-dot"></i>
                    <input type="text" name = "address" placeholder="Enter Your Address" required>
                  </div>
                  <div class="input-box">
                    <i class="fa-solid fa-location-dot"></i>
                    <input type="text" name = "AI"placeholder="Enter Additional information">
                  </div>
                  <!-- <form id="fo" action="#"> -->
                  <!-- <select name="" id="country" style="margin-top: 10px;">
                    <option value="">Giza </option>
                    <option value="">Cairo </option>
                    <option value="">Shargya </option>
                    <option value="">Helwan </option>
                  </select> -->
                  <!-- </form> -->
                </div>
              </form>
            </div>
          </div>
        </div>
          
          <?php
          
                ob_start();
                // session_start();
                include ("config/db_config.php");
                if (isset($_SESSION['cart'])) {
                  echo '<div class="nn">';
                    if (!empty($_SESSION['cart'])) {
                      $myQuantity = array();
                      $j = 0;
                      $totalPrice = 0;
                            foreach ($_SESSION['cart'] as $identifier) {
                            list($product_id, $size) = explode('_', $identifier);

                            $sql = "SELECT Image, ProductBrand, Price FROM product WHERE product.ProductId = " . $product_id;
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);

                            $imageData = $row['Image'];
                            $description = $row['ProductBrand'];
                            $price = $row['Price'];
                            
                            echo '<div class="proo">';
                            echo '<div class="dess">';
                            echo '<a href="sproduct.php?buttonClicked=3"><span>' . $description . '</span>';
                            echo '<h5>quantity: <span>' . $_SESSION['quantity'][$identifier] . '</span></h5>';
                            echo '<h4>' . ($price * $_SESSION['quantity'][$identifier]) . ' $</h4>';
                            $totalPrice += $price * $_SESSION['quantity'][$identifier];
                            echo '</a>';
                            echo '</div>';
                            echo '<img width="50%" style="display: block; margin-left: auto;" src="data:image/jpeg;base64,' . base64_encode($imageData) . '">';
                            echo '</div>';
                            // echo '<br>';
                            $myQuantity[$j] = $_SESSION['quantity'][$identifier];
                            $myProductId[$j] = $product_id;
                            $j++;
                        }
                    } else {
                        echo '<tr><td colspan="7">Cart is Empty</td></tr>';
                        echo '<tr><td colspan="7"><a style="color: black;" href="index.php">Back To Home</a></td></tr>';
                    }
                }
                echo '</div>';

                
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
        
    </div>
    <div id="title">Order summary</div>
    <div id="total">
      <p id="bb"><b>Total amount</b></p>
      <p id="bb"><b><?php echo $totalPrice;?>$</b></p>
    </div>
    <div id="total">
      <p id="bb"><b>taxes</b></p>
      <p id="bb"><b><?php echo $totalPrice * 0.5 / 100;?>$</b></p>
    </div>
    <div id="total">
      <p id="bb"><b>Total amount</b></p>
      <p id="bb"><b><?php 
      $_SESSION['totalPrice'] =  $totalPrice + $totalPrice * 0.5 / 100;
      echo $_SESSION['totalPrice'];?>$</b></p>
    </div>
    <div class="button">
    <div class="button-layer"></div>
    <button type="submit" name="placeOrder">Place Order</button>
    </div>
  </div>
  </div> <!--ns container  -->
  </form>
      <?php
      if (isset($_POST['placeOrder'])) {
        // echo $_SESSION['totalPrice'];
        // echo $_SESSION['CustomerId'];
        $totalPrice = $_SESSION['totalPrice'];
        $customerId = $_SESSION['CustomerId'];
        $address = $_POST['address'];
        $AI = isset($_POST['AI']) ? $_POST['AI'] : NULL;

        // Insert the data into the database using prepared statements
      $insertSql = "INSERT INTO orders (Address, AI, TotalAmount, CustomerId) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($insertSql);
      $stmt->bind_param("ssss", $address, $AI, $totalPrice, $customerId);

      if ($stmt->execute()) {
          // Insert successful, now retrieve the last OrderId
          $selectSql = "SELECT MAX(OrderId) AS LastOrderId FROM orders";
          $result3 = mysqli_query($conn, $selectSql);

          if ($result3) {
              $row = mysqli_fetch_assoc($result3);
              if ($row['LastOrderId'] !== null) {
                  $lastOrderId = $row['LastOrderId'];
                  for ($i = 0; $i < $j; $i++) {
                    $sql = "INSERT INTO orderitems (Quantity, OrderId, ProductId) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    
                    // Check if the indices exist in the arrays before accessing them
                    if (isset($myQuantity[$i]) && is_scalar($myQuantity[$i]) && isset($myProductId[$i]) && is_scalar($myProductId[$i])) {
                        $stmt->bind_param("iii", $myQuantity[$i], $lastOrderId, $myProductId[$i]);
                
                        if ($stmt->execute()) {
                            // Insert successful, do something if needed
                        } else {
                            // Handle error in the INSERT query
                            echo "Error in orderitems INSERT: " . $stmt->error;
                        }
                    } else {
                        echo "Error: Trying to access undefined or non-scalar indices in arrays.";
                    }
                  }
              } else {
                  echo "No orders in the database yet.";
              }
          } else {
              // Handle query error
              echo "Error: " . mysqli_error($conn);
          }
      } else {
          // Error in SQL query for INSERT
          echo "Error: " . $stmt->error;
      }
      }
      ?>
  <script src="Assets/js/script.js"></script>
</body>
</html>