<?php
session_start();
include_once 'config/db_config.php';

if (isset($_GET['item_id'])) {
    $item_id = $_GET['item_id'];
    $OrderId = $_GET['order_id'];

    $query = "DELETE FROM `orderitems` WHERE orderitems.ProductId = '$item_id';";

    $query1 = "INSERT INTO `returnitems` (`ProductId`, `OrderId`, `CustomerId`, `Price`, `Quantity`)
    SELECT
        orderitems.ProductId,
        orderitems.OrderId,
        customer.CustomerId,
        product.Price,
        orderitems.Quantity
    FROM
        orderitems
    JOIN product ON product.ProductId = orderitems.ProductId
    JOIN orders ON orders.OrderId = orderitems.OrderId
    JOIN customer ON customer.CustomerId = orders.CustomerId
    WHERE
        orderitems.OrderId = '$OrderId'
        AND orderitems.ProductId = '$item_id';";

    $result1 = mysqli_query($conn, $query1);
    $result = mysqli_query($conn, $query);

    if ($result && $result1) {
        header("Location: view&update.php");
    } 
}

?>