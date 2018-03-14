<?php
	require_once("../utilities.php");	
	print cached('villages.json', doJsonQuery("SELECT village_id, village_name, village_lat, village_lng FROM villages"));
?>
