<?php
require_once("utilities.php");

$fptr = fopen('data/projects.csv', 'r');
$labels = fgetcsv($fptr);
while ($projRow = fgetcsv($fptr)) {
    $village = $projRow[1];
    $district = $projRow[2];
    $country = $projRow[3];
    $lat = $projRow[4];
    $lng = $projRow[5];
    $population = $projRow[6];
    $households = $projRow[7];
    $projName = $projRow[8];
    $foName = $projRow[9];
    $foEmail = $projRow[10];
    $foPhone = $projRow[11];
    $projCost = $projRow[12];
    $projLaborCost = $projRow[13];
    $projMaterialsCost = $projRow[14];
    $projTransportCost = $projRow[15];
    $projDataPics = $projRow[16];
    $projAdminCost = $projRow[17];
    $projFees = $projRow[18];
    $projSumCheck = $projRow[19];
    $dateCommunityContribution = $projRow[20];
    $dateProjectPosted = $projRow[21];
    $dateProjectFunded = $projRow[22];
    $dateProjectCompleted = $projRow[23];
    $projProfile = $projRow[24];
    $projExample = $projRow[25];
    
    $date = DateTime::createFromFormat("d/m/Y", $dateProjectPosted);
    $projYear = $date->format("Y");
    
    $result = doQuery("SELECT district_id FROM districts WHERE district_name='$district'");
    if ($row = $result->fetch_assoc()) {
        $districtId = $row['district_id'];
    } else {
        doQuery("INSERT INTO districts (district_name) VALUES ('$district')");
        $districtId = $link->insert_id;
    }
    
    $result = doQuery("SELECT country_id FROM countries WHERE country_label='$country'");
    if ($row = $result->fetch_assoc()) {
        $countryId = $row['country_id'];
    } else {
        doQuery("INSERT INTO countries (country_label) VALUES ('$country')");
        $countryId = $link->insert_id;
    }
    
    $result = doQuery("SELECT fo_id FROM field_officers WHERE fo_email='$foEmail'");
    if ($row = $result->fetch_assoc()) {
        $foId = $row['fo_id'];    
    } else {
        $spaceIndex = strpos($foName, ' ');
        $firstName = substr($foName, 0, $spaceIndex);
        $lastName = substr($foName, $spaceIndex + 1);
        doQuery("INSERT INTO field_officers (fo_first_name, fo_last_name, fo_email, fo_phone) VALUES ('$firstName', '$lastName', '$foEmail', '$foPhone')");
        $foId = $link->insert_id;
    }
    
    $result = doQuery("SELECT village_id FROM villages WHERE village_name='$village' AND village_district=$districtId");
    if ($row = $result->fetch_assoc()) {
        $villageId = $row['village_id'];
        doQuery("UPDATE villages SET village_district=$districtId, village_pending=0 WHERE village_id=$villageId");
    } else {
        doQuery("INSERT INTO villages (village_name, village_district, village_lat, village_lng, village_pending, village_country) VALUES ('$village', $districtId, $lat, $lng, 0, $countryId)");
        $villageId = $link->insert_id;;
    }
   
    $result = doQuery("SELECT picture_id FROM pictures WHERE picture_filename='$projProfile'");
    if ($row = $result->fetch_assoc()) {
        $profileId = $row['picture_id'];
    } else {
        doQuery("INSERT INTO pictures (picture_filename) VALUES ('$projProfile')");
        $profileId = $link->insert_id;
    }
    
    $projBanner = str_replace("profile", "banner", $projProfile);
    $result = doQuery("SELECT picture_id FROM pictures WHERE picture_filename='$projBanner'");
    if ($row = $result->fetch_assoc()) {
        $bannerId = $row['picture_id'];
    } else {
        doQuery("INSERT INTO pictures (picture_filename) VALUES ('$projBanner')");
        $bannerId = $link->insert_id;
    }
   
    $result = doQuery("SELECT picture_id FROM pictures WHERE picture_filename='$projExample'");
    if ($row = $result->fetch_assoc()) {
        $exampleId = $row['picture_id'];
    } else {
        doQuery("INSERT INTO pictures (picture_filename) VALUES ('$projExample')");
        $exampleId = $link->insert_id;
    }
    
    $result = doQuery("SELECT project_id FROM projects WHERE project_village_id=$villageId AND project_name='$projName'") ;
    if ($row = $result->fetch_assoc()) {
        $projectId = $row['project_id'];
        doQuery("UPDATE projects SET project_budget=$projCost, project_staff_id=$foId, project_banner_image_id=$bannerId, project_profile_image_id=$profileId, project_similar_image_id=$exampleId, project_date_posted=STR_TO_DATE('$dateProjectPosted', '%m/%d/%Y') WHERE project_id=$projectId");
    } else {
        doQuery("INSERT INTO projects (project_village_id, project_name, project_lat, project_lng, project_budget, project_staff_id, project_banner_image_id, project_profile_image_id, project_similar_image_id) VALUES ($villageId, '$projName', $lat, $lng, $projCost, $foId, $bannerId, $profileId, $exampleId)");
        $projectId = $link->insert_id;
        print "New Project Added for $village";
    }
    
    doQuery("DELETE FROM project_costs WHERE pc_project_id=$projectId");
    doQuery("INSERT INTO project_costs (pc_project_id, pc_label, pc_amount, pc_type) VALUES ($projectId, 'labor', $projLaborCost, 1)");
    doQuery("INSERT INTO project_costs (pc_project_id, pc_label, pc_amount, pc_type) VALUES ($projectId, 'materials', $projMaterialsCost, 2)");
    doQuery("INSERT INTO project_costs (pc_project_id, pc_label, pc_amount, pc_type) VALUES ($projectId, 'admin', $projAdminCost, 3)");
    doQuery("INSERT INTO project_costs (pc_project_id, pc_label, pc_amount, pc_type) VALUES ($projectId, 'transport', $projTransportCost, 4)");
    doQuery("INSERT INTO project_costs (pc_project_id, pc_label, pc_amount, pc_type) VALUES ($projectId, 'fees', $projFees, 5)");
    doQuery("INSERT INTO project_costs (pc_project_id, pc_label, pc_amount, pc_type) VALUES ($projectId, 'pics/data', $projDataPics, 6)");
    
    doQuery("DELETE FROM project_events WHERE pe_project_id=$projectId");
    doQuery("INSERT INTO project_events (pe_description, pe_date, pe_project_id) VALUES ('Village Raises Cash Contribution', STR_TO_DATE('$dateCommunityContribution', '%m/%d/%Y'), $projectId)");
    doQuery("INSERT INTO project_events (pe_description, pe_date, pe_project_id) VALUES ('Project Posted', STR_TO_DATE('$dateProjectPosted', '%m/%d/%Y'), $projectId)");
    if (strlen($dateProjectFunded) > 3) {
        doQuery("INSERT INTO project_events (pe_description, pe_date, pe_project_id) VALUES ('Project Funded', STR_TO_DATE('$dateProjectFunded', '%m/%d/%Y'), $projectId)");
        doQuery("INSERT INTO project_events (pe_description, pe_date, pe_project_id) VALUES ('Project Completed', STR_TO_DATE('$dateProjectCompleted', '%m/%d/%Y'), $projectId)");
    }
    
    doQuery("DELETE FROM village_stats WHERE stat_village_id=$villageId AND (stat_type_id=18 OR stat_type_id=19) AND stat_year=$projYear");
    doQuery("INSERT INTO village_stats (stat_type_id, stat_village_id, stat_value, stat_year) VALUES (18, $villageId, $population, $projYear)");
    doQuery("INSERT INTO village_stats (stat_type_id, stat_village_id, stat_value, stat_year) VALUES (19, $villageId, $households, $projYear)");
}