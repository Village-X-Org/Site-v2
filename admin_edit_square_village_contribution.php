<?php
require_once("utilities.php");
if ($session_is_admin) {
	$id = paramInt('id');
	$result = doUnprotectedQuery("SELECT project_budget, project_funded, project_community_contribution, SUM(donation_amount) AS donationSum FROM ((SELECT project_budget, project_funded, project_community_contribution, SUM(donation_amount) AS donation_amount FROM projects LEFT JOIN donations ON project_id=donation_project_id WHERE project_id=$id) UNION (SELECT project_budget, project_funded, project_community_contribution, SUM(sd_amount) AS donation_amount FROM projects LEFT JOIN subscription_disbursals ON project_id=sd_project_id WHERE project_id=$id)) AS tableC");
	if ($row = $result->fetch_assoc()) {
		$budget = $row['project_budget'];
		$funded = $row['project_funded'];
		$communityContribution = $row['project_community_contribution'];
		$donationSum = $row['donationSum'];

		$community = $budget * $communityContribution / 100;
		$funded = $community + $donationSum;

		doUnprotectedQuery("UPDATE projects SET project_funded=$funded WHERE project_id=$id");
	}

	print "$$funded raised, $".($budget - $funded)." to go";
 } else {
 	print "please log in";
 }