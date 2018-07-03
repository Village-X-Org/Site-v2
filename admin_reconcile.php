<?php
require_once("utilities.php");

if ($session_is_admin) {
	if (hasParam('update')) {
		$updateId = paramInt('update');
		$amount = param('amount');
	}
	$result = doUnprotectedQuery("SELECT project_id, project_name, project_funded * .9 AS amountReported, 
		SUM(donation_amount) AS donations FROM projects JOIN donations ON donation_project_id=project_id 
		GROUP BY project_id HAVING donations < amountReported");
	while ($row = $result->fetch_assoc()) {
		$projectId = $row['project_id'];
		$projectName = $row['project_name'];
		$amountReported = $row['amountReported'];
		$donations = $row['donations'];
		$deficiency = $amountReported - $donations;
		print "$projectId\t$projectName\t$amountReported\t$donations\t(-$deficiency)\t<form method='post' target='admin_reconcile.php'>
				\t<input type='hidden' name='update' value='$projectId' /><input type='text' name='amount' value='0' /><p/>";
	}
} else {
	print "You do not have permission to perform this operation.";
}