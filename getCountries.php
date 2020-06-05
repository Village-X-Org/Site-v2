<?php
require_once("utilities.php");

$file = fopen("cached/countries.json","w");
$count = 0;
$result = doUnprotectedQuery("SELECT country_id, country_label, country_latitude, country_longitude, country_zoom, country_bounds_sw_lat, country_bounds_sw_lng, country_bounds_ne_lat, country_bounds_ne_lng FROM countries JOIN villages ON village_country=country_id GROUP BY country_id");
while ($row = $result->fetch_assoc()) {
    $countryId = $row['country_id'];
    $countryLabel = $row['country_label'];
    $lat = $row['country_latitude'];
    $lng = $row['country_longitude'];
    $zoom = $row['country_zoom'];
    $swLat = $row['country_bounds_sw_lat'];
    $swLng = $row['country_bounds_sw_lng'];
    $neLat = $row['country_bounds_ne_lat'];
    $neLng = $row['country_bounds_ne_lng'];
    
	fwrite($file, ($count > 0 ? "," : '{ "type": "FeatureCollection", "features": [').
	'{
		"type": "Feature",
		"geometry": {
			"type": "Point",
			"coordinates": ['.$lng.', '.$lat.']
		},
		"properties": {
			"id": "'.$countryId.'",
			"name": "'.$countryLabel.'",
			"zoom": "'.$zoom.'",
			"boundsSwLat": "'.$swLat.'",
			"boundsSwLng": "'.$swLng.'",
			"boundsNeLat": "'.$neLat.'",
			"boundsNeLng": "'.$neLng.'" 
		}
	}');
	$count++;
}
fwrite($file, "]}");
fclose($file);
?>