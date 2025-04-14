<?php
include __DIR__ . "/db.php";



// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); // Sanitize input
    $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: manage_reviews.php");
    exit;
}

// Fetch all reviews
$reviews = $conn->query("SELECT * FROM reviews ORDER BY created_at DESC");

if (!$reviews) {
    die("MySQL Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <?php include __DIR__ . '/inc/navbar.php'; ?>
    <?php include __DIR__ . '/inc/sidebar.php'; ?>

    <div class="container">
        <h2 class="mb-4">Manage Reviews</h2>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Fullname</th>
                    <th>Rating</th>
                    <th>Comments</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $reviews->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                    <td><?= $row['rating'] ?> ⭐</td>
                    <td><?= nl2br(htmlspecialchars($row['comments'])) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this review?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>