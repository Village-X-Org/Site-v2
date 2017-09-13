<!DOCTYPE html>
<html lang="en">
<head>

<meta property="fb:appid" content="<?php print FACEBOOK_APP_ID; ?>"/>
<meta property="og:image" content="<?php print PICTURES_DIR.$bannerPicture; ?>"/>
<meta property="og:title" content="I donated to <?php print $projectName; ?> in <?php print $villageName; ?> Village"/>
<meta property="og:url" content="https://4and.me/project.php?id=<?php print $projectId; ?>"/>
<meta property="og:description" content="Disrupt extreme poverty by funding projects villages choose. <?php print $summary; ?>"/>

<?php include('header.inc'); ?>
<?php $result = doQuery("SELECT project_name, village_name, country_label, picture_filename, peopleStats.stat_value AS peopleCount, hhStats.stat_value AS householdCount
        FROM projects JOIN villages ON project_id=$projectId AND project_village_id=village_id
        JOIN countries ON country_id=village_country
        JOIN village_stats AS peopleStats ON peopleStats.stat_type_id=18 AND peopleStats.stat_village_id=village_id
        JOIN village_stats AS hhStats ON hhStats.stat_type_id=19 AND hhStats.stat_village_id=village_id
        JOIN pictures ON picture_id=project_banner_image_id ORDER BY hhStats.stat_year DESC, peopleStats.stat_year DESC LIMIT 1"); 
if ($row = $result->fetch_assoc()) {
    $villageName = $row['village_name'];
?>
<div id="index-banner" class="parallax-container" style="background-color: rgba(0, 0, 0, 0.3); height: 500px;">
	<div class="section no-pad-bot valign-wrapper" style="height: 100%; width:100%;">
		<div class="row center">
			<h2 class="header col s12 white-text text-lighten-2 text-shadow: 2px 2px 7px #111111">Thanks for the donation!</h2>	

			<div class="parallax" style="background-size: cover;">
				<img src="<?php print PICTURES_DIR."/".$row['picture_filename']; ?>" />
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
			<p>We processed your donation for $<?php print $donationAmountDollars; ?> to <?php print $row['project_name']; ?> in <?php print $villageName; ?> Village! You have disrupted 
			extreme poverty for <?php print $row['peopleCount']; ?> people and <?php print $row['householdCount']; ?> households in <?php print $row['country_label']; ?>.</p>
			<p class="center-align"><b>Share the good news:</b> 
					<?php printShareButtons($projectId, 
						    "Disrupt extreme poverty by funding projects villages choose.", 
						    "I donated to $projectName in $villageName Village"); ?>
			</p>
			<p>This was your <?php print ordinal($donationCount); ?> donation to a village-led project. We deeply appreciate every donation and hope you will give again. Please
			 stay tuned for project updates. As soon as they arrive, we'll notify you by email.</p>
        		<p>If you haven't done so already, please consider supporting The Village Fund, which allows you to donate automatically every month (as little as $5) and enjoy
        		email updates all year long.</p> 
        		<p>Sincerely,</p>
        		<p> The Village X Team and <?php print $villageName; ?> Village</p>
        </div>
      
    </div>
	</div>
</div>
<?php } ?>
<?php include('footer.inc'); ?>
