
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/admin/db.php";
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>KwaDrop - Water Supply Website</title>
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
                    <h1 class="text-primary"><i class="fas fa-tint text-primary me-3"></i>Kwadrop</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="index.php" class="nav-item nav-link">Home</a>
                        <a href="about.php" class="nav-item nav-link">About</a>
                        <a href="service.php" class="nav-item nav-link ">Service</a>
                        <a href="contact.php" class="nav-item nav-link active">Contact</a>
                        <a href="register.php" class="nav-item nav-link">Log In/Register</a>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </nav>

            <!-- Header Start -->
            <div class="container-fluid bg-breadcrumb">
                <div class="container text-center py-5" style="max-width: 900px;">
                    <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Contact Us</h4>
                    <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                        <li class="nav-item nav-link"><a href="#Contact">Contact US</a></li>
                        <li class="nav-item nav-link" ><a href="#Reviews">Customer Review</a></li>
                    </ol>    
                </div>
            </div>
            <!-- Header End -->
        </div>
        <!-- Navbar & Hero End -->

<!-- Contact Start -->
<div class="container-fluid contact bg-light py-5">
    <div class="container py-5" id="Contact">
        <div class="row justify-content-center">
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.2s">
                <div class="text-center pb-4">
                    <h4 class="text-uppercase text-primary">Let’s Connect</h4>
                    <h1 class="display-4 text-capitalize mb-3">Get in Touch</h1>
                    <p class="mb-0">Have any questions or need assistance? Fill out the form below, and we’ll get back to you as soon as possible.</p>
                </div>
                <form action="submit_contact.php" method="POST">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control border-0" id="name" name="name" placeholder="Your Name" required autocomplete="name">
                <label for="name">Your Name</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating">
                <input type="email" class="form-control border-0" id="email" name="email" placeholder="Your Email" required autocomplete="email">
                <label for="email">Your Email</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating">
                <input type="tel" class="form-control border-0" id="phone" name="phone" placeholder="Phone" autocomplete="tel">
                <label for="phone">Your Phone</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control border-0" id="subject" name="subject" placeholder="Subject">
                <label for="subject">Subject</label>
            </div>
        </div>
        <div class="col-12">
            <div class="form-floating">
                <textarea class="form-control border-0" placeholder="Leave a message here" id="message" name="message" style="height: 150px" required></textarea>
                <label for="message">Your Message</label>
            </div>
        </div>
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary rounded-pill py-3 px-5 w-50">Send Message</button>
        </div>
    </div>
</form>

            </div>
        </div>
    </div>
</div>
<!-- Contact End -->



<!-- Customer Reviews Section start-->
<div class="container-fluid contact bg-light py-5">
    <div class="container py-5" id="Reviews">
        <div class="row justify-content-center">
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.2s">
                <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                    <h4 class="text-uppercase text-primary">What Our Customers Say</h4>
                    <h1 class="display-3 text-capitalize mb-3">Customer Reviews</h1>
                </div>
                <form>
                    <div class="row g-4">
                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <input type="text" class="form-control border-0" id="reviewerName" placeholder="Your Name">
                                <label for="reviewerName">Your Name</label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <select id="rating" class="form-select border-0">
                                    <option value="">Rate us</option>
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="5">5 Stars</option>
                                </select>
                                <label for="rating">Your Rating</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control border-0" placeholder="Write your review here..." id="reviewText" style="height: 120px"></textarea>
                                <label for="reviewText">Your Review</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-primary w-100 py-3" onclick="submitReview()">Submit Review</button>
                        </div>
                    </div>
                </form>
                <div id="reviewsList" class="mt-5"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function submitReview() {
    const name = document.getElementById("reviewerName").value;
    const text = document.getElementById("reviewText").value;
    const rating = document.getElementById("rating").value;

    if (name && text && rating) {
        const formData = new FormData();
        formData.append("fullname", name);
        formData.append("rating", rating);
        formData.append("review", text);

        fetch("http://localhost/acuas-main/admin/submit_review.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload(); // Refresh to show the new review
        })
        .catch(error => console.error("Error:", error));
    } else {
        alert("Please fill all fields.");
    }
}


</script>
<!-- Customer Reviews Section End -->


        <!-- Footer Start -->
        <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
            <div class="container py-5">
                <div class="row g-5 mb-5 align-items-center">
                </div>
                <div class="row g-5">
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <div class="footer-item">
                                <h3 class="text-white mb-4"><i class="fas fa-tint text-primary me-3"></i>KwaDrop</h3>
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