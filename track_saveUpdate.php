<?php
require_once("utilities.php");
$updateId = paramInt('updateId');
$content = param('updateContent');

if (!$session_is_admin) {
	print "Please login before attempting to edit updates.";
	die(1);
}

$stmt = prepare("UPDATE raw_updates SET ru_description=? WHERE ru_id=?");
$stmt->bind_param('sd', $content, $updateId);
execute($stmt);

$content = stripslashes(str_replace("\\r\\n", "\n", $content));
?>