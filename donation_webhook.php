<?php
require_once("utilities.php");

// Retrieve the request's body and parse it as JSON
$input = @file_get_contents("php://input");
$event_json = json_decode($input);
if ($event_json->type == 'invoice.payment_succeeded') {
    $subscriptionId = $event_json->data->object->lines->data[0]->plan->id;
    $donationAmount = $event_json->data->object->total;
    $donorId = -1;
    $result = doQuery("SELECT donation_donor_id FROM donations WHERE donation_subscription_id='$subscriptionId' LIMIT 1");
    if ($row = $result->fetch_assoc()) {
        $donorId = $row['donation_donor_id'];
        doQuery("INSERT INTO donations (donation_donor_id, donation_amount, donation_subscription_id) VALUES ($donorId, ".($donationAmount / 100).", '$subscriptionId')");
        include("disburseSubscriptionPayment.php");
    }
}

doQuery("INSERT INTO webhook_events (we_content) VALUES ('".$link->escape_string($input)."')");

http_response_code(200);

?>

