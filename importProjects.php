<?php
require_once("utilities.php");
require_once("utility_readSheets.php");

$spreadsheetId = '1YdE_8GNlF1HAKSnDozYZm9cRt0uzD877mRPgEF4Ub2A';
$range = 'Sheet1!A:AK';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$sheet = $response->getValues();

$rowCount = 0;
foreach ($sheet as $projRow) {
    if ($rowCount++ == 0) {
        $labels = $projRow;
        continue;
    } elseif (!isset($projRow[0])) {
        break;
    }
    $projId = $projRow[0];
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
    $elapsedDays = $projRow[24];
    $peopleReached = $projRow[25];
    $projProfile = $projRow[26];
    $projExample = $projRow[27];
    $summary = escStr($projRow[28]);
    $problem = escStr($projRow[29]);
    $solution = escStr($projRow[30]);
    $partners = escStr($projRow[31]);
    $impact = escStr($projRow[32]);
    $funded = $projRow[33];
    $status = $projRow[34];
    $type = $projRow[35];
    $category = $projRow[36];
    
    $date = DateTime::createFromFormat("d/m/Y", $dateProjectPosted);
    $projYear = $date->format("Y");
    
    $result = doUnprotectedQuery("SELECT district_id FROM districts WHERE district_name='$district'");
    if ($row = $result->fetch_assoc()) {
        $districtId = $row['district_id'];
    } else {
        doUnprotectedQuery("INSERT INTO districts (district_name) VALUES ('$district')");
        $districtId = $link->insert_id;
    }
    
    $result = doUnprotectedQuery("SELECT country_id FROM countries WHERE country_label='$country'");
    if ($row = $result->fetch_assoc()) {
        $countryId = $row['country_id'];
    } else {
        doUnprotectedQuery("INSERT INTO countries (country_label) VALUES ('$country')");
        $countryId = $link->insert_id;
    }
    
    $result = doUnprotectedQuery("SELECT fo_id FROM field_officers WHERE fo_email='$foEmail'");
    if ($row = $result->fetch_assoc()) {
        $foId = $row['fo_id'];    
    } else {
        $spaceIndex = strpos($foName, ' ');
        $firstName = substr($foName, 0, $spaceIndex);
        $lastName = substr($foName, $spaceIndex + 1);
        doUnprotectedQuery("INSERT INTO field_officers (fo_first_name, fo_last_name, fo_email, fo_phone) VALUES ('$firstName', '$lastName', '$foEmail', '$foPhone')");
        $foId = $link->insert_id;
    }
    
    $result = doUnprotectedQuery("SELECT village_id FROM villages WHERE village_name='$village' AND village_district=$districtId");
    if ($row = $result->fetch_assoc()) {
        $villageId = $row['village_id'];
        doUnprotectedQuery("UPDATE villages SET village_district=$districtId, village_pending=0, village_lat=$lat, village_lng=$lng WHERE village_id=$villageId");
    } else {
        doUnprotectedQuery("INSERT INTO villages (village_name, village_district, village_lat, village_lng, village_pending, village_country) VALUES ('$village', $districtId, $lat, $lng, 0, $countryId)");
        $villageId = $link->insert_id;
    }
   
    $result = doUnprotectedQuery("SELECT picture_id FROM pictures WHERE picture_filename='$projProfile'");
    if ($row = $result->fetch_assoc()) {
        $profileId = $row['picture_id'];
    } else {
        doUnprotectedQuery("INSERT INTO pictures (picture_filename) VALUES ('$projProfile')");
        $profileId = $link->insert_id;
    }
    
    $projBanner = str_replace("profile", "banner", $projProfile);
    $result = doUnprotectedQuery("SELECT picture_id FROM pictures WHERE picture_filename='$projBanner'");
    if ($row = $result->fetch_assoc()) {
        $bannerId = $row['picture_id'];
    } else {
        doUnprotectedQuery("INSERT INTO pictures (picture_filename) VALUES ('$projBanner')");
        $bannerId = $link->insert_id;
    }
   
    $result = doUnprotectedQuery("SELECT picture_id FROM pictures WHERE picture_filename='$projExample'");
    if ($row = $result->fetch_assoc()) {
        $exampleId = $row['picture_id'];
    } else {
        doUnprotectedQuery("INSERT INTO pictures (picture_filename) VALUES ('$projExample')");
        $exampleId = $link->insert_id;
    }
    
    $result = doUnprotectedQuery("SELECT project_id FROM projects WHERE project_village_id=$villageId AND project_name='$projName'") ;
    if ($row = $result->fetch_assoc()) {
        $projectId = $row['project_id'];
        doUnprotectedQuery("UPDATE projects SET project_budget=$projCost, project_staff_id=$foId, project_banner_image_id=$bannerId, project_profile_image_id=$profileId, project_similar_image_id=$exampleId, project_date_posted=STR_TO_DATE('$dateProjectPosted', '%m/%d/%Y'), project_lat=$lat, project_lng=$lng, project_summary='$summary', project_community_problem='$problem', project_community_solution='$solution', project_community_partners='$partners', project_impact='$impact', project_status='$status', project_type='$type', project_elapsed_days=$elapsedDays, project_people_reached=$peopleReached WHERE project_id=$projectId");
        invalidateCaches($projectId);
    } else {
        doUnprotectedQuery("INSERT INTO projects (project_id, project_village_id, project_name, project_lat, project_lng, project_budget, project_staff_id, project_banner_image_id, project_profile_image_id, project_similar_image_id, project_summary, project_community_problem, project_community_solution, project_community_partners, project_impact, project_funded, project_status, project_type, project_elapsed_days, project_people_reached) VALUES ($projId, $villageId, '$projName', $lat, $lng, $projCost, $foId, $bannerId, $profileId, $exampleId, '$summary', '$problem', '$solution', '$partners', '$impact', $funded, '$status', '$type', $elapsedDays, $peopleReached)");
        $projectId = $link->insert_id;
    }
    
    doUnprotectedQuery("DELETE FROM project_costs WHERE pc_project_id=$projectId");
    doUnprotectedQuery("INSERT INTO project_costs (pc_project_id, pc_label, pc_amount, pc_type) VALUES ($projectId, 'labor', $projLaborCost, 1)");
    doUnprotectedQuery("INSERT INTO project_costs (pc_project_id, pc_label, pc_amount, pc_type) VALUES ($projectId, 'materials', $projMaterialsCost, 2)");
    doUnprotectedQuery("INSERT INTO project_costs (pc_project_id, pc_label, pc_amount, pc_type) VALUES ($projectId, 'admin', $projAdminCost, 3)");
    doUnprotectedQuery("INSERT INTO project_costs (pc_project_id, pc_label, pc_amount, pc_type) VALUES ($projectId, 'transport', $projTransportCost, 4)");
    doUnprotectedQuery("INSERT INTO project_costs (pc_project_id, pc_label, pc_amount, pc_type) VALUES ($projectId, 'fees', $projFees, 5)");
    doUnprotectedQuery("INSERT INTO project_costs (pc_project_id, pc_label, pc_amount, pc_type) VALUES ($projectId, 'pics/data', $projDataPics, 6)");
    
    //doUnprotectedQuery("DELETE FROM project_events WHERE pe_project_id=$projectId");
    $row = doUnprotectedQuery("SELECT pe_id FROM project_events WHERE pe_project_id=$projectId");
    if ($row = $result->fetch_assoc()) {
    } else {
        doUnprotectedQuery("INSERT INTO project_events (pe_type, pe_date, pe_project_id) VALUES ((SELECT pet_id FROM project_event_types WHERE pet_label='Village Raises Cash Contribution' LIMIT 1), STR_TO_DATE('$dateCommunityContribution', '%m/%d/%Y'), $projectId)");
        doUnprotectedQuery("INSERT INTO project_events (pe_type, pe_date, pe_project_id) VALUES ((SELECT pet_id FROM project_event_types WHERE pet_label='Project Posted' LIMIT 1), STR_TO_DATE('$dateProjectPosted', '%m/%d/%Y'), $projectId)");
        if (strlen($dateProjectFunded) > 3) {
            doUnprotectedQuery("INSERT INTO project_events (pe_type, pe_date, pe_project_id) VALUES ((SELECT pet_id FROM project_event_types WHERE pet_label='Project Funded' LIMIT 1), STR_TO_DATE('$dateProjectFunded', '%m/%d/%Y'), $projectId)");
            doUnprotectedQuery("INSERT INTO project_events (pe_type, pe_date, pe_project_id) VALUES ((SELECT pet_id FROM project_event_types WHERE pet_label='Project Completed' LIMIT 1), STR_TO_DATE('$dateProjectCompleted', '%m/%d/%Y'), $projectId)");
        }
    }
    
    doUnprotectedQuery("DELETE FROM village_stats WHERE stat_village_id=$villageId AND (stat_type_id=18 OR stat_type_id=19) AND stat_year=$projYear");
    doUnprotectedQuery("INSERT INTO village_stats (stat_type_id, stat_village_id, stat_value, stat_year) VALUES (18, $villageId, $population, $projYear)");
    doUnprotectedQuery("INSERT INTO village_stats (stat_type_id, stat_village_id, stat_value, stat_year) VALUES (19, $villageId, $households, $projYear)");
}

include('getProjects.php');
include('getVillages.php');

?>