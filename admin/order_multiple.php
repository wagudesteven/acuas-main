<?php
include __DIR__ . "/db.php";

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data['user_id'];
$cart = $data['cart'];

if (!$user_id || empty($cart)) {
    echo "Invalid order data.";
    exit;
}

foreach ($cart as $item) {
    $product = $conn->real_escape_string($item['productName']);
    $quantity = (int)$item['quantity'];
    $total_cost = (int)$item['totalPrice'];
    $payment_method = $conn->real_escape_string($item['paymentMethod']);
    $house_name = $conn->real_escape_string($item['houseName']);

    $conn->query("INSERT INTO orders (user_id, product, quantity, total_cost, payment_method, house_name) 
                  VALUES ('$user_id', '$product', '$quantity', '$total_cost', '$payment_method', '$house_name')");
}

echo "Order submitted successfully!";
