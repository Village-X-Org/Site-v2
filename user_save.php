<?php
require_once("utilities.php");
$firstName = param('register_first_name');
$lastName = param('register_last_name');
$email = param('register_email');
$password = md5(param('register_password'));
$captcha = param('g-recaptcha-response');

if (!verifyRecaptcha($captcha)) {
	print "Google has decided you are a robot.  If you think this is an error, please tell the site administrator.";
    emailAdmin("Robot detected in login", "Someone tried to login with these parameters: FirstName: $firstName\n LastName: $lastName\n
    		Email: $email");
    die(1);
}

$stmt = prepare("SELECT donor_id FROM donors WHERE donor_email=?");
$stmt->bind_param('s', $email);
$result = execute($stmt);
if ($row = $result->fetch_assoc()) {
	print "This email is already in use.  Please try <a href='user_login.php'>logging in</a> or <a href=''>click here to request a password reset</a>";
	exit(1);
}
$stmt = prepare("INSERT INTO donors (donor_first_name, donor_last_name, donor_email, donor_password) VALUES (?, ?, ?, ?)");
$stmt->bind_param('ssss', $firstName, $lastName, $email, $password);
execute($stmt);
$stmt->close();

$_SESSION['donor_id'] = $session_donor_id = $id = $link->insert_id;
$session_first_name = $_SESSION['first_name'] = $firstName;
$session_last_name = $_SESSION['last_name'] = $lastName;
$session_email = $_SESSION['email'] = $email;

print 'success';

?>