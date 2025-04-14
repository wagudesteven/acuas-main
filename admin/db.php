<?php
$host = "localhost";
$user = "root"; // Default for XAMPP
$pass = ""; // Leave empty for XAMPP
$dbname = "kwa_vonza";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

