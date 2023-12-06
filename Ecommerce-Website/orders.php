<?php
    include('config/db_config.php');

    $orderquery = 'SELECT customer.Email, orders.*
    FROM customer
    RIGHT JOIN orders ON customer.CustomerId = orders.CustomerId ORDER BY OrderId DESC';
    $orderresult = mysqli_query($conn, $orderquery);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playpen+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/453f139144.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="Assets/css/adminTables.css">
    </head>
<body>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li>
                    <a href="admin.php">
                        <i class="fa-solid fa-table-columns"></i>
                        <div class="title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="products.php">
                        <i class="fas fa-box"></i>
                        <div class="title">Products</div>
                    </a>
                </li>
                <li>
                    <a href="users.php">
                        <i class="fas fa-users"></i>
                        <div class="title">Users</div>
                    </a>
                </li>
                <li>
                    <a href="orders.php">
                        <i class="fas fa-shopping-cart"></i>
                        <div class="title">Orders</div>
                    </a>
                </li>
                <li>
                    <a href="admin.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <div class="title">Logout</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main">
            <div class="top-bar">
                <div class="user">
                    <h3>Hello, Admin</h3>
                </div>
            </div>
        <div class="tables">
            <h2 style="color: #072763;">All Orders</h2>
            <div class="total-orders">
                <table class="orders-table">
                    <thead>
                        <td>Order ID</td>
                        <td>Customer Email</td>
                        <td>Order Date</td>
                        <td>Total Price</td>
                        <td>Status</td>
                        <td>Address</td>
                    </thead>
                    <tbody>
                        <?php
                            while($row = mysqli_fetch_assoc($orderresult)){
                                echo "<tr>";
                                echo "<td>".$row['OrderId']."</td>";
                                echo "<td>".$row['Email']."</td>";
                                echo "<td>".$row['OrderDate']."</td>";
                                echo "<td>".$row['TotalAmount']."</td>";
                                echo "<td>".$row['Status']."</td>";
                                echo "<td>".$row['Address']."</td>";
                                echo "<td><a href='orders.php?order_id=". $row['OrderId']. "&toggleOrderItems=1'><i class='fas fa-eye'></i></a>
                                <i style='cursor: pointer;' class='fas fa-edit' onclick='openEditModal(".$row['OrderId'].");'></i></td>";
                                echo "</tr>";
                            }

                            if(isset($_GET['order_id'])) {
                                $order_id = $_GET['order_id'];

                                $orderdetails = "SELECT orderitems.ProductId, product.ProductBrand, product.Price, orderitems.Quantity 
                                FROM orderitems 
                                JOIN product ON orderitems.ProductId = product.ProductId 
                                WHERE orderitems.OrderId = '$order_id';";

                                $orderdetailsresult = mysqli_query($conn, $orderdetails);
                                $record = mysqli_fetch_assoc($orderdetailsresult);
                                
                                ?>
                    </tbody>
                </table>
            </div>
        <?php
            if(isset($record)) {
                $show = false;

                if(isset($_GET['toggleOrderItems'])) {
                    $show = !$show;
                }

                if($show) {
        ?>
        <div class="order-items">
            <h3>Order Items</h3>
            <a href="?"><i class="fas fa-times"></i></a>
            <table class="order-items-table">
                <thead>
                    <td>Product ID</td>
                    <td>Product Name</td>
                    <td>Price</td>
                    <td>Quantity</td>
                </thead>
                <tbody>
                    <?php foreach($orderdetailsresult as $record) { ?>
                    <tr>
                        <td>
                            <?php echo $record['ProductId'] ?>
                        </td>
                        <td>
                            <?php echo $record['ProductBrand'] ?>
                        </td>
                        <td>
                            <?php echo $record['Price'] ?>
                        </td>
                        <td>
                            <?php echo $record['Quantity'] ?>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                }   
            }
            ?>
            </tbody>
        </table>
        <div id="editModal" class="modal">
            <div class="modal-content">
                <i id="closeModal" class="fas fa-times" onclick="closeEditModal()"></i>
                <form method="post" action="manageOrders.php">
                <input id="OrderId" name="id" readonly>
                <input id="Status" name="status" placeholder="Status">
                <button style="background-color: green; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer;" 
                type="submit">Apply</button>
                </form>
            </div>
        </div>
    </div>
        </div>
    </div>

    <script>
        function openEditModal(id) {
            document.getElementById("editModal").style.display = "block";
            document.getElementById("OrderId").value = id;
        }

        function closeEditModal() {
            document.getElementById("editModal").style.display = "none";
        }
    </script>

</body>
</html>