<?php 
	require_once("utilities.php");
	$result = doUnprotectedQuery("SELECT picture_id, picture_filename FROM pictures JOIN project_updates ON pu_image_id=picture_id");
	while ($row = $result->fetch_assoc()) {
		$filename = $row['picture_filename'];
		$picId = $row['picture_id'];
		rename("uploads/$filename", "uploads/$picId.jpg");
		doUnprotectedQuery("UPDATE pictures SET picture_filename='$picId.jpg' WHERE picture_id=$picId");
	}
?>

//SELECT pu_project_id, CONCAT(',',GROUP_CONCAT(pu_image_id),','), pu_timestamp FROM `project_updates` GROUP BY pu_project_id, pu_timestamp