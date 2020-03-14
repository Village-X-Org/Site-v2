<?php
require_once("utilities.php");
$projectId = $start = $userId = $foId = $villageId = $small = 0; 
$pageTitle = "Village X<br/>Latest Updates";

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

    }
    $stmt->close();
}

if (hasParam('small')) {
    $small = paramInt('small');
}

ob_start();
$includeFirst = 1;
include("track_updates.php");
$updateHTML = ob_get_contents();
ob_end_clean();

if (count($updates) > 0) {
    $latestDate = date("F j, Y", $updates[0]["timestamp"]);

    $pictureStr = $updates[0]["picture_ids"];
    if (strpos($pictureStr, ',') > 0) {
        $pictureIds = explode(",", $pictureStr);
    } else {
        $pictureIds = array($pictureStr);
    }
}
?>
<HTML>
<HEAD>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
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
        width:100%;
    }
</style>

</HEAD>
<BODY>
<?php
if (count($updates) == 0) {
    print "<div class='updateHeader' style='text-align:center;'>No updates available just yet.<br/>Stay tuned!</div>";
    die(1);
}
?>

<div class='trackEntries' style="vertical-align:top;text-align:center;overflow:hidden;right:-17px;display:inline-block;">
    <div style='width:100%;padding-right:0px;'>
            <div id='updatesDiv'>
            <?php
            print $updateHTML;
            ?>
            <img id='loadingImage' style='text-align:center;width:32px;visibility:hidden;' src='images/loading.gif' />
            </div>
</div>
</div>

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
            url = "track_updates.php?start=" + newStart;
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

    function smoothScroll(elemId) {
        document.getElementById(elemId).scrollIntoView({ 
          behavior: 'smooth' 
        });
    }

    function saveUpdate(updateId) {
        document.getElementById('updateText' + updateId).innerHTML = document.getElementById('updateTextEdit' + updateId).value;

        document.getElementById('updateDisplay' + updateId).style.display = 'block';
        document.getElementById('updateEdit' + updateId).style.display = 'none';
        document.getElementById('updateEditLink' + updateId).style.display = 'inline';
        $.post('<?php print getBaseURL(); ?>/track_saveUpdate.php', $('#updateEditForm' + updateId).serialize());
    }
    </script>
</div>
</BODY>
</HTML>