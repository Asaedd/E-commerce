<?php
session_start();
include 'config/db_config.php';

 
if(isset($_POST['add'])){

   $brand = $_POST['brand'];
   $description = $_POST['description'];
   $price = $_POST['price'];
   
   
   $sql = "INSERT INTO product(ProductBrand, Description, Price, CategoryId, ColorId) 
           VALUES('$brand', '$description', $price, $_POST[category], $_POST[color])";
           
   mysqli_query($conn, $sql);
   
  
   header('Location: products.php');
  
}

if(isset($_POST['edit'])) {
    $id = $_POST['id'];
    $brand = $_POST['brand'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];
  
    
    $sql = "UPDATE product 
            SET ProductBrand='$brand', Description='$description', 
            Price=$price, Rating=$rating
            WHERE ProductId = $id";

    mysqli_query($conn, $sql);
    
    header('Location: products.php');
}

if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM product WHERE ProductId = $id";
    mysqli_query($conn, $sql);
    
    header('Location: products.php');
}

?>