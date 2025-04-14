<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}
$user_id = $_SESSION['user_id'];

require_once __DIR__ . "/admin/db.php";

// Check required fields
if (
    isset($_POST['product_id'], $_POST['name'], $_POST['price'], $_POST['quantity'],
          $_POST['payment_method'], $_POST['house_name'])
) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['name'];
    $price = (float) $_POST['price'];
    $quantity = (int) $_POST['quantity'];
    $payment_method = trim($_POST['payment_method']);
    $house_name = trim($_POST['house_name']);
    $total_price = $price * $quantity;

    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, product_name, price, quantity, total_price, payment_method, house_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissdiss", $user_id, $product_id, $product_name, $price, $quantity, $total_price, $payment_method, $house_name);

    if ($stmt->execute()) {
        // Return cart count
        $result = $conn->query("SELECT COUNT(*) FROM cart WHERE user_id = $user_id");
        $row = $result->fetch_row();
        echo $row[0]; // Number of cart items
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Missing required parameters.";
}

$conn->close();
?>
