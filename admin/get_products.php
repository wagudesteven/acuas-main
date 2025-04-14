<<?php
// get_products_api.php
include __DIR__ . "/db.php";

$products = $conn->query("SELECT * FROM products ORDER BY id DESC");

$productArray = [];
while ($row = $products->fetch_assoc()) {
    $productArray[] = $row;
}

header('Content-Type: application/json');
echo json_encode($productArray);
?>
