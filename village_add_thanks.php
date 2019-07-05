<!DOCTYPE html>
<html lang="en">
<head>

<meta property="fb:appid" content="<?php print FACEBOOK_APP_ID; ?>"/>
<meta property="og:image" content="<?php print PICTURES_DIR.$bannerPicture; ?>"/>  <!-- here could we put the pic uploaded by the user? -->
<meta property="og:title" content="I just added <?php print $villageName; ?> to Village X's map!"/>
<meta property="og:url" content="<?php print BASE_URL.$projectId; ?>"/>  <!-- not sure what to put here -->
<meta property="og:description" content="Village X maps villages and funds development projects chosen by them."/>

<?php 
$metaProvided = 1; 
include('header.inc'); ?>

<div class="row" style="height:90vh;">

<div class="col s12 m12 l6" style="height:100%;padding:7% 6% 6% 6%">
	<div class="valign-wrapper">
		<div>
        		<div class="row left-align">
        			<h3 class="header col s12 black-text text-lighten-2 text-shadow: 2px 2px 7px #111111 flow-text" style="font-weight: 300">Thanks, (name), for adding your village in (country) on (date)!</h3>
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

