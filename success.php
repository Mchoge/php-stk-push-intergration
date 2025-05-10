<?php
session_start();

// Check if the payment was successful
if (!isset($_SESSION['payment_success']) || !$_SESSION['payment_success']) {
    header("Location: checkout.php?error=" . urlencode("Payment failed or not initiated."));
    exit;
}

$phone = $_SESSION['payment_phone'] ?? 'N/A';
$amount = $_SESSION['payment_amount'] ?? 'N/A';
$transaction_id = $_SESSION['payment_reference'] ?? 'N/A';
$timestamp = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f8ff;
            text-align: center;
            padding: 50px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            display: inline-block;
        }
        h1 {
            color: #28a745;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            color: #333;
        }
        .details {
            margin-top: 20px;
            text-align: left;
        }
        .details strong {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>✅ Payment Successful!</h1>
        <p>Thank you for your payment.</p>

        <div class="details">
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($phone); ?></p>
            <p><strong>Amount Paid:</strong> KES <?php echo htmlspecialchars($amount); ?></p>
            <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($transaction_id); ?></p>
            <p><strong>Timestamp:</strong> <?php echo htmlspecialchars($timestamp); ?></p>
        </div>
    </div>
</body>
</html>

<?php
// Clear session data after showing the success page to prevent reuse
session_unset();
session_destroy();
?>
