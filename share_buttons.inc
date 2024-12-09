	<a href="https://www.facebook.com/dialog/feed?app_id=<?php print FACEBOOK_APP_ID; ?>&display=popup&caption=<?php print urlEncode($facebookMessage); ?>&link=<?php print BASE_URL.($fundraiserId ? "fundraiser/$fundraiserId" : $projectId); ?>" target="_blank"> 
  		<i style="font-size: 40px" class="fa">&#xf082;</i>
  	</a>
    &nbsp;&nbsp;&nbsp;
    <a href="https://twitter.com/share?url=<?php print BASE_URL.($fundraiserId ? "fundraiser/$fundraiserId" : $projectId); ?>;text=<?php print urlencode($twitterMessage); ?>&amp;hashtags=villagex"
		    target="_blank"> <i style="font-size: 40px" class="fa">&#xf081;</i>
   </a>
