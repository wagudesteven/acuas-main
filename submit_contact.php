<?php
$to = "test@localhost"; // Use the local email you just created
$subject = "Test Email from Mercury Mail";
$message = "Hello, this is a test email!";
$headers = "From: admin@localhost";

if (mail($to, $subject, $message, $headers)) {
    echo "<script>alert('Email sent successfully!'); window.location.replace('contact.php');</script>";
} else {
    echo "<script>alert('Failed to send email.'); window.location.replace('contact.php');</script>";
}
?>