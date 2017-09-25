<?php
require_once("utilities.php");
require_once("utility_readSheets.php");

$spreadsheetId = '1mq2wXXs4JbOFj7n8oacs2NAFFwMQ5ZuLl2ZmW742rlI';
$range = 'project_updates_new_site!A:E';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$sheet = $response->getValues();

$rowCount = 0;
foreach ($sheet as $updateRow) {
    if ($rowCount++ == 0) {
        continue;
    }
	$updateId = $updateRow[0];
	$projectId = $updateRow[1];
	$filename = $updateRow[2];
	$lastSlash = strrpos($filename, '/');
	$filename = substr($filename, $lastSlash + 1);
	$date = $updateRow[3];
	$description = '';
	if (isset($updateRow[4])) {
	   $description = addslashes($updateRow[4]);
	}
    
    $result = doQuery("SELECT picture_id FROM pictures WHERE picture_filename='$filename'");
    if ($row = $result->fetch_assoc()) {
    		$pictureId = $row['picture_id'];
    	} else {
    	    doQuery("INSERT INTO pictures (picture_filename) VALUES ('$filename')");
    		print "Missing picture id for $filename\n";
    		$pictureId = $link->insert_id;
    	} 
    
    if ($updateId) {
    		$result = doQuery("UPDATE project_updates SET pu_project_id=$projectId, pu_image_id=$pictureId, pu_timestamp=DATE('$date'), pu_description='$description' WHERE pu_id=$updateId");
    	} else {
    		$result = doQuery("INSERT INTO project_updates (pu_project_id, pu_image_id, pu_timestamp, pu_description) VALUES ($projectId, $pictureId, DATE('$date'), '$description')");
    		$updateId = $link->insert_id;
    		print $updateId."\n";
    	}

}

?>
