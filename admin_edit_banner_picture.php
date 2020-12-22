<?php
require_once("utilities.php");
if (!$session_is_admin) {
	print "Please login first";
	die(0);
}

$projectId = paramInt('projectId');
$imageId = paramInt('imageId');
$smallImageId = paramint('smallImageId');
doUnprotectedQuery("UPDATE projects SET project_banner_image_id=$imageId, project_profile_image_id=$smallImageId WHERE project_id=$projectId");

include('rc.php');

?>