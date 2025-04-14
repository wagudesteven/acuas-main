<?php
if (isset($_POST['submit'])) {
    date_default_timezone_set('Africa/Nairobi');

    // Access token credentials
    $consumerKey = 'nk16Y74eSbTaGQgc9WF8j6FigApqOMWr';
    $consumerSecret = '40fD1vRXCq90XFaU';

    // M-Pesa credentials
    $BusinessShortCode = '174379';
    $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
    
    // Payment details from POST
    $PartyA = $_POST['phone']; // Customer phone number
    $AccountReference = '2255'; // Reference for the transaction
    $TransactionDesc = 'Test Payment'; // Description of the transaction
    $Amount = $_POST['amount']; // Payment amount

    // Get the timestamp
    $Timestamp = date('YmdHis');

    // Password (base64 encoded string)
    $Password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

    // Access token URL
    $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    // Initiate transaction URL
    $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

    // Callback URL (ensure it's secure and points to your callback handler)
    $CallBackURL = 'https://yourdomain.com/callback_url.php';

    // Get access token
    $curl = curl_init($access_token_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json; charset=utf8']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
    $result = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if (curl_errno($curl)) {
        echo 'cURL Error: ' . curl_error($curl);
        exit();
    }

    $result = json_decode($result);
    $access_token = $result->access_token;
    curl_close($curl);

    // STK Push request headers
    $stkheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];

    // Data for the STK Push request
    $curl_post_data = array(
        'BusinessShortCode' => $BusinessShortCode,
        'Password' => $Password,
        'Timestamp' => $Timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $Amount,
        'PartyA' => $PartyA,
        'PartyB' => $BusinessShortCode,
        'PhoneNumber' => $PartyA,
        'CallBackURL' => $CallBackURL,
        'AccountReference' => $AccountReference,
        'TransactionDesc' => $TransactionDesc
    );

    // Send the STK Push request
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $initiate_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($curl_post_data));
    $curl_response = curl_exec($curl);
    
    // Handle cURL errors
    if (curl_errno($curl)) {
        echo 'cURL Error: ' . curl_error($curl);
        exit();
    }

    curl_close($curl);

    // Process M-Pesa response (for debugging purposes)
    echo $curl_response;

    // You can log this response or handle it based on the response data.
    // If you want to process this further and update the database, you can do that here.
}
?>

