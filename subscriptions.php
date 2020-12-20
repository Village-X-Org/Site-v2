<?php
require_once("utilities.php");

if (!$session_is_admin) {
	return;
}
print "<table>";
$result = doUnprotectedQuery("SELECT donor_id, donor_first_name, donor_last_name, sd_amount, SUM(sd_amount) AS total, MAX(sd_timestamp) AS latest, GROUP_CONCAT(project_id) AS projects FROM donations JOIN donors ON donation_subscription_id IS NOT NULL AND donation_amount=0 AND donation_donor_id=donor_id JOIN subscription_disbursals ON sd_donor_id=donor_id JOIN projects ON sd_project_id=project_id GROUP BY sd_donor_id ORDER BY latest DESC");
while ($row = $result->fetch_assoc()) {
	$donorId = $row['donor_id'];
	$donorName = $row['donor_first_name'].' '.$row['donor_last_name'];
	$amount = $row['total'];
	$last = $row['latest'];

	$next = doUnprotectedQuery("SELECT project_id, project_name, village_name, project_budget - project_funded AS remaining, COUNT(sd_project_id) AS disbursalCount, p1.project_type, IFNULL(typeCount, 0) FROM projects AS p1 LEFT JOIN (SELECT project_type, COUNT(project_id) AS typeCount FROM subscription_disbursals JOIN projects ON sd_project_id=project_id AND sd_donor_id=$donorId GROUP BY project_type) AS types ON types.project_type=p1.project_type JOIN villages ON project_village_id=village_id LEFT JOIN subscription_disbursals ON project_id=sd_project_id AND sd_donor_id=$donorId WHERE project_funded<project_budget GROUP BY project_id ORDER BY disbursalCount ASC, typeCount ASC, project_date_posted ASC, remaining ASC");
	if ($rowNext = $next->fetch_assoc()) {
		print "<tr><td>$donorName</td><td>$$amount</td><td>$last</td><td>".$rowNext['project_name'].' for '.$rowNext['village_name']."</td></tr>";
	}
}
print "</table>";
