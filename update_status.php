<?php
require_once __DIR__ . "/admin/db.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['action'])) {
    $order_id = (int)$_POST['order_id'];
    $user_id = $_SESSION['user_id'];
    $action = $_POST['action'];

    // Confirm this order belongs to the logged-in user
    $result = $conn->query("SELECT * FROM orders WHERE order_id = $order_id AND user_id = $user_id");

    if ($result->num_rows == 0) {
        die("Unauthorized access.");
    }

    if ($action === 'cancel') {
        $conn->query("UPDATE orders SET order_status = 'cancelled' WHERE order_id = $order_id");
    } elseif ($action === 'delivered') {
        $conn->query("UPDATE orders SET order_status = 'delivered' WHERE order_id = $order_id");
    }
}

header("Location: my_order.php");
exit();
