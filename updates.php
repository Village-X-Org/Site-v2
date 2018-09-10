<HTML><HEAD>
<script src="js/lightbox-plus-jquery.min.js"></script>
<link href="css/lightbox.min.css" rel="stylesheet" >
</HEAD>
<BODY>
<?php
require_once("utilities.php");
$projectId = 0;
if (hasParam('projectId')) {
	$projectId = paramInt('projectId');
}
$result = doUnprotectedQuery("SELECT ru_date, ru_description, ru_picture_ids, project_name, project_id FROM raw_updates 
	JOIN projects ON ru_project_id=project_id ".($projectId ? "AND project_id=$projectId " : "")."ORDER BY ru_project_id, ru_date DESC");
$lastProjectId = 0;
$updateCount = 0;
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

	print "<p><b>$date</b> ".($description ? " -- ".$description." -- " : "")."</p>";

	if (strlen($pictureIds) > 0) {
		$resultPics = doUnprotectedQuery("SELECT picture_filename FROM pictures WHERE picture_id IN ($pictureIds)");
		while ($rowPics = $resultPics->fetch_assoc()) {
			$picFilename = $rowPics['picture_filename'];
			print "<a href='uploads/$picFilename' data-lightbox='update$updateCount'>
					<img style='width:300px;' src='uploads/$picFilename' /></a>";
		}
		$resultPics->close();
	}
	$updateCount++;
}
$result->close();

?>
</BODY></HTML>
