<?php
ob_start();
// session_start();
// include 'Controllers/dbController.php';
// include 'getProducts.php';

$db = new dbController();
$db->openConnection();

function filterSort() {
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
    $category = isset($_GET['category']) ? $_GET['category'] : 'default';
    $brand = isset($_GET['brand']) ? $_GET['brand'] : 'default';
    $size = isset($_GET['size']) ? $_GET['size'] : 'default';
    $color = isset($_GET['color']) ? $_GET['color'] : 'default';

    $query = "SELECT * FROM product";

    $conditions = [];

    if ($category != 'default') {
        $conditions[] = "CategoryId = (SELECT CategoryId FROM category WHERE CategoryName = '$category')";
    }

    if ($brand != 'default') {
        $conditions[] = "ProductBrand = '$brand'";
    }

    if ($size != 'default') {
        $conditions[] = "ProductId IN (SELECT ProductId FROM sizes WHERE sName = '$size')";
    }

    if ($color != 'default') {
        $conditions[] = "Color = '$color'";
    }

    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    if ($sort != 'default') {
        if ($sort == 'relevance') {
            $query .= " ORDER BY ProductId DESC";
        } else if ($sort == 'price_asc') {
            $query .= " ORDER BY Price ASC";
        } else if ($sort == 'price_desc') {
            $query .= " ORDER BY Price DESC";
        } else if ($sort == 'rating_desc') {
            $query .= " ORDER BY Rating DESC";
        }
    }

    // header("Location: shop.php");
    return $query;
}
?>