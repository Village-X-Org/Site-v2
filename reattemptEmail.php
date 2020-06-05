<?php
require_once("utilities.php");

$donationId = param('id');
if (!$session_is_admin) {
	print "Operation not permitted";
	die(0);
}

$result = doUnprotectedQuery("SELECT village_name, donation_amount, donation_fundraiser_id, donation_project_id, donor.donor_id AS donorId, donor.donor_first_name AS donorFirstName, donor.donor_last_name AS donorLastName, donor.donor_email AS donorEmail, IF(donation_subscription_id IS NULL OR donation_subscription_id='NULL' OR donation_subscription_id='', 0, 1) AS isSubscription, donation_message, honoree.donor_id AS honoreeId, honoree.donor_first_name AS honoreeFirstName, honoree.donor_last_name AS honoreeLastName, honoree.donor_email AS honoreeEmail FROM donations JOIN donors AS donor ON donor.donor_id=donation_donor_id LEFT JOIN donors AS honoree ON honoree.donor_id=donation_honoree_id LEFT JOIN projects ON donation_project_id=project_id LEFT JOIN villages ON village_id=project_village_id WHERE donation_id=$donationId");
if ($row = $result->fetch_assoc()) {
	$donorId = $row['donorId'];
	$donorEmail = $row['donorEmail'];
	$donorFirstName = $row['donorFirstName'];
	$donorLastName = $row['donorLastName'];
	$honoreeId = $row['honoreeId'];
	$honoreeEmail = $row['honoreeEmail'];
	$honoreeFirstName = $row['honoreeFirstName'];
	$honoreeMessage = $row['donation_message'];
	$isSubscription = $row['isSubscription'];
	$donationAmountDollars = $row['donation_amount'];
	$fundraiserId = $row['donation_fundraiser_id'];
	$projectId = $row['donation_project_id'];
	$villageName = $row['village_name'];
}

$result = doUnprotectedQuery("SELECT COUNT(donation_id) AS donationCount FROM donations WHERE donation_donor_id=$donorId");
if ($row = $result->fetch_assoc()) {
	$donationCount = $row['donationCount'];
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
    $output, getCustomerServiceEmail());
sendMail(getAdminEmail(), $isSubscription ? "Monthly Subscription for Village X ($donorEmail) ($honoreeId)": "Donation to Village X ($donorEmail)",
    $output, getCustomerServiceEmail());

if (isset($honoreeFirstName)) {
    $useHonoree = 1;
    ob_start();
    include("email_content.php");
    $output = ob_get_clean();
        
    sendMail($honoreeEmail, (strlen($donorFirstName) > 0 ? "$donorFirstName $donorLastName" : "Someone")." has donated to Village X in your honor!",
        $output, getCustomerServiceEmail());
}
?>