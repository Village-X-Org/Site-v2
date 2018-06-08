<?php
	require_once("utilities.php");
	$email = param('email');
	$stmt = prepare("SELECT donor_id, donor_email, donor_password FROM donors WHERE donor_email=?");
	$stmt->bind_param('s', $email);
	$result = execute($stmt);
	if ($row = $result->fetch_assoc()) {
		$id = $row['donor_id'];
		$code = md5($row['donor_email'].$row['donor_password']);

		sendMail($email, "Password Reset Requested", "A password reset has been requested for your account.  
			If you did not ask for a reset, please ignore this.\n\nClick the link below to reset your password.\n\n
			https://villagex.org/user_forgot_password.php?id=$id&code=$code\n\nThe Village X Team", getCustomerServiceEmail());
		print "success";
	} else {
		print "failure";
	}
?>