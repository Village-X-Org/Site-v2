<?php 
	require_once("utilities.php");
	if (isset($session_is_admin) && $session_is_admin) {
		$id = param('id');
		doUnprotectedQuery("DELETE FROM proposed_villages WHERE pv_id=$id");
		if ($link->affected_rows > 0) {
			print "Successfully deleted.  But the icon will stick around till the next page load.";
		} else {
			print "Looks like this proposal has already been deleted.";
		}
  		include("generateProposedJson.php");
	} else {
		print "Failed to delete proposal";
	}
?>