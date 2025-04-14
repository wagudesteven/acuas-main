<?php
session_start();
require_once "admin/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if ($quantity <= 0) {
        unset($_SESSION['cart'][$product_id]);
    } else {
        $_SESSION['cart'][$product_id] = $quantity;

        // If user is logged in, update in database too
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            $check = $conn->prepare("SELECT * FROM user_cart WHERE user_id = ? AND product_id = ?");
            $check->bind_param("ii", $user_id, $product_id);
            $check->execute();
            $result = $check->get_result();

            if ($result->num_rows > 0) {
                // Update quantity
                $update = $conn->prepare("UPDATE user_cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
                $update->bind_param("iii", $quantity, $user_id, $product_id);
                $update->execute();
            } else {
                // Insert new
                $insert = $conn->prepare("INSERT INTO user_cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
                $insert->bind_param("iii", $user_id, $product_id, $quantity);
                $insert->execute();
            }
        }
    }

    echo json_encode(['status' => 'success']);
    exit;
}
?>
