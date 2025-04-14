<?php
include 'db.php';

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id=?");
    $stmt->bind_param("i", $_GET['id']);

    echo $stmt->execute() ? "User deleted successfully" : "Error deleting user";
}
?>
