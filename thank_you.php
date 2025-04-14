<?php
session_start();
$order_id = $_GET['order_id'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container text-center mt-5">
    <h2>🎉 Thank You for Your Order!</h2>
    <?php if ($order_id): ?>
        <p>Your order ID is <strong>#<?= htmlspecialchars($order_id) ?></strong>.</p>
    <?php else: ?>
        <p>Thank you for shopping with us.</p>
    <?php endif; ?>
    <a href="index.html" class="btn btn-primary mt-3">Back to Home</a>
</div>
</body>
</html>
