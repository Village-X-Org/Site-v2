	<a href="https://www.facebook.com/dialog/feed?app_id=<?php print FACEBOOK_APP_ID; ?>&display=popup&caption=<?php print urlEncode($facebookMessage); ?>&link=<?php print BASE_URL.($fundraiserId ? "fundraiser/$fundraiserId" : $projectId); ?>" target="_blank"> 
  		<img src="https://simplesharebuttons.com/images/somacro/facebook.png"
  			alt="Facebook" align="middle" height="<?php print $sideSize; ?>" width="<?php print $sideSize; ?>" />
  	</a>
    &nbsp;&nbsp;&nbsp;
    <a href="https://twitter.com/share?url=<?php print BASE_URL.($fundraiserId ? "fundraiser/$fundraiserId" : $projectId); ?>;text=<?php print urlencode($twitterMessage); ?>&amp;hashtags=villagex"
		    target="_blank"> <img
		    src="https://simplesharebuttons.com/images/somacro/twitter.png"
		    alt="Twitter" align="middle" height="<?php print $sideSize; ?>" width="<?php print $sideSize; ?>" />
   </a>
