<?php
require_once("utilities.php");
require_once('lib/stripe/init.php');

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

$donorEmail = param('stripeEmail');
$donorFirstName = param('firstName');
$donorLastName = param('lastName');
$donationAmount = param('stripeAmount');
$projectId = param('projectId');
$isSubscription = param('isSubscription');
$token = param('stripeToken');
$honoreeId = paramInt('honoreeId');
$honoreeMessage = param('honoreeMessage');

$stmt = prepare("SELECT donor_id FROM donors WHERE donor_email=?");
$stmt->bind_param('s', $donorEmail);
$result = execute($stmt);
if ($row = $result->fetch_assoc()) {
    $donorId = $row['donor_id'];
    
    $stmt = prepare("UPDATE donors SET donor_first_name=?, donor_last_name=? WHERE donor_id=?");
    $stmt->bind_param('ssi', $donorFirstName, $donorLastName, $donorId);
    execute($stmt);
    $stmt->close();
    
    $stmt = prepare("SELECT count(donation_id) AS donationCount FROM donations WHERE donation_donor_id=? AND donation_remote_id<>?");
    $stmt->bind_param('is', $donorId, $token);
    $result = execute($stmt);
    if ($row = $result->fetch_assoc()) {
        $donationCount = $row['donationCount'] + 1;
    }
    $stmt->close();
} else {
    $stmt = prepare("INSERT INTO donors (donor_email, donor_first_name, donor_last_name) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $donorEmail, $donorFirstName, $donorLastName);
    execute($stmt);
    $stmt->close();
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
             "interval" => "month",
             "currency" => "usd",
             "amount" => $donationAmount,
         ));
             
         $customer = \Stripe\Customer::create(array(
             'email' => $donorEmail,
             'source'  => param('stripeToken'),
             'plan' => $plan
         ));
         $subscriptionId = $customer->subscriptions->data[0]->id;
         
    } catch (Exception $e) {
        sendMail(getAdminEmail(), "Problem creating subscription", $e->getMessage(), getAdminEmail());
    }
} else {
    $charge = \Stripe\Charge::create(array(
        "amount" => $donationAmount,
        "currency" => "usd",
        "description" => "Project Donation",
        "source" => $token,
    ));
}

$donationAmountDollars = $donationAmount / 100;

$code = null;
if (isset($_SESSION['code'])) {
    $code = $_SESSION['code'];
}

$stmt = prepare("SELECT donation_id FROM donations WHERE donation_remote_id=?");
$stmt->bind_param("s", $token);
$result = execute($stmt);
if ($row = $result->fetch_assoc()) {
    $donationId = $row['donation_id'];
} else {
    $stmt->close();
    $stmt = prepare("INSERT INTO donations (donation_donor_id, donation_amount, donation_project_id, donation_subscription_id, donation_remote_id, donation_code, donation_honoree_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insertAmount = $isSubscription ? 0 : $donationAmountDollars;
    $stmt->bind_param("idisssi", $donorId, $insertAmount, $projectId, $subscriptionId, $token, $code, $honoreeId);
    execute($stmt);
    $stmt->close();
    $donationId = $link->insert_id;
    if ($projectId) {
        recordDonation($projectId, $donationAmountDollars, $donationId);
    }
}

if ($honoreeId > 0) {
    $stmt = prepare("SELECT donor_email, donor_first_name, donor_last_name FROM donors WHERE donor_id=?");
    $stmt->bind_param('i', $honoreeId);
    $result = execute($stmt);
    if ($row = $result->fetch_assoc()) {
        $honoreeFirstName = $row['donor_first_name'];
        $honoreeLastName = $row['donor_last_name'];
        $honoreeEmail = $row['donor_email'];
        
        $stmt->close();
    }
}

if ($isSubscription) {
    // Instead of actually disbursing, just find a project.
    $result = doUnprotectedQuery("SELECT project_id, project_name, village_name, country_label, picture_filename, peopleStats.stat_value AS peopleCount, hhStats.stat_value AS householdCount
    FROM projects JOIN villages ON project_village_id=village_id
    JOIN countries ON country_id=village_country
    JOIN village_stats AS peopleStats ON peopleStats.stat_type_id=18 AND peopleStats.stat_village_id=village_id
    JOIN village_stats AS hhStats ON hhStats.stat_type_id=19 AND hhStats.stat_village_id=village_id
    JOIN pictures ON picture_id=project_similar_image_id WHERE project_funded<project_budget ORDER BY (EXISTS (SELECT sd_project_id FROM subscription_disbursals WHERE sd_donor_id=$donorId)) ASC,
        project_budget - project_funded ASC, hhStats.stat_year DESC, peopleStats.stat_year DESC LIMIT 1");
    if ($row = $result->fetch_assoc()) {
        $projectId = $row['project_id'];
        $projectName = $row['project_name'];
        $projectExampleImage = $row['picture_filename'];
        $villageName = $row['village_name'];
        $countryName = $row['country_label'];
        $numPeople = $row['peopleCount'];
        $numHouseholds = $row['householdCount'];
    }
    
    include("thanks_for_donating_monthly.php");
} else {
    include("thanks_for_donating_one_time.php");
}

$type = EMAIL_TYPE_THANKS_FOR_DONATING;
ob_start();
include("email_content.php");
$output = ob_get_clean();
sendMail($donorEmail, $isSubscription ? "Monthly Subscription for Village X": "Donation to Village X", 
    $output, getCustomerServiceEmail());
sendMail(getCustomerServiceEmail(), $isSubscription ? "Monthly Subscription for Village X ($donorEmail) ($honoreeId)": "Donation to Village X ($donorEmail)",
    $output, getAdminEmail());
sendMail(getAdminEmail(), $isSubscription ? "Monthly Subscription for Village X ($donorEmail) ($honoreeId)": "Donation to Village X ($donorEmail)",
    $output, getAdminEmail());

if (isset($honoreeFirstName)) {
    $useHonoree = 1;
    ob_start();
    include("email_content.php");
    $output = ob_get_clean();
        
    sendMail($honoreeEmail, (strlen($donorFirstName) > 0 ? "$donorFirstName $donorLastName" : "Someone")." has donated to Village X in your honor!",
        $output, getCustomerServiceEmail());
}
?>
