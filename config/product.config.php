<?php
require_once(__DIR__ . "/connect.php");

try {
    $logoSql = "SELECT A.*, B.name AS category FROM products A JOIN categories B ON A.category_id = B.category_id";
    $result = $conn->query($logoSql);
    if (!$result) {
        throw new Exception("Error fetching products: " . $conn->error);
    }
    
    $productList = [];
    while ($row = $result->fetch_assoc()) {
        $productList[] = $row;
    }

    $newListSql = "SELECT A.*, B.name AS category FROM products A JOIN categories B ON A.category_id = B.category_id ORDER BY A.created_at DESC";
    $result = $conn->query($newListSql);
    if (!$result) {
        throw new Exception("Error fetching new products: " . $conn->error);
    }
    
    $newList = [];
    while ($row = $result->fetch_assoc()) {
        $newList[] = $row;
    }
} catch (Exception $e) {
    error_log("Error in product.config.php: " . $e->getMessage());
    $productList = [];
    $newList = [];
}
?>