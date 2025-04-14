<?php
session_start();
include __DIR__ . "/db.php";

// Handle delete payment
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM payments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: manage_payments.php");
    exit;
}

// Fetch payments from the database, joining with users
$sql = "
    SELECT p.id AS payment_id, u.fullname, p.total_amount, p.payment_method, p.payment_status, p.payment_date
    FROM payments p
    JOIN users u ON p.user_id = u.id
    ORDER BY p.payment_date DESC
";

$payments = $conn->query($sql);

if (!$payments) {
    die("MySQL Error: " . $conn->error);
}

// Helper function to color-code payment status
function getStatusColor($status) {
    return match ($status) {
        'pending' => 'warning',
        'completed' => 'success',
        'failed' => 'danger',
        default => 'secondary',
    };
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <?php include __DIR__ . '/inc/navbar.php'; ?>
    <?php include __DIR__ . '/inc/sidebar.php'; ?>

    <div class="container">
        <h2 class="mb-4">Manage Payments</h2>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Paid At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $payments->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['payment_id'] ?></td>
                        <td><?= htmlspecialchars($row['fullname']) ?></td>
                        <td>KES <?= number_format($row['total_amount'], 2) ?></td>
                        <td><?= htmlspecialchars($row['payment_method']) ?></td>
                        <td>
                            <span class="badge bg-<?= getStatusColor($row['payment_status']) ?>">
                                <?= ucfirst($row['payment_status']) ?>
                            </span>
                        </td>
                        <td><?= $row['payment_date'] ?></td>
                        <td>
                            <a href="?delete=<?= $row['payment_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this payment?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
