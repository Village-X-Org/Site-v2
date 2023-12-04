<?php require_once("utilities.php");

$projectId = paramInt('id');

if (!$session_is_admin) {
    print "Login first";
    die(0);
}

    $donorStmt = prepare("SELECT donor_id, donor_email, donation_id, donor_first_name, donor_last_name, isSubscription FROM donors JOIN ((SELECT sd_id as donation_id, sd_donor_id AS donation_donor_id, 1 as isSubscription FROM subscription_disbursals WHERE sd_project_id=?) UNION (SELECT donation_id, donation_donor_id, 0 as isSubscription FROM donations WHERE donation_project_id=? AND donation_is_test=0)) AS derived ON donation_donor_id=donor_id GROUP BY donor_id");
    $donorStmt->bind_param("ii", $projectId, $projectId);
    $donorResult = execute($donorStmt);
    
while ($donorRow = $donorResult->fetch_assoc()) {
    $donationId = $donorRow['donation_id'];
    $donorEmail = $donorRow['donor_email'];
    $donorFirstName = $donorRow['donor_first_name'];
    $donorLastName = $donorRow['donor_last_name'];
    
    $type = EMAIL_TYPE_PROJECT_FULLY_FUNDED;
    $isSubscription = $donorRow['isSubscription'];
    include("email_content.php");
}