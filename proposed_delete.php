<?php
	require_once("utilities.php");
	if (!$session_is_admin) {
		print "You must be logged in to manage proposals.";
		die(0);
	}

	$id = param('id');
	doUnprotectedQuery("DELETE FROM proposed_villages WHERE pv_id=$id");
	if ($link->affected_rows > 0) {
		print "Successfully deleted.  But the icon will stick around till the next page load.";
	} else {
		print "Looks like this proposal has already been deleted.";
	}
	include("generateProposedJson.php");
?>