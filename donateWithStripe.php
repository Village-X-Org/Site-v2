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
             "interval" => "day",
             "currency" => "usd",
             "amount" => $amount,
         ));
             
         $customer = \Stripe\Customer::create(array(
             'email' => $donorEmail,
             'source'  => param('stripeToken'),
             'plan' => $plan
         ));
         $subscriptionId = "'$planName'";
        sendMail($donorEmail, "Monthly Subscription for Village X", "Thank you for your generous contribution!  Stay tuned for updates to the projects your funds support.<P>The Village X Team</P>");
    } catch (Exception $e) {
        sendMail(getAdminEmail(), "Problem creating subscription", $e->getMessage(), getAdminEmail());
    }
} else {
    sendMail($donorEmail, "Donation to Village X", "Thank you for your generous contribution!  Stay tuned for updates to the projects your funds support.<P>The Village X Team</P>");
}

doQuery("INSERT INTO donations (donation_donor_id, donation_amount, donation_project_id, donation_subscription_id) VALUES ($donorId, $amount / 100, $projectId, $subscriptionId)");
if ($projectId) {
    doQuery("UPDATE projects SET project_funded=project_funded + ($amount / 100) WHERE project_id=$projectId");
} else {
    include("disburseSubscriptionPayment.php");
}

if ($isSubscription) {
    include("thanks_for_donating_monthly.php");
} else {
    include("thanks_for_donating_one_time.php");
}
