<?php
require_once("utilities.php");
$projectId = $foId = 0;
if (hasParam('projectId')) {
    $projectId = paramInt('projectId');
}
if (hasParam('foId')) {
    $foId = paramInt('foId');
}
?>
<HTML>
<HEAD><TITLE>Village X Project Tracker</TITLE>
<meta name="viewport" content="width=640">
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.46.0/mapbox-gl.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.46.0/mapbox-gl.css' rel='stylesheet' />
<script src='<?php print BASE_URL; ?>/scripts/mapbox_polyline.js'></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta property="og:type" content="website" />
<meta property="og:image" content="https://villagex.org/images/villagemtg.jpg"/>
<meta property="og:title" content="Village X Project Tracking"/>
<meta property="og:url" content="<?php print getBaseURL()."/track.php"; ?>" />
<meta property="og:description" content="Follow our field officers as they visit our village partners and report on project progress"/>
</HEAD>
<BODY style='margin-top:0px;position:relative;'>
<TABLE style="width:100%;height:100%;margin-left:30px;position:fixed;" cellpadding='0'>
<TR >
<?php 
    $result = doUnprotectedQuery("SELECT project_id, picture_id, picture_filename, ru_id, ru_description, ru_project_id, UNIX_TIMESTAMP(ru_date) AS timestamp, ru_lat, ru_lng, project_lat, project_lng, project_name, village_name, project_staff_id, fo_first_name, fo_last_name, fo_color FROM pictures JOIN raw_updates ON ru_picture_ids LIKE CONCAT('%,', picture_id,',%') JOIN projects ON ru_project_id=project_id JOIN villages ON village_id=project_village_id JOIN field_officers ON project_staff_id=fo_id ".($projectId ? "WHERE project_id=$projectId" : ($foId ? "WHERE project_staff_id=$foId" : ""))." ORDER BY fo_id, ru_date DESC");

    $coordsCode = "var coords = [ ";
    $pathsCode = "";
    $lastProjectId = $lastPictureId = $lastLat = $lastLng = $lastFoId = $lastUpdateId = $earliestDate = $latestDate = 0;
    $pictures = array();
    $avgLat = 0;
    $avgLng = 0;
    $coordCount = 0;
    while ($row = $result->fetch_assoc()) {
        $pictureId = $row['picture_id'];
        $filename = $row['picture_filename'];
        $lat = $row['ru_lat'];
        $lng = $row['ru_lng'];
        if ($lat == 0) {
            $lat = $row['project_lat'];
            $lng = $row['project_lng'];
        }
        $description = $row['ru_description'];
        $foId = $row['project_staff_id'];
        $foName = $row['fo_first_name'].' '.$row['fo_last_name'];
        $projectId = $row['project_id'];
        $projectName = $row['project_name'];
        $villageName = $row['village_name'];
        $color = $row['fo_color'];
        $updateId = $row['ru_id'];

        $timestamp = $row['timestamp'];
        if ($latestDate == 0 || $timestamp > $latestDate) {
            $latestDate = strtotime(date('d-m-Y H:i:s', strtotime('today', $timestamp + (24 * 60 * 60))));
        }
        if ($earliestDate == 0 || $timestamp < $earliestDate) {
            $earliestDate = $timestamp;
        }

        if ($updateId == $lastUpdateId) {
            $description = '';
        }
        $title = "$projectName in $villageName ($foName)";
        $lastProjectId = $projectId;
        array_push($pictures, array($pictureId, $timestamp, $filename, $lat, $lng, $timestamp, $foId, $description, $projectId, $title));

        if ($lat == 0) {
            if ($lastLat == 0 && $foId != $lastFoId) {
                continue;
            }
            $lat = $lastLat;
            $lng = $lastLng;
        } else {
            if ($lastLat != 0 && $foId == $lastFoId && $lastUpdateId != $updateId && $lastLat != $lat) {
                $encoded = getPath($foId, $lastUpdateId, $lastLat, $lastLng, $updateId, $lat, $lng);

                if ($encoded) {
                    $pathsCode .= "map.addLayer({
                                        \"id\": \"LineString$pictureId\",
                                        \"type\": \"line\",
                                        \"source\": {
                                            \"type\": \"geojson\",
                                            \"data\": polyline.toGeoJSON(\"$encoded\")
                                        },
                                        \"layout\": {
                                            \"line-join\": \"round\",
                                            \"line-cap\": \"round\"
                                        },
                                        \"paint\": {
                                            \"line-color\": \"$color\",
                                            \"line-width\": 5
                                        }
                                    });\n";
                }
            }
            $lastPictureId = $pictureId;
        }
        $lastFoId = $foId;
        $lastUpdateId = $updateId;

        if ($lat != $lastLat) { 
            if ($coordCount > 0 && $coordsCode[strlen($coordsCode) - 1] != '\n') {
                $coordsCode .= ",\n";
            }
            $coordsCode .= "['img".$pictureId."',$lat,$lng]"; 
        }
        $avgLat += $lat;
        $avgLng += $lng;
        $coordCount++;

        $lastLat = $lat;
        $lastLng = $lng;
    }
    if ($coordCount > 0) {
        $avgLat /= $coordCount;
        $avgLng /= $coordCount;

        $coordsCode .= "];";
        $numDays = ceil(($latestDate - $earliestDate) / (24 * 60 * 60));
        for ($i = 0; $i < count($pictures); $i++) {
            $pictures[$i][1] = $latestDate - $pictures[$i][1];
        }

        function cmpDates($a, $b) {
            if ($a[1] == $b[1]) {
                return 0;
            }
            return ($a[1] < $b[1]) ? -1 : 1;
        }
        usort($pictures,"cmpDates");
        ?>

<TD style="height:100%;vertical-align:top;text-align:center;">
    <div class='trackEntries' style='overflow-y:scroll;position:fixed;height:100%;'>
        <div id='titleDisplay'>
            <H4>Village X Project Tracker
            </H4>
            <i style='font-weight:normal;font-size:14px;'>Follow our field officers as they visit our village partners and report on project progress</i>
        </div>
        <?php 
        $pictureIndex = 0;
        $pictureCount = count($pictures);
        $dayNav = '';
        for ($i = 0; ; $i++) {
            $day = $i + 1;
            $beginningOfDay = $day * 24 * 60 * 60;
            if ($pictures[$pictureIndex][1] > $beginningOfDay) {
                continue;
            }
            $dayNav .= "<TR><TD class='day' style='vertical-align:middle;border-bottom:.01em solid grey;'><a href='' onclick=\"smoothScroll('day$day');return false;\">".date("M j", $pictures[$pictureIndex][5])."</a></TD></TR>";
            print "<div id='dayDisplay".$i."'><h4 id='day$day'>";
            if ($pictures[$pictureIndex][5] > 0) {
                print date("M j, Y", $pictures[$pictureIndex][5]);
            }
            if ($pictures[$pictureIndex][9]) {
                print " - ".$pictures[$pictureIndex][9];
            }
            $lastProjectId = $pictures[$pictureIndex][8];
            print "</h4>\n</div>";
            while ($pictureIndex < $pictureCount) {
                if ($pictures[$pictureIndex][1] > $beginningOfDay) {
                    break;
                }
                
                $projectId = $pictures[$pictureIndex][8];
                if ($projectId != $lastProjectId) {
                    print "<h4>".$pictures[$pictureIndex][9]."</h4>";
                }
                $lastProjectId = $projectId;
                
                $pictureId = $pictures[$pictureIndex][0];
                if ($pictures[$pictureIndex][7]) {
                    print "<p class='blog' style='text-align:center;margin-left:20px;margin-right:20px;'>".$pictures[$pictureIndex][7]."</p>";
                }
                print "<img src=\"".getBaseURL()."/".PICTURES_DIR.$pictures[$pictureIndex][2]."\" id=\"img".$pictures[$pictureIndex][0]."\" 
                        ".($pictures[$pictureIndex][3] != 0 ? "onclick=\"zoomTo(this, ".$pictures[$pictureIndex][3].", ".$pictures[$pictureIndex][4].");\"" : "")." />\n";
                $pictureIndex++;
            }
            if ($pictureIndex >= $pictureCount) {
                break;
            } 
        } 
        ?>
    </div>
