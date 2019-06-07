<?php
require_once("utilities.php");
$updateId = paramInt('updateId');
$content = param('updateContent');
$title = param('updateTitleEdit');

if (!$session_is_admin) {
	print "Please login before attempting to edit updates.";
	die(1);
}

$stmt = prepare("UPDATE raw_updates SET ru_description=?, ru_title=? WHERE ru_id=?");
$stmt->bind_param('ssd', $content, $title, $updateId);
execute($stmt);

$content = stripslashes(str_replace("\\r\\n", "\n", $content));
?>