<div id="index-banner" class="parallax-container"
	style="background-color: rgba(0, 0, 0, 0.3); height: 800px">
	<div class="section no-pad-bot valign-wrapper"
		style="height: 100%; width: 100%;">
		<div class="container">
			<div class="row center">
				<h5
					class="header col s12 white-text light text-shadow: 4px 4px 7px #FFFFFF;">
					support the<br> <b>VILLAGE FUND</b>
				</h5>
			</div>
			<div class="row center">
				<a
					id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1 modal-trigger" href='village_fund_payment_view.php' 
					>Give Monthly</a>	
				<div id="subscriptionModal" class="modal" style='color:black;'>
					<div class="modal-content">
						<h4>Give Monthly</h4>
						<p>A bunch of text</p>
					</div>
					<div class="modal-footer">
						<div class='row'>
							<div class='col'>
								$ <input type='text' id='footerAmountText' value='20' />
							</div>
							<div class='col'>
                        			<button id="customButton">Subscribe!</button>
                        		</div>
                        </div>
                        <script>

                        document.getElementById('customButton').addEventListener('click', function(e) {
                          // Open Checkout with further options:
                          handler.open({
                            name: 'Village X Org',
                            description: 'Monthly Subscription',
                            amount: $('#footerAmountText').val() * 100
                          });
                          e.preventDefault();
                        });
                        </script>
					</div>
				</div>
			</div>
			<br>
			<div class="row center">
				<h6
					class="header col s12 white-text light text-shadow: 4px 4px 7px #FFFFFF;" style="padding:0% 5% 0% 5%;">
					automatically donate to a project each<br> month, and enjoy impact
					updates all year long
				</h6>
			</div>
			<div class="row center">
				<h5
					class="header col s12 white-text light text-shadow: 4px 4px 7px #FFFFFF;">
					starting at</h5>
				<h3
					class="header col s12 white-text light text-shadow: 4px 4px 7px #FFFFFF;">
					$5</h3>
				<h5
					class="header col s12 white-text light text-shadow: 4px 4px 7px #FFFFFF;">
					/ month</h5>
			</div>
		</div>
	</div>
	<div class="parallax">
		<img src="images/footer1.jpg" alt="Unsplashed background img 2">
	</div>
</div>

<footer class="page-footer light blue">
	<div class="container">
		<div class="row">
			<div class="col l4 s12">
				<h6 class="white-text">
					<b><a class="white-text" href="index.php">Village X Org</a></b>
				</h6>
				<ul>
					<li><a class="white-text" href="project_tiles.php">Projects</a></li>
					<li><a class="white-text" href="map.php">Map</a></li>
					<li><a class="white-text" href="model.php">Model</a></li>
					<li><a class="white-text" href="impacts.php">Impacts</a></li>
					<li><a class="white-text" href="faq.php">FAQ</a></li>
					<li><a class="white-text" href="about.php">About</a></li>
				</ul>
			</div>

			<div class="col l4 s12">
				<h6 class="white-text">
					<b>Connect</b>
				</h6>
				<ul>
					<li><a class="white-text"
						href="https://www.instagram.com/villagexorg/" target="_blank"><i
							style="font-size: 15px" class="fa">&#xf16d;</i> Instagram</a></li>
					<li><a class="white-text"
						href="https://www.facebook.com/villagexorg/" target="_blank"><i
							style="font-size: 15px" class="fa">&#xf082;</i> Facebook</a></li>
					<li><a class="white-text"
						href="https://twitter.com/villagexorg" target="_blank"><i
							style="font-size: 15px" class="fa">&#xf081;</i> Twitter</a></li>
				</ul>
				
				<h6 class="white-text">
						<b>Share Our Mission</b>
					</h6>
					
					
						<a
							href="https://www.facebook.com/dialog/feed?
  									app_id=<?php print FACEBOOK_APP_ID; ?>
  									&display=popup&caption=This site disrupts extreme poverty in Africa
  									&link=https://www.4and.me"
							target="_blank"> <img
							src="https://simplesharebuttons.com/images/somacro/facebook.png"
							alt="Facebook" align="middle" height="30" width="30" />
						</a>
						&nbsp;&nbsp;&nbsp;
						<a
							href="https://twitter.com/share?url=https://www.4and.me;text=This site disrupts extreme Poverty in Africa&amp;hashtags=villagex"
							target="_blank"> <img
							src="https://simplesharebuttons.com/images/somacro/twitter.png"
							alt="Twitter" align="middle" height="30" width="30" />
						</a>
				
			</div>

			<div class="col l4 s12">
				<h6 class="white-text">
					<b>Contact</b>
				</h6>
				<ul>
					<li><a class="white-text">Village X Org</a></li>
					<li><a class="white-text">3717 W Street NW</a></li>
					<li><a class="white-text">Washington, DC 20007</a></li>
					<li><a class="white-text">202&#65279;-360&#65279;-9931</a></li>
					<li><a class="white-text">chat@villagex.org</a></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="footer-copyright">
		<div class="container">
			<div class="row">
				<div class="col s12 m4 l4" align="left">
					<p style="line-height:1.5;">©Village X Org, 2017 <br>501(c)(3) nonprofit <br>EIN: 47&#65279;-1845825&#65279;</p>
				</div>
				<div class="col s12 m4 l4" align="left">
					<p style="line-height:1.5;"><b>Our technology disrupts extreme poverty with data and direct giving. Aiming to reach 390 million people in rural Africa.</b></p>
				</div>
				<div class="col s12 m4 l4" align="left">
					<p style="line-height:1.5;">
						<a href="tos.php">Terms of Service</a><br> <a href="privacy_policy.php">Privacy Policy</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</footer>

</body>

</html>