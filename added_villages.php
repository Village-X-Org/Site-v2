<?php
require_once("utilities.php");
if (!$session_is_admin) {
	print "Please log in.";
	die(0);
}

if (hasParam('hide')) {
	$toHide = paramInt('hide');
	$stmt = prepare("UPDATE proposed_villages SET pv_hidden=1 WHERE pv_id=?");
	$stmt->bind_param('i', $toHide);
	execute($stmt);
	$stmt->close();
}

$lastEmail = '';
$result = doUnprotectedQuery("SELECT pv_id, pv_name, pv_dev_problem, pv_submitter_name, pv_submitter_email, pv_submitter_phone, pv_population, pv_dev_problem, pv_lat, pv_lng, pv_images, pv_date_added FROM proposed_villages WHERE pv_hidden=0 AND pv_promoted=0 ORDER BY pv_submitter_email, pv_date_added DESC");
while ($row = $result->fetch_assoc()) {
	$id = $row['pv_id'];
	$villageName = $row['pv_name'];
	$devProblem = $row['pv_dev_problem'];
	$population = $row['pv_population'];
	$submitterName = $row['pv_submitter_name'];
	$submitterEmail = $row['pv_submitter_email'];
	if ($lastEmail !== $submitterEmail) {
		$lastEmail = $submitterEmail;
		print "<H3>$submitterName</H3>";
	}
	$lat = $row['pv_lat'];
	$lng = $row['pv_lng'];
	$dateAdded = $row['pv_date_added'];
	$images = explode(',', $row['pv_images']);
	foreach ($images as $image) {
		if (strlen($image) > 1) {
			print "<img src='".getBaseUrl()."/uploads/$image.jpg' style='height:350px;' />";
		}
	}

	$result2 = doUnprotectedQuery("SELECT village_name, fo_first_name, fo_last_name, project_lat, project_lng, (((project_lat-$lat)*(project_lat-$lat))+((project_lng-$lng)*(project_lng-$lng))) AS distance FROM projects JOIN villages ON project_village_id=village_id JOIN field_officers ON project_staff_id=fo_id ORDER BY distance ASC LIMIT 1");
	if ($row2 = $result2->fetch_assoc()) {
		$closestVillage = $row2['village_name'];
		$closestVillageLat = $row2['project_lat'];
		$closestVillageLng = $row2['project_lng'];
		$foName = $row2['fo_first_name'].' '.$row2['fo_last_name'];

		$distance = number_format(getDistanceMeters($closestVillageLat, $closestVillageLng, $lat, $lng) / 1600, 2);
	}
	$result2->close();

	print "<BR>$villageName ($foName) <a href=\"\" onclick=\"if (confirm('Are you sure you want to hide this')) { document.location = 'added_villages.php?hide=$id';} return false;\">hide</a><br/>$devProblem<br/>pop. $population, $dateAdded, added by $submitterName<br/>$distance miles from $closestVillage<br/><br/>";
}