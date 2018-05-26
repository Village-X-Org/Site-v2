<?php
require_once("utilities.php");

$title = param('fundraiser_title');
$donorId = $session_user_id;
$projectId = paramInt('fundraiser_project_id');
$deadline = strtotime(param('fundraiser_deadline'));
$amount = paramInt('fundraiser_amount');
$description = param('fundraiser_description');

$stmt = prepare("INSERT INTO fundraisers (fundraiser_title, fundraiser_donor_id, fundraiser_project_id, fundraiser_deadline, fundraiser_amount, fundraiser_description) 
	VALUES (?, ?, ?, FROM_UNIXTIME(?), ?, ?)");
$stmt->bind_param('siiiis', $title, $donorId, $projectId, $deadline, $amount, $description);
execute($stmt);
$stmt->close();

$id = $link->insert_id;
header("Location: fundraiser_view.php?id=$id");
?>