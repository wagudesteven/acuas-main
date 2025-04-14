<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "db.php"; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = mysqli_real_escape_string($conn, $_POST["fullname"]);
    $rating = intval($_POST["rating"]); // Ensure it's an integer
    $review = mysqli_real_escape_string($conn, $_POST["review"]);

    $sql = "INSERT INTO reviews (fullname, rating, comments) VALUES ('$fullname', $rating, '$review')";

    if ($conn->query($sql) === TRUE) {
        echo "Review submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>

