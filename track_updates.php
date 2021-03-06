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

    $result = doUnprotectedQuery("SELECT project_id, village_id, ru_id, ru_description, ru_project_id, ru_title, ru_picture_ids, ru_video_id,
    	UNIX_TIMESTAMP(ru_date) AS timestamp, ru_lat, ru_lng, ru_emailed, project_lat, project_lng, project_name, village_name, project_staff_id, project_last_email,
    	fo_first_name, fo_last_name, fo_color, COUNT(donation_donor_id) AS donorCount FROM raw_updates LEFT JOIN projects 
    	ON ru_project_id=project_id LEFT JOIN villages ON village_id=project_village_id LEFT JOIN field_officers ON project_staff_id=fo_id 
        LEFT JOIN donations ON donation_project_id=project_id " 
    	.($projectId ? "WHERE project_id=$projectId" : ($foId ? "WHERE project_staff_id=$foId" : ($villageId ?  "WHERE village_id=$villageId" : "")))
    	." GROUP BY ru_id ORDER BY ru_date DESC LIMIT $start, ".(RECS_PER_PAGE + 1));

    $updates = array();
    $count = $hasMore = 0;
    while ($row = $result->fetch_assoc()) {
    	if ($count++ == RECS_PER_PAGE) {
    		$hasMore = 1;
    		break;
    	}
        $pictureIds = $row['ru_picture_ids'];
        $videoId = $row['ru_video_id'];
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
        $updateEmail = $row['ru_emailed'];
        $lastEmail = $row['project_last_email'];
        $donorCount = $row['donorCount'];

        $timestamp = $row['timestamp'];

        $lastProjectId = $nextProjectId;
        array_push($updates, array("update_id"=>$updateId, "update_email"=>$updateEmail, "project_id"=>$nextProjectId, "project_name"=>$projectName, "village_name"=>$villageName, "post_title"=>$postTitle, "staff"=>$foName, "last_email"=>$lastEmail, "donor_count"=>$donorCount,
        	"picture_ids"=>$pictureIds, "video_id"=>$videoId, "timestamp"=>$timestamp, "lat"=>$lat, "lng"=>$lng, "timestamp"=>$timestamp, 
            "description"=>$description));
    }
    /*if (!$putInVar) {
    	print json_encode(array("has_more_records"=>$hasMore, "updates"=>$updates));
    }*/
    $count = 0;
    print "<script>hasMoreRecords = $hasMore;newStart = ".(RECS_PER_PAGE + $start)."</script>";
    foreach ($updates as $update) {
        if (strlen($update['picture_ids']) < 2 && !$update['video_id']) {
            continue;
        }
        $updateId = $update['update_id'];
        if (date('Y', $update["timestamp"]) < 2000) {
            $dateStr = 0; 
        } else {
            $dateStr = date("F j, Y", $update["timestamp"]);
        }
        if ($update['project_id'] > 0) {
            $title = (!$projectId ? "<a style='color:white;font-weight:600;' href='project.php?id=".$update['project_id']."' target='_blank'>".$update['project_name']."</a> in ".$update['village_name'] : "").($dateStr ? "<br/>".$dateStr : "");
        } else {
            $title = $update['post_title'].($dateStr ? "<br/>".$dateStr : "");
        }
        ?>
        <div id='updateDisplay<?php print $updateId; ?>'>
            <form id='updateEditForm<?php print $updateId; ?>'>
                <div id='updateTitle<?php print $updateId; ?>' class='updateHeader'>
                    <span id='updateTitleText<?php print $updateId; ?>'><?php print $title; ?></span>
                    <?php if ($session_is_admin) { ?>
                        <a id='updateEditLink<?php print $updateId; ?>' href='' style='color:white;font-size:small;vertical-align:bottom;' 
                            onclick="document.getElementById('updateTitleText<?php print $updateId; ?>').style.display='none';
                                document.getElementById('updateText<?php print $updateId; ?>').style.display='none';
                                document.getElementById('updateTitleEdit<?php print $updateId; ?>').style.display='inline-block';
                                document.getElementById('updateEdit<?php print $updateId; ?>').style.display='inline-block';
                                this.style.display='none';return false;">
                            <?php print (!$update['description'] ? " what happened here?" : " edit"); ?>    
                        </a>
                    <?php if ($update['update_email']) { ?>
                        <br/>
                        <span style='color:white;font-size:small;'> This update was emailed to 
                                <?php print $update['donor_count']." donors on ".$update['update_email']; ?>
                        </span>
                    <?php } else if ($update['donor_count']) { ?>
                        <br/>
                    <?php if ($update['project_id']) { ?>
                        <a href='track_emailUpdate.php?id=<?php print $update['update_id']; ?>&count=<?php print $update['donor_count']; ?>&lastEmail=<?php print $update['last_email']; ?>' 
                            target='_blank' style='color:white;font-size:small;font-weight:bold;'>Email this update to donors for this project
                        </a> 
                    <?php } ?>
                        &nbsp;&nbsp; <span style='color:white;font-size:small;'> Last email for this project went to 
                            <?php print $update['donor_count']." donors".($update['last_email'] ? " on ".$update['last_email'] : "."); ?>
                        </span>
                    <?php } ?>
                <?php } ?>
                    <TEXTAREA name='updateTitleEdit' id='updateTitleEdit<?php print$updateId; ?>' style='padding:5px; background:none;border:0;height:100px;width:100%;color:white;display:none;' <?php print ($update['project_id'] > 0 ? "placeholder='No editable content - Project Name is autopopulated'" : ""); ?> ><?php 
                        print $update['post_title']; 
                    ?></TEXTAREA>
                </div>
                <div class='update updateText' id='updateText<?php print $updateId; ?>'>
                    <?php print ($update['description'] ? stripslashes($update['description']) : ""); ?>
                </div>
                <div id='updateEdit<?php print $updateId; ?>' style='display:none;width:100%;'>
                    <input type='hidden' name='updateId' value='<?php print $updateId; ?>' />
                    <div class='updateText flow-text'>
                        <TEXTAREA name='updateContent' class='updateText' id='updateTextEdit<?php print $updateId; ?>' 
                            style='padding:5px; background:none;border:0;height:100px;width:100%;' 
                            placeholder='Say something about your update.  But this box has no auto-save, so copy+paste it from an editor.'><?php 
                            print ($update['description'] ? htmlspecialchars(stripslashes($update['description'])) : ""); 
                            ?></TEXTAREA>
                    </div>
                    <div style='width:90%;text-align:right;'>
                        <input type='button' value='save content' style='margin-top:10px;' onclick='saveUpdate(<?php print $updateId; ?>);' />
                    </div>
                </div>
            </form>
        </div>
        <?php if ($update['video_id']) { ?>
        <iframe src='https://www.youtube.com/embed/<?php print $update['video_id']; ?>?modestbranding=1&autohide=1&showinfo=0&controls=0&rel=0&fs=0' frameborder='0' gesture='media' allow='encrypted-media' width='100%' height='500px'>
        </iframe>
                <?php if ($session_is_admin) {
                ?><div style='text-align:right;'>
                    <a href='' onclick='deleteVideo(<?php print "$updateId";?>);return false;'><img style='border:none;width:24px;' src='images/trash.svg' /></a>
                </div>
                <?php
            } ?>
        <?php } ?>
        <?php 
        $pictures = explode(',', $update["picture_ids"]);
        for ($pictureIndex = ($count > 0 || isset($includeFirst) ? 0 : 1); $pictureIndex < count($pictures); $pictureIndex++) {
            $pictureId = $pictures[$pictureIndex];
            if (!$pictureId) {
                continue;
            }
            if ($update['project_id'] > 0) {
                print "<div style='position:relative;'><a href='".$update['project_id']."' target='_blank'><img src=\"".ABS_PICTURES_DIR.($small ? 's' : '').$pictureId.".jpg\" id=\"img".$updateId.$pictureIndex."\" 
                    onmouseover=\"zoomTo(0, ".$update['lat'].", ".$update['lng'].");\" style='width:100%;padding:0;margin-left:0px;margin-right:0px;margin-top:5px;margin-bottom:5px;' ></a>\n";
            } else {
                print "<div style='position:relative;'><img src=\"".ABS_PICTURES_DIR.($small ? 's' : '').$pictureId.".jpg\" id=\"img".$updateId.$pictureIndex."\" 
                    onmouseover=\"zoomTo(0, ".$update['lat'].", ".$update['lng'].");\" 
                        style='width:100%;padding:0;margin-left:0px;margin-right:0px;margin-top:5px;margin-bottom:5px;' >";
            }
            if ($session_is_admin) {
                ?><div style='position:absolute;bottom:10px;right:10px;'>
                    <a href='' onclick='spotlightImage(this, <?php print $update['project_id'].", $pictureId";?>);return false;'><img style='border:none;width:24px;' src='images/spotlight.svg' /></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    <a href='' onclick='deleteImage(<?php print "$updateId, $pictureId";?>);return false;'><img style='border:none;width:24px;' src='images/trash.svg' /></a>
                </div>
                <?php
            }
            print "</div>";
        }
        $count++;  
    }
    if ($session_is_admin) {?>
        <script>
            function spotlightImage(link, projectId, pictureId) {
                if (confirm('Are you sure you want to set this image as the spotlighted image on the project page?')) {
                    $.post("update.php", {updateProjectId: projectId, pictureIdToBeSpotlighted: pictureId}, function(data) {
                        alert(data);
                    })
                }
            }
            function deleteImage(updateId, pictureId) {
                if (confirm('Are you sure you want to delete this image?')) {
                    $.post("update.php", {updateId: updateId, pictureIdToBeDeleted: pictureId}, function( data ) {
                        alert(data);
                    });
                }
            }
            function deleteVideo(updateId) {
                if (confirm('Are you sure you want to delete this video?')) {
                    $.post("update.php", {updateId: updateId, videoToBeDeleted: true}, function( data ) {
                        alert(data);
                    });
                }
            }
        </script>
    <?php }
   ?>