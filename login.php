<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/c/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Ecommerce Website - Login</title>
    <!--<title> Login and Registration Form in HTML & CSS | CodingLab </title>-->
    <link rel="stylesheet" href="Assets/css/login.css">
    <link rel="stylesheet" href="Assets/css/index.css">
    <script src="https://kit.fontawesome.com/453f139144.js" crossorigin="anonymous"></script>
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="img/logo.png">
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
      <!-- <div class="back">
        <img class="backImg" src="img/hero4.png" alt="">
        <div class="text">
          <span class="text-1">Complete miles of journey <br> with one step</span>
          <span class="text-2">Let's get started</span>
        </div>
      </div> -->
    </div>
    <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <div class="title">Login</div>
          <form action="#">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" placeholder="Enter your email" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Enter your password" required>
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
        <form action="#">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="Enter your name" required>
              </div>
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" placeholder="Enter your email" required>
              </div>
              <div class="input-box">
                <i class="fa-solid fa-phone"></i>
                <input type="text" placeholder="Enter your phone number" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Enter your password" required>
              </div>
              <div class="button input-box">
                <input type="submit" value="Sumbit">
              </div>
              <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label></div>
            </div>
      </form>
    </div>
    </div>
    </div>
  </div>
  <script src="Assets/js/script.js"></script>
</body>
</html>