</TD>
<TD style="width:50%" rowspan=2>
<div class='map' id='map' style='width: 100%; height: 100%;'></div>
<script><?php print $coordsCode; ?>
mapboxgl.accessToken = 'pk.eyJ1IjoiamRlcHJlZSIsImEiOiJjajdjMndlbG4xMDk5MndwbGZyc3I3YnN5In0.uCkT-Femn4KqxRbrlr-CIA';
var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v9',
    center: [<?php print "$avgLat, $avgLng"; ?>],
    zoom: 3
});
      function zoomTo(elem, lat, lng) {
        map.flyTo({center: [lng, lat], zoom: 16});
          elem.scrollIntoView({
            behavior: 'smooth'
          });
      }

function smoothScroll(elemId) {
    document.getElementById(elemId).scrollIntoView({ 
      behavior: 'smooth' 
    });
}
</script>
<?php } ?>
    <style>
    img {
        padding:10px 10px 0 10px;
        width:95%;
        cursor:pointer;
    }
    td.day {
        padding-left:5px;
        vertical-align:top;
        text-align:center;
    }

    h4 {
        margin-top:20px;
        margin-bottom:2px;
    }

    p.blog {
        text-align:left;
        margin:10px;
    }
    span.caption {
        margin-top:0px;
        font-size:small;
        font-weight:600;
        opacity:.75;
    }

    a {
        text-decoration:none;
        font-weight:800;
        color: #005500;
    }
    .marker {
      background-image: url('<?php print getBaseURL(); ?>images/type_village.png');
      background-size: cover;
      width: 32px;
      height: 32px;
      cursor: pointer;
    }

    .trackEntries {
        width:<?php print ($coordCount > 0 ? "50%" : "95%"); ?>;
    }
    @media only screen and (max-width : 920px) {
        .trackEntries {
            width:95%;
        }
        
        .map {
          display: none;
        }

    }

    </style>
    <script>

        bounds = new mapboxgl.LngLatBounds();
        coords.forEach(function(point) {

          var el = document.createElement('div');
          el.className = 'marker';

          var newMarker = new mapboxgl.Marker(el)
          newMarker.setLngLat([point[2], point[1]]);
          newMarker.addTo(map);
          bounds.extend([point[2], point[1]]);
        });
        map.fitBounds(bounds, {
            padding: {top: 10, bottom:25, left: 25, right: 25}
        });

        map.on('load', function() {
            <?php print $pathsCode; ?>
        });

        map.on('click', function(e) {
            closestId = 0;
            closest = 100000;
            closestLat = 0;
            closestLng = 0;
            lat = e.lngLat.lat;
            lng = e.lngLat.lng;
            coords.forEach(function(point) {
                nextLat = lat - point[1];
                nextLng = lng - point[2];
                dist = (nextLat * nextLat) + (nextLng * nextLng);
                if (dist < closest) {
                    closest = dist;
                    closestId = point[0];
                    closestLat = point[1];
                    closestLng = point[2];
                }
            });
            if (closestId) {
                console.log("Scrolling to " + closestId);
                zoomTo(document.getElementById(closestId), closestLat, closestLng);
            }
          });

    </script>
