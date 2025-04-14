<?php
session_start();

// Get the cart and user details
$cart = $_SESSION['cart'] ?? [];
$user_id = $_SESSION['user_id']; // Assuming user is logged in and user_id is stored in session
$grandTotal = 0;
foreach ($cart as $item) {
    $grandTotal += $item['total'];
}

// If no items in the cart, redirect to the cart page
if (empty($cart)) {
    header("Location: payment.php");
    exit;
}

// Process the order (You can save this order into the database)
include __DIR__ . "/admin/db.php"; // Your database connection file
foreach ($cart as $item) {
    $product_id = $item['name'];
    $quantity = $item['quantity'];
    $total_price = $item['total'];
    
    $stmt = $conn->prepare("INSERT INTO orders (user_id, house_name, payment_method, total_cost) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiii", $user_id, $product_id, $quantity, $total_price);
    $stmt->execute();
}

// Clear the cart
unset($_SESSION['cart']);

echo "
    <script>
        alert('Order placed successfully! Your total is Ksh " . number_format($grandTotal, 2) . ". Click OK to proceed to payment.');
        window.location.href = 'index.php'; // Redirect to the payment page
    </script>
";
?>
