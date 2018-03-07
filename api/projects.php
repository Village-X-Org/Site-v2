<?php
	require_once("../utilities.php");	
	print cached('projects.json', doJsonQuery("SELECT project_id, project_name, project_lat + (RAND() * .04 - .02) AS project_lat, project_lng + (RAND() * .04 - .02) AS project_lng, 
		project_village_id, project_type, project_budget, project_funded, picture_filename FROM projects JOIN pictures ON picture_id=project_profile_image_id"));
?>