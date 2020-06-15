<?php
require_once("utilities.php");

if (!isset($email)) {
	$email = param('login_email');
}
if (!isset($password)) {
	$password = md5(param('login_password'));

	$captcha = param('g-recaptcha-response');
	if (!verifyRecaptcha3($captcha, 'userCheck')) {
		print "Google has decided you are a robot.  If you think this is an error, please tell the site administrator, or maybe just try again.";
	    emailAdmin("Robot detected in login", "Someone tried to login with these parameters: Email: $email");
	    die(1);
	}
}

$stmt = prepare("SELECT donor_id, donor_first_name, donor_last_name, donor_email, donor_is_admin FROM donors WHERE donor_email=? AND donor_password=?");
$stmt->bind_param('ss', $email, $password);
$result = execute($stmt);
if ($row = $result->fetch_assoc()) {
	$session_donor_id = $_SESSION['donor_id'] = $row['donor_id'];
	$session_first_name = $_SESSION['first_name'] = $row['donor_first_name'];
	$session_last_name = $_SESSION['last_name'] = $row['donor_last_name'];
	$session_email = $_SESSION['email'] = $row['donor_email'];
	$session_is_admin = $_SESSION['is_admin'] = $row['donor_is_admin'];

	setcookie ( "username", $email, time () + (60 * 60 * 24 * 30) );
	setcookie ( "password", $password, time () + (60 * 60 * 24 * 30) );
	if (!isset($hideOutput)) {
		print "success";
	}
} else {
	if (!isset($hideOutput)) {
		print "user with email $email not found";
	}
}
?>