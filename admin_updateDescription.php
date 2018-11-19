<?php
require_once("utilities.php");
if (isset($session_is_admin) && $session_is_admin && hasParam('newDescription')) {
	$id = param('id');
	$description = param('newDescription');
	$stmt = prepare("UPDATE raw_updates SET ru_description=? WHERE ru_id=?");
    $stmt->bind_param('si', $description, $id);
    execute($stmt);

	print "1";
} else {
	print "0";
}