<?php
require_once("utilities.php");
if (!$session_is_admin) {
	print "Please log in.";
	die(0);
}

$max = 0;
if (hasParam('max')) {
	$max = paramInt('max');
}

if (hasParam('hide')) {
	$toHide = paramInt('hide');
	$stmt = prepare("UPDATE proposed_villages SET pv_hidden=1 WHERE pv_id=?");
	$stmt->bind_param('i', $toHide);
	execute($stmt);
	$stmt->close();
}

if (hasParam('promote')) {
	$id = paramInt('promote');
	$foId = paramInt('fo');

	$stmt = prepare("SELECT pv_name, pv_lat, pv_lng, pv_images FROM proposed_villages WHERE pv_id=?");
	$stmt->bind_param('i', $id);
	$result = execute($stmt);
	if ($row = $result->fetch_assoc()) {
		$villageName = $row['pv_name'];
		$lat = $row['pv_lat'];
		$lng = $row['pv_lng'];
		$images = explode(',', $row['pv_images']);
		$imageId = $images[1];
	}
	$stmt->close();

	$url = "https://nominatim.openstreetmap.org/search?q=$lat,$lng&format=json&addressdetails=1";
	$ch = curl_init( $url );
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT,'Village X');
    $result = curl_exec($ch);
    $geoloc = json_decode($result, true);
    
    $first = $geoloc[0]['address'];
    $district = 0;
    $region = 0;
    $country = 0;
    $districtId = $regionId = $countryId = 0;
    if (isset($first['state_district'])) {
        $district = $first['state_district'];
    } elseif (isset($first['county'])) {
		$district = $first['county'];
    } elseif (isset($first['state'])) {
		$district = $first['state'];
    }
    if (isset($first['region'])) {
		$region = $first['region'];
    } 
    if (isset($first['country'])) {
    	$country = $first['country'];
    }

    if ($district) {
	    $result = doUnprotectedQuery("SELECT district_id FROM districts WHERE district_name='$district'");
	    if ($row = $result->fetch_assoc()) {
	        $districtId = $row['district_id'];
	    } else {
	        doUnprotectedQuery("INSERT INTO districts (district_name) VALUES ('$district')");
	        $districtId = $link->insert_id;
	    }
	}

    if ($region) {
	    $result = doUnprotectedQuery("SELECT region_id FROM regions WHERE region_name='$region'");
	    if ($row = $result->fetch_assoc()) {
	        $regionId = $row['region_id'];
	    } else {
	        doUnprotectedQuery("INSERT INTO regions (region_name) VALUES ('$region')");
	        $regionId = $link->insert_id;
	    }
	}

	if ($country) {
		$result = doUnprotectedQuery("SELECT country_id FROM countries WHERE country_label='$country'");
	    if ($row = $result->fetch_assoc()) {
	        $countryId = $row['country_id'];
	    }
	}

	$result = doUnprotectedQuery("SELECT village_id FROM villages WHERE village_name='$villageName' AND round($lat * 10)=round(village_lat*10) AND round($lng * 10)=round(village_lng*10)");
    if ($row = $result->fetch_assoc()) {
    	$villageId = $row['village_id'];
    } else {
		$stmt = prepare("INSERT INTO villages (village_name, village_district, village_region, village_country, village_lat, village_lng, village_pending) VALUES (?, ?, ?, ?, ?, ?, 0)");
		$stmt->bind_param('siiidd', $villageName, $districtId, $regionId, $countryId, $lat, $lng);
		execute($stmt);
		$villageId = $link->insert_id;
		$stmt->close();
	}

	$stmt = prepare("INSERT INTO projects (project_village_id, project_name, project_lat, project_lng, project_budget, project_staff_id, project_banner_image_id, project_profile_image_id, project_similar_image_id, project_summary, project_community_problem, project_community_solution, project_community_partners, project_impact, project_funded, project_status, project_type, project_type_id, project_elapsed_days, project_people_reached, project_completion) VALUES (?, 'Insert Goal Here', ?, ?, 0, ?, ?, ?, 2511, 'Insert Summary Here', 'Insert Community Problem Here', 'Insert Community Solution Here', 'Insert Partners Here', 'Insert Impact Here', 0, 'funding', 'business', 1, 0, 0, '')");
	$stmt->bind_param('iddiii', $villageId, $lat, $lng, $foId, $imageId, $imageId);
	execute($stmt);
    $projectId = $link->insert_id;
	$stmt->close();

	doUnprotectedQuery("INSERT INTO project_costs (pc_project_id, pc_label, pc_amount, pc_type) VALUES ($projectId, 'labor', 0, 1),
		($projectId, 'materials', 0, 2), ($projectId, 'admin', 0, 3), ($projectId, 'transport', 0, 4), ($projectId, 'fees', 0, 5)");
	doUnprotectedQuery("INSERT INTO project_events (pe_date, pe_type, pe_project_id) VALUES (NOW(), 1, $projectId), (NOW(), 2, $projectId)");
	doUnprotectedQuery("INSERT INTO village_stats (stat_type_id, stat_village_id, stat_value, stat_year) VALUES (18, $villageId, 100, YEAR(NOW())), (19, $villageId, 100, YEAR(NOW()))");
	header("Location: project.php?id=$projectId");
	doUnprotectedQuery("UPDATE proposed_villages SET pv_promoted=$projectId WHERE pv_id=$id");
	die(0);
}


