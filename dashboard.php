<?php

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header('Location: register.php');
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Kv Water Supplies</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wdth,wght@0,75..100,300..800;1,75..100,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar & Hero Start -->
        <div class="container-fluid position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <h1 class="text-primary"><i class="fas fa-hand-holding-water me-3"></i>KwaDrop</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <a href="about.php" class="nav-item nav-link">About</a>
                        <a href="service.php" class="nav-item nav-link">Service</a>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                        <a href="cart.php" class="nav-item nav-link">Cart</a>
                        <a href="logout.php" class="nav-item nav-link ">Log Out</a>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </nav>

            <!-- Water Supply Showcase Start -->
            <div class="carousel-header">
                <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active"></li>
                        <li data-bs-target="#carouselId" data-bs-slide-to="1"></li>
                        <li data-bs-target="#carouselId" data-bs-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                    <!--Item_1 start-->
                        <div class="carousel-item active">
                            <img src="img/carousel-1.jpg" class="img-fluid w-100" alt="Image">
                            <div class="carousel-caption">
                                <h4 class="text-white text-uppercase fw-bold mb-4">Stay Hydrated!! Stay Healthy!!</h4>
                                <h2 class="display-2 text-capitalize text-white mb-4">Dependable Water Supply for Every Home in Kwa Vonza</h2>
                                <p class="mb-5 fs-5 text-white">Clean & Affordable Water Delivered to You Anytime, Anywhere By Acuas!!</p>
                                <a class="btn btn-primary rounded-pill flex-shrink-0 py-3 px-5 me-2" href="service.php">Order Now</a>
                            </div>
                        </div>
                    <!--Item_1 end-->

                    <!--Item_2 start-->
                        <div class="carousel-item">
                            <img src="img/carousel-2.jpg" class="img-fluid w-100" alt="Image">
                            <div class="carousel-caption">
                                <h4 class="text-white text-uppercase fw-bold mb-4">Stay Hydrated!! Stay Healthy!!</h4>
                                <h2 class="display-2 text-capitalize text-white mb-4">Dependable Water Supply for Every Home in Kwa Vonza</h2>
                                <p class="mb-5 fs-5 text-white">Clean & Affordable Water Delivered to You Anytime, Anywhere By Acuas!!</p>
                                <a class="btn btn-primary rounded-pill flex-shrink-0 py-3 px-5 me-2" href="service.php">Order Now</a>
                            </div>
                        </div>
                    <!--Item_2 End-->

                    <!--Item_3 start-->
                        <div class="carousel-item">
                            <img src="img/carousel-2.jpg" class="img-fluid w-100" alt="Image">
                            <div class="carousel-caption">
                                <h4 class="text-white text-uppercase fw-bold mb-4">Stay Hydrated!! Stay Healthy!!</h4>
                                <h2 class="display-2 text-capitalize text-white mb-4">Dependable Water Supply for Every Home in Kwa Vonza</h2>
                                <p class="mb-5 fs-5 text-white">Clean & Affordable Water Delivered to You Anytime, Anywhere By Acuas!!</p>
                                <a class="btn btn-primary rounded-pill flex-shrink-0 py-3 px-5 me-2" href="service.php">Order Now</a>
                            </div>
                        </div>
                    </div>
                    <!--Item_3 End-->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <!-- Water Supply Showcase End -->

            <!-- Add Bootstrap JS if not already included -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

            <!-- Force Carousel Start -->
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var myCarousel = new bootstrap.Carousel(document.getElementById('carouselId'), {
                        interval: 3000,
                        ride: 'carousel'
                    });
                });
            </script>

        </div>
        <!-- Navbar & Hero End -->

        <!-- About Start -->
        <div class="container-fluid about overflow-hidden py-5">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="about-img rounded h-100">
                            <img src="img/about.jpg" class="img-fluid rounded h-100 w-100" style="object-fit: cover;" alt="">
                            <div class="about-exp"><span>Free Delivery</span></div>
                        </div>
                    </div>
                    <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="about-item">
                            <h1 class="text-primary text-uppercase">About Us</h1>
                            <p class="mb-4">Kwa Vonza Water Supply was established 2 years ago with a mission to provide clean, fresh water to households and businesses in the region. Located in a semi-arid area, we understand the importance of reliable water access. That’s why we offer doorstep delivery of fresh water, well water, and high-quality water refillings to keep you hydrated and healthy.
                            </p>
                            <div class="bg-light rounded p-4 mb-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="bg-light rounded p-4 mb-4">
                                            <h6 class="display-3 mb-3">why choose us?</h6>
                                            <ul class="list-unstyled">
                                                <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i><strong>Fast & Reliable Delivery:</strong> We bring water directly to your home or business.</li>
                                                <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i><strong>Fresh & Safe Water:</strong> Our water meets high-quality standards.</li>
                                                <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i><strong>Affordable Water Refilling:</strong> Get convenient access to clean drinking water.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="about.php" class="btn btn-secondary rounded-pill py-3 px-5">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->




        <!-- Services Start -->
        <?php
// Include database connection
require_once __DIR__ . "/admin/db.php";

// Ensure database connection is successful
if (!$conn) {
    die("Database connection failed: " . $conn->connect_error);
}

// Fetch products
$products = $conn->query("SELECT * FROM products ORDER BY id DESC");

// Check if query executed successfully
if (!$products) {
    die("Error fetching products: " . $conn->error);
}
?>

<!-- Services Start -->
<div class="container-fluid product py-5">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h1 class="text-uppercase text-primary">Our Services</h1>
            <h4 class="display-3 text-capitalize mb-3">We Deliver Best Quality Water Supply Services.</h4>
        </div>
        <div class="row g-4 justify-content-center">
            <?php if ($products->num_rows > 0): ?>
                <?php while ($product = $products->fetch_assoc()): ?>
                    <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="product-item">
                            <img src="admin/uploads/<?= htmlspecialchars($product['image']) ?>" class="img-fluid w-100 rounded-top" alt="Product Image">
                            <div class="product-content bg-light text-center rounded-bottom p-4">
                                <h4 class="text-primary"><?= htmlspecialchars($product['name']) ?></h4>
                                <p><?= htmlspecialchars($product['description']) ?></p>
                                <p class="fs-4 text-primary mb-3">Ksh <?= number_format($product['price'], 2) ?></p>
                                <a href="service.php#<?= htmlspecialchars(str_replace(' ', '_', $product['name'])) ?>" class="btn btn-secondary rounded-pill py-2 px-4">Order Now</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No products found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Services End -->

        <!-- Services End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

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
                                <h6 class="text-muted mb-0">submit_contact</h6>
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
        

        
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    </body>

</html>