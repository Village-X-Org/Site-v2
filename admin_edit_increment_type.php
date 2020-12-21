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
$result = doUnprotectedQuery("SELECT MIN(project_type_id) AS min FROM project_types WHERE project_type>$typeId");
if ($row = $result->fetch_assoc()) {
	$typeId = $row['min'];
}
if (!$typeId) {
	$result = doUnprotectedQuery("SELECT MIN(project_type_id) AS min FROM project_types");
	if ($row = $result->fetch_assoc()) {
		$typeId = $row['min'];
	}
}

doUnprotectedQuery("UPDATE projects SET project_type_id=$typeId WHERE project_id=$projectId");
$result = doUnprotectedQuery("SELECT picture_filename FROM pictures JOIN project_types ON pt_sample_image=picture_id WHERE pt_id=$typeId");
if ($row = $result->fetch_assoc()) {
	$filename = $row['picture_filename'];
}
print getBaseUrl()."/uploads/$filename";
?>