<?php
	require_once("utilities.php");
	$email = param('email');
	$stmt = prepare("SELECT donor_id, donor_password FROM donors WHERE donor_email=?");
	$result = $stmt->bind_param('s', $email);
	if ($row = $result->fetch_assoc()) {
		$id = $row['donor_id'];
		$code = md5($email.$password);

		sendMail($email, "Password Reset Requested", "A password reset has been requested for your account.  
			If you did not ask for a reset, please ignore this.\n\nClick the link below to reset your password.\n\n
			https://villagex.org/user_setNewPassword.php?email=$email&code=$code\n\nThe Village X Team", getCustomerServiceEmail());
	} else {
		print "failure";
	}
?>