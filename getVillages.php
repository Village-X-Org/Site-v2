<?php
require_once("utilities.php");

$file = fopen("cached/villages.json","w");
$count = 0;
$result = doUnprotectedQuery("SELECT village_id, village_name, village_lat, village_lng, picture_filename, SUM(IF(project_status='funding', 1, 0)) AS fundingCount, SUM(IF(project_status='completed', 1, 0)) AS completedCount, SUM(IF(project_status='construction', 1, 0)) AS constructionCount, village_summary, MIN(project_lat) AS swLat, MIN(project_lng) AS swLng, MAX(project_lat) AS neLat, MAX(project_lng) AS neLng FROM villages JOIN projects ON project_status<>'cancelled' AND village_pending=0 AND project_village_id=village_id LEFT JOIN pictures ON picture_id=project_profile_image_id GROUP BY village_id");
while ($row = $result->fetch_assoc()) {
    $funding = $row['fundingCount'];
    $completed = $row['completedCount'];
    $construction = $row['constructionCount'];
    
	fwrite($file, ($count > 0 ? "," : '{ "type": "FeatureCollection", "features": [').
	'{
		"type": "Feature",
		"geometry": {
			"type": "Point",
			"coordinates": ['.$row['village_lng'].', '.$row['village_lat'].']
		},
		"properties": {
			"id": "'.$row['village_id'].'",
			"name": "'.$row['village_name'].'",
			"picture_filename": "'.$row['picture_filename'].'",
			"fundingCount": "'.$funding.'",
			"completedCount": "'.$completed.'",
			"constructionCount": "'.$construction.'",
			"boundsSwLat": "'.$row['swLat'].'",
			"boundsSwLng": "'.$row['swLng'].'",
			"boundsNeLat": "'.$row['neLat'].'",
			"boundsNeLng": "'.$row['neLng'].'",
			"projectCount": "'.($funding > 0 ? "$funding in funding" : "")
			.($completed > 0 ? ($funding > 0 ? ", " : "")."$completed completed" : "")
			.($construction > 0 ? ($funding + $completed > 0 ? ", " : "")."$construction in-progress" : "")
			.'"}'/*
			"village_summary": '.json_encode($row['village_summary']).'
		*/.'
	}');
	$count++;
}
fwrite($file, "]}");
fclose($file);
?>