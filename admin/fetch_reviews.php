<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "db.php"; // Include your database connection

$sql = "SELECT fullname, rating, comments FROM reviews ORDER BY created_at DESC";
$result = $conn->query($sql);

$reviews = array(); // Initialize an empty array

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row; // Add each row to the array
    }
}

$conn->close();

header('Content-Type: application/json'); // Set the correct header
echo json_encode(array("reviews" => $reviews)); // Return the reviews as JSON
?>

