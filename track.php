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
<HEAD><TITLE>Village X | Latest Updates</TITLE>
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
    
    .dayHeader {
        font-family: flicker;
        color:white;
        text-align:left;
        font-size:32px;
        padding-left:20px;
        padding-top:10px;
        padding-bottom:10px;
        margin-top:10px;
        width:100%;
        background:url('<?php print getBaseURL(); ?>/images/noise.png');
    }

    .dayText {
        font-family: 'Montserrat', sans-serif;
        text-align:left;
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
<meta property="og:image" content="https://villagex.org/images/villagemtg.jpg"/>
<meta property="og:title" content="Village X | Latest Updates"/>
<meta property="og:url" content="<?php print getBaseURL()."/track.php"; ?>" />
<meta property="og:description" content="Get the latest news on our in-progress and completed projects."/>
</HEAD>
<BODY style="margin:0px;padding:0px;background:url('<?php print getBaseURL(); ?>/images/text_noise.png');">
<TABLE style="width:100%;height:100%;">
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
        $nextProjectId = $row['project_id'];
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
        $lastProjectId = $nextProjectId;
        array_push($pictures, array($pictureId, $timestamp, $filename, $lat, $lng, $timestamp, $foId, $description, $nextProjectId, $title));

        if ($lat == 0) {
            if ($lastLat == 0 && $foId != $lastFoId) {
                continue;
            }
            $lat = $lastLat;
            $lng = $lastLng;
        } else {
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
<TD style="height:100%;vertical-align:top;text-align:center;overflow:hidden;right:-17px;">
    <div class='trackEntries' style='overflow-y:scroll;position:fixed;height:100%;padding-right:17px;'>
        <div style="width:100%;height:100%;background-size:cover;background-position:center;padding:0;margin:0;position:relative;" >
            <div style='background-color:black;width:100%;height:100%;padding:0;margin:0;'><div style="background-image:url('<?php print ABS_PICTURES_DIR.$filename; ?>');width:100%;height:100%;background-size:cover;background-position:center;padding:0;margin:0;opacity:.7;"></div></div>
                <div style="position:absolute;right:0px;bottom:60px;padding:10px;width:75%;background-color:#00000088;">
                    <div style='text-align:right;' id='titleDisplay'>
                        <span class='topTitle' id='topTitle'>Village X | Latest Updates</span>
                        <br/>
                        <span class='topDescription' id='topDescription'>
                            Get the latest news from our in-progress and completed projects.
                        </span><br/><br/><span class='topDescription'><i>Last Update: November 23rd</i></span>
                    </div>
                
                    <?php if ($session_is_admin) { ?>
                        <div id='titleEdit' style='display:none;text-align:left;width:75%;height:350px;'>
                            <form id='titleEditForm'>
                                <input type='hidden' name='blogId' value='<?php print $blogId; ?>' />
                                <input type='hidden' name='code' value='<?php print $code; ?>' />
                                <input type='hidden' name='userId' value='<?php print $userId; ?>' />
                                <input class='topTitle' id='titleInput' type='text' name='title' style='border:0;background:none;height:75px;
                                        line-height:75px;width:100%;' 
                                value='<?php print "$title"; ?>' /><br/><br/>
                                <TEXTAREA type='text' id='descriptionInput' class='topDescription' name='description' style='background:none;border:0;height:200px;width:100%;margin-bottom:5px;'><?php print stripslashes($description); ?></TEXTAREA>
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
        $days = array();
        $result = doQuery("SELECT bd_day, bd_title, bd_content FROM blog_days WHERE bd_blog_id=$blogId");
        while ($row = $result->fetch_assoc()) {
            $dayIndex = $row['bd_day'];
            $dayContent = stripslashes(str_replace("\\r\\n", "\n", $row['bd_content']));
            $days[$dayIndex] = array($row['bd_title'], $dayContent, nl2br($dayContent, false));
        }
        ?>
        <?php 
        $pictureIndex = 0;
        $pictureCount = count($pictures);
        for ($i = 0; $i < $numDays; $i++) {
            $hasDay = isset($days[$i]);
            $day = $i + 1;
            $endOfDay = $day * 24 * 60 * 60;
            if (!$hasDay && $pictures[$pictureIndex][1] > $endOfDay) {
                continue;
            }
            $picLocIndex = $pictureIndex;
            $picLat = $picLng = 0;
            while ($picLocIndex < $pictureCount && $pictures[$picLocIndex][1] < $endOfDay) {
                if ($pictures[$picLocIndex][3] != 0) {
                    $picLat = $pictures[$picLocIndex][3];
                    $picLng = $pictures[$picLocIndex][4];
                    break;
                }
                $picLocIndex++;
            }

            $dayNav .= "<div class='day' style='width:{$dayLinkWidth}px;cursor:pointer;color:white' onclick=\"zoomTo(document.getElementById('dayDisplay$i'), $picLat, $picLng);return false;\">".($hasDay ? stripslashes($days[$i][0]) : "Day $day: ")
                ."</div>";
            $dayLinkCount++;
            print "<div id='dayDisplay$i'><div id='dayTitle$i' class='dayHeader'><span id='dayTitleText$i'>".($hasDay ? stripslashes($days[$i][0]) : "Day $day: ")."</span>";
           if ($session_user_id == $userId) { ?>
               <a id='dayEditLink<?php print $i; ?>' href='' style='color:white;font-size:small;vertical-align:bottom;' 
                    onclick="document.getElementById('dayDisplay<?php print $i; ?>').style.display='none';
                            document.getElementById('dayEdit<?php print $i; ?>').style.display='inline-block';
                            this.style.display='none';return false;">
                    <?php print (!$hasDay ? " what happened on this day?" : " edit"); ?>    
                </a>
            <?php }
            print "\n</div><div class='blog dayText' id='dayText$i'>".($hasDay ? stripslashes($days[$i][2]) : "")."</div></div>";
            print "\n<div id='dayEdit$i' style='display:none;width:100%;'><form id='dayEditForm$i'>
                    <input type='hidden' name='blogId' value='$blogId' />
                    <input type='hidden' name='dayIndex' value='$i' />
                    <input type='hidden' name='code' value='$code' />
                    <input type='hidden' name='userId' value='$userId' />
                    <div class='dayHeader'><input type='text' id='dayTitleEdit$i' name='dayTitle' class='dayHeader' style='background:none;border:0;height:75px;line-height:75px;' value=\"".($hasDay ? htmlspecialchars(stripslashes($days[$i][0])) : "Day $day: ")."\"></div>
                    <div class='dayText'>
                    <TEXTAREA name='dayContent' class='dayText' id='dayTextEdit$i' style='padding:5px; background:none;border:0;height:250px;width:100%;' placeholder='Say something about your day.  But this box has no auto-save, so copy+paste it from an editor.'>"
                        .($hasDay ? htmlspecialchars(stripslashes($days[$i][1])) : "").
                "</TEXTAREA></div><div style='width:90%;text-align:right;'><input type='button' value='save content' style='margin-top:10px;' onclick='saveDay($i);' /></div></form></div>";
            while ($pictureIndex < $pictureCount) {
                if ($pictures[$pictureIndex][1] > $endOfDay) {
                    break;
                }
                $pictureId = $pictures[$pictureIndex][0];
                print "<img src=\"".getBaseURL()."/".PICTURES_DIR.$pictures[$pictureIndex][2]."\" id=\"img".$pictures[$pictureIndex][0]."\" 
                        onclick=\"if (".$pictures[$pictureIndex][3]." != 0) { zoomTo(this, ".$pictures[$pictureIndex][3].", ".$pictures[$pictureIndex][4]."); }\" style='width:100%;padding:0;margin-left:0px;margin-right:0px;margin-top:5px;margin-bottom:5px;' />\n";
                if ($session_user_id == $userId) { ?>
                    <div id='captionDisplay<?php print $pictureId; ?>'><span class='caption' id='captionDisplayText<?php print $pictureId; ?>'><?php print $pictures[$pictureIndex][5]; ?></span>
                    <a id='captionEditLink<?php print $pictureId; ?>' href=''
                            onclick="document.getElementById('captionDisplay<?php print $pictureId; ?>').style.display='none';
                            document.getElementById('captionEdit<?php print $pictureId; ?>').style.display='inline-block';
                            document.getElementById('changeCoverPhotoLink<?php print $pictureId; ?>').style.display='none';
                            this.style.display='none'; return false;" style='color:black;'>
                            <?php print (!$pictures[$pictureIndex][5] ? "add a caption to your picture" : " edit caption"); ?>            
                    </a><?php print " - <a href='' id='changeCoverPhotoLink$pictureId' style='color:black;' onclick='changeCoverPhoto($pictureId);return false;'>".($coverPhotoId == $pictureId ? "current cover photo" : "set as cover photo")."</a>" ?></span></div>
                    <div id='captionEdit<?php print $pictureId; ?>' style='display:none;margin:10px;width:100%;'>
                        <form id='captionEditForm<?php print $pictureId; ?>'>
                            <input type='hidden' name='pictureId' value='<?php print $pictureId; ?>' />
                            <input type='hidden' name='code' value='<?php print $code; ?>' />
                            <input type='hidden' name='userId' value='<?php print $userId; ?>' />
                            <input type='text' class='caption' placeholder="Caption Text" name='caption' style='width:80%;background:none;border:0;' id='captionDisplayEdit<?php print $pictureId; ?>' value="<?php print $pictures[$pictureIndex][5]; ?>" 
                            style='width:500px;' /> <input type='button' value='save caption' onclick='saveCaption(<?php print $pictureId; ?>);' />
                        </form>
                    </div>
                <?php } else {
                    print "<div><span class='caption'>".$pictures[$pictureIndex][5]."</span></div>\n";
                }
                $pictureIndex++;
            } 
        } ?>
</TD>
<TD style="width:50%" rowspan=2>
<div class='map' id='map' style='width: 100%; height: 100%;'></div>
<script><?php print $coordsCode; ?>
mapboxgl.accessToken = 'pk.eyJ1IjoiamRlcHJlZSIsImEiOiJjajdjMndlbG4xMDk5MndwbGZyc3I3YnN5In0.uCkT-Femn4KqxRbrlr-CIA';
var map = new mapboxgl.Map({
    container : 'map',
    style : 'mapbox://styles/jdepree/cj37ll51d00032smurmbauiq4',
    center : [20.5, 2.5],
    zoom : 4
});
map.addControl(new mapboxgl.NavigationControl(), 'top-right');

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
        <?php if (!$projectId) { ?>
        map.fitBounds(bounds, {
            padding: {top: 100, bottom:100, left: 50, right: 50}
        });
        <?php } else { ?>
            if (coords.length > 0) {
                map.flyTo({center: [coords[0][2], coords[0][1]], zoom: 12}); 
            }
        <?php } ?>

        map.on('load', function() {
            <?php print $pathsCode; ?>

        });

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
            map.flyTo({ center: village.geometry.coordinates, zoom: 18,
                padding : {
                    top : 20,
                    bottom : 150,
                    left : 20,
                    right : 20
                }
            });
        }

        function selectProject(id) {

        }

        map.on('click', 'villages', function(e) {
            selectVillage(e.features[0]);
        });

        map.on('click', 'projects', function (e) {
                if (selectedElem == e.features[0]) {
                return;
            }
                window.open("project.php?id=" + e.features[0].properties.id, '_blank');
        });
    </script>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>
