<?php
require_once("utilities.php");
require_once('lib/stripe/init.php');

// Be sure to replace this with your actual test API key
// (switch to the live key later)
\Stripe\Stripe::setApiKey("sk_test_DGoi26vx76FlFn7sen3IDSC8");

$donorEmail = param('stripeEmail');
$donorFirstName = param('firstName');
$donorLastName = param('lastName');
$donationAmount = param('stripeAmount');
$projectId = param('projectId');
$isSubscription = param('isSubscription');

if ($isSubscription) {
    $plan = \Stripe\Plan::create(array(
        "name" => "Basic Plan",
        "id" => "basic-monthly",
        "interval" => "month",
        "currency" => "usd",
        "amount" => paramInt('stripeAmount'),
    ));
    
    try {
        $customer = \Stripe\Customer::create(array(
            'email' => $donorEmail,
            'source'  => param('stripeToken'),
            'plan' => 'basic-monthly'
        ));
        print "You successfully registered for monthly payments.  Thank you!";
        exit;
    } catch(Exception $e) {
        print "Registration failed.  Please contact us and let us know this happened.";
    }
}
$result = doQuery("SELECT donor_id FROM donors WHERE donor_email='$donorEmail'");
if ($row = $result->fetch_assoc()) {
    $donorId = $row['donor_id'];
} else {
    doQuery("INSERT INTO donors (donor_email, donor_first_name, donor_last_name) VALUES ('$donorEmail', '$donorFirstName', '$donorLastName')");
    $donorId = $link->insert_id;
}
doQuery("INSERT INTO donations (donation_donor_id, donation_amount, donation_project_id, donation_is_subscription) VALUES ($donorId, $donationAmount, $projectId, $isSubscription)");
