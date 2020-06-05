<?php
require_once("utilities.php");

$result = doUnprotectedQuery("SELECT project_id, project_name, village_name, pe2.pe_date AS maxDate, fo_first_name, fo_last_name, DATEDIFF(pe2.pe_date, pe1.pe_date) AS diff FROM projects JOIN project_events pe1 ON pe1.pe_project_id=project_id AND pe1.pe_type=3 JOIN project_events pe2 ON pe2.pe_project_id=project_id AND pe2.pe_type=4 JOIN villages ON project_village_id=village_id JOIN field_officers ON project_staff_id=fo_id ORDER BY diff DESC");

while ($row = $result->fetch_assoc()) {
	$date = strtotime($row['maxDate']);
	$foName = $row['fo_first_name'].' '.$row['fo_last_name'];
	print "<p>{$row['diff']} days elapsed - <a target='_blank' href='{$row['project_id']}'>{$row['project_name']}</a> in {$row['village_name']}, 
			funded on ".date('M j', $date)." (".$foName.")</p>";
}

?>