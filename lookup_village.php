<?php
require_once("utilities.php");

$villageName = param('villageName');
$stmt = prepare("SELECT village_id, village_lat, village_lng FROM villages WHERE village_name=?");
$stmt->bind_param('s', $villageName);
$result = execute($stmt);
$rows = mysqli_fetch_all($result,MYSQLI_ASSOC);
print json_encode($rows);