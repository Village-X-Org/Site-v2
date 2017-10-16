<!DOCTYPE html>
<html lang="en">
<head>

<meta property="fb:appid" content="<?php print FACEBOOK_APP_ID; ?>"/>
<meta property="og:image" content="images/village_family.jpg"/>
<meta property="og:title" content="I signed up for the Village Fund!"/>
<meta property="og:url" content="<?php print BASE_URL.$projectId; ?>"/>
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
          <?php if ($donorFirstName) { ?>
          	<p><?php print $donorFirstName; ?>,</p>
          <?php } ?> 
			<p>We processed your first monthly donation of $<?php print $donationAmountDollars; ?>! 
			
			<?php if (isset($projectName)) { ?>
			We applied this donation to <?php print $projectName; ?> in <?php print $villageName; ?> Village, <?php print $countryName; ?>. You have disrupted extreme poverty for <?php print $numPeople; ?> people and <?php print $numHouseholds; ?> households.</p>
			<?php } ?>
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