</TD>
</TR>
</TABLE>
<div style='position:fixed;width:30px;top:0;bottom:0;left:0;overflow:hidden;right:-17px;'>
    <div style='position:absolute;width:100%;height:100%;padding-right:17px;overflow-y:scroll;'>
        <TABLE style="height:100%;margin-left:-2px;font-size:12px;font-weight:bold;">
            <?php print $dayNav; ?>
        </TABLE>
    </div>
</div>
</BODY>
</HTML>

<?php

function getPath($foId, $origin, $originLat, $originLng, $destination, $destLat, $destLng) {
    global $link;
    $ch = curl_init();
        
    $pathId = 0;
    $result = doUnprotectedQuery("SELECT tp_path FROM track_paths WHERE tp_start_pic_id=$origin AND tp_end_pic_id=$destination AND tp_fo_id=$foId");
    if ($row = $result->fetch_assoc()) {  
        return base64_decode($row['tp_path']);
    }

    $crowFliesDistance = getDistance($originLat, $originLng, $destLat, $destLng);
    if ($crowFliesDistance < 1000) {
        return;
    }
        
    $directionsUrl = "https://api.mapbox.com/directions/v5/mapbox/walking/$originLng,$originLat;$destLng,$destLat.json?access_token=".MAPBOX_API_KEY."&overview=full&geometries=polyline";
    curl_setopt($ch, CURLOPT_URL, $directionsUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $osmResultObj = json_decode($response);
   
    if ($osmResultObj && $osmResultObj->code == 'Ok') {
        $firstLeg = $osmResultObj->routes[0]->legs[0];
        $polyline = $osmResultObj->routes[0]->geometry;
        $polyline = str_replace("\\", "\\\\", $polyline);
        $encoded = base64_encode($polyline);
        doUnprotectedQuery("INSERT INTO track_paths (tp_start_pic_id, tp_end_pic_id, tp_fo_id, tp_distance, tp_time, tp_path) VALUES ($origin, $destination, $foId, {$firstLeg->distance}, {$firstLeg->duration}, '$encoded')");
        return $polyline;
    } else {
        $crowFliesDistance = getDistance($originLat, $originLng, $destLat, $destLng);
        $metersPerSecondMapping = array('driving'=>30, 'walking'=>2, 'bicycling'=>5, 'transit'=>15, 'flight'=>300, 'boat'=>2); 
        $time = $crowFliesDistance / $metersPerSecondMapping[$mode];
        doUnprotectedQuery("INSERT INTO track_paths (tp_start_pic_id, tp_end_pic_id, tp_fo_id, tp_distance, tp_time) VALUES ($origin, $destination, $foId, '$crowFliesDistance', '$time')");
        return null;
    }
}

function getDistance($startLat, $startLng, $endLat, $endLng) {
    $theta = $startLng - $endLng;
    $dist = sin(deg2rad($startLat)) * sin(deg2rad($endLat)) +  cos(deg2rad($startLat)) * cos(deg2rad($endLat)) * cos(deg2rad($theta));  
    $dist = acos($dist);
    $dist = rad2deg($dist);
    return $dist * 111189.3006; // meters conversion
}
?>
