<?php
require_once("utilities.php");
$firstName = param('register_first_name');
$lastName = param('register_last_name');
$email = param('register_email');
$password = md5(param('register_password'));

$stmt = prepare("SELECT donor_id FROM donors WHERE donor_email=?");
$stmt->bind_param('s', $email);
$result = execute($stmt);
if ($row = $result->fetch_assoc()) {
	print "This email is already in use.  Please try <a href='user_login.php'>logging in.</a>";
	exit(1);
}
$stmt = prepare("INSERT INTO donors (donor_first_name, donor_last_name, donor_email, donor_password) VALUES (?, ?, ?, ?)");
$stmt->bind_param('ssss', $firstName, $lastName, $email, $password);
execute($stmt);
$stmt->close();

$id = $link->insert_id;

header("Location: user_profile.php?id=".$id);

?>