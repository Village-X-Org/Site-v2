<?php
require_once("utilities.php");
$email = param('login_email');
$password = md5(param('login_password'));
$captcha = param('g-recaptcha-response');

if (!verifyRecaptcha($captcha)) {
	print "Google has decided you are a robot.  If you think this is an error, please tell the site administrator.";
    emailAdmin("Robot detected in login", "Someone tried to login with these parameters: FirstName: $firstName\n LastName: $lastName\n
    		Email: $email");
    die(1);
}

$stmt = prepare("SELECT donor_id, donor_first_name, donor_last_name, donor_email FROM donors WHERE donor_email=? AND donor_password=?");
$stmt->bind_param('ss', $email, $password);
$result = execute($stmt);
if ($row = $result->fetch_assoc()) {
	$session_donor_id = $_SESSION['donor_id'] = $row['donor_id'];
	$session_first_name = $_SESSION['first_name'] = $row['donor_first_name'];
	$session_last_name = $_SESSION['last_name'] = $row['donor_last_name'];
	$session_email = $_SESSION['email'] = $row['donor_email'];
	print 'success';
} else {
	print 'Username or password incorrect';
}
?>