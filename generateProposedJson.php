<?php require_once("utilities.php");

$file = fopen("cached/proposed.json","w");
$count = 0;
$result = doUnprotectedQuery("SELECT pv_id, pv_name, pv_lat, pv_lng, pv_images, pv_population, pv_dev_problem, DATE_FORMAT(pv_date_added, '%M %e, %Y') AS dateAdded FROM proposed_villages WHERE pv_promoted=0");
while ($row = $result->fetch_assoc()) {
    
	fwrite($file, ($count > 0 ? "," : '{ "type": "FeatureCollection", "features": [').
	'{
		"type": "Feature",
		"geometry": {
			"type": "Point",
			"coordinates": ['.$row['pv_lng'].', '.$row['pv_lat'].']
		},
		"properties": {
			"id": "'.$row['pv_id'].'",
			"name": "'.$row['pv_name'].'",
			"pictures": "'.$row['pv_images'].'",
			"date_added": "'.$row['dateAdded'].'",
			"dev_problem": "'.$row['pv_dev_problem'].'",
			"population": "'.$row['pv_population'].'"
		}
	}');
	$count++;
}
fwrite($file, "]}");
fclose($file);
?>