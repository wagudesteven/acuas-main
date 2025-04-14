<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Kwa Vonza Water Supply</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <?php 
    include __DIR__ . '/inc/navbar.php';
    include __DIR__ . '/inc/sidebar.php';
    include "db.php";
    ?>

    <div class="container-fluid">
        <div class="row">
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h1 class="mt-4 mb-4">Admin Dashboard</h1>

                <div class="row g-4">
                    <!-- Total Sales -->
                    <div class="col-md-3">
                        <div class="card text-white bg-success shadow">
                            <div class="card-body">
                                <h5 class="card-title">Total Sales</h5>
                                <p class="card-text fs-4">
                                    KES 
                                    <?php
                                    $salesQuery = $conn->query("SELECT SUM(total_cost) AS total_sales FROM orders");
                                    $salesRow = $salesQuery->fetch_assoc();
                                    echo number_format($salesRow['total_sales'] ?? 0, 2);
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Users -->
                    <div class="col-md-3">
                        <div class="card text-white bg-primary shadow">
                            <div class="card-body">
                                <h5 class="card-title">Users</h5>
                                <p class="card-text fs-4">
                                    <?php
                                    $usersQuery = $conn->query("SELECT COUNT(*) AS total_users FROM users");
                                    $usersRow = $usersQuery->fetch_assoc();
                                    echo $usersRow['total_users'] ?? 0;
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Reviews -->
                    <div class="col-md-3">
                        <div class="card text-white bg-warning shadow">
                            <div class="card-body">
                                <h5 class="card-title">Reviews</h5>
                                <p class="card-text fs-4">
                                    <?php
                                    $reviewsQuery = $conn->query("SELECT COUNT(*) AS total_reviews FROM reviews");
                                    $reviewsRow = $reviewsQuery->fetch_assoc();
                                    echo $reviewsRow['total_reviews'] ?? 0;
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Orders -->
                    <div class="col-md-3">
                        <div class="card text-white bg-danger shadow">
                            <div class="card-body">
                                <h5 class="card-title">Orders</h5>
                                <p class="card-text fs-4">
                                    <?php
                                    $ordersQuery = $conn->query("SELECT COUNT(*) AS total_orders FROM orders");
                                    $ordersRow = $ordersQuery->fetch_assoc();
                                    echo $ordersRow['total_orders'] ?? 0;
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Products -->
                    <div class="col-md-3">
                        <div class="card text-white bg-info shadow">
                            <div class="card-body">
                                <h5 class="card-title">Products</h5>
                                <p class="card-text fs-4">
                                    <?php
                                    $productsQuery = $conn->query("SELECT COUNT(*) AS total_products FROM products");
                                    $productsRow = $productsQuery->fetch_assoc();
                                    echo $productsRow['total_products'] ?? 0;
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- You can add additional dashboard content below -->
            </main>
        </div>
    </div>

    <script src="admin.js"></script>
</body>
</html>
