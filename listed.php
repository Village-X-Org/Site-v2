<?php
require_once("utilities.php");

$result = doUnprotectedQuery("SELECT project_id, project_name, village_name, project_date_posted,
 project_budget, project_funded FROM projects JOIN villages ON project_village_id=village_id AND project_funded<project_budget - 1 ORDER BY project_date_posted asc");
while ($row = $result->fetch_assoc()) {
	$projectId = $row['project_id'];
	$projectName = $row['project_name'];
	$villageName = $row['village_name'];
	$datePosted = $row['project_date_posted'];
	$funded = $row['project_funded'];
	$budget = $row['project_budget'];

	print "<a href='project.php?id=$projectId'>$projectName in $villageName Village</a> - posted on $datePosted ($$funded out of $$budget)<br/>";
}
?>