<?php
session_start();

if (isset($_POST['submit'])) {
    date_default_timezone_set('Africa/Nairobi');

    // Access credentials
    $consumerKey = 'vaNbtqxCtoA6p1Z7fp4gHfxvHSLygCmOHJvG9b5qWcpTPMYS';
    $consumerSecret = '3ovAWVWWh4qWNDE3NvYLg2Ca1VownzpHa6sWEAKdZwd7lnNur7afqjmLA0gWQtJb';

    // Transaction details
    $BusinessShortCode = '174379';
    $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';

    $PartyA = trim($_POST['phone'] ?? '');
    $Amount = trim($_POST['amount'] ?? '');
    $AccountReference = '2255';
    $TransactionDesc = 'Test Payment';

    // Normalize phone number
    if (substr($PartyA, 0, 1) == '0') {
        if (substr($PartyA, 0, 3) == '011') {
            $PartyA = '254' . substr($PartyA, 3);
        } else {
            $PartyA = '254' . substr($PartyA, 1);
        }
    }

    // Validate phone number format
    if (!preg_match('/^2547\d{8}$/', $PartyA)) {
        header("Location: checkout.php?error=" . urlencode("Invalid phone number format. Use 2547XXXXXXXX"));
        exit;
    }

    $Timestamp = date('YmdHis');
    $Password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

    // Access token request
    $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $headers = ['Content-Type:application/json; charset=utf8'];

    $curl = curl_init($access_token_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
    $result = curl_exec($curl);
    curl_close($curl);

    $result = json_decode($result);
    if (!isset($result->access_token)) {
        header("Location: checkout.php?error=" . urlencode("Failed to get access token."));
        exit;
    }

    $access_token = $result->access_token;

    // STK Push request
    $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $stkheader = [
        'Content-Type:application/json',
        'Authorization:Bearer ' . $access_token
    ];

    $curl_post_data = [
        'BusinessShortCode' => $BusinessShortCode,
        'Password' => $Password,
        'Timestamp' => $Timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $Amount,
        'PartyA' => $PartyA,
        'PartyB' => $BusinessShortCode,
        'PhoneNumber' => $PartyA,
        'CallBackURL' => 'https://yourdomain.com/callback_url.php', // TODO: Replace with your callback handler
        'AccountReference' => $AccountReference,
        'TransactionDesc' => $TransactionDesc
    ];

    $data_string = json_encode($curl_post_data);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $initiate_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $curl_response = curl_exec($curl);
    curl_close($curl);

    $response = json_decode($curl_response, true);

    if (isset($response["ResponseCode"]) && $response["ResponseCode"] == "0") {
        $_SESSION['payment_success'] = true;
        $_SESSION['payment_amount'] = $Amount;
        $_SESSION['payment_phone'] = $PartyA;
        $_SESSION['payment_reference'] = $response["MerchantRequestID"];

        header("Location: success.php");
    } else {
        $error = $response["errorMessage"] ?? $response["ResponseDescription"] ?? "Unknown error";
        header("Location: checkout.php?error=" . urlencode($error));
    }
}
?>
