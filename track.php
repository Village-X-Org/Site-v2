<?php
require_once("utilities.php");
$projectId = $start = $userId = $foId = $villageId = $small = 0; 
$pageTitle = "Village X<br/>Latest Updates";
$pageDescription = 'Get the latest news on our in-progress and completed projects.';
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

if (hasParam('small')) {
    $small = paramInt('small');
}

ob_start();
include("track_updates.php");
$updateHTML = ob_get_contents();
ob_end_clean();

if (count($updates) == 0) {
    print "No records found";
    die(1);
}
$latestDate = date("F j, Y", $updates[0]["timestamp"]);

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
    body {
        margin:0px;
        padding:0px;
        background:url('<?php print getBaseURL(); ?>/images/text_noise.png');"
    }

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
        font-family: 'Montserrat', sans-serif;
        font-size:36px;
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
        font-family: 'Montserrat', sans-serif;
        color:white;
        text-align:left;
        font-size:24px;
        padding-left:20px;
        padding-top:10px;
        padding-bottom:10px;
        margin-top:20px;
        width:100%;
        background:url('<?php print getBaseURL(); ?>/images/noise.png');
    }

    .updateText {
        text-align:left;
        font-size:18px;
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

    img.update {
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
<?php 
$metaProvided = 1;
include('header.inc'); 
?>
<div class='trackEntries' style="vertical-align:top;text-align:center;overflow:hidden;right:-17px;display:inline-block;">
    <div style='width:100%;padding-right:0px;'>
        <div style="width:100%;background-size:cover;background-position:center;padding:0;margin:0;position:relative;" >
            <div style='background-color:black;width:100%;padding:0;margin:0;'>
                <div style="background-image:url('uploads/<?php print $picture; ?>');width:100%;height:100%;background-size:cover;background-position:center;padding:0;margin:0;opacity:.7;">
                </div>
            </div>
            <div style="position:absolute;right:0px;bottom:80px;padding:10px;width:75%;background-color:#00000088;">
                <div style='text-align:right;' id='titleDisplay'>
                    <span class='topTitle' id='topTitle'><?php print $pageTitle; ?></span>
                    <br/>
                    <span class='topDescription' id='topDescription'>
                        <?php print $pageDescription; ?>
                    </span><br/><br/><span class='topDescription'><i>Last Update: <?php print $latestDate; ?></i></span>
                </div>
            </div> 
        </div>
        <div id='updatesDiv'>
            <?php
            print $updateHTML;
            ?>
            <img id='loadingImage' style='text-align:center;width:32px;visibility:hidden;' src='images/loading.gif' />
        </div>
    </div>
</div>
<div class='map' id='map' style='position:absolute;right:0;top:67px;width:50%;height:100%;'></div>
<script>
    projectId = <?php print $projectId; ?>;
    lastScrollTop = 0;
    refreshing = 0;
    small = <?php print $small; ?>;
    $(window).on("scroll", function(e) {
        scrollTop = document.body.scrollTop;
        if (scrollTop > lastScrollTop && scrollTop > 67) {
            $('#map').css({position: 'fixed', top:'0'});
        } else if (scrollTop < lastScrollTop && scrollTop <= 67) {
            $('#map').css({position: 'absolute', top:'67'});
        }
        if (!refreshing && hasMoreRecords && scrollTop > $('body').height() - 2000) {
            refreshing = 1;
            url = "track_updates.php?includeFirst=1&start=" + newStart;
            if (projectId > 0) {
                url += "&projectId=" + projectId;
            }
            if (small > 0) {
                url += '&small=' + small;
            }

            $('#loadingImage').css({visibility: 'visible'});
            $.get(url, function(data) {
                $('#loadingImage').css({visibility: 'hidden'});
                $("#updatesDiv").append( data );
                refreshing = 0;
            });
        }
        lastScrollTop = scrollTop;
    });

    mapboxgl.accessToken = 'pk.eyJ1IjoiamRlcHJlZSIsImEiOiJjajdjMndlbG4xMDk5MndwbGZyc3I3YnN5In0.uCkT-Femn4KqxRbrlr-CIA';
    var map = new mapboxgl.Map({
        container : 'map',
        style : 'mapbox://styles/jdepree/cj37ll51d00032smurmbauiq4',
        center : [34,-13.024],
        zoom : 6, 
        padding: {top: 20, bottom:150, left: 20, right: 20}
    });
    map.scrollZoom.disable();
    map.addControl(new mapboxgl.NavigationControl(), 'top-right');

    function zoomTo(elem, lat, lng) {
        map.flyTo({center: [lng, lat], zoom: 15});
        if (elem) {
            elem.scrollIntoView({
                behavior: 'smooth'
            });
        }
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

    function saveUpdate(updateId) {
        document.getElementById('updateText' + updateId).innerHTML = document.getElementById('updateTextEdit' + updateId).value;

        document.getElementById('updateDisplay' + updateId).style.display = 'block';
        document.getElementById('updateEdit' + updateId).style.display = 'none';
        document.getElementById('updateEditLink' + updateId).style.display = 'inline';
        $.post('<?php print getBaseURL(); ?>/track_saveUpdate.php', $('#updateEditForm' + updateId).serialize());
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
</BODY>
</HTML>
