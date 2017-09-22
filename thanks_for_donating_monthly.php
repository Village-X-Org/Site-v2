<!DOCTYPE html>
<html lang="en">
<head>

<?php
$result = doQuery("SELECT project_id, project_name, village_name, country_label, picture_filename, peopleStats.stat_value AS peopleCount, hhStats.stat_value AS householdCount
    FROM projects JOIN villages ON project_village_id=village_id
    JOIN countries ON country_id=village_country
    JOIN village_stats AS peopleStats ON peopleStats.stat_type_id=18 AND peopleStats.stat_village_id=village_id
    JOIN village_stats AS hhStats ON hhStats.stat_type_id=19 AND hhStats.stat_village_id=village_id
    JOIN pictures ON picture_id=project_banner_image_id WHERE project_funded<project_budget ORDER BY (EXISTS (SELECT sd_project_id FROM subscription_disbursals WHERE sd_donor_id=$donorId)) ASC,
        project_budget - project_funded ASC, hhStats.stat_year DESC, peopleStats.stat_year DESC LIMIT 1"); 
if ($row = $result->fetch_assoc()) {
    $projectName = $row['project_name'];
    $villageName = $row['village_name'];
    $countryName = $row['country_label'];
    $numPeople = $row['peopleCount'];
    $numHouseholds = $row['householdCount'];
}

?>
<meta property="fb:appid" content="<?php print FACEBOOK_APP_ID; ?>"/>
<meta property="og:image" content="images/village_family.jpg"/>
<meta property="og:title" content="I signed up for the Village Fund!"/>
<meta property="og:url" content="https://4and.me/project.php?id=<?php print $projectId; ?>"/>
<meta property="og:description" content="Disrupt extreme poverty by funding projects villages choose."/>

<?php 
$metaProvided = 1; 
include('header.inc'); ?>

<div id="index-banner" class="parallax-container" style="background-color: rgba(0, 0, 0, 0.3); height: 500px;">
	<div class="section no-pad-bot valign-wrapper" style="height: 100%; width:100%;">
		<div class="container">
		<div class="row center">
			<h2 class="header col s12 white-text text-lighten-2 text-shadow: 2px 2px 7px #111111">Thanks for joining the Village Fund!</h2>
		</div>
			<br>
			<div class="row center"><p class="white-text text-lighten-2 text-shadow: 2px 2px 7px #111111"><b>Share your generosity to inspire others</b></p>	
			</div> 
			<div class="row center">
					<?php printShareButtons($projectId, 
						    "I disrupt extreme poverty every month by funding projects villages choose.", 
						    "I donate monthly to projects chosen by extreme poverty villages in Africa.", 70); ?>
			</div>
	</div>
			<div class="parallax" style="background-size: cover;">
				<img src="images/village_family.jpg">
			</div>
		</div>
	</div>
</div>
<br>
<div class="container">

	<div class="row">
      <div class="col s12 m12 l12">
        
          <div class="black-text flow-text"><p class="flow-text">
          	<p><?php print $donorFirstName; ?>,</p> 
			<p>We processed your first monthly donation of $<?php print $donationAmountDollars; ?>! We applied this donation to <?php print $projectName; ?> in <?php print $villageName; ?> Village, <?php print $countryName; ?>. You have disrupted extreme poverty for <?php print $numPeople; ?> people and <?php print $numHouseholds; ?> households.</p>
			<p>We deeply appreciate your commitment to Village X Org. With each montly donation, we'll send you a thank you email identifying the project you've supported.</p> 
			<p>Please stay tuned for project updates. As soon as they arrive, we'll notify you by email.</p>
        		<p>Sincerely,</p>
        		<p> The Village X Team</p>
        </div>
      
    </div>
	</div>
</div>
</body>
</html>
