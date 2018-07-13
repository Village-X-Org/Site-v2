<?php
require_once("utilities.php");

print "<HTML><HEAD><style>td { vertical-align:top; }</style></HEAD><BODY><TABLE cellpadding='5'>";
if (isset($session_is_admin) && $session_is_admin) {
	if (hasParam('update')) {
		$projectId = paramInt('update');
		$amount = param('amount');
		$date = date('Y-m-d', strtotime(param('date')));
		$userId = param('userId');

		$stmt = prepare("INSERT INTO donations (donation_donor_id, donation_amount, donation_date, donation_project_id) 
			VALUES (?, ?, ?, ?)");
		$stmt->bind_param("iisi", $userId, $amount, $date, $projectId);
		execute($stmt);
	}
	$surpluses = 0;
	$deficiencies = 0;
	$result = doUnprotectedQuery("SELECT project_id, project_name, project_funded - (project_budget * .05) AS amountReported, 
		SUM(donation_amount) AS donations, GROUP_CONCAT(donor_id) AS donorIds, 
		GROUP_CONCAT(CONCAT(donor_first_name,' ',donor_last_name)) AS donorNames, 
		GROUP_CONCAT(donation_amount) AS donationAmounts, GROUP_CONCAT(donation_date) AS donationDates,
		MAX(donation_date) as maxDate 
		FROM projects JOIN donations ON donation_project_id=project_id 
		JOIN donors ON donor_id=donation_donor_id WHERE donation_is_test=0
		GROUP BY project_id ORDER BY maxDate DESC");
	while ($row = $result->fetch_assoc()) {
		$projectId = $row['project_id'];
		$projectName = $row['project_name'];
		$amountReported = $row['amountReported'];
		$donations = round($row['donations']);
		$donorIds = explode(',', $row['donorIds']);
		$donorNames = explode(',', $row['donorNames']);
		$donationAmounts = explode(',', $row['donationAmounts']);
		$donationDates = explode(',', $row['donationDates']);

		array_multisort($donationAmounts, SORT_DESC, $donorIds, $donorNames, $donationDates);
		$surplus = $donations - $amountReported;
		if ($surplus > 0) {
			$surpluses += $surplus;
		} else {
			$deficiencies -= $surplus;
		}
		print "<TR><TD>$projectId</TD><TD>$projectName</TD><TD>$$amountReported</TD><TD><b>$$donations</b>";	
		for ($i = 0; $i < count($donorNames); $i++) {
			print "<br/>".$donorIds[$i]." ".$donorNames[$i]." \$".$donationAmounts[$i]." ".$donationDates[$i];
		}
		print "</TD><TD ".($surplus < 0 ? "style='color:red;'" : "").">($$surplus)
				</TD><TD><form method='post' target='admin_reconcile.php'>
				<input type='hidden' name='update' value='$projectId' />
				User id: <input type='text' name='userId' size='4' />
				Donation amount: <input type='text' name='amount' size='4' />
				Donation date: <input type='text' name='date' size='6' />
				<input type='submit' value='Submit Donation' /></form></TD></TR>";
	}
	print "<P>Surpluses: $$surpluses &nbsp;&nbsp;&nbsp;Deficiencies: $$deficiencies";
} else {
	print "You do not have permission to perform this operation.";
}
print "</TABLE></BODY></HTML>";