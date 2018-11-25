<?php
require_once("utilities.php");

$projectId = $start = $userId = $foId = $villageId = 0; 
$pageTitle = "Village X<br/>Latest Updates";
$pageDescription = 'Get the latest news on our in-progress and completed projects."';
$pagePicture = 'images/khwalala_market.jpg';

if (hasParam('projectId')) {
    $projectId = paramInt('projectId');
    $stmt = prepare("SELECT project_name, village_name, village_lat, village_lng, fo_first_name, fo_last_name FROM projects JOIN villages ON village_id=project_village_id 
        JOIN field_officers ON project_staff_id=fo_id WHERE project_id=?");
    $stmt->bind_param("d", $projectId);
    $result = execute($stmt);
    if ($row = $result->fetch_assoc()) {
        $projectName = $row['project_name'];
        $villageName = $row['village_name'];
        $villageLat = $row['village_lat'];
        $villageLng = $row['village_lng'];
        $foName = $row['fo_first_name'].' '.$row['fo_last_name'];

        $pageTitle = "$projectName<br/>$villageName Village";
        $pageDescription = "Updates from Village X field officer, $foName";
    }
    $stmt->close();
}

include("track_updates.php");

if (count($updates) == 0) {
    print "No records found";
    die(1);
}
$latestDate = date("F n, Y", $updates[0]["timestamp"]);

$pictureStr = $updates[0]["picture_ids"];
if (strpos($pictureStr, ',') > 0) {
    $pictureIds = explode(",", $pictureStr);
} else {
    $pictureIds = array($pictureStr);
}

$picture = $pictureIds[0].".jpg";
?>
<HTML>
<HEAD><TITLE><?php print str_replace("<br/>", " | ", $pageTitle); ?></TITLE>
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<style>
    table td {
       padding:0; margin:0;
    }

    table {
       border-collapse: collapse;
    }

    @font-face {
        font-family: flicker;
        src: url('<?php print getBaseURL(); ?>/fonts/flicker.otf');
    }

    .topTitle {
        font-family: flicker;
        font-size:48px;
        text-align:right;
        color:white;
    }

    .topDescription {
        font-family: 'Montserrat', sans-serif;
        color:white;
        font-size:16px;
        opacity:.9;
        text-align:right;
    }
    
    .updateHeader {
        font-family: flicker;
        color:white;
        text-align:left;
        font-size:32px;
        padding-left:20px;
        padding-top:10px;
        padding-bottom:10px;
        margin-top:20px;
        width:100%;
        background:url('<?php print getBaseURL(); ?>/images/noise.png');
    }

    .updateText {
        text-align:left;
        font-size:22px;
        color:#303030;
        padding-left:30px;
        padding-right:10px;
        padding-top:10px;
        padding-bottom:10px;
    }

    span.caption {
        font-family: 'Montserrat', sans-serif;
        margin-top:0px;
        font-weight:600;
        text-align:center;
    }

    img {
        padding:10px 10px 0 10px;
        width:100%;
        cursor:pointer;
    }

    a {
        text-decoration:none;
        font-weight:800;
        color: white;
    }

    .trackEntries {
        width:50%;
    }
    @media only screen and (max-width : 920px) {
        .trackEntries {
            width:100%;
        }
        
        .map {
          display: none;
        }
    }
</style>
<meta name="viewport" content="width=640">
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.46.0/mapbox-gl.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.46.0/mapbox-gl.css' rel='stylesheet' />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta property="og:type" content="website" />
<meta property="og:image" content="<?php print ($picture ? ABS_PICTURES_DIR.$picture : "https://villagex.org/images/villagemtg.jpg"); ?>" />
<meta property="og:title" content="<?php print str_replace("<br/>", " | ", $pageTitle); ?>"/>
<meta property="og:url" content="<?php print getBaseURL().($projectId ? "track.php?projectId=$projectId" : "/track.php"); ?>" />
<meta property="og:description" content="<?php print $pageDescription; ?>" />
</HEAD>
<BODY style="margin:0px;padding:0px;background:url('<?php print getBaseURL(); ?>/images/text_noise.png');">
<TABLE style="width:100%;height:100%;">
<TR >

<TD style="height:100%;vertical-align:top;text-align:center;overflow:hidden;right:-17px;">
    <div class='trackEntries' style='overflow-y:scroll;position:fixed;height:100%;padding-right:17px;'>
        <div style="width:100%;height:100%;background-size:cover;background-position:center;padding:0;margin:0;position:relative;" >
            <div style='background-color:black;width:100%;height:100%;padding:0;margin:0;'><div style="background-image:url('uploads/<?php print $picture; ?>');width:100%;height:100%;background-size:cover;background-position:center;padding:0;margin:0;opacity:.7;"></div></div>
                <div style="position:absolute;right:0px;bottom:60px;padding:10px;width:75%;background-color:#00000088;">
                    <div style='text-align:right;' id='titleDisplay'>
                        <span class='topTitle' id='topTitle'><?php print $pageTitle; ?></span>
                        <br/>
                        <span class='topDescription' id='topDescription'>
                            <?php print $pageDescription; ?>
                        </span><br/><br/><span class='topDescription'><i>Last Update: <?php print $latestDate; ?></i></span>
                    </div>
                
                    <?php if ($session_is_admin) { ?>
                        <div id='titleEdit' style='display:none;text-align:left;width:75%;height:350px;'>
                            <form id='titleEditForm'>
                                <input type='hidden' name='projectId' value='<?php print $projectId; ?>' />
                                <input class='topTitle' id='titleInput' type='text' name='title' style='border:0;background:none;height:75px;
                                        line-height:75px;width:100%;' 
                                value='<?php print str_replace("<br/>", " | ", $pageTitle); ?>' /><br/><br/>
                                <TEXTAREA type='text' id='descriptionInput' class='topDescription' name='description' style='background:none;border:0;height:200px;width:100%;margin-bottom:5px;'><?php print stripslashes($pageDescription); ?></TEXTAREA>
                                <br/>
                                <input type='button' value='save new title and description' style='text-align:right;' onclick='saveTitle();' />
                            </form>
                        </div>
                        <div style='text-align:right;'>
                            <span style='font-size:16px;'>
                                <a href='' id='titleEditLink' style='font-size:smaller;vertical-align:bottom;' 
                                        onclick="document.getElementById('titleDisplay').style.display='none';this.style.display='none';
                                        document.getElementById('titleEdit').style.display='inline-block';return false;"> edit title and description</a>
                            </span>
                        </div>
                    <?php } ?>
                </div> 
        </div>
            <?php
            $count = 0;
            foreach ($updates as $update) {
                if (strlen($update['picture_ids']) < 2) {
                    continue;
                }
                $updateId = $update['update_id'];
                if (date('Y', $update["timestamp"]) < 2000) {
                    $dateStr = "Date unspecified"; 
                } else {
                    $dateStr = date("F n, Y", $update["timestamp"]);
                }
                $title = (!$projectId ? $update['project_name']." in ".$update['village_name']." | " : "").$dateStr;
                print "<div id='updateDisplay$updateId'><div id='updateTitle$updateId' class='updateHeader'><span id='updateTitleText$updateId'>$title</span>";
                if ($session_is_admin) { ?>
                   <a id='updateEditLink<?php print $updateId; ?>' href='' style='color:white;font-size:small;vertical-align:bottom;' 
                        onclick="document.getElementById('updateDisplay<?php print $updateId; ?>').style.display='none';
                                document.getElementById('updateEdit<?php print $updateId; ?>').style.display='inline-block';
                                this.style.display='none';return false;">
                        <?php print (!$update['description'] ? " what happened here?" : " edit"); ?>    
                    </a>
                <?php }
                print "\n</div><div class='update updateText flow-text' id='updateText$updateId'>".($update['description'] ? stripslashes($update['description']) : "")."</div></div>";
                print "\n<div id='updateEdit$updateId' style='display:none;width:100%;'><form id='updateEditForm$updateId'>
                        <input type='hidden' name='updateId' value='$updateId' />
                        <div class='updateText flow-text'>
                        <TEXTAREA name='updateContent' class='updateText' id='updateTextEdit$updateId' style='padding:5px; background:none;border:0;height:250px;width:100%;' placeholder='Say something about your update.  But this box has no auto-save, so copy+paste it from an editor.'>"
                            .($update['description'] ? htmlspecialchars(stripslashes($update['description'])) : "").
                    "</TEXTAREA></div><div style='width:90%;text-align:right;'><input type='button' value='save content' style='margin-top:10px;' onclick='saveUpdate($updateId);' /></div></form></div>";
                $pictures = explode(',', $update["picture_ids"]);
                for ($pictureIndex = ($count > 0 ? 0 : 1); $pictureIndex < count($pictures); $pictureIndex++) {
                    $pictureId = $pictures[$pictureIndex];
                    if (!$pictureId) {
                        continue;
                    }
                    print "<img src=\"".ABS_PICTURES_DIR.$pictureId.".jpg\" id=\"img".$updateId.$pictureIndex."\" 
                            onclick=\"\" style='width:100%;padding:0;margin-left:0px;margin-right:0px;margin-top:5px;margin-bottom:5px;' />\n";
                    $pictureIndex++;
                }
                $count++;  
            }
            ?>
</TD>
<TD style="width:50%" rowspan=2>
<div class='map' id='map' style='width: 100%; height: 100%;'></div>
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiamRlcHJlZSIsImEiOiJjajdjMndlbG4xMDk5MndwbGZyc3I3YnN5In0.uCkT-Femn4KqxRbrlr-CIA';
    var map = new mapboxgl.Map({
        container : 'map',
        style : 'mapbox://styles/jdepree/cj37ll51d00032smurmbauiq4',
        center : [34,-13.024],
        zoom : 6, 
        padding: {top: 20, bottom:150, left: 20, right: 20}
    });

    map.addControl(new mapboxgl.NavigationControl(), 'top-right');

    function zoomTo(elem, lat, lng) {
        map.flyTo({center: [lng, lat], zoom: 12});
            elem.scrollIntoView({
            behavior: 'smooth'
        });
    }

    function smoothScroll(elemId) {
        document.getElementById(elemId).scrollIntoView({ 
          behavior: 'smooth' 
        });
    }

    function selectVillage(village) {
        selectedVillage = village;
        sw = [ parseFloat(selectedVillage.properties.boundsSwLng),
                parseFloat(selectedVillage.properties.boundsSwLat) ];
        ne = [ parseFloat(selectedVillage.properties.boundsNeLng),
                parseFloat(selectedVillage.properties.boundsNeLat) ];
        if (Math.abs(ne[0] - sw[0]) < .001) {
            ne[0] += .005;
            sw[0] -= .005;
        }
        if (Math.abs(ne[1] - sw[1]) < .001) {
            ne[1] += .005;
            sw[1] -= .005;
        }
        map.flyTo({ center: village.geometry.coordinates, zoom: 15,
            padding : {
                top : 20,
                bottom : 150,
                left : 20,
                right : 20
            }
        });
    }

    map.on('click', 'villages', function(e) {
        selectVillage(e.features[0]);
    });

    map.on('click', 'projects', function (e) {
            window.open("project.php?id=" + e.features[0].properties.id, '_blank');
    });

    <?php if ($projectId) { ?>
        map.on('load', function() {
            map.addSource("source_circle_500", {
                "type": "geojson",
                "data": {
                    "type": "FeatureCollection",
                    "features": [{
                        "type": "Feature",
                        "geometry": {
                            "type": "Point",
                            "coordinates": [<?php print "$villageLng, $villageLat"; ?>]
                        }
                    }]
                }
            });

            map.addLayer({
                "id": "circle500",
                "type": "circle",
                "source": "source_circle_500",
                "paint": {
                    "circle-radius": 20,
                    "circle-color": "#5b94c6",
                    "circle-opacity": 0.6
                }
            });
        });
    <?php } ?> 
    </script>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>
