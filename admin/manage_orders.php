<?php
include __DIR__ . "/db.php";

// Handle Order Status Update
if (isset($_POST['update_order'])) {
    $id = $_POST['order_id'];
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE orders SET order_status=? WHERE order_id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    header("Location: manage_orders.php");
    exit;
}

// Handle Order Deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete related order details first
    $conn->query("DELETE FROM order_details WHERE order_id = $id");

    // Then delete the order itself
    $conn->query("DELETE FROM orders WHERE order_id = $id");

    header("Location: manage_orders.php");
    exit;
}

// Fetch all orders and related user data
$orders = $conn->query("
    SELECT 
        orders.order_id, 
        users.fullname, 
        orders.total_cost, 
        orders.order_status,
        orders.house_name, 
        orders.order_date AS created_at
    FROM orders
    JOIN users ON orders.user_id = users.id
    ORDER BY orders.order_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div><?php include __DIR__ . '/inc/navbar.php'; ?></div>
    <?php include __DIR__ . '/inc/sidebar.php'; ?>

    <div class="container">
        <h2 class="mb-4">Manage Orders</h2>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Products</th>
                    <th>Total Cost</th>
                    <th>Status</th>
                    <th>House Name</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['order_id'] ?></td>
                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                    
                    <td>
                        <?php
                            $orderId = $row['order_id'];
                            $productsResult = $conn->query("
                                SELECT products.name AS product_name, order_details.quantity 
                                FROM order_details 
                                JOIN products ON order_details.product_id = products.id 
                                WHERE order_details.order_id = $orderId
                            ");

                            if ($productsResult->num_rows > 0) {
                                while ($product = $productsResult->fetch_assoc()) {
                                    echo htmlspecialchars($product['product_name']) . " x" . htmlspecialchars($product['quantity']) . "<br>";
                                }
                            } else {
                                echo "No products";
                            }
                        ?>
                    </td>

                    <td>KES <?= number_format($row['total_cost'], 2) ?></td>
                    <td><?= htmlspecialchars($row['order_status']) ?></td>
                    <td><?= htmlspecialchars($row['house_name']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['order_id'] ?>">Update</button>
                        <a href="?delete=<?= $row['order_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this order?')">Delete</a>
                    </td>
                </tr>

                <!-- Modal for Updating Order -->
                <div class="modal fade" id="editModal<?= $row['order_id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="POST" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update Order Status</h5>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                                <select name="status" class="form-control">
                                    <option value="Pending" <?= $row['order_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Processing" <?= $row['order_status'] == 'Processing' ? 'selected' : '' ?>>Processing</option>
                                    <option value="Out for Delivery" <?= $row['order_status'] == 'Out for Delivery' ? 'selected' : '' ?>>Out for Delivery</option>
                                    <option value="Delivered" <?= $row['order_status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="update_order" class="btn btn-success">Save Changes</button>
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
