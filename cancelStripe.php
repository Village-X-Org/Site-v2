<?php
require_once("utilities.php");
require_once('lib/stripe/init.php');

// Be sure to replace this with your actual test API key
// (switch to the live key later)
\Stripe\Stripe::setApiKey("sk_test_DGoi26vx76FlFn7sen3IDSC8");

$donorEmail = param('email');

$result = doQuery("SELECT DISTINCT donation_subscription_id, donor_first_name, donor_last_name FROM donations JOIN donors ON donation_donor_id=donor_id AND donor_email='$donorEmail' WHERE donation_subscription_id IS NOT NULL");
$count = 0;
while ($row = $result->fetch_assoc()) {
    $subscriptionId = $row['donation_subscription_id'];
    try {
        $subscription = \Stripe\Subscription::retrieve($subscriptionId);
        $subscription->cancel();
        doQuery("UPDATE donations SET donation_subscription_id=NULL WHERE donation_subscription_id='$subscriptionId'");
        $count++;
    } catch (Exception $e) {
    }
}

if ($count == 0) {
    print "We were not able to find any subscriptions associated with this email.";
} else {
    print "We cancelled $count subscription(s) associated with this email.";
    $firstName = $row['donor_first_name'];
    $lastName = $row['donor_last_name'];
    sendMail($donorEmail, "Subscription Cancelled", "Hi $donorEmail,\n\nWe have cancelled your subscription.\n\nThe Village X Team", getAdminEmail());
}

?>