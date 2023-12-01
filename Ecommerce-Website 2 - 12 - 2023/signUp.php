<?php
include_once 'Controllers/dbController.php';
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection details
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "ecommerce";

    // Create a database connection
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the form data
    $name = $_POST['name1'];
    $email = $_POST['email1'];
    $phoneNumber = $_POST['phoneNumper'];
    $password = $_POST['password1'];

    //checking if email already exist...
    $db = new dbController();
    $db->openConnection();

    $query = "  SELECT *
                FROM customer;";
    $result = $db->select($query);
    // print_r($result);
    $product_char = array(); // initialize array
    $totalProductEmails = count(array_unique(array_column($result, 'CustomerId')));
    $flag = false;
    for($i = 0 ; $i < $totalProductEmails ; $i++)
    {
        if($email == $result[$i]["Email"])
        {
            $flag = true;
            break;
        }
    }

    //checking if email is an email
    $flag1 = false;
    function isValidEmail($email) {
        // Use filter_var to check if the email is valid
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    // Example usage:
    $emailToCheck = $email;
    if (isValidEmail($emailToCheck)) {
        // echo "The email is valid.";
    } else {
        // echo "The email is not valid.";
        $flag1 = true;
    }

    if(!$flag && !$flag1)
    {
        // Insert the data into the database
            $sql = "INSERT INTO customer (Name, Email, Password, Phone) 
            VALUES ('$name', '$email', '$password', '$phoneNumber')";

        if ($conn->query($sql) === TRUE) {
        // Registration successful, redirect to login page
        header("Location: login.php");
        exit();
        } else {
        // Error in SQL query
        echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    else
    {
        // header("Location: login.php");
        if($flag1)
        {
            $errMsg = "Email Is Not Valid"; // Set your error message here   
        }
        else
            $errMsg = "Email already exists"; // Set your error message here
    }
    

    // Close the database connection
    $conn->close();
} else {
    // If someone tries to access this page directly, redirect to login page
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/c/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <!--<title> Login and Registration Form in HTML & CSS | CodingLab </title>-->
    <link rel="stylesheet" href="Assets/css/login.css">
    <link rel="stylesheet" href="Assets/css/index.css">
    <script src="https://kit.fontawesome.com/453f139144.js" crossorigin="anonymous"></script>
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
<!-- start header  -->
<div class="abs">
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
                <li><b><a href="buy1get1.php" class="sale">Sale</a></b></li>
                <li id="lg-bag"><a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
                <li id="lg"><a class="active" href="login.php"><i class="fa-solid fa-user"></i></a></li>
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
          <span class="text-1
          ">Super value deals
            On all products</span>
          <span class="text-2">new adventure</span>
        </div>
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <div class="title">Login</div>
          <form method="POST">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" name = "Email" placeholder="Enter your email" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name = "Password" placeholder="Enter your password" required>
              </div>
              <div class="text"><a href="#">Forgot password?</a></div>
              <div class="button input-box">
                <input type="submit" value="Sumbit">
              </div>
              <div class="text sign-up-text">Don't have an account? <label for="flip">Signup now</label></div>
            </div>
        </form>
      </div>
        <div class="signup-form">
          <div class="title">Signup</div>
          <?php
            if ($errMsg != "") {
                echo '<br>';
                echo '<div class="alert">';
                echo '    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
                echo '    <strong>ERROR:</strong> ' . $errMsg;
                echo '</div>';
            }            
            ?>
          <form method="POST" action="signUp.php">
        <div class="input-boxes">
            <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" name="name1" placeholder="Enter your name" required>
            </div>
            <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" name="email1" placeholder="Enter your email" required>
            </div>
            <div class="input-box">
                <i class="fa-solid fa-phone"></i>
                <input type="text" name="phoneNumper" placeholder="Enter your phone number" required>
            </div>
            <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password1" placeholder="Enter your password" required>
            </div>
            <div class="button input-box">
                <input type="submit" value="Submit">
            </div>
            <div class="text sign-up-text">Already have an account? <a href="login.php">Login now</a></div>
        </div>
    </form>
    </div>
    </div>
    </div>
  </div>
  <script src="Assets/js/script.js"></script>
</body>
</html>
