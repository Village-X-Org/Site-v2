<?php
require_once("utilities.php");
require_once('lib/stripe/init.php');

// Be sure to replace this with your actual test API key
// (switch to the live key later)
\Stripe\Stripe::setApiKey("sk_test_DGoi26vx76FlFn7sen3IDSC8");

$donorEmail = param('stripeEmail');
$donorFirstName = param('firstName');
$donorLastName = param('lastName');
$amount = param('stripeAmount');
$projectId = param('projectId');
$isSubscription = param('isSubscription');
$token = param('stripeToken');

$result = doQuery("SELECT donor_id FROM donors WHERE donor_email='$donorEmail'");
if ($row = $result->fetch_assoc()) {
    $donorId = $row['donor_id'];
    $result = doQuery("SELECT count(donation_id) AS donationCount FROM donations WHERE donation_donor_id=$donorId AND donation_remote_id<>'$token'");
    if ($row = $result->fetch_assoc()) {
        $donationCount = $row['donationCount'] + 1;
    }
} else {
    doQuery("INSERT INTO donors (donor_email, donor_first_name, donor_last_name) VALUES ('$donorEmail', '$donorFirstName', '$donorLastName')");
    $donorId = $link->insert_id;
    $donationCount = 1;
}

$subscriptionId = "NULL";

if ($isSubscription) {
    $planName = "basic-monthly-$donorId-".time();
     try {
         $plan = \Stripe\Plan::create(array(
             "name" => "Basic Plan",
             "id" => $planName,
             "interval" => "day",
             "currency" => "usd",
             "amount" => $amount,
         ));
             
         $customer = \Stripe\Customer::create(array(
             'email' => $donorEmail,
             'source'  => param('stripeToken'),
             'plan' => $plan
         ));
         $subscriptionId = "'".$customer->subscriptions->data[0]->id."'";
         
    } catch (Exception $e) {
        sendMail(getAdminEmail(), "Problem creating subscription", $e->getMessage(), getAdminEmail());
    }
}

$donationAmountDollars = $amount / 100;

$result = doQuery("SELECT donation_id FROM donations WHERE donation_remote_id='$token'");
if ($row = $result->fetch_assoc()) {
    $donationId = $row['donation_id'];
} else {
    doQuery("INSERT INTO donations (donation_donor_id, donation_amount, donation_project_id, donation_subscription_id, donation_remote_id) VALUES ($donorId, ".($isSubscription ? 0 : $donationAmountDollars).", $projectId, $subscriptionId, '$token')");
    $donationId = $link->insert_id;
    if ($projectId) {
        doQuery("UPDATE projects SET project_funded=project_funded + $donationAmountDollars WHERE project_id=$projectId");
        invalidateCaches($projectId);
    }
}

$type = EMAIL_TYPE_THANKS_FOR_DONATING;
ob_start();
include("email_content.php");
$output = ob_get_clean();
sendMail($donorEmail, $isSubscription ? "Monthly Subscription for Village X": "Donation to Village X", 
    $output, getAdminEmail());

if ($isSubscription) {
    include("thanks_for_donating_monthly.php");
} else {
    include("thanks_for_donating_one_time.php");
}
