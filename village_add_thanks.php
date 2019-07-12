
<?php include("utilities.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
if (!hasParam('proposed')) {
	print "You must supply a proposed village id.";
	die(0);
}
$proposedId = param('proposed');
$stmt = prepare("SELECT pv_images, pv_name, pv_lat, pv_lng FROM proposed_villages WHERE pv_id=?");
$stmt->bind_param('i', $proposedId);
$result = execute($stmt);
if ($row = $result->fetch_assoc()) {
	$pictureIds = $row['pv_images'];
	$villageName = $row['pv_name'];
	$villageLat = $row['pv_lat'];
	$villageLng = $row['pv_lng'];
}
$stmt->close();

$commaIndex = strpos($pictureIds, ',');
$firstPic = substr($pictureIds, 0, $commaIndex);

$pageImage = PICTURES_DIR.$firstPic.".jpg";
$pageTitle = "I just added $villageName to Village X's map!";
$pageUrl = BASE_URL."village_add_thanks.php?proposed=$proposedId";
$pageDescription = "Village X maps villages and funds development projects chosen by them.";
include('header.inc'); ?>

<div class="row" style="padding:0;margin:0;">
	<div class="col s12 m12 l6" style="padding:3% 6% 0 6%;">
		<div class="row center">
			<?php foreach (explode(',', $pictureIds) as $pictureId) {
				if (strlen($pictureId) > 1) {
					print "<img src='".PICTURES_DIR."$pictureId.jpg' style='height:100px' />";
				}
			}
			?>
		</div>
    	<div class="row left-align">
			<h3 class="header col s12 black-text text-lighten-2 flow-text" style="font-weight: 300">Thanks for adding <?php print $villageName; ?>!</h3>
			<h4 class="header col s12 black-text text-lighten-2 flow-text" style="font-weight: 300">We put your village on our map to recognize your commitment to community-led 
			development and share your village's development needs with organizations that might be able to help.</h4> 
			<h4 class="header col s12 black-text text-lighten-2 flow-text" style="font-weight: 300">Please add more villages to the map and encourage your friends to do the same.</h4>
			<h4 class="header col s12 black-text text-lighten-2 flow-text" style="font-weight: 300">Sincerely,</h4>
			<h4 class="header col s12 black-text text-lighten-2 flow-text" style="font-weight: 300">Village X Team</h4>
		 
		</div>
		<br>
		<div class="row center">
			<h5 class="black-text text-lighten-2 flow-text"><b>Share the good news on Facebook and Twitter!</b>
			</h5>	
		</div> 
		<div class="row center">
				<?php printShareButtons($proposedId, 
					    "Put your village on the map.", 
					    "I just added $villageName Village", 70); ?>
		</div>
	</div>

	<div class="col s12 m12 l6 center" style="padding:0;margin:0;">
		<img src='<?php print "https://api.mapbox.com/styles/v1/jdepree/cj37ll51d00032smurmbauiq4/static/url-https%3A%2F%2Fwww.villagex.org%2Fimages%2Ficon_village.png($villageLng,$villageLat)/$villageLng,$villageLat,10,0,60.00/800x800?access_token=".MAPBOX_API_KEY; ?>' /> 
	</div>
</div>
<?php include('footer.inc'); ?>

