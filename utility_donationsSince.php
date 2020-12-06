<?php
require_once("utilities.php");
if (!hasParam('since')) {
	$since = 0;
} else {
	$since = paramInt('since');
}
if (isset($session_is_admin) && $session_is_admin) {

	$stmt = prepare("SELECT donation_id, donor_email, donor_first_name, donor_last_name, 
	        donation_amount, donation_date, donation_project_id, donation_subscription_id, donation_matched_to FROM donations 
	        JOIN donors ON donation_donor_id=donor_id WHERE donation_id>? ORDER BY donation_date DESC");
	$stmt->bind_param('i', $since);
	$result = execute($stmt);
	print "<pre>";
	while ($row = $result->fetch_assoc()) {
	    print $row['donation_id'].",".$row['donor_email'].",".$row['donor_first_name'].",".$row['donor_last_name'].",".$row['donation_amount']
	            .",".$row['donation_date'].",".$row['donation_project_id'].",".$row['donation_subscription_id'].",".$row['donation_matched_to']."\n";
	}
	print "</pre>";
	$stmt->close();

} else {
	print "Login with your admin account first";
}

?>