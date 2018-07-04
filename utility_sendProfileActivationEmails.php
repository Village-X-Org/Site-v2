<?php
require_once("utilities.php");

$resultOuter = doUnprotectedQuery("SELECT donor_email, donor_id FROM donors WHERE donor_id=634 OR donor_id=99");
while ($rowOuter = $resultOuter->fetch_assoc()) {
	$type = EMAIL_TYPE_PROFILE_ACTIVATION;
	$donorEmail = $rowOuter['donor_email'];
	$donorId = $rowOuter['donor_id'];
    ob_start();
    include("email_content.php");
    $output = ob_get_clean();
    sendMail($donorEmail, "Activate Your Profile Today!", $output, getCustomerServiceEmail());
    print "Activation email sent to $donorEmail<br/>";
}
?>