<?php
	require_once("utilities.php");
	if (!hasParam('email')) {
		return;
	}
	$email = param('email');
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return;
	}
	$stmt = prepare("SELECT donor_id, donor_email, donor_password FROM donors WHERE donor_email=?");
	$stmt->bind_param('s', $email);
	$result = execute($stmt);
	if ($row = $result->fetch_assoc()) {
		$id = $row['donor_id'];
		$code = md5($row['donor_email'].$row['donor_password']);

		sendMail($email, "Password Reset Requested", "A password reset has been requested for your account.  
			If you did not ask for a reset, please ignore this.<br/><a href='https://villagex.org/reset/$id/$code'>Reset my password</a><br/><br/>The Village X Team", 
			getCustomerServiceEmail());
		print "success";
	} else {
		print "failure";
	}
?>
