<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/admin/db.php"; // Ensure correct path to db.php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Check if all required fields are set
    if (isset($_POST['fullname'], $_POST['email'], $_POST['password'])) {
        $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Check if email already exists
        $checkEmail = $conn->query("SELECT * FROM users WHERE email='$email'");

        if ($checkEmail->num_rows > 0) {
            echo "<script>alert('Email already exists!');</script>";
        } else {
            // Ensure your 'users' table has 'fullname', 'email', 'password', and 'role' columns
            $sql = "INSERT INTO users (fullname, email, password, role) VALUES ('$fullname', '$email', '$password', 'user')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Registration successful! Please login.');</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
        }
    } else {
        echo "<script>alert('All fields are required!');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    if (isset($_POST['email'], $_POST['password'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        $result = $conn->query("SELECT * FROM users WHERE email='$email'");
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] == 'admin') {
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: dashboard.php");
                }
                exit();
            } else {
                echo "<script>alert('Incorrect password');</script>";
            }
        } else {
            echo "<script>alert('User not found');</script>";
        }
    } else {
        echo "<script>alert('All fields are required!');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>KwaDrop - Login/Register</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Open Sans', sans-serif;
        }
        .bg-slideshow {
            position: fixed;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        .bg-slideshow img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            opacity: 0;
            transition: opacity 2s;
        }
        .bg-slideshow img.active {
            opacity: 1;
        }
        .form-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .form-container h2 {
            color: white;
            margin-bottom: 20px;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            border: none;
            background: #007bff;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .toggle-link {
            margin-top: 15px;
            display: block;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
            <!-- Navbar & Hero Start -->
            <div class="container-fluid position-relative p-0">
                <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                    <a href="" class="navbar-brand p-0">
                        <h1 class="text-primary"><i class="fas fa-tint text-primary me-3"></i>KwaDrop</h1>
                        <!-- <img src="img/logo.png" alt="Logo"> -->
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav ms-auto py-0">
                            <a href="index.php" class="nav-item nav-link">Home</a>
                            <a href="about.php" class="nav-item nav-link">About</a>
                            <a href="service.php" class="nav-item nav-link">Service</a>
                            <a href="contact.php" class="nav-item nav-link">Contact</a>
                            <a href="register.php" class="nav-item nav-link active ">Log In/Register</a>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </nav>
    <div class="bg-slideshow">
        <img src="img/carousel-1.jpg" class="active" alt="Background Image">
        <img src="img/carousel-2.jpg" alt="Background Image">
    </div>
    
    <div class="form-container" id="login-form">
    <h2>Login</h2>
    <form action="register.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn btn-primary w-100 py-3" name="login">Login</button>
        <p class="toggle-link" onclick="toggleForms()">Don't have an account? Register</p>
    </form>
</div>

    
    <div class="form-container" id="register-form" style="display: none;">
    <h2>Register</h2>
    <form action="register.php" method="POST">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button class="btn btn-primary w-100 py-3" type="submit" name="register">Register</button>
        <p class="toggle-link" onclick="toggleForms()">Already have an account? Login</p>
    </form>
</div>

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script>
        function toggleForms() {
            document.getElementById('login-form').style.display = 
                document.getElementById('login-form').style.display === 'none' ? 'block' : 'none';
            document.getElementById('register-form').style.display = 
                document.getElementById('register-form').style.display === 'none' ? 'block' : 'none';
        }
        
        let images = document.querySelectorAll('.bg-slideshow img');
        let current = 0;
        
        function slideshow() {
            images[current].classList.remove('active');
            current = (current + 1) % images.length;
            images[current].classList.add('active');
        }
        setInterval(slideshow, 5000);
    </script>
</body>
</html>
