<?php
require_once("utilities.php");

if (!$session_is_admin) {
	print "login first";
	die(0);
}

$projectId = paramInt('id');

$result = doUnprotectedQuery("SELECT project_type_id FROM projects WHERE project_id=$projectId");
if ($row = $result->fetch_assoc()) {
	$typeId = $row['project_type_id'];
}
$result = doUnprotectedQuery("SELECT MIN(pt_id) AS min FROM project_types WHERE pt_id>$typeId");
if ($row = $result->fetch_assoc()) {
	$typeId = $row['min'];
}
if (!$typeId) {
	$result = doUnprotectedQuery("SELECT MIN(pt_id) AS min FROM project_types");
	if ($row = $result->fetch_assoc()) {
		$typeId = $row['min'];
	}
}

$result = doUnprotectedQuery("SELECT picture_id, picture_filename FROM pictures JOIN project_types ON pt_sample_image=picture_id WHERE pt_id=$typeId");
if ($row = $result->fetch_assoc()) {
	$filename = $row['picture_filename'];
	$pictureId = $row['picture_id'];
	doUnprotectedQuery("UPDATE projects SET project_type_id=$typeId, project_similar_image_id=$pictureId WHERE project_id=$projectId");
}
print getBaseUrl()."/uploads/$filename";
?>