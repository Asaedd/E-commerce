<?php 
    // session_start();
    include ('config/db_config.php');

    function getProducts($conn, $sql, $flag) {
        $result = mysqli_query($conn, $sql);
    
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product_id = $row['ProductId'];
                $imageData = $row['Image'];
                $brand = $row['ProductBrand'];
                $description = substr($row['Description'], 0, 60) . '....';
                $price = $row['Price'];
    
                echo '<a style="text-decoration: none;" href="sproduct.php?buttonClicked=' . $product_id . '">';
                echo '<div class="pro">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '">';
                echo '<div class="des">';
                echo '<span>' . $brand . '</span>';
                echo '<h5>' . $description . '</h5>';
                echo '<div class="star">';
                for ($i = 0; $i < $row['Rating']; $i++) {
                    echo '<i class="fas fa-star"></i>';
                }
                echo '</div>';
                if ($flag) {
                    echo '<h4>$' . $row['Price'] . '</h4>';
                    echo '</div>';
                    echo '<a href="wishlist.php?product_id=' . $product_id . '"><i class="fa-solid fa-heart"></i></a>';
                    echo '</div>';
                } else {
                    $randomNo = rand(10, 50) / 100;
                    $discount = $row['Price'] - $row['Price'] * $randomNo;
                    echo '<div style="display: flex;">';
                    echo '<h4 style="color: #ff523b;">$' . $discount . '</h4>';
                    echo '<del><h4 style="padding-left: 10px;">$' . $row['Price'] . '</h4></del></div>';
                    echo '<h6 style="color: #ff523b;">(Save ' . $randomNo * 100 . '%)</h6>';
                    echo '</div>';
                    echo '<a href="wishlist.php?product_id=' . $product_id . '&price=' . $discount . '"><i class="fa-solid fa-heart"></i></a>';
                    echo '</div>';
                }
                echo '</a>';
            }   
        }
    }
?>