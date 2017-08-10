<?php
require_once("utilities.php");

$fptr = fopen('data/comp_score.csv', 'r');
$labels = fgetcsv($fptr);
while ($statRow = fgetcsv($fptr)) {
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
}
?>
