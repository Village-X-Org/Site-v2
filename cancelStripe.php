<?php
require_once("utilities.php");
require_once('lib/stripe/init.php');

// Be sure to replace this with your actual test API key
// (switch to the live key later)
\Stripe\Stripe::setApiKey("sk_test_DGoi26vx76FlFn7sen3IDSC8");

$donorEmail = param('email');

$stmt = prepare("SELECT DISTINCT donation_subscription_id, donor_first_name, donor_last_name FROM donations JOIN donors ON donation_donor_id=donor_id AND donor_email=? WHERE donation_subscription_id IS NOT NULL");
$stmt->bind_param('s', $email);
$result = execute($stmt);

$count = 0;
while ($row = $result->fetch_assoc()) {
    $subscriptionId = $row['donation_subscription_id'];
    try {
        $subscription = \Stripe\Subscription::retrieve($subscriptionId);
        $subscription->cancel();
        doUnprotectedQuery("UPDATE donations SET donation_subscription_id=NULL WHERE donation_subscription_id='$subscriptionId'");
        $count++;
    } catch (Exception $e) {
    }
}
$stmt->close();

if ($count == 0) {
    print "We were not able to find any subscriptions associated with this email.";
} else {
    print "We cancelled $count subscription(s) associated with this email.";
    $donorFirstName = $row['donor_first_name'];
    $donorLastName = $row['donor_last_name'];
    $type = EMAIL_TYPE_SUBSCRIPTION_CANCELLATION;
    ob_start();
    include("email_content.php");
    $output = ob_get_clean();
    sendMail($donorEmail, "Subscription Cancelled", $output, getCustomerServiceEmail());
}

?>