<?php
session_start();
include __DIR__ . "/db.php";

// Prevent admin from adding users
if (isset($_POST['add_user'])) {
    echo "<script>alert('Admins are not allowed to add users manually.'); window.location.href='manage_users.php';</script>";
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id = $id");
    header("Location: manage_users.php");
    exit;
}

// Handle update user
if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $name = $_POST['edit_name'];
    $email = $_POST['edit_email'];

    $stmt = $conn->prepare("UPDATE users SET fullname=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $email, $id);
    $stmt->execute();
    header("Location: manage_users.php");
    exit;
}

// Fetch all users
$users = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include __DIR__ . '/inc/navbar.php'; ?>
<?php include __DIR__ . '/inc/sidebar.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-10 mx-auto">

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">User List</h4>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-striped m-0">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $users->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= $row['created_at'] ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
                                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form method="POST" class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                <div class="mb-3">
                                                    <input type="text" name="edit_name" class="form-control" value="<?= htmlspecialchars($row['fullname']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="email" name="edit_email" class="form-control" value="<?= htmlspecialchars($row['email']) ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="update_user" class="btn btn-success">Save Changes</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
