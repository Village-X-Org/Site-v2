<?php
require_once("utilities.php");

// Retrieve the request's body and parse it as JSON
$input = @file_get_contents("php://input");
$event_json = json_decode($input);
if ($event_json->type == 'invoice.payment_succeeded') {
    $subscriptionId = $event_json->data->object->lines->data[0]->plan->id;
    $donationAmountDollars = $event_json->data->object->total / 100;
    $donorId = -1;
    $stmt = prepare("SELECT donation_donor_id FROM donations WHERE donation_subscription_id=? LIMIT 1");
    $stmt->bind_param('s', $subscriptionId);
    $result = execute($stmt);
    if ($row = $result->fetch_assoc()) {
        $donorId = $row['donation_donor_id'];
        $stmt = prepare("INSERT INTO donations (donation_donor_id, donation_amount, donation_subscription_id) VALUES (?, ?, ?)");
        $stmt->bind_param('ids', $donorId, $donationAmountDollars, $subscriptionId);
        execute($stmt);
        include("disburseSubscriptionPayment.php");
    		$stmt->close();
    }
}

$stmt = prepare("INSERT INTO webhook_events (we_content) VALUES (?)");
$stmt->bind_param($input);
execute($stmt);
$stmt->close();

http_response_code(200);

?>

