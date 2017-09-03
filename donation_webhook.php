<?php
require_once("utilities.php");

// Retrieve the request's body and parse it as JSON
$input = @file_get_contents("php://input");
$event_json = json_decode($input);
if ($event_json->type == 'invoice.payment_succeeded') {
    $subscriptionId = $event_json->data->object->lines->data->plan->id;
    $amount = $event_json->data->object->total;
    $donorId = -1;
    $result = doQuery("SELECT donation_donor_id FROM donations WHERE donation_subscription_id='$subscriptionId' AND donation_date>DATE_SUB(NOW(), INTERVAL 1 DAY)");
    if ($row = $result->fetch_assoc()) {
        $donorId = $row['donor_id'];
    }
    if ($isPending) {
        doQuery("UPDATE donations SET donation_amount=$amount, donation_is_pending=0 WHERE donation_subscription_id='$subscriptionId'");   
    } else {
        doQuery("INSERT INTO donations (donation_donor_id, donation_amount, donation_subscription_id) VALUES ($donorId, $amount, '$subscriptionId')");
        include("disburseSubscriptionPayment.php");
    }
}

doQuery("INSERT INTO webhook_events (we_content) VALUES ('".$link->escape_string($input)."')");

//http_response_code(200); // PHP 5.4 or greater

?>

