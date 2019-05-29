<?php
require_once("utilities.php");
$id = paramInt('id');

$stmt = prepare("SELECT ru_description, ru_picture_ids, ru_date FROM raw_updates WHERE ru_project_id=?");
$stmt->bind_param("i", $id);
$result = execute($stmt);

$pictures = array();
while ($row = $result->fetch_assoc()) {
	$description = $row['ru_description'];
	$pictureIds = explode(',', $row['ru_picture_ids']);
	$timestamp = $row['ru_date'];
	foreach ($pictureIds as $pictureId) {
		if (strlen($pictureId) > 0) {
			$pictures[] = array($pictureId, $description, $timestamp);
		}
	}
}
$stmt->close();

foreach ($pictures as $picture) {
	$pictureId = $picture[0];
	$result = doUnprotectedQuery("SELECT pu_id FROM project_updates WHERE pu_project_id=$id AND pu_image_id=$pictureId");
	if ($row = $result->fetch_assoc()) {
		$result->close();
		print "Image ($pictureId) already transferred<br/>";
	} else {
		$result->close();
		$stmt = prepare("INSERT INTO project_updates (pu_project_id, pu_image_id, pu_description, pu_timestamp) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("iiss", $id, $pictureId, $picture[1], $picture[2]);
		execute($stmt);
		$stmt->close();
		print "Transferring image $pictureId<br/>";
	}
}
?>