<?php
session_start();
require_once 'admin/db.php';

// Optional: Fetch user-specific payment details here if needed

?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
    <script>
        alert("Payment has been received. Your order is on the way.");
    </script>
</head>
<body>
    <h2>Thank you for your payment!</h2>
    <p>Your order has been confirmed and is on the way.</p>
</body>
</html>

