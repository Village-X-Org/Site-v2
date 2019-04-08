<?php
require_once("utilities.php");

$file = fopen("cached/villageInfo.json","w");
$count = 0;
$result = doUnprotectedQuery("SELECT village_id, village_name, village_lat, village_lng, SUM(IF(project_status='funding', 1, 0)) AS fundingCount, SUM(IF(project_status='completed', 1, 0)) AS completedCount, SUM(IF(project_status='construction', 1, 0)) AS constructionCount FROM villages JOIN projects ON project_status<>'cancelled' AND village_pending=0 AND project_village_id=village_id GROUP BY village_id");
while ($row = $result->fetch_assoc()) {
    $funding = $row['fundingCount'];
    $completed = $row['completedCount'];
    $construction = $row['constructionCount'];
    
	fwrite($file, ($count > 0 ? "," : '[').
	'{
		"id": "'.$row['village_id'].'",
		"name": "'.$row['village_name'].'",
		"lat": "'.$row['village_lat'].'",
		"lng": "'.$row['village_lng'].'",
		"project_summary": "'.($funding > 0 ? "$funding in funding" : "")
		.($completed > 0 ? ($funding > 0 ? ", " : "")."$completed completed" : "")
		.($construction > 0 ? ($funding + $completed > 0 ? ", " : "")."$construction under construction" : "")
	.'"}');
	$count++;
}
fwrite($file, "]");
fclose($file);
?>