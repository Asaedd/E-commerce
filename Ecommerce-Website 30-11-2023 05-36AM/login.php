<?php
session_start();
require_once 'Controllers/AuthController.php';
require_once 'Models/customer.php';
$errMsg = "";
if (isset($_POST['Email']) && isset($_POST['Password'])) {
    if (!empty($_POST['Email']) && !empty($_POST['Password'])) {
        $customer = new customer;
        $auth = new AuthController;
        $customer->Email = $_POST['Email'];
        $customer->Password = $_POST['Password'];
        if (!$auth->login($customer)) {
          // Login failed
          $errMsg= "error";
          // echo "Error: Incorrect username or password"; // You can customize this message
      } else {
          // Login successful
          if (isset($_SESSION["CustomerId"])) {
              header("location: index.php");
          } else {
              echo "Error: Session not set"; 
          }
      }      
    }
}
// if (!empty($_POST['name1']) && !empty($_POST['password1']) && !empty($_POST['email1']) && !empty($_POST['phoneNumber'])) {
//   $customer = new customer;
//   $auth = new AuthController;

//   $customer->Name = $_POST['name1'];
//   $customer->Password = password_hash($_POST['password1'], PASSWORD_DEFAULT);
//   $customer->Email = $_POST['email1'];
//   $customer->phoneNumber = $_POST['phoneNumber'];

//   if (!$auth->signUp($customer)) {
//       // SignUp failed
//       $errMsg = "error";
//       // Handle the error
//   } else {
//       // SignUp successful
//       session_start();
//       header("location: index.php");
//       exit(); // Important to prevent further execution
//   }
// }

      // Database configuration
      $dbHost = "localhost";
      $dbUser = "root";
      $dbPassword = "";
      $dbName = "ecommerce";

      // Create a connection to the database
      $conn = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

      // Check the connection
      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }

      // Get the form data
      if (!empty($_POST['name1']) && !empty($_POST['password1']) && !empty($_POST['email1']) && !empty($_POST['phoneNumber'])) {
          $name = $_POST['name1'];
          $password = $_POST['password1'];
          $email = $_POST['email1'];
          $phoneNumber = $_POST['phoneNumber'];

          // Hash the password (for security)
          $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

          // Insert the data into the database
          $sql = "INSERT INTO customer (Name, Email, Password, Phone) 
                  VALUES ('$name', '$email', '$hashedPassword', '$phoneNumber')";

          if (mysqli_query($conn, $sql)) {
              // Retrieve the last inserted ID
              $lastCustomerId = mysqli_insert_id($conn);

              // Use $lastCustomerId as needed
              echo "Record inserted successfully. Last inserted ID is: " . $lastCustomerId;
          } else {
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
      }

      // Close the database connection
      mysqli_close($conn);


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
  <a href="#"><img src="img/logo.png" class="logo" alt=""></a>
  <div>
      <ul id="navbar">
          <li><a  href="index.php">Home</a></li>
          <li><a href="shop.php">Shop</a></li>
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
            <?php
            if($errMsg!="")
            {
                ?>
                <br>
                <div class="alert">
                     <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                     <strong>ERROR:</strong> wrong email or password
                </div>
                <?php
            }
            ?>
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
