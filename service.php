<?php
require_once __DIR__ . "/admin/db.php";
session_start();

$is_logged_in = isset($_SESSION['user_id']);
$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>KwaDrop - Water Supply Website</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Fonts and Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
            <a href="" class="navbar-brand p-0">
                <h1 class="text-primary"><i class="fas fa-tint text-primary me-3"> KwaDrop</i></h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="about.php" class="nav-item nav-link">About</a>
                    <a href="service.php" class="nav-item nav-link active">Service</a>
                    <a href="my_order.php" class="nav-item nav-link">My Order</a>
                    <a href="contact.php" class="nav-item nav-link">Contact</a>
                    <?php if ($is_logged_in): ?>
                        <a href="cart.php" class="nav-item nav-link" id="cart-link">
                            <i class="fas fa-shopping-cart"></i> Cart (<span id="cart-count"><?= $_SESSION['cart_count'] ?? 0 ?></span>)
                        </a>
                    <?php else: ?>
                        <a href="register.php" class="nav-item nav-link">Log In/Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </div>

    <!-- Breadcrumb -->
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4">Our Products</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0">
                <?php
                while ($product = $products->fetch_assoc()) :
                ?>
                    <li class="nav-item nav-link"><a href="#product<?= $product['id'] ?>"><?= htmlspecialchars($product['name']) ?></a></li>
                <?php endwhile; ?>
            </ol>
        </div>
    </div>

    <!-- Product Section -->
    <div class="container py-5">
        <div class="row g-5">
            <?php
            // Reset pointer to the beginning for fetching products again
            $products->data_seek(0);
            while ($product = $products->fetch_assoc()): ?>
                <div class="col-xl-6">
                    <div class="about-img rounded h-100">
                        <img src="admin/uploads/<?= htmlspecialchars($product['image']) ?>" class="product-image" alt="Product Image">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="about-item">
                        <h1 class="display-3 mb-3"><?= htmlspecialchars($product['name']) ?></h1>
                        <p class="mb-4"><?= htmlspecialchars($product['description']) ?></p>
                        <div class="bg-light rounded p-4 mb-4">
                            <form id="orderForm<?= $product['id'] ?>">
                                <label class="h5 d-block mb-3">Enter Quantity:</label>
                                <input type="number" id="quantity<?= $product['id'] ?>" class="form-control mb-3" placeholder="Enter quantity" min="1" required>

                                <label class="h5 d-block mb-3">Payment Method:</label>
                                <select id="paymentMethod<?= $product['id'] ?>" class="form-control mb-3" required>
                                    <option value="">Select Payment</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Mpesa">Mpesa</option>
                                </select>

                                <label class="h5 d-block mb-3">House Name:</label>
                                <input type="text" id="houseName<?= $product['id'] ?>" class="form-control mb-3" placeholder="House Name" required>

                                <div class="mt-3">
                                    <h5>Total Price: Ksh <span id="totalPrice<?= $product['id'] ?>">0</span></h5>
                                </div>

                                <button type="button" class="btn btn-primary rounded-pill py-3 px-5 mt-3" onclick="addToCart(<?= $product['id'] ?>, '<?= htmlspecialchars($product['name']) ?>', <?= $product['price'] ?>)">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

            <!-- Footer Start -->
            <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
            <div class="container py-5">
                <div class="row g-5 mb-5 align-items-center">
                </div>
                <div class="row g-5">
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <div class="footer-item">
                                <h3 class="text-white mb-4"><i class="fas fa-hand-holding-water text-primary me-3"></i>Acuas</h3>
                                <p class="mb-3">Kwa Vonza Water Supply has a mission to provide clean, fresh water to households and businesses in the region. Located in a Kwa Vonza.We offer doorstep delivery of fresh water, well water, and high-quality water refilling.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="text-white mb-4">Business Hours</h4>
                            <div class="d-flex align-items-center justify-content-center justify-content-lg-end">
                                <h6 class="text-muted mb-0">Mon - Friday:</h6>
                                <p class="text-white mb-0">09.00 am to 07.00 pm</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-center justify-content-lg-end">
                                <h6 class="text-muted mb-0">Saturday:</h6>
                                <p class="text-white mb-0">10.00 am to 05.00 pm</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-center justify-content-lg-end">
                                <h6 class="text-muted mb-0">Sunday:</h6>
                                <p class="text-white mb-0">Closed</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="text-white mb-4">Contact Info</h4>
                            <a href="mailto:wagudesteven01@gmail.com"><i class="fas fa-envelope me-2"></i>kwavonzasupplies@gmail.com</a>
                            <a href="tel:+923105157438"><i class="fas fa-phone me-2"></i> +254113879707</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="d-flex align-items-center justify-content-center justify-content-lg-end">
                            <a class="btn btn-secondary btn-md-square rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-secondary btn-md-square rounded-circle me-3" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-secondary btn-md-square rounded-circle me-3" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-secondary btn-md-square rounded-circle me-0" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
        

        <!-- Back to Top -->
      <a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


    <!-- JS -->
    <script>
        const isLoggedIn = <?= $is_logged_in ? 'true' : 'false' ?>;
        const cartCount = document.getElementById("cart-count");

        // Update price when quantity changes
        function updatePrice(productId, price) {
            const qty = parseInt(document.getElementById("quantity" + productId).value) || 0;
            document.getElementById("totalPrice" + productId).textContent = qty * price;
        }

        // Add to cart function
        function addToCart(productId, name, price) {
            if (!isLoggedIn) {
                alert("You must log in to add items to cart.");
                window.location.href = "register.php";
                return;
            }

            const quantity = parseInt(document.getElementById("quantity" + productId).value);
            if (!quantity || quantity <= 0) {
                alert("Please enter a valid quantity.");
                return;
            }

            const paymentMethod = document.getElementById("paymentMethod" + productId).value;
            const houseName = document.getElementById("houseName" + productId).value;

            if (!paymentMethod || !houseName) {
                alert("Please fill in both payment method and house name.");
                return;
            }

            const params = new URLSearchParams();
            params.append("product_id", productId);
            params.append("name", name);
            params.append("price", price);
            params.append("quantity", quantity);
            params.append("payment_method", paymentMethod);
            params.append("house_name", houseName);

            fetch("add_to_cart.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: params.toString()
            })
            .then(response => response.text())
            .then(count => {
                if (!isNaN(count)) {
                    cartCount.textContent = count;
                    alert("Item added to cart!");
                    // ✅ Reset form and price
                    document.getElementById("orderForm" + productId).reset();
                    document.getElementById("totalPrice" + productId).textContent = "0";
                } else {
                    alert("Error adding to cart: " + count);
                }
            })
            .catch(err => {
                alert("Error: " + err);
            });
        }

        // Attach price update listener for each product
        <?php
        $products->data_seek(0);
        while ($product = $products->fetch_assoc()) {
            echo "document.getElementById('quantity{$product['id']}').addEventListener('input', function() { updatePrice({$product['id']}, {$product['price']}); });\n";
        }
        ?>
    </script>

    <!-- External Scripts -->
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
