<?php
header("Content-Type: application/json");

$response = [
    "ResultCode" => 0,
    "ResultDesc" => "Confirmation Received Successfully"
];

// DATA
$mpesaResponse = file_get_contents('php://input');

// Log the response to a file
$logFile = "M_PESAConfirmationResponse.txt";

// Write to file
$log = fopen($logFile, "a");
fwrite($log, $mpesaResponse . "\n");
fclose($log);

// Respond with the success message
echo json_encode($response);
?>
