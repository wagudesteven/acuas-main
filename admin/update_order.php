<?php
include __DIR__ . "/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id); // "si" indicates string and integer

    if ($stmt->execute()) {
        header("Location: manage_orders.php?success=Order updated successfully");
        exit; // Important: Stop further execution after redirect
    } else {
        echo "Error updating record: " . $stmt->error; // Use $stmt->error for prepared statements
    }
}
?>
