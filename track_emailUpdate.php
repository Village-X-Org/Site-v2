<?php
require_once("utilities.php");
$updateId = paramInt('id');
if (hasParam('send')) {
	if (!$session_is_admin || !$updateId) {
		die(1);
	}
	$stmt = prepare("UPDATE raw_updates SET ru_emailed=NOW() WHERE ru_id=?");
	$stmt->bind_param('i', $updateId);
	execute($stmt);
	$affected = $link->affected_rows;
	$stmt->close();
	if ($affected > 0) {
		$donorStmt = prepare("SELECT ru_project_id, donor_id, donor_email FROM raw_updates JOIN donations ON ru_id=? AND donation_project_id=ru_project_id JOIN donors ON donation_donor_id=donor_id WHERE donation_is_test=0 GROUP BY donor_id");
	    $donorStmt->bind_param("i", $updateId);
	    $donorResult = execute($donorStmt);
	    
	    while ($donorRow = $donorResult->fetch_assoc()) {
	        $donorId = $donorRow['donor_id'];
	        $donorEmail = $donorRow['donor_email'];
	        $projectId = $donorRow['ru_project_id'];
	        $type = EMAIL_TYPE_UPDATE;
	        ob_start();
	        include("email_content.php");
	        $output = ob_get_clean();
	        sendMail($donorEmail, "There's an update for one of the projects you've supported!", $output, getCustomerServiceEmail());
	    }
	    sendMail(getCustomerServiceEmail(), "There's an update for one of the projects you've supported!", $output, getCustomerServiceEmail());
	    recordProjectEmailDate($projectId);
	    print $output;
	} else {
		print $affected." records found";
	}
	die(0);
}
$count = paramInt('count');
$lastEmail = param('lastEmail');
$donorId = $session_donor_id;
$type = EMAIL_TYPE_UPDATE;

include('email_content.php');
print "<center><div style='width:600px;font-weight:bold;margin:20px;'>This update, with the title &quot;A new update has been added for one of your projects!&quot; will be emailed to $count donors. These donors were last emailed about this project on $lastEmail. <br/><br/><a href='track_emailUpdate.php?id=$updateId&send=true' style='font-size:20px;'>Send Emails</button></div></center>";

?>