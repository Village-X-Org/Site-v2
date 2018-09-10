<?php
require_once("utilities.php");
$result = doUnprotectedQuery("SELECT ru_date, ru_description, ru_picture_ids, project_name, project_id FROM raw_updates 
	JOIN projects ON ru_project_id=project_id ORDER BY ru_project_id");
$lastProjectId = 0;
while ($row = $result->fetch_assoc()) {
	$projectId = $row['project_id'];
	$projectName = $row['project_name'];
	$pictureIds = $row['ru_picture_ids'];
	if (strlen($pictureIds) > 0) {
		$pictureIds = substr($pictureIds, 0, strlen($pictureIds) - 1);
	}
	$description = $row['ru_description'];
	$date = $row['ru_date'];

	if ($projectId != $lastProjectId) {
		print "<H3>$projectName</H3>";
	}
	$lastProjectId = $projectId;

	print "<H4>$date - $description</H4>";

	if (strlen($pictureIds) > 0) {
		$resultPics = doUnprotectedQuery("SELECT picture_filename FROM pictures WHERE picture_id IN ($pictureIds)");
		while ($rowPics = $resultPics->fetch_assoc()) {
			$picFilename = $rowPics['picture_filename'];
			print "<img src='uploads/$picFilename' style='width:300px;' />";
		}
		$resultPics->close();
	}
}
$result->close();

?>