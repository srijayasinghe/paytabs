<?php
//  Capture PayTabs Response
$response = $_GET;

// Log Response for Debugging
file_put_contents("paytabs_payment.log", json_encode($response), FILE_APPEND);

// Check Transaction Status
if (isset($response['respStatus']) && $response['respStatus'] == "A") {
    echo "<h1>Payment Successful!</h1>";
    echo "<p>Transaction Reference: " . $response['tranRef'] . "</p>";
} else {
    echo "<h1>Payment Failed</h1>";
    echo "<p>Reason: " . $response['respMessage'] . "</p>";
}
?>