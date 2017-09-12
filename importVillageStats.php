<?php
require_once("utilities.php");
require_once("utility_readSheets.php");

$spreadsheetId = '1UInm1feS27-iZz6TTZEZvP_1yY4VrW8psqrm7ZBPskc';
$range = 'CompScore!A1:AC97';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$sheet = $response->getValues();

$rowCount = 0;
foreach ($sheet as $statRow) {
    if ($rowCount == 0) {
        $labels = $statRow;
        continue;
    }
    $village = $statRow[1];
    $year = $statRow[2];
    
    $result = doQuery("SELECT village_id FROM villages WHERE village_name='$village'");
    if ($row = $result->fetch_assoc()) {
        $villageId = $row['village_id'];
    } else {
        print "Village $village missing\n";
        continue;
    }
    
    for ($j = 3; $j < count($statRow); $j++) {
        $typeId = 0;
        $result = doQuery("SELECT st_id FROM stat_types WHERE st_label='{$labels[$j]}'");
        if ($row = $result->fetch_assoc()) {
            $typeId = $row['st_id'];
        }
        $result = doQuery("SELECT stat_id FROM village_stats WHERE stat_type_id=$typeId AND stat_village_id=$villageId AND stat_year=$year");
        if ($row = $result->fetch_assoc()) {
            $statId = $row['stat_id'];
            doQuery("UPDATE village_stats SET stat_value={$statRow[$j]} WHERE stat_id=$statId");
        } else {
            doQuery("INSERT INTO village_stats (stat_type_id, stat_village_id, stat_value, stat_year) VALUES ($typeId, $villageId, {$statRow[$j]}, $year)");
        }
    }
    
    $rowCount++;
}

?>
