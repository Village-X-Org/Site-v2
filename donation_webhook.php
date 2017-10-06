<?php
require_once("utilities.php");

// Retrieve the request's body and parse it as JSON
$input = @file_get_contents("php://input");
$event_json = json_decode($input);
if ($event_json->type == 'invoice.payment_succeeded') {
    $subscriptionId = $event_json->data->object->subscription;
    $donationAmountDollars = $event_json->data->object->total / 100;
    
    \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
    $charge = \Stripe\Charge::create(array(
        "amount" => $event_json->data->object->total,
        "currency" => "usd",
        "description" => "Subscription Charge",
        "source" => $token,
    ));
    
    $donorId = -1;
    $stmt = prepare("SELECT donation_id, donation_donor_id, donation_code FROM donations WHERE donation_subscription_id=? LIMIT 1");
    $stmt->bind_param('s', $subscriptionId);
    $result = execute($stmt);
    if ($row = $result->fetch_assoc()) {
        $donationId = $row['donation_id'];
        $donorId = $row['donation_donor_id'];
        $donationCode = $row['donation_code'];
        $stmt = prepare("INSERT INTO donations (donation_donor_id, donation_amount, donation_subscription_id, donation_code) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('idss', $donorId, $donationAmountDollars, $subscriptionId, $donationCode);
        execute($stmt);
        $stmt->close();
        include("disburseSubscriptionPayment.php");
    }
}

$stmt = prepare("INSERT INTO webhook_events (we_content) VALUES (?)");
$stmt->bind_param('s', $input);
execute($stmt);
$stmt->close();

http_response_code(200);

?>

