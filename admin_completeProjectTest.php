<?php require_once("utilities.php");

$projectId = paramInt('id');

if (!$session_is_admin) {
    print "Login first";
    die(0);
}

$donorStmt = prepare("SELECT donor_email, donation_id, donor_first_name, donor_last_name FROM donors JOIN donations ON donation_donor_id=donor_id WHERE donation_project_id=? AND donation_is_test=0 GROUP BY donor_id LIMIT 1");
    $donorStmt->bind_param("i", $projectId);
    $donorResult = execute($donorStmt);
    
if ($donorRow = $donorResult->fetch_assoc()) {
    $donationId = $donorRow['donation_id'];
    $donorEmail = $donorRow['donor_email'];
    $donorFirstName = $donorRow['donor_first_name'];
    $donorLastName = $donorRow['donor_last_name'];
    
    $type = EMAIL_TYPE_PROJECT_COMPLETED;
    $isSubscription = 1;
    include("email_content.php");
} else {
    print "Must have at least one donation.";
}