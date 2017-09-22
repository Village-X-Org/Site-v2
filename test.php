
<!DOCTYPE html>
<html lang="en">
<head>

<!--  
<meta property="fb:appid" content="<?php print FACEBOOK_APP_ID; ?>"/>
<meta property="og:image" content="<?php print PICTURES_DIR.$bannerPicture; ?>"/>
<meta property="og:title" content="I donated to <?php print $projectName; ?> in <?php print $villageName; ?> Village"/>
<meta property="og:url" content="https://4and.me/<?php print $projectId; ?>"/>
<meta property="og:description" content="Disrupt extreme poverty by funding projects villages choose. <?php print $summary; ?>"/>
-->
<?php
$metaProvided = 1; 
include('header.inc'); ?>


<div id="index-banner" class="parallax-container" style="background-color: rgba(0, 0, 0, 0.3); height: 500px;">
	<div class="section no-pad-bot valign-wrapper" style="height: 100%; width:100%;">
	<div class="container">
		<div class="row center">
			<h2 class="header col s12 white-text text-lighten-2 text-shadow: 2px 2px 7px #111111">Thanks for the donation!</h2>
		</div>
			<br>
			<div class="row center"><p class="white-text text-lighten-2 text-shadow: 2px 2px 7px #111111"><b>Share your generosity to inspire others</b></p>	
			</div> 
			<div class="row center">
					<a href="https://www.facebook.com/dialog/feed?app_id=<?php print FACEBOOK_APP_ID; ?>&display=popup&caption=text&link=https://4and.me/100" target="_blank"> 
  		<img src="https://simplesharebuttons.com/images/somacro/facebook.png"
  			alt="Facebook" align="middle" height="70" width="70" style="margin:0% 0% 1% 0%"/>
  	</a>
    &nbsp;&nbsp;&nbsp;
    <a href="https://twitter.com/share?url=https://4and.me/100;text=test&amp;hashtags=villagex"
		    target="_blank"> <img
		    src="https://simplesharebuttons.com/images/somacro/twitter.png"
		    alt="Twitter" align="middle" height="70" width="70" style="margin:0% 0% 1% 0%"/>
   </a>
			
			</div>
	</div>

			<div class="parallax" style="background-size: cover;">
				<img src="" />
			</div>
		</div>
	</div>
</div>
<br>

<div class="container">

	<div class="row">
      <div class="col s12 m12 l12">
        
          
      
    </div>
	</div>
</div>


<?php include('footer.inc'); ?>
