<?php
    session_start();
    include 'config/db_config.php';

    print_r($_POST);
    $id = $_POST['id'];
    $Status = $_POST['status'];
    
    $sql = "UPDATE orders 
            SET orders.Status =  '$Status' WHERE orders.OrderId = $id";
    echo $sql;
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    } else {
        echo "Record updated successfully";
    }

    header('Location: orders.php');
?>