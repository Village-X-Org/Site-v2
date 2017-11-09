<?php
require_once("utilities.php");
$username = param('username');
$password = md5(param('password'));
$newPassword = md5(param('newPassword'));

$stmt = prepare("SELECT user_id FROM users WHERE user_username=? AND user_password=?");
$stmt->bind_param('ss', $username, $password);
$result = execute($stmt);
if ($row = $result->fetch_assoc()) {
    $userId = $row['user_id'];
    $stmt = prepare("UPDATE users SET user_password=? WHERE user_id=?");
    $stmt->bind_param('si', $newPassword, $userId);
} else {
    print "You are not authorized to perform this action.";
}