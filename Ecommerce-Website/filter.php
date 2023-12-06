<?php

function filterSort() {
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
    $category = isset($_GET['category']) ? $_GET['category'] : 'default';
    $brand = isset($_GET['brand']) ? $_GET['brand'] : 'default';
    $size = isset($_GET['size']) ? $_GET['size'] : 'default';
    $color = isset($_GET['color']) ? $_GET['color'] : 'default';

    $query = "SELECT * FROM product";

    $conditions = [];

    if ($category != 'default') {
        $query .= " JOIN category ON product.CategoryId = category.CategoryId";
        $conditions[] = " category.CategoryName = '$category'";
    }

    if ($size != 'default') {
        $query .= " JOIN sizes ON product.ProductId = sizes.ProductId";
        $conditions[] = " sName = '$size'";
    }

    if ($color != 'default') {
        $query .= " JOIN colors ON product.ColorId = colors.ColorId";
        $conditions[] = " cName = '$color'";
    }

    if ($brand != 'default') {
        $conditions[] = " ProductBrand = '$brand'";
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

    return $query;
}
?>