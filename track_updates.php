<?php
require_once("utilities.php");

$start = param('start');
$projectId = $foId = $villageId = 0; 
if (hasParam('projectId')) {
	$projectId = param('projectId');
}
if (hasParam('foId')) {
	$foId = param('foId');
}
if (hasParam('villageId')) {
	$villageId = param('villageId');
}

    $result = doUnprotectedQuery("SELECT project_id, village_id, picture_id, picture_filename, ru_id, ru_description, ru_project_id, 
    	UNIX_TIMESTAMP(ru_date) AS timestamp, ru_lat, ru_lng, project_lat, project_lng, project_name, village_name, project_staff_id, 
    	fo_first_name, fo_last_name, fo_color FROM pictures JOIN raw_updates ON ru_picture_ids LIKE CONCAT('%,', picture_id,',%') JOIN projects 
    	ON ru_project_id=project_id JOIN villages ON village_id=project_village_id JOIN field_officers ON project_staff_id=fo_id 
    	WHERE ru_date > $latestDate " 
    	.($projectId ? "AND project_id=$projectId" : ($foId ? "AND project_staff_id=$foId" : ($villageId ?  "AND village_id=$villageId" : "")))
    	." ORDER BY ru_date DESC LIMIT 50 START $start");

    $coordsCode = "var coords = [ ";
    $pathsCode = "";
    $lastProjectId = $lastPictureId = $lastLat = $lastLng = $lastFoId = $lastUpdateId = $earliestDate = $latestDate = 0;
    $pictures = array();
    $avgLat = 0;
    $avgLng = 0;
    $coordCount = 0;
    while ($row = $result->fetch_assoc()) {
        $pictureId = $row['picture_id'];
        $filename = $row['picture_filename'];
        $lat = $row['ru_lat'];
        $lng = $row['ru_lng'];
        if ($lat == 0) {
            $lat = $row['project_lat'];
            $lng = $row['project_lng'];
        }
        $description = $row['ru_description'];
        $foId = $row['project_staff_id'];
        $foName = $row['fo_first_name'].' '.$row['fo_last_name'];
        $nextProjectId = $row['project_id'];
        $projectName = $row['project_name'];
        $villageName = $row['village_name'];
        $color = $row['fo_color'];
        $updateId = $row['ru_id'];

        $timestamp = $row['timestamp'];
        if ($latestDate == 0 || $timestamp > $latestDate) {
            $latestDate = strtotime(date('d-m-Y H:i:s', strtotime('today', $timestamp + (24 * 60 * 60))));
        }
        if ($earliestDate == 0 || $timestamp < $earliestDate) {
            $earliestDate = $timestamp;
        }

        if ($updateId == $lastUpdateId) {
            $description = '';
        }
        $title = "$projectName in $villageName ($foName)";
        $lastProjectId = $nextProjectId;
        array_push($pictures, array($pictureId, $timestamp, $filename, $lat, $lng, $timestamp, $foId, $description, $nextProjectId, $title));

        $lastPictureId = $pictureId;
        $lastFoId = $foId;
        $lastUpdateId = $updateId;
    }
    print json_encode($pictures);
   ?>