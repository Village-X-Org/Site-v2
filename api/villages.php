<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
	require_once("../utilities.php");	
	print cached('villages', doJsonQuery("SELECT
		village_id,
		village_name,
		village_lat,
		village_lng,
		(SELECT COUNT(*) FROM projects WHERE project_village_id=village_id) AS project_count,
		(SELECT MAX(ru_date) FROM raw_updates JOIN projects ON ru_project_id=project_id WHERE project_village_id=village_id) AS latest_update
	FROM villages"));
?>
