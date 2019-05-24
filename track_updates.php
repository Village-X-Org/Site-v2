<?php
require_once("utilities.php");

define('RECS_PER_PAGE', 5);

if (!isset($start)) {
	$projectId = $foId = $villageId = $start = $small = 0; 
	if (hasParam('projectId')) {
		$projectId = paramInt('projectId');
	}
	if (hasParam('foId')) {
		$foId = paramInt('foId');
	}
	if (hasParam('villageId')) {
		$villageId = paramInt('villageId');
	}
	if (hasParam('start')) {
		$start = paramInt('start');
	}
    if (hasParam('small')) {
        $small = paramInt('small');
    }
    if (hasParam('includeFirst')) {
        $includeFirst = paramInt('includeFirst');
    }
	$putInVar = 0;
} else {
	$putInVar = 1;
}

    $result = doUnprotectedQuery("SELECT project_id, village_id, ru_id, ru_description, ru_project_id, ru_title, ru_picture_ids,
    	UNIX_TIMESTAMP(ru_date) AS timestamp, ru_lat, ru_lng, project_lat, project_lng, project_name, village_name, project_staff_id, 
    	fo_first_name, fo_last_name, fo_color FROM raw_updates LEFT JOIN projects 
    	ON ru_project_id=project_id LEFT JOIN villages ON village_id=project_village_id LEFT JOIN field_officers ON project_staff_id=fo_id " 
    	.($projectId ? "AND project_id=$projectId" : ($foId ? "AND project_staff_id=$foId" : ($villageId ?  "AND village_id=$villageId" : "")))
    	." ORDER BY ru_date DESC LIMIT $start, ".(RECS_PER_PAGE + 1));

    $updates = array();
    $count = $hasMore = 0;
    while ($row = $result->fetch_assoc()) {
    	if ($count++ == RECS_PER_PAGE) {
    		$hasMore = 1;
    		break;
    	}
        $pictureIds = $row['ru_picture_ids'];
        $pictureIds = substr($pictureIds, 1, -1);
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
        $postTitle = $row['ru_title'];
        $color = $row['fo_color'];
        $updateId = $row['ru_id'];

        $timestamp = $row['timestamp'];

        $lastProjectId = $nextProjectId;
        array_push($updates, array("update_id"=>$updateId, "project_id"=>$nextProjectId, "project_name"=>$projectName, "village_name"=>$villageName, "post_title"=>$postTitle, "staff"=>$foName, 
        	"picture_ids"=>$pictureIds, "timestamp"=>$timestamp, "lat"=>$lat, "lng"=>$lng, "timestamp"=>$timestamp, "description"=>$description));
    }
    /*if (!$putInVar) {
    	print json_encode(array("has_more_records"=>$hasMore, "updates"=>$updates));
    }*/
    $count = 0;
    print "<script>hasMoreRecords = $hasMore;newStart = ".(RECS_PER_PAGE + $start)."</script>";
    foreach ($updates as $update) {
        if (strlen($update['picture_ids']) < 2) {
            continue;
        }
        $updateId = $update['update_id'];
        if (date('Y', $update["timestamp"]) < 2000) {
            $dateStr = 0; 
        } else {
            $dateStr = date("F j, Y", $update["timestamp"]);
        }
        if ($update['project_id'] > 0) {
            $title = (!$projectId ? "<a style='color:white;font-weight:600;' href='project.php?id=".$update['project_id']."' target='_blank'>".$update['project_name']."</a> in ".$update['village_name']."<br/>" : "").($dateStr ? $dateStr : "");
        } else {
            $title = $update['post_title'];
        }
        print "<div id='updateDisplay$updateId'><div id='updateTitle$updateId' class='updateHeader'><span id='updateTitleText$updateId'>$title</span>";
        if ($session_is_admin) { ?>
           <a id='updateEditLink<?php print $updateId; ?>' href='' style='color:white;font-size:small;vertical-align:bottom;' 
                onclick="document.getElementById('updateDisplay<?php print $updateId; ?>').style.display='none';
                        document.getElementById('updateEdit<?php print $updateId; ?>').style.display='inline-block';
                        this.style.display='none';return false;">
                <?php print (!$update['description'] ? " what happened here?" : " edit"); ?>    
            </a>
        <?php }
        print "\n</div><div class='update updateText' id='updateText$updateId'>".($update['description'] ? stripslashes($update['description']) : "")."</div></div>";
        print "\n<div id='updateEdit$updateId' style='display:none;width:100%;'><form id='updateEditForm$updateId'>
                <input type='hidden' name='updateId' value='$updateId' />
                <div class='updateText flow-text'>
                <TEXTAREA name='updateContent' class='updateText' id='updateTextEdit$updateId' style='padding:5px; background:none;border:0;height:100px;width:100%;' placeholder='Say something about your update.  But this box has no auto-save, so copy+paste it from an editor.'>"
                    .($update['description'] ? htmlspecialchars(stripslashes($update['description'])) : "").
            "</TEXTAREA></div><div style='width:90%;text-align:right;'><input type='button' value='save content' style='margin-top:10px;' onclick='saveUpdate($updateId);' /></div></form></div>";
        $pictures = explode(',', $update["picture_ids"]);
        for ($pictureIndex = ($count > 0 || isset($includeFirst) ? 0 : 1); $pictureIndex < count($pictures); $pictureIndex++) {
            $pictureId = $pictures[$pictureIndex];
            if (!$pictureId) {
                continue;
            }
            if ($update['project_id'] > 0) {
                print "<a href='".$update['project_id']."' target='_blank'><img src=\"".ABS_PICTURES_DIR.($small ? 's' : '').$pictureId.".jpg\" id=\"img".$updateId.$pictureIndex."\" 
                    onmouseover=\"zoomTo(0, ".$update['lat'].", ".$update['lng'].");\" style='width:100%;padding:0;margin-left:0px;margin-right:0px;margin-top:5px;margin-bottom:5px;' /></a>\n";
            } else {
                print "<img src=\"".ABS_PICTURES_DIR.($small ? 's' : '').$pictureId.".jpg\" id=\"img".$updateId.$pictureIndex."\" 
                    onmouseover=\"zoomTo(0, ".$update['lat'].", ".$update['lng'].");\" 
                        style='width:100%;padding:0;margin-left:0px;margin-right:0px;margin-top:5px;margin-bottom:5px;' />";
            }
        }
        $count++;  
    }
   ?>