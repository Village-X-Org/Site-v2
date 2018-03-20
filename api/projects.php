<?php
	require_once("../utilities.php");	
	print cached('projects.json', doJsonQuery("SELECT project_id, project_name, project_lat + (RAND() * .04 - .02) AS project_lat, 
		project_lng + (RAND() * .04 - .02) AS project_lng, project_village_id, project_type, project_budget, project_funded, 
		(SELECT picture_filename FROM pictures WHERE picture_id=project_profile_image_id) AS picture_filename, 
		(SELECT picture_filename FROM pictures WHERE picture_id=project_banner_image_id) AS banner_filename, 
		project_summary, project_community_problem, project_community_solution, project_impact, project_community_partners, 
		(SELECT COUNT(donation_donor_id) FROM donations WHERE donation_project_id=project_id) AS donor_count, timeline.dates AS event_dates, timeline.labels AS event_labels,
			updates.pictures AS update_pictures, updates.descriptions AS update_descriptions,
			updates.dates AS update_dates
		FROM projects JOIN (SELECT pe_project_id, GROUP_CONCAT(DATE_FORMAT(pe_date, '%b %D') ORDER BY pet_id) AS dates, GROUP_CONCAT(pet_label ORDER BY pet_id) AS labels FROM project_event_types JOIN project_events ON pet_id=pe_type GROUP BY pe_project_id) AS timeline ON timeline.pe_project_id=project_id
		LEFT JOIN (SELECT pu_project_id, GROUP_CONCAT(picture_filename) AS pictures, GROUP_CONCAT(IF(pu_description IS NULL OR pu_description='', 0, pu_description) SEPARATOR '~') AS descriptions, GROUP_CONCAT(DATE_FORMAT(pu_timestamp, '%b %D')) AS dates FROM project_updates JOIN pictures ON pu_image_id=picture_id GROUP BY pu_project_id) AS updates ON updates.pu_project_id=project_id
		ORDER BY project_funded < project_budget DESC, (project_budget - project_funded) / project_budget ASC"));
?>