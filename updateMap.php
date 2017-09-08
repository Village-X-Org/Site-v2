<?php
// NOT WORKING, USE SHELL SCRIPT INSTEAD
/*
include("getVillages.php");
include("getProjects.php");

function curlDataset($datasetId, $filename) {
    $url = "https://api.mapbox.com/datasets/v1/jdepree/$datasetId?access_token=".MAPBOX_API_KEY;
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type:application/json'
    ));
    
    $dataFile = curl_file_create($filename,'text','data');
    curl_setopt($ch, CURLOPT_POSTFIELDS,
        array(
            'data' => $dataFile
        )
    );
    $head = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch); 
    
    print "$url $httpCode\n$head\n\n";
}

curlDataset("cj7c0nlxf0yko33o7uz9pogof", "cached/villages.json");
curlDataset("cj7c0n3dl0ykf33o73m0pv5u6", "cached/projects.json");
*/
?>