<?php
    session_start();
    include('config/db_config.php');

    $productquery = 'SELECT * FROM product';
    $productresult = mysqli_query($conn, $productquery);
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
                <h2 style="color: #072763;">All Products</h2>
                <div class="total-orders">
                    <table class="products">
                        <thead>
                            <td>Product ID</td>
                            <td>Brand</td>
                            <td>Description</td>
                            <td>Price</td>
                            <td>Rating</td>
                            <td>Action</td>
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
                                    echo "<td><i class='fas fa-edit' onclick='openEditModal(" . $row['ProductId'] . ", \"" . $row['ProductBrand'] . "\", \"" . $row['Description'] . "\", " . $row['Price'] . ", " . $row['Rating'] . ");'></i>
                                    <a href='#' onclick='confirmDelete(" . $row['ProductId'] . ")'><i id='deleteModal' class='fas fa-trash'></i></a></td>";
                                    echo "</tr>";
                                }
                            ?> 
                        </tbody>
                        <button style="background-color: green; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer;"
                         onclick="openAddModal()">Add Product</button>
                    </table>


                    <div id="addModal" class="modal">
                        <div class="modal-content">
                        <i id="closeModal" class="fas fa-times" onclick="closeAddModal()"></i>
                            <form method="post" action="manageProducts.php">
                            <input name="brand" placeholder="Brand">
                            <input name="description" placeholder="Product Description">
                            <input name="price" placeholder="Price">
                            <input name="add" type="hidden">
                            <?php 
                                $categoryquery = 'SELECT * FROM category';
                                $categoryresult = mysqli_query($conn, $categoryquery);

                                $colorquery = 'SELECT * FROM colors';
                                $colorresult = mysqli_query($conn, $colorquery);

                                echo "<select name='category'>";
                                while($row = mysqli_fetch_assoc($categoryresult)){
                                    echo "<option value=" . $row['CategoryId'] . ">" . $row['CategoryName'] . "</option>";
                                }
                                echo "</select>";
                                echo "<select name='color'>";
                                while($row = mysqli_fetch_assoc($colorresult)){
                                    echo "<option value=" . $row['ColorId'] . ">" . $row['cName'] . "</option>";
                                }
                                echo "</select>";
                            ?>
                            <button style="background-color: green; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer;" 
                            type="submit">Add</button>
                            </form>
                        </div>
                    </div> 


                    <div id="editModal" class="modal">
                        <div class="modal-content">
                            <i id="closeModal" class="fas fa-times" onclick="closeEditModal()"></i>
                            <form method="post" action="manageProducts.php">
                            <input id="ProductId" name="id" readonly>
                            <input id="brandd" name="brand" placeholder="Brand">
                            <input id="descriptionn" name="description" placeholder="Product Description">
                            <input id="pricee" name="price" placeholder="Price">
                            <input id="ratingg" name="rating" placeholder="Rating">
                            <input name="edit" type="hidden">
                            <?php 
                                $categoryquery = 'SELECT * FROM category';
                                $categoryresult = mysqli_query($conn, $categoryquery);
                            
                                $colorquery = 'SELECT * FROM colors';
                                $colorresult = mysqli_query($conn, $colorquery);
                                
                                echo "<select name='category'>";
                                while($row = mysqli_fetch_assoc($categoryresult)){
                                    echo "<option value=" . $row['CategoryId'] . ">" . $row['CategoryName'] . "</option>";
                                }
                                echo "</select>";
                                echo "<select name='color'>";
                                while($row = mysqli_fetch_assoc($colorresult)){
                                    echo "<option value=" . $row['ColorId'] . ">" . $row['cName'] . "</option>";
                                }
                                echo "</select>";
                            ?>
                            <button style="background-color: green; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer;" 
                            type="submit">Apply</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <script>
            function openAddModal() {
                document.getElementById("addModal").style.display = "block";
            }

            function closeAddModal() {
                document.getElementById("addModal").style.display = "none";
            }

            function openEditModal(productId, brand, description, price, rating) {
                document.getElementById("editModal").style.display = "block";
                document.getElementById("ProductId").value = productId;
                document.getElementById("brandd").value = brand;
                document.getElementById("descriptionn").value = description;
                document.getElementById("pricee").value = price;
                document.getElementById("ratingg").value = rating;
            }

            function closeEditModal() {
                document.getElementById("editModal").style.display = "none";
            }

            function confirmDelete(productId) {
                if (confirm("Are you sure you want to delete this product?")) {
                    window.location.href = "manageProducts.php?delete=" + productId;
                }
            }
        </script>


    </body>
</html>