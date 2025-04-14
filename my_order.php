<?php
require_once __DIR__ . "/admin/db.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$orders_query = $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>My Orders - KwaDrop</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<!-- Navbar -->
<div class="container-fluid position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="#" class="navbar-brand p-0">
            <h1 class="text-primary"><i class="fas fa-tint text-primary me-3"></i>KwaDrop</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="about.php" class="nav-item nav-link">About</a>
                <a href="service.php" class="nav-item nav-link">Service</a>
                <a href="my_order.php" class="nav-item nav-link active">My Order</a>
                <a href="contact.php" class="nav-item nav-link">Contact</a>
                <a href="cart.php" class="nav-item nav-link">
                    <i class="fas fa-shopping-cart"></i> Cart (<span id="cart-count"><?= $_SESSION['cart_count'] ?? 0 ?></span>)
                </a>
            </div>
        </div>
    </nav>
</div>

<!-- Breadcrumb -->
<div class="container-fluid bg-breadcrumb">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h4 class="text-white display-4 mb-4">My Orders</h4>
        <p class="text-white">Track your past purchases and their status.</p>
    </div>
</div>

<!-- Order Section -->
<div class="container py-5">
    <?php if ($orders_query->num_rows > 0): ?>
        <?php while ($order = $orders_query->fetch_assoc()): ?>
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Order #<?= $order['order_id'] ?></strong>
                        </div>
                        <div>
                            <span class="badge bg-light text-dark me-2"><?= ucfirst($order['order_status']) ?></span>
                            <?php if ($order['order_status'] == 'pending'): ?>
                                <form method="post" action="update_status.php" class="d-inline">
                                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                    <input type="hidden" name="action" value="cancel">
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel</button>
                                </form>
                                <form method="post" action="update_status.php" class="d-inline">
                                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                    <input type="hidden" name="action" value="delivered">
                                    <button class="btn btn-sm btn-success">Mark as Delivered</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p><strong>Payment Method:</strong> <?= $order['payment_method'] ?></p>
                    <p><strong>House Name:</strong> <?= htmlspecialchars($order['house_name']) ?></p>
                    <p><strong>Date:</strong> <?= date('d M Y, h:i A', strtotime($order['order_date'])) ?></p>

                    <!-- Fetch products for this order -->
                    <?php
                    $order_id = $order['order_id'];
                    $items_query = $conn->query("SELECT od.*, p.name FROM order_details od JOIN products p ON od.product_id = p.id WHERE od.order_id = $order_id");
                    ?>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($item = $items_query->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td>Ksh <?= number_format($item['price'], 2) ?></td>
                                <td>Ksh <?= number_format($item['quantity'] * $item['price'], 2) ?></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                    <h5 class="text-end">Total: <strong>Ksh <?= number_format($order['total_cost'], 2) ?></strong></h5>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info text-center">You have no orders yet.</div>
    <?php endif; ?>
</div>

<!-- Footer -->
<div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item">
                    <h3 class="text-white mb-4"><i class="fas fa-tint text-primary me-3"></i>KwaDrop</h3>
                    <p class="mb-3">Kwa Vonza Water Supply provides clean water to homes and businesses. We deliver fresh and high-quality refilled water directly to your doorstep.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <h4 class="text-white mb-4">Business Hours</h4>
                <p class="text-white">Mon - Fri: 09:00 AM to 07:00 PM</p>
                <p class="text-white">Saturday: 10:00 AM to 05:00 PM</p>
                <p class="text-white">Sunday: Closed</p>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <h4 class="text-white mb-4">Contact Info</h4>
                <p><i class="fas fa-envelope me-2"></i> kwavonzasupplies@gmail.com</p>
                <p><i class="fas fa-phone me-2"></i> +254113879707</p>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="d-flex">
                    <a class="btn btn-secondary btn-md-square rounded-circle me-2" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-secondary btn-md-square rounded-circle me-2" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-secondary btn-md-square rounded-circle me-2" href="#"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-secondary btn-md-square rounded-circle" href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/counterup/counterup.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
