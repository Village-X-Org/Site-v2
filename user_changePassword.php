<?php
require_once("utilities.php");

$id = param('id');
$code = param('code');
$newPassword = md5(param('newPassword'));

if (strlen($code) < 8) {
	print "Code is too short";
	die(0);
}
$stmt = prepare("UPDATE donors SET donor_password=? WHERE donor_id=? AND substr(md5(concat(donor_email, donor_password)), 0, 8)=substr(?, 0, 8)");
$stmt->bind_param('sis', $newPassword, $id, $code);
execute($stmt);
if ($link->affected_rows > 0) {
	$stmt = prepare("SELECT donor_id, donor_first_name, donor_last_name, donor_email, donor_is_admin FROM donors WHERE donor_id=?");
	$stmt->bind_param('i', $id);
	$result = execute($stmt);
	if ($row = $result->fetch_assoc()) {
		$session_donor_id = $_SESSION['donor_id'] = $row['donor_id'];
		$session_first_name = $_SESSION['first_name'] = $row['donor_first_name'];
		$session_last_name = $_SESSION['last_name'] = $row['donor_last_name'];
		$session_is_admin = $_SESSION['is_admin'] = $row['donor_is_admin'];
		$session_email = $_SESSION['email'] = $row['donor_email'];
		include('user_profile.php');
	}
} else {
	print "Bad code or password unchanged";
}
