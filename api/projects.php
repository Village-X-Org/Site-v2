<?php
	require_once("../utilities.php");	
	print cached('projects.json', doJsonQuery("SELECT project_name, project_lat, project_lng, project_village_id, project_type, project_budget, project_funded FROM projects"));
?>