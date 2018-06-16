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

sendMail(getAdminEmail(), "Fundraiser Created: $title", "Visit the new fundraiser here: https://villagex.org/fundraiser/$id", getAdminEmail());

	header("Location: fundraiser_view.php?id=$id");
} else {
	print "You must be logged in to create a fundraiser.";
}
?>