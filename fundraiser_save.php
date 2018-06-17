<?php
require_once("utilities.php");

$title = param('fundraiser_title');
$donorId = $session_donor_id;
$projectId = paramInt('fundraiser_project_id');
$deadline = strtotime(param('fundraiser_deadline')) + (24 * 3600);
$amount = paramInt('fundraiser_amount');
$description = param('fundraiser_description');

if ($donorId) {
	$stmt = prepare("INSERT INTO fundraisers (fundraiser_title, fundraiser_donor_id, fundraiser_project_id, fundraiser_deadline, fundraiser_amount, fundraiser_description) 
		VALUES (?, ?, ?, FROM_UNIXTIME(?), ?, ?)");
	$stmt->bind_param('siiiis', $title, $donorId, $projectId, $deadline, $amount, $description);
	execute($stmt);
	$stmt->close();

	$id = $link->insert_id;

	$type = EMAIL_TYPE_FUNDRAISER;
	ob_start();
	include("email_content.php");
	$output = ob_get_clean();
	sendMail($donorEmail, "Your fundraiser has been created!", 
	    $output, getCustomerServiceEmail());
	sendMail(getCustomerServiceEmail(), "Your fundraiser has been created! ($donorId)",
	    $output, getAdminEmail());
	sendMail(getAdminEmail(), "Your fundraiser has been created! ($donorId)",
	    $output, getAdminEmail());

	sendMail(getAdminEmail(), "Fundraiser Created: $title", "Visit the new fundraiser here: https://villagex.org/fundraiser/$id", getAdminEmail());

	header("Location: fundraiser_view.php?id=$id");
} else {
	print "You must be logged in to create a fundraiser.";
}
?>