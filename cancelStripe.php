<?php
require_once("utilities.php");
require_once('lib/stripe/init.php');

\Stripe\Stripe::setApiKey(isset($_SESSION['test']) && $_SESSION['test'] ? STRIPE_TEST_SECRET_KEY : STRIPE_SECRET_KEY);

$donorEmail = param('email');

$stmt = prepare("SELECT DISTINCT donation_subscription_id, donor_first_name, donor_last_name FROM donations JOIN donors ON donation_donor_id=donor_id AND donor_email=? WHERE donation_subscription_id IS NOT NULL");
$stmt->bind_param('s', $donorEmail);
$result = execute($stmt);

$count = 0;
while ($row = $result->fetch_assoc()) {
    $subscriptionId = $row['donation_subscription_id'];
    $donorFirstName = $row['donor_first_name'];
    $donorLastName = $row['donor_last_name'];
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
    $type = EMAIL_TYPE_SUBSCRIPTION_CANCELLATION;
    ob_start();
    $isSubscription = 1;
    include("email_content.php");
    $output = ob_get_clean();
    sendMail($donorEmail, "Subscription Cancelled", $output, getCustomerServiceEmail());
}

?>