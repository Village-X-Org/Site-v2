<?php
require_once("utilities.php");
$result = doQuery("SELECT pu_id, picture_filename, pu_description, donor_id, donor_email, project_id, project_name, pu_timestamp FROM project_updates JOIN donations ON pu_project_id=donation_project_id JOIN donors ON donor_id=donation_donor_id JOIN projects ON pu_project_id=project_id JOIN pictures ON pu_image_id=picture_id WHERE pu_timestamp>DATE_SUB(NOW(), INTERVAL 1 WEEK) ORDER BY donor_id, project_id");
$emailBuffer = '';
$lastDonorId = 0;
$lastProjectId = 0;
while ($row = $result->fetch_assoc()) {
    $projectId = $row['project_id'];
    $updateTime = $row['pu_timestamp'];
    $donorId = $row['donor_id'];
    $email = $row['donor_email'];
    $updatePicture = $row['picture_filename'];
    $updateText = $row['pu_description'];
    $lastDonorId = $donorId;
    
    if ($donorId != $lastDonorId) {
        if (strlen($emailBuffer) > 5) {
            sendMailSend($email, "Project Updates for this Past Week", $emailBuffer, "admin@adventureanywhere.org", "admin@adventureanywhere.org");
            $emailBuffer = '';
        }
        $lastDonorId = $donorId;
    }
    if ($projectId != $lastProjectId) {
        if ($lastProjectId > 0) {
            $emailBuffer .= "</TABLE>";       
        }
        $projectName = $row['project_name'];
        $emailBuffer .= "<H3>$projectName</H3><TABLE>";
        $lastProjectId = $projectId;
    }
    $emailBuffer .= "<TR><TD><img src='".PICTURES_DIR.$updatePicture."' style='width:400px;' /></TD><TD>$updateTime<BR>$updateText</TD>";
}
if (strlen($emailBuffer) > 5) {
    sendMailSend($email, "Project Updates for this Past Week", $emailBuffer, "admin@adventureanywhere.org", "admin@adventureanywhere.org");
}
?>