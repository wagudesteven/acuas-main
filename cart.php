<?php
session_start();
require_once __DIR__ . "/admin/db.php";

if (!isset($_SESSION['user_id'])) {
    header('Location: register.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // UPDATE CART ITEMS
    foreach ($_POST['update_cart'] ?? [] as $cart_id => $value) {
        $quantity = max(1, (int) $_POST['quantities'][$cart_id]);
        $payment_method = trim($_POST['payment_methods'][$cart_id]);
        $house_name = trim($_POST['house_names'][$cart_id]);

        $stmt = $conn->prepare("SELECT price FROM cart WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $cart_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $price = $result['price'];
        $total_price = $price * $quantity;

        $update_stmt = $conn->prepare("UPDATE cart SET quantity = ?, total_price = ?, payment_method = ?, house_name = ? WHERE id = ? AND user_id = ?");
        $update_stmt->bind_param("idssii", $quantity, $total_price, $payment_method, $house_name, $cart_id, $user_id);
        $update_stmt->execute();
    }

    // DELETE CART ITEMS
    foreach ($_POST['delete_cart'] ?? [] as $cart_id => $value) {
        $delete_stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $delete_stmt->bind_param("ii", $cart_id, $user_id);
        $delete_stmt->execute();
    }

    // MAKE ORDER
    if (isset($_POST['make_order'])) {
        $cart_data = [];
        $total_cost = 0;
        $any_mpesa = false;
        $house_name = '';

        foreach ($_POST['quantities'] as $cart_id => $quantity) {
            $quantity = max(1, (int) $quantity);
            $payment_method = trim($_POST['payment_methods'][$cart_id]);
            $house_name_input = trim($_POST['house_names'][$cart_id]);

            $stmt = $conn->prepare("SELECT * FROM cart WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $cart_id, $user_id);
            $stmt->execute();
            $item = $stmt->get_result()->fetch_assoc();

            if (!$item) continue;

            $price = $item['price'];
            $total_price = $price * $quantity;

            $cart_data[] = [
                'product_id' => $item['product_id'],
                'quantity' => $quantity,
                'price' => $price,
                'total_price' => $total_price,
                'payment_method' => $payment_method,
                'house_name' => $house_name_input
            ];

            $total_cost += $total_price;
            $house_name = $house_name_input;

            if ($payment_method === 'M-Pesa') {
                $any_mpesa = true;
            }
        }

        $payment_method = $any_mpesa ? 'M-Pesa' : 'Cash';
        $insert_order = $conn->prepare("INSERT INTO orders (user_id, total_cost, payment_method, house_name) VALUES (?, ?, ?, ?)");
        $insert_order->bind_param("idss", $user_id, $total_cost, $payment_method, $house_name);
        $insert_order->execute();
        $order_id = $insert_order->insert_id;

        foreach ($cart_data as $item) {
            $insert_detail = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $insert_detail->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
            $insert_detail->execute();
        }

        $conn->query("DELETE FROM cart WHERE user_id = $user_id");

        if ($any_mpesa) {
            header("Location: payment.php");
        } else {
            echo "<script>alert('Order placed successfully using Cash!'); window.location.href='my_order.php';</script>";
        }
        exit();
    }

    header("Location: cart.php");
    exit();
}

$cart_items = $conn->query("SELECT * FROM cart WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: rgb(0, 255, 255);
            color: white;
        }
        .card-body {
            background-color: #ffffff;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-danger, .btn-success, .btn-primary {
            width: 100%;
        }
        .total-amount {
            font-size: 1.25rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Your Cart</h4>
            <a href="service.php" class="btn btn-outline-dark btn-sm">← Back to Shopping</a>
        </div>
        <div class="card-body">
            <?php if ($cart_items->num_rows > 0): ?>
                <form method="post">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>Product Name</th>
                                <th>Price (Ksh)</th>
                                <th>Quantity</th>
                                <th>Total Price (Ksh)</th>
                                <th>Payment Method</th>
                                <th>House Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total_amount = 0;
                        $cart_items->data_seek(0);
                        while ($item = $cart_items->fetch_assoc()):
                            $cart_id = $item['id'];
                            $total_amount += $item['total_price'];
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($item['product_name']) ?></td>
                                <td><?= number_format($item['price'], 2) ?></td>
                                <td>
                                    <input type="number" name="quantities[<?= $cart_id ?>]" value="<?= $item['quantity'] ?>" class="form-control" min="1" style="width: 80px;">
                                </td>
                                <td><?= number_format($item['total_price'], 2) ?></td>
                                <td>
                                    <select name="payment_methods[<?= $cart_id ?>]" class="form-select">
                                        <option value="M-Pesa" <?= $item['payment_method'] === 'M-Pesa' ? 'selected' : '' ?>>M-Pesa</option>
                                        <option value="Cash" <?= $item['payment_method'] === 'Cash' ? 'selected' : '' ?>>Cash</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="house_names[<?= $cart_id ?>]" value="<?= htmlspecialchars($item['house_name']) ?>" class="form-control" required>
                                </td>
                                <td>
                                    <button type="submit" name="update_cart[<?= $cart_id ?>]" class="btn btn-sm btn-success mb-2">Update</button>
                                    <button type="submit" name="delete_cart[<?= $cart_id ?>]" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end mb-4">
                        <h4 class="total-amount">Total Amount: Ksh <?= number_format($total_amount, 2) ?></h4>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="service.php" class="btn btn-outline-dark">← Back to Shopping</a>
                        <button type="submit" name="make_order" class="btn btn-primary">Make Order</button>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-danger">Your cart is empty.</div>
                <a href="service.php" class="btn btn-outline-dark mt-3">← Back to Shopping</a>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
