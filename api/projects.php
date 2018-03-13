<?php
	require_once("../utilities.php");	
	print cached('projects.json', doJsonQuery("SELECT project_id, project_name, project_lat + (RAND() * .04 - .02) AS project_lat, 
		project_lng + (RAND() * .04 - .02) AS project_lng, project_village_id, project_type, project_budget, project_funded, picture_filename, 
		project_summary, project_community_problem, project_community_solution, project_impact, project_community_partners, 
		COUNT(donation_donor_id) AS donor_count,
		GROUP_CONCAT(pe_date) AS dates, GROUP_CONCAT(pet_label) AS event_labels
		FROM projects JOIN pictures ON picture_id=project_profile_image_id 
		JOIN project_events ON pe_project_id=project_id 
		JOIN project_event_types ON pe_type=pet_id 
		JOIN donations ON donation_project_id=project_id
		GROUP BY project_id
		ORDER BY project_funded < project_budget DESC, (project_budget - project_funded) / project_budget ASC"));
?>