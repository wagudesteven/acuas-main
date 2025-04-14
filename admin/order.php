<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $products = $_POST['quantities'];
    $total_cost = $_POST['total_cost'];

    $stmt = $conn->prepare("INSERT INTO orders (user_id, products, total_cost) VALUES (?, ?, ?)");

    if ($stmt) { // Check if prepare was successful
        $stmt->bind_param("isd", $user_id, $products, $total_cost);

        if ($stmt->execute()) {
            echo "Order placed successfully!";
        } else {
            echo "Error placing order: " . $stmt->error;
        }

        $stmt->close(); // Close the statement
    } else {
        echo "Error preparing statement: " . $conn->error; // Handle prepare error
    }

    $conn->close(); //Close the connection.
}
?>
