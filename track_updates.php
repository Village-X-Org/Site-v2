<?php
require_once("utilities.php");

define('RECS_PER_PAGE', 20);

if (!isset($start)) {
	$projectId = $foId = $villageId = $start = 0; 
	if (hasParam('projectId')) {
		$projectId = paramInt('projectId');
	}
	if (hasParam('foId')) {
		$foId = paramInt('foId');
	}
	if (hasParam('villageId')) {
		$villageId = paramInt('villageId');
	}
	if (hasParam('start')) {
		$start = paramInt('start');
	}
	$putInVar = 0;
} else {
	$putInVar = 1;
}

    $result = doUnprotectedQuery("SELECT project_id, village_id, ru_id, ru_description, ru_project_id, ru_picture_ids,
    	UNIX_TIMESTAMP(ru_date) AS timestamp, ru_lat, ru_lng, project_lat, project_lng, project_name, village_name, project_staff_id, 
    	fo_first_name, fo_last_name, fo_color FROM raw_updates JOIN projects 
    	ON ru_project_id=project_id JOIN villages ON village_id=project_village_id JOIN field_officers ON project_staff_id=fo_id " 
    	.($projectId ? "AND project_id=$projectId" : ($foId ? "AND project_staff_id=$foId" : ($villageId ?  "AND village_id=$villageId" : "")))
    	." ORDER BY ru_date DESC LIMIT $start, ".(RECS_PER_PAGE + 1));

    $updates = array();
    $count = $hasMore = 0;
    while ($row = $result->fetch_assoc()) {
    	if (++$count == RECS_PER_PAGE) {
    		$hasMore = 1;
    		break;
    	}
        $pictureIds = $row['ru_picture_ids'];
        $pictureIds = substr($pictureIds, 1, -1);
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

        $lastProjectId = $nextProjectId;
        array_push($updates, array("update_id"=>$updateId, "project_id"=>$nextProjectId, "project_name"=>$projectName, "village_name"=>$villageName, "staff"=>$foName, 
        	"picture_ids"=>$pictureIds, "timestamp"=>$timestamp, "lat"=>$lat, "lng"=>$lng, "timestamp"=>$timestamp, "description"=>$description));
    }
    if (!$putInVar) {
    	print json_encode(array("has_more_records"=>$hasMore, "updates"=>$updates));
    }
   ?>