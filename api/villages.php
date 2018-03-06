<?php
	require_once("../utilities.php");

	if (!file_exists("villages.json")) {
		$result = doUnprotectedQuery("SELECT village_name, village_lat, village_lng FROM villages");
		$buffer = "[";
		$count	= 0;
		while ($row = $result->fetch_assoc()) {
			if ($count > 0) {
				$buffer .= ",\n";
			}
			$buffer .= "{\"name\": \"{$row['village_name']}\",
				\"lat\": \"{$row['village_lat']}\",
				\"lng\": \"{$row['village_lng']}\"}";
			$count++;	 
		}
		$buffer .= "]";
		
		$handle = fopen('villages.json', 'w');
		fwrite($handle, $buffer);
		fclose($handle);
	}
	print file_get_contents('villages.json');
	
?>
