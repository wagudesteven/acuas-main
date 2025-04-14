<?php
require_once 'admin/db.php';

// Receive the callback data
$mpesaResponse = file_get_contents('php://input');
$response = json_decode($mpesaResponse, true);

// Log the response (optional for debugging)
file_put_contents("mpesa_log.txt", $mpesaResponse . "\n", FILE_APPEND);

if (isset($response['Body']['stkCallback']['ResultCode']) && $response['Body']['stkCallback']['ResultCode'] == 0) {
    $callbackMetadata = $response['Body']['stkCallback']['CallbackMetadata']['Item'];

    $amount = 0;
    $transaction_id = '';
    $phone_number = '';

    foreach ($callbackMetadata as $item) {
        if ($item['Name'] == 'Amount') $amount = $item['Value'];
        if ($item['Name'] == 'MpesaReceiptNumber') $transaction_id = $item['Value'];
        if ($item['Name'] == 'PhoneNumber') $phone_number = $item['Value'];
    }

    // You should get this from session or track with order ID
    $user_id = 1; // Replace with actual user logic
    $payment_status = 'completed';
    $payment_method = 'Mpesa';
    $payment_date = date('Y-m-d H:i:s');

    // Save to the payments table
    $stmt = $conn->prepare("INSERT INTO payments (user_id, phone_number, payment_status, transaction_id, total_amount, payment_method, payment_date)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssdss", $user_id, $phone_number, $payment_status, $transaction_id, $amount, $payment_method, $payment_date);
    $stmt->execute();
    $stmt->close();

    // Response to Safaricom (M-Pesa)
    echo json_encode(['ResultCode' => 0, 'ResultDesc' => 'Confirmation Received Successfully']);

    // Optional: redirect to success page or trigger user notification
    file_put_contents("payment_done_flag.txt", "success");

} else {
    echo json_encode(['ResultCode' => 1, 'ResultDesc' => 'Payment Failed']);
}
?>
