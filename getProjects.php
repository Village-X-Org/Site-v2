<?php
require_once("utilities.php");

$file = fopen("cached/projects.json","w");
$count = 0;
doQuery("SET SESSION group_concat_max_len = 1000000;");
$result = doQuery("SELECT project_id, project_name, project_lat, project_lng, project_type, picture_filename, project_summary, GROUP_CONCAT(CONCAT(pu_image_id, ':', DATE_FORMAT(pu_timestamp, '%b %D, %Y'), ' ', IFNULL(pu_description,' ')) SEPARATOR '~') AS updatePictures, village_name, project_funded, project_budget FROM projects JOIN villages ON project_village_id=village_id LEFT JOIN project_updates ON pu_project_id=project_id JOIN pictures ON project_profile_image_id=picture_id GROUP BY project_id ");

while ($row = $result->fetch_assoc()) {
    $jitterLng = rand(-9, 9) * .0001;
    $jitterLat = rand(-9, 9) * .0001;
	fwrite($file, ($count > 0 ? "," : '{ "type": "FeatureCollection", "features": [').
	'{
		"type": "Feature",
		"geometry": {
			"type": "Point",
			"coordinates": ['.($row['project_lng'] + $jitterLng).', '.($row['project_lat'] + $jitterLat).']
		},
		"properties": {
			"id": "'.$row['project_id'].'",
			"name": "'.$row['project_name'].'",
			"villageName": "'.$row['village_name'].'",
            "icon": "'.$row['project_type'].'",
			"picture_filename": "'.$row['picture_filename'].'",
			"project_budget": "'.$row['project_budget'].'",
			"project_funded": "'.$row['project_funded'].'"'/*,
		 	"updatePictures": '.json_encode($row['updatePictures']).',
			"project_summary": '.json_encode($row['project_summary']).'
            */
		.'}
	}');
	$count++;
}
fwrite($file, "]}");
fclose($file);
?>