<?php
    include('config/db_config.php');

    $userquery = 'SELECT * FROM customer';
    $userresult = mysqli_query($conn, $userquery);
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
                <h2 style="color: #072763;">All Users</h2>
                <div class="total-orders">
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
                                    echo "<td><a href='#' onclick='confirmDelete(" . $row['CustomerId'] . ")'><i id='deleteModal' class='fas fa-trash'></i></a></td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <script>
            function confirmDelete(id){
                if(confirm("Are you sure you want to delete this user?")){
                    window.location.href = "manageUsers.php?delete=" + id;
                }
            }
        </script>


    </body>
</html>