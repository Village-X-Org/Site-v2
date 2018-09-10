<?php
require_once("utilities.php");

$result = doUnprotectedQuery("SELECT project_id, project_name, village_name, MAX(pe_date) AS maxDate, MAX(pe_type) AS maxType 
	FROM projects JOIN villages ON project_village_id=village_id 
	JOIN project_events ON pe_project_id=project_id GROUP BY project_id HAVING maxType=3 ORDER BY maxDate ASC");

while ($row = $result->fetch_assoc()) {
	$date = strtotime($row['maxDate']);
	$diff = round((time() - $date) / (24 * 60 * 60));
	print "<p>$diff days elapsed - <a target='_blank' href='{$row['project_id']}'>{$row['project_name']}</a> in {$row['village_name']}, 
			funded on ".date('M j', $date)."</p>";
}
?>