print "Max distance from existing projects (miles): <a href='added_villages.php'>∞</a> <a href='added_villages.php?max=200'>200</a> <a href='added_villages.php?max=100'>100</a> <a href='added_villages.php?max=50'>50</a> <a href='added_villages.php?max=20'>20</a> <a href='added_villages.php?max=10'>10</a> <a href='added_villages.php?max=5'>5</a> <a href='added_villages.php?max=2'>2</a> <a href='added_villages.php?max=1'>1</a><p/>";

$lastEmail = '';
$result = doUnprotectedQuery("SELECT pv_id, pv_name, pv_dev_problem, pv_submitter_name, pv_submitter_email, pv_submitter_phone, pv_population, pv_dev_problem, pv_lat, pv_lng, pv_images, pv_date_added, pv_promoted FROM proposed_villages WHERE pv_hidden=0 AND LENGTH(pv_images) > 2 ORDER BY pv_submitter_email, pv_date_added DESC");
while ($row = $result->fetch_assoc()) {
	$buffer = '';

	$id = $row['pv_id'];
	$villageName = $row['pv_name'];
	$devProblem = $row['pv_dev_problem'];
	$population = $row['pv_population'];
	$submitterName = $row['pv_submitter_name'];
	$submitterEmail = $row['pv_submitter_email'];
	$promotedProject = $row['pv_promoted'];
	$lat = $row['pv_lat'];
	$lng = $row['pv_lng'];
	$dateAdded = $row['pv_date_added'];
	$images = explode(',', $row['pv_images']);
	foreach ($images as $image) {
		if (strlen($image) > 1) {
			$buffer .= "<a href='".getBaseUrl()."/uploads/$image.jpg' target='_blank'><img src='".getBaseUrl()."/uploads/$image.jpg' style='height:350px;border:0;' /></a>";
		}
	}

	$result2 = doUnprotectedQuery("SELECT village_name, fo_id, fo_first_name, fo_last_name, project_lat, project_lng, (((project_lat-$lat)*(project_lat-$lat))+((project_lng-$lng)*(project_lng-$lng))) AS distance FROM projects JOIN villages ON project_village_id=village_id JOIN field_officers ON project_staff_id=fo_id ORDER BY distance ASC LIMIT 1");
	if ($row2 = $result2->fetch_assoc()) {
		$closestVillage = $row2['village_name'];
		$closestVillageLat = $row2['project_lat'];
		$closestVillageLng = $row2['project_lng'];
		$foId = $row2['fo_id'];
		$foName = $row2['fo_first_name'].' '.$row2['fo_last_name'];

		$distance = number_format(getDistanceMeters($closestVillageLat, $closestVillageLng, $lat, $lng) / 1600, 2);
	}
	$result2->close();
	if ($max && $max < $distance) {
		continue;
	}

	print "$buffer<br/>Submitted by <b>$submitterName</b><br/>$villageName <a href=\"\" onclick=\"if (confirm('Are you sure you want to hide this')) { document.location = 'added_villages.php?hide=$id';} return false;\">hide</a> &nbsp;";
	if ($promotedProject) {
		print "<a href=\"project.php?id=$promotedProject\" target='_blank'>view project</a>";
	} else {
		print " <a href=\"\" onclick=\"if (confirm('Are you sure you want to promote this? Clicking OK will create a new project.')) { document.location = 'added_villages.php?promote=$id&fo=$foId';} return false;\">promote</a>";
	}
	print "<br/>$devProblem<br/>pop. $population, $dateAdded, added by $submitterName<br/>$distance miles from $closestVillage ($foName) (<a href='https://www.google.com/maps/dir/$closestVillageLat,$closestVillageLng/$lat,$lng/' target='_blank'>map</a>)<br/><br/>";
}