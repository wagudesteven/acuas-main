<?php
include __DIR__ . "/db.php";

// Handle add product
if (isset($_POST['add_product'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $price = floatval($_POST['price']);
    $description = htmlspecialchars(trim($_POST['description']));
    $image = "";

    // Validation
    if (empty($name) || empty($price) || empty($description)) {
        echo "<script>alert('Please fill in all fields.');</script>";
        return;
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowed_types)) {
            $imageName = time() . "_" . basename($_FILES['image']['name']);
            $imagePath = "uploads/" . $imageName;

            // Check if the file is too large
            if ($_FILES['image']['size'] > 5000000) { // 5MB limit
                echo "<script>alert('Image is too large. Please upload an image smaller than 5MB.');</script>";
                return;
            }

            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $image = $imageName;
            } else {
                echo "<script>alert('Error uploading image.');</script>";
                return;
            }
        } else {
            echo "<script>alert('Invalid image type.');</script>";
            return;
        }
    }

    $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sdss", $name, $price, $description, $image);
        if ($stmt->execute()) {
            echo "<script>alert('Product added successfully.');</script>";
            header("Location: manage_products.php");
            exit;
        } else {
            echo "<script>alert('Database error: " . $stmt->error . "');</script>";
            error_log("Database error: " . $stmt->error);
        }
        $stmt->close();
    } else {
        echo "<script>alert('Database error: " . $conn->error . "');</script>";
        error_log("Database error: " . $conn->error);
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<script>alert('Product deleted successfully.');</script>";
            header("Location: manage_products.php");
            exit;
        } else {
            echo "<script>alert('Database error: " . $stmt->error . "');</script>";
            error_log("Database error: " . $stmt->error);
        }
        $stmt->close();
    } else {
        echo "<script>alert('Database error: " . $conn->error . "');</script>";
        error_log("Database error: " . $conn->error);
    }
}

// Handle update product
if (isset($_POST['update_product'])) {
    $id = intval($_POST['id']);
    $name = htmlspecialchars(trim($_POST['edit_name']));
    $price = floatval($_POST['edit_price']);
    $description = htmlspecialchars(trim($_POST['edit_description']));
    $existing_image = $_POST['existing_image'];
    $image = $existing_image; // Default to existing image

    // Validation
    if (empty($name) || empty($price) || empty($description)) {
        echo "<script>alert('Please fill in all fields.');</script>";
        return;
    }

    // Check if a new image was uploaded
    if (isset($_FILES['edit_image']) && $_FILES['edit_image']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['edit_image']['type'], $allowed_types)) {
            $imageName = time() . "_" . basename($_FILES['edit_image']['name']);
            $imagePath = "uploads/" . $imageName;

            // Check if the file is too large
            if ($_FILES['edit_image']['size'] > 5000000) { // 5MB limit
                echo "<script>alert('Image is too large. Please upload an image smaller than 5MB.');</script>";
                return;
            }

            if (move_uploaded_file($_FILES['edit_image']['tmp_name'], $imagePath)) {
                $image = $imageName;
                // Optionally delete the old image if you want to save space
                if ($existing_image && file_exists("uploads/" . $existing_image)) {
                    unlink("uploads/" . $existing_image);
                }
            } else {
                echo "<script>alert('Error uploading image.');</script>";
                return;
            }
        } else {
            echo "<script>alert('Invalid image type.');</script>";
            return;
        }
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, description=?, image=? WHERE id=?");
    if ($stmt) {
        $stmt->bind_param("sdssi", $name, $price, $description, $image, $id);
        if ($stmt->execute()) {
            echo "<script>alert('Product updated successfully.');</script>";
            header("Location: manage_products.php");
            exit;
        } else {
            echo "<script>alert('Database error: " . $stmt->error . "');</script>";
            error_log("Database error: " . $stmt->error);
        }
        $stmt->close();
    } else {
        echo "<script>alert('Database error: " . $conn->error . "');</script>";
        error_log("Database error: " . $conn->error);
    }
}

// Fetch all products
$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div>
        <?php include __DIR__ . '/inc/navbar.php'; ?>
    </div>

    <?php include __DIR__ . '/inc/sidebar.php'; ?>
    <div class="container">
        <h2 class="mb-4">Manage Products</h2>

        <form method="POST" enctype="multipart/form-data" class="mb-4 border p-4 rounded shadow-sm bg-light">
            <h5>Add New Product</h5>
            <input type="text" name="name" class="form-control mb-2" placeholder="Product Name" required>
            <input type="number" step="0.01" name="price" class="form-control mb-2" placeholder="Price" required>
            <textarea name="description" class="form-control mb-2" placeholder="Description" required></textarea>
            <input type="file" name="image" class="form-control mb-2" required>
            <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
        </form>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr><th>ID</th><th>Image</th><th>Name</th><th>Price</th><th>Description</th><th>Created</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php while($row = $products->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><img src="uploads/<?= $row['image'] ?>" width="50" height="50" class="rounded"></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>KES <?= number_format($row['price'], 2) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
                    </td>
                </tr>

                <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="POST" enctype="multipart/form-data" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Product</h5>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <input type="hidden" name="existing_image" value="<?= $row['image'] ?>">
                                <input type="text" name="edit_name" class="form-control mb-
                                                                <input type="text" name="edit_name" class="form-control mb-2" value="<?= htmlspecialchars($row['name']) ?>" required>
                                <input type="number" step="0.01" name="edit_price" class="form-control mb-2" value="<?= $row['price'] ?>" required>
                                <textarea name="edit_description" class="form-control mb-2"><?= htmlspecialchars($row['description']) ?></textarea> 
                                <label>Current Image:</label><br>
                                <img src="uploads/<?= $row['image'] ?>" width="80" height="80" class="mb-2 rounded"><br>
                                <input type="file" name="edit_image" class="form-control mb-2">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="update_product" class="btn btn-success">Save Changes</button>
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

