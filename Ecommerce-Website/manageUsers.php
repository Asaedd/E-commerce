<?php

session_start();
include 'config/db_config.php';

if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM customer WHERE customerId = $id";
    mysqli_query($conn, $sql);
    
    header('Location: users.php');
}
?>