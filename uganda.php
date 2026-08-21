<?php
require_once("utilities.php");

$result = doUnprotectedQuery("SELECT pv_id, pv_name, pv_dev_problem, pv_submitter_name, pv_submitter_email, pv_submitter_phone, pv_population, pv_households, pv_cost, pv_has_contribution, pv_dev_problem, pv_lat, pv_lng, pv_images, pv_date_added, pv_promoted FROM proposed_villages WHERE pv_submitter_name LIKE '%Esiat%' ORDER BY pv_submitter_email, pv_date_added DESC");
while ($row = $result->fetch_assoc()) {
	$buffer = '';

	$id = $row['pv_id'];
	$villageName = $row['pv_name'];
	$devProblem = $row['pv_dev_problem'];
	$population = $row['pv_population'];
	$households = $row['pv_households'];
	$cost = $row['pv_cost'];
	$hasContribution = $row['pv_has_contribution'];
	$submitterName = $row['pv_submitter_name'];
	$submitterEmail = $row['pv_submitter_email'];
	$promotedProject = $row['pv_promoted'];
	$lat = $row['pv_lat'];
	$lng = $row['pv_lng'];
	$dateAdded = $row['pv_date_added'];
	$images = explode(',', $row['pv_images']);
	foreach ($images as $image) {
		if (strlen($image) > 1) {
			$buffer .= "<a href='".getBaseUrl()."/uploads/$image.jpg' target='_blank'><img src='".getBaseUrl()."/uploads/$image.jpg' style='height:350px;border:0;' /></a>";
		}
	}

	print "$buffer<br/>Submitted by <b>$submitterName</b><br/>$villageName &nbsp;";

	print "<br/>$devProblem<br/>pop. $population, $dateAdded, added by $submitterName (<a href='https://www.google.com/maps/?q=$lat,$lng' target='_blank'>map</a>)<br/><br/>";
}
?>