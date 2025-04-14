<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = intval($_POST['user_id']);
    $order_id = intval($_POST['order_id']);
    $amount = floatval($_POST['amount']);
    $payment_method = trim($_POST['payment_method']);
    $transaction_id = trim($_POST['transaction_id']);

    // Validate inputs
    if (empty($user_id) || empty($order_id) || empty($amount) || empty($payment_method) || empty($transaction_id)) {
        echo json_encode(["status" => "error", "message" => "All fields are required!"]);
        exit;
    }

    // Insert payment
    $stmt = $conn->prepare("INSERT INTO payments (user_id, order_id, amount, payment_method, transaction_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $user_id, $order_id, $amount, $payment_method, $transaction_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Payment recorded successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
}
?>
