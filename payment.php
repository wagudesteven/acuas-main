<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: register.php');
    exit();
}

// Include DB connection
require_once __DIR__ . "/admin/db.php";

$total_price = 0;
$user_id = $_SESSION['user_id'];

try {
    // Fetch the latest order's total_cost for the current user
    $stmt = $conn->prepare("SELECT total_cost FROM orders WHERE user_id = ? ORDER BY order_date DESC LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_price = floatval($row['total_cost']);
    }

    $stmt->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lipa na Mpesa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }
        .card {
            max-width: 450px;
            width: 100%;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .mpesa span {
            font-weight: bold;
            font-size: 20px;
        }
    </style>
</head>
<body oncontextmenu="return false">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card px-4 py-5">
            <div class="text-center mb-3">
                <div class="mpesa"><span>Mpesa Payment</span></div>
            </div>
            <div class="d-flex align-items-center mb-4">
                <img src="img/1200px-M-PESA_LOGO-01.svg.png" height="60" class="me-3" />
                <div>
                    <h6 class="mb-0">Enter Your Number to Pay</h6>
                </div>
            </div>
            <form action="./stk_initiate.php" method="POST">
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount (KES)</label>
                    <input type="text" class="form-control" id="amount" value="<?php echo htmlspecialchars(number_format($total_price, 2)); ?>" readonly>
                    <!-- Pass amount via hidden field -->
                    <input type="hidden" name="amount" value="<?php echo htmlspecialchars($total_price); ?>">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="phone" placeholder="e.g. 254712345678" pattern="^254\d{9}$" required>
                    <small class="form-text text-muted">Use format: 2547XXXXXXXX</small>
                </div>
                <div class="d-grid">
                <button type="submit" name="submit" class="btn btn-success" onclick="return confirmPayment()">Pay Now</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function confirmPayment() {
        alert("Waiting for your payment...");
        return true; // continue form submission
    }
</script>


    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
