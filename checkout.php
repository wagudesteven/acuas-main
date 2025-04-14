<?php
session_start();

// Include the database connection
require_once __DIR__ . "/admin/db.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: register.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items from the database
$cart_items = $conn->query("SELECT * FROM cart WHERE user_id = $user_id");

// Initialize total amount
$total_amount = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container py-5">
    <h2 class="mb-4">Checkout</h2>

    <?php if ($cart_items->num_rows > 0) : ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Product Name</th>
                <th>Price (Ksh)</th>
                <th>Quantity</th>
                <th>Total Price (Ksh)</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($item = $cart_items->fetch_assoc()) :
                $price = (float)$item['price'];
                $quantity = (int)$item['quantity'];
                $item_total = $price * $quantity;
                $total_amount += $item_total;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td><?= number_format($price, 2) ?></td>
                    <td><?= $quantity ?></td>
                    <td><?= number_format($item_total, 2) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <h4 class="text-end">Total Amount: <strong>Ksh <?= number_format($total_amount, 2) ?></strong></h4>

        <form method="POST" action="process_checkout.php" class="mt-4">
            <!-- Add any other fields like address or payment method here if needed -->
            <input type="hidden" name="total_amount" value="<?= $total_amount ?>">
            <button type="submit" class="btn btn-primary">Proceed to Payment</button>
        </form>
    <?php else : ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
