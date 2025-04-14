<?php
session_start();
include __DIR__ . "/db.php"; // Ensure this file correctly sets up $conn

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        $error_message = "Please enter both email and password.";
    } else {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Query the admins table
        $stmt = $conn->prepare("SELECT id, name, password FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($admin_id, $admin_name, $stored_password);
            $stmt->fetch();

            // ✅ Correctly verify the password
            if (password_verify($password, $stored_password)) {
                $_SESSION['admin_id'] = $admin_id;
                $_SESSION['admin_name'] = $admin_name;
                header("Location: admin.php");
                exit();
            } else {
                $error_message = "❌ Invalid password.";
            }
        } else {
            $error_message = "❌ Admin not found.";
        }
        
        $stmt->close();
    }
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Kwa Vonza Water Supply</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

<div class="card p-4 shadow" style="width: 350px;">
    <h2 class="text-center">Admin Login</h2>
    
    <?php if (isset($error_message)): ?>
        <p class="text-danger text-center"><?= $error_message ?></p>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>

</body>
</html>
