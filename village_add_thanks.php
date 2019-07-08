
<?php include("utilities.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$proposedId = param('proposed');
$stmt = prepare("SELECT pv_picture_ids, pv_name FROM proposed_villages WHERE pv_id=?");
$stmt->bind_param('i', $proposedId);
$result = execute($stmt);
if ($row = $result->fetch_assoc()) {
	$pictureIds = $row['pv_picture_ids'];
	$villageName = $row['pv_name'];
}
$stmt->close();

$commaIndex = strpos($pictureIds, ',');
$firstPic = substr($pictureIds, 0, $commaIndex);

$pageImage = PICTURES_DIR.$firstPic.".jpg";
$pageTitle = "I just added $villageName to Village X's map!";
$pageUrl = BASE_URL."village_add_thanks.php?proposed=$proposedId";
$pageDescription = "Village X maps villages and funds development projects chosen by them.";
include('header.inc'); ?>

<div class="row" style="height:90vh;">

<div class="col s12 m12 l6" style="height:100%;padding:7% 6% 6% 6%">
	<div class="valign-wrapper">
		<div>
        		<div class="row left-align">
        			<h3 class="header col s12 black-text text-lighten-2 text-shadow: 2px 2px 7px #111111 flow-text" style="font-weight: 300">Thanks for adding <?php print villageName; ?>!</h3>
        			<h4 class="header col s12 black-text text-lighten-2 text-shadow: 2px 2px 7px #111111 flow-text" style="font-weight: 300">We put your village on our map to recognize your commitment to community-led 
        			development and share your village's development needs with organizations that might be able to help.</h4> 
        			<h4 class="header col s12 black-text text-lighten-2 text-shadow: 2px 2px 7px #111111 flow-text" style="font-weight: 300">Please add more villages to the map and encourage your friends to do the same.</h4>
        			<h4 class="header col s12 black-text text-lighten-2 text-shadow: 2px 2px 7px #111111 flow-text" style="font-weight: 300">Sincerely,</h4>
        			<h4 class="header col s12 black-text text-lighten-2 text-shadow: 2px 2px 7px #111111 flow-text" style="font-weight: 300">Village X Team</h4>
        		 
        		</div>
			<br>
			<div class="row center">
				<h5 class="black-text text-lighten-2 text-shadow: 2px 2px 7px #111111 flow-text"><b>Share the good news on Facebook and Twitter!</b>
				</h5>	
			</div> 
			<div class="row center">
					<?php printShareButtons($projectId, 
						    "Put your village on the map.", 
						    "I just added $villageName Village", 70); ?>
			</div>
		</div>
	</div>
</div>

<div class="col s12 m12 l6">

<!-- add map here with shadow for location of newly added village -->
  
</div>

</div>

<?php include('footer.inc'); ?>

