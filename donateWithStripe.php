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

$result = doQuery("SELECT donor_id FROM donors WHERE donor_email='$donorEmail'");
if ($row = $result->fetch_assoc()) {
    $donorId = $row['donor_id'];
} else {
    doQuery("INSERT INTO donors (donor_email, donor_first_name, donor_last_name) VALUES ('$donorEmail', '$donorFirstName', '$donorLastName')");
    $donorId = $link->insert_id;
}

$subscriptionId = "NULL";

if ($isSubscription) {
    $planName = "basic-monthly-$donorId-".time();
     try {
         $plan = \Stripe\Plan::create(array(
             "name" => "Basic Plan",
             "id" => $planName,
             "interval" => "month",
             "currency" => "usd",
             "amount" => $donationAmount,
         ));
             
         $customer = \Stripe\Customer::create(array(
             'email' => $donorEmail,
             'source'  => param('stripeToken'),
             'plan' => $plan
         ));
         $subscriptionId = "'$planName'";
        print "You successfully registered for monthly payments.  Thank you!";
    } catch (Exception $e) {
        print "Problem creating subscription: ".$e->getMessage();
    }
} else {
    print "Your donation was successful!  Thank you!";
}

doQuery("INSERT INTO donations (donation_donor_id, donation_amount, donation_project_id, donation_subscription_id) VALUES ($donorId, $donationAmount, $projectId, $subscriptionId)");
