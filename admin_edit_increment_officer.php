<?php
require_once("utilities.php");

if (!$session_is_admin) {
	print "login first";
	die(0);
}

$projectId = paramInt('id');

$result = doUnprotectedQuery("SELECT project_staff_id FROM projects WHERE project_id=$projectId");
if ($row = $result->fetch_assoc()) {
	$foId = $row['project_staff_id'];
}
$result = doUnprotectedQuery("SELECT MIN(fo_id) AS min FROM field_officers WHERE fo_id>$foId");
if ($row = $result->fetch_assoc()) {
	$foId = $row['min'];
} 
if (!$foId) {
	$result = doUnprotectedQuery("SELECT MIN(fo_id) AS min FROM field_officers");
	if ($row = $result->fetch_assoc()) {
		$foId = $row['min'];
	}
}

doUnprotectedQuery("UPDATE projects SET project_staff_id=$foId WHERE project_id=$projectId");
$result = doUnprotectedQuery("SELECT picture_filename, fo_first_name, fo_last_name, fo_email, fo_phone FROM pictures JOIN field_officers ON fo_picture_id=picture_id WHERE fo_id=$foId");
if ($row = $result->fetch_assoc()) {
	$filename = $row['picture_filename'];
	$name = $row['fo_first_name'].' '.$row['fo_last_name'];
	$email = $row['fo_email'];
	$phone = $row['fo_phone'];
}
print "{\"picture\":\"".getBaseUrl()."/uploads/$filename\",\"name\":\"$name\",\"email\":\"$email\",\"phone\":\"$phone\"}";
?>