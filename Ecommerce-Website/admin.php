<?php
    include('config/db_config.php');

    $userquery = 'SELECT * FROM customer ORDER BY CustomerId DESC LIMIT 3';
    $userresult = mysqli_query($conn, $userquery);

    $productquery = 'SELECT * FROM product ORDER BY ProductId DESC LIMIT 3';
    $productresult = mysqli_query($conn, $productquery);

    $orderquery = 'SELECT customer.Email, orders.*
    FROM customer
    RIGHT JOIN orders ON customer.CustomerId = orders.CustomerId ORDER BY OrderId DESC LIMIT 3';
    $orderresult = mysqli_query($conn, $orderquery);

    $usercount = 'SELECT COUNT(*) AS row_count FROM customer';
    $usercountresult = mysqli_query($conn, $usercount);

    $productcount = 'SELECT COUNT(*) AS row_count FROM product';
    $productcountresult = mysqli_query($conn, $productcount);

    $ordercount = 'SELECT COUNT(*) AS row_count FROM orders';
    $ordercountresult = mysqli_query($conn, $ordercount);

    $earnings = 'SELECT SUM(TotalAmount) AS total_earnings FROM orders';
    $earningsresult = mysqli_query($conn, $earnings);

    $returnquery = 'SELECT returnitems.OrderId, returnitems.CustomerId, returnitems.Price, returnitems.Quantity, customer.Name
    FROM returnitems
    Join customer ON returnitems.CustomerId = customer.CustomerId';
    $returnresult = mysqli_query($conn, $returnquery);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin-Dashboard</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playpen+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/453f139144.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="Assets/css/admin.css">
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
                    <a href="">
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
            <div class="cards">
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?php echo mysqli_fetch_assoc($usercountresult)['row_count']; ?></div>
                        <div class="card-name">Total Users</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?php echo mysqli_fetch_assoc($productcountresult)['row_count']; ?></div>
                        <div class="card-name">Total Products</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?php echo mysqli_fetch_assoc($ordercountresult)['row_count']; ?></div>
                        <div class="card-name">Total Orders</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?php echo mysqli_fetch_assoc($earningsresult)['total_earnings']; ?></div>
                        <div class="card-name">Earnings</div>
                    </div>
                    <div class="icon-box">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
            <div class="tables">
                <div class="total-orders">
                    <div class="heading">
                        <h2>Recent Orders</h2>
                        <a href="orders.php" class="btn">View All</a>
                    </div>
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
                                    echo "<td><a href='orders.php'><i class='fas fa-eye'></i></a>
                                              <a href='orders.php'><i class='fas fa-edit'></i></a>
                                    </td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="new-users">
                    <div class="heading">
                        <h2>New Users</h2>
                        <a href="users.php" class="btn">View All</a>
                    </div>
                    <table class="users">
                        <thead>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Phone No</td>
                        </thead>
                        <tbody>
                            <?php
                                while($row = mysqli_fetch_assoc($userresult)){
                                    echo "<tr>";
                                    echo "<td>".$row['CustomerId']."</td>";
                                    echo "<td>".$row['Name']."</td>";
                                    echo "<td>".$row['Email']."</td>";
                                    echo "<td>".$row['Phone']."</td>";
                                    echo "<td><a href='users.php'><i class='fas fa-trash'></i></a></td>";
                                }
                            ?>  
                        </tbody>
                    </table>
                </div>
                <div class="all-products">
                    <div class="heading">
                        <h2>Total Products</h2>
                        <a href="products.php" class="btn">View All</a>
                    </div>
                    <table class="products">
                        <thead>
                            <td>Product ID</td>
                            <td>Brand</td>
                            <td>Description</td>
                            <td>Price</td>
                            <td>Rating</td>
                        </thead>
                        <tbody>
                            <?php
                                while($row = mysqli_fetch_assoc($productresult)){
                                    echo "<tr>";
                                    echo "<td>".$row['ProductId']."</td>";
                                    echo "<td>".$row['ProductBrand']."</td>";
                                    echo "<td>".substr($row['Description'] , 0, 39)."...</td>";
                                    echo "<td>".$row['Price']."</td>";
                                    echo "<td>".$row['Rating']."</td>";
                                    echo "<td><a href='products.php'><i class='fas fa-edit'></i></a>";
                                    echo "</tr>";
                                }
                            ?> 
                        </tbody>
                    </table>
                </div>
                <div class="total-orders">
                    <div class="heading">
                        <h2>Return requests</h2>
                        <a href="orders.php" class="btn">View All</a>
                    </div>
                    <table class="orders-table">
                        <thead>
                            <td>Order ID</td>
                            <td>Customer Name</td>
                            <td>Price</td>
                            <td>Quantity</td>
                        </thead>
                        <tbody>
                            <?php
                                while($row = mysqli_fetch_assoc($returnresult)){
                                    echo "<tr>";
                                    echo "<td>".$row['OrderId']."</td>";
                                    echo "<td>".$row['Name']."</td>";
                                    echo "<td>".$row['Price']."</td>";
                                    echo "<td>".$row['Quantity']."</td>";
                                    echo "<td><a href='orders.php'><i class='fas fa-eye'></i></a>
                                    <a href='orders.php'><i class='fas fa-edit'></i></a></td>";
                                    echo "</tr>";
                                }
                            ?> 
                        </tbody>
                    </table>
                </div>
            </div>
       </div>
    </div>
</body>
</html>