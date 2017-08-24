<?php
require_once ('utilities.php');
include ('header.inc');
?>
<script>
function addSubscription() {
	
}
</script>
<div id="index-banner" class="parallax-container"
	style="background-color: rgba(0, 0, 0, 0.3); height: 500px">
	<div class="section no-pad-bot valign-wrapper"
		style="height: 100%; width: 100%;">
		<div class="row center">
			<div style="padding: 5% 5% 5% 5%;">
				<h2
					class="header col s12 white-text text-lighten-2 text-shadow: 2px 2px 7px #111111">Fund
					Projects That Villages Choose</h2>
			</div>

			<div style="padding: 5% 5% 5% 5%;">
				<br>
				<br>
				<h5 class="header center light text-shadow: 2px 2px 7px #111111">because
					everyone deserves a voice in development</h5>
			</div>

			<div style="padding: 0% 5% 5% 5%;">
				<br>
				<br>
				<a href="project_tiles.php" id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1">meet
					the villages</a>
			</div>

			<div class="parallax">
				<img src="images/header1.jpg">
			</div>
		</div>
	</div>
</div>

<div class="container">
	<br>
	<h4 class="header center light blue-text text-lighten-2">Help African
		villages disrupt extreme poverty</h4>

	<!--   <h5 class="header center brown-text text-lighten-2">How It Works</h5> -->
	<div class="section">
		<!--   Icon Section   -->
		<div class="row">
			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center brown-text">
						<img src="images/icon_village.png" height="75px" width="75px">
					</h2>
					<h5 class="center">Find a village</h5>

					<p class="light center">Our partner villages are located in rural
						Africa, where extreme poverty is on the rise. Our model and
						technology elevate their voices in international development.</p>

				</div>
			</div>

			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center brown-text">
						<img src="images/icon_heart.png" height="75px" width="75px">
					</h2>
					<h5 class="center">Fund a project</h5>

					<p class="light center">Villages identify their biggest problems
						and propose locally appropriate solutions. They also put skin in
						the game by contributing cash, labor, and materials.</p>
				</div>
			</div>

			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center brown-text">
						<img src="images/icon_pic.png" height="75px" width="75px">
					</h2>
					<h5 class="center">Track your impact</h5>

					<p class="light center">Donors receive email updates with project
						pictures and data showing exactly how each donation has helped.
						It's our 100% transparency guarantee.</p>
				</div>
			</div>
		</div>

	</div>
</div>
<hr width="85%">

<div class="container">
	<br>
	<h5 class="header center brown-text text-lighten-2">Featured Projects</h5>
	<div class="section">

		<!--   project section   -->
		<div class="row">
<?php
$result = doQuery("SELECT project_id, project_name, picture_filename, project_summary, village_name, project_funded, project_budget FROM projects JOIN villages ON project_village_id=village_id JOIN pictures ON project_image_id=picture_id WHERE project_status = 'funding' LIMIT 3");

while ($row = $result->fetch_assoc()) {
    $projectId = $row['project_id'];
    $funded = $row['project_funded'];
    $projectTotal = $row['project_budget'];
    $fundedPercent = $funded / $projectTotal * 100;
    $villageContribution = $projectTotal * .05;
    print "<div class='col s12 m4' style='min-width:300px;'>
			<div class='card sticky-action hoverable'>
				<div class='card-image waves-effect waves-block waves-light'>
					<img class='activator' src='" . PICTURES_DIR . "/{$row['picture_filename']}' onclick=\"document.location='project.php?id=$projectId';\">
				</div>
				<div class='card-content'>
					<span class='card-title activator grey-text text-darken-4'  style='font-size:18px;'  onclick=\"document.location='project.php?id=$projectId';\">{$row['project_name']}
						<i class='material-icons right'>more_vert</i>
					</span>
					<h6 class='brown-text'>
						<b>{$row['village_name']} Village</b>
					</h6>
					<br>
					<h6>
						<b>\$$funded funded out of \$$projectTotal</b>
					</h6>
					<div class='progress'>
						<div class='determinate' style='width: $fundedPercent%'></div>
					</div>
					<p>Locals Contributed: \$$villageContribution</p>
				</div>
				<div class='card-action'>
					<div class='row center'>
						<div class='col s12'>
							<a href='http://materializecss.com/getting-started.html'
								id='download-button'
								class='btn waves-effect waves-light light blue lighten-1'>Donate</a>
						</div>
					</div>
				</div>
			</div>
	      </div>";
}
?>			
		</div>
		<br>

		<div class="row center">
			<a href='Project_Tiles.php' id="download-button"
				class="btn-large waves-effect waves-light light blue lighten-1">more
				projects</a>
		</div>
	</div>
</div>

<!-- <hr width="85%">

  <div class="container">
	<br>
	<h5 class="header center brown-text text-lighten-2">Map-Based
		Reporting</h5>
	<p style="text-align: center;">
		<img src="images/map_screenshot.png"
			style="opacity: 0.7; width: 100%; height: auto;">
	</p>
</div> -->

<hr width="85%">

<div class="container">
	<br>
	<h5 class="header center brown-text text-lighten-2">Our Impact</h5>
	<div class="section">

		<!--   Icon Section   -->
		<div class="row center">
			<br>
			<div class="col s12 m3 l3">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">trending_down</i>
					<h5 class="center brown-test">waterborne illness</h5>
					<h4 class="light center">-70%</h4>
					<h6 class="light center">p-value&lt;=0.01</h6>
					<br> <br> <br>
				</div>
			</div>

			<div class="col s12 m3 l3">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">trending_up</i>
					<h5 class="center brown-test">boys/girls in nursery school</h5>
					<h4 class="light center">+66%/60%</h4>
					<h6 class="light center">p-value&lt;=0.05</h6>
					<br> <br> <br>
				</div>
			</div>

			<div class="col s12 m3 l3">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">trending_up</i>
					<h5 class="center brown-test">non-agricultural businesses</h5>
					<h4 class="light center">+100%</h4>
					<h6 class="light center">p-value&lt;=0.05</h6>
					<br> <br> <br>
				</div>
			</div>

			<div class="col s12 m3 l3">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">trending_up</i>
					<h5 class="center brown-test">girls in high school</h5>
					<h4 class="light center">+80%</h4>
					<h6 class="light center">p-value~0.1</h6>
					<br> <br> <br>
				</div>
			</div>
		</div>

		<div>
			<h6 class="light center-align">
				*based on difference-in-differences analysis using data, from 2014
				to 2016, on 21 projects and 32 villages (more info <a
					href='Impacts.php'>here</a>)
			</h6>
		</div>
		<br>
	</div>

</div>

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
					class="btn-large waves-effect waves-light light blue lighten-1 modal-trigger" href="#subscriptionModal" 
					>Give Monthly</a>	
				<script>
                		$(document).ready(function(){
                    		$('.modal').modal();
                  	});
                </script>
				<div id="subscriptionModal" class="modal" style='color:black;'>
					<div class="modal-content">
						<h4>Give Monthly</h4>
						<p>A bunch of text</p>
					</div>
					<div class="modal-footer">
						<div class='row'>
							<div class='col'>
								$ <input type='text' id='amountText' value='20' />
							</div>
							<div class='col'>
                        			<button id="customButton">Subscribe!</button>
                        		</div>
                        </div>
                        <script>
                        var handler = StripeCheckout.configure({
                          key: 'pk_test_AXxdOsB0Xz9tOVdCVq8jpkAQ',
                          image: 'https://s3.amazonaws.com/stripe-uploads/acct_14tfQ6EfZscNLAofmerchant-icon-1414779028120-Screen%20Shot%202014-09-29%20at%2012.21.02%20PM.png',
                          locale: 'auto',
                          token: function(token) {
                        	  $.post("subscribe.php", {
                			        stripeToken: token.id,
                			        stripeEmail: token.email,
                			        stripeAmount: $('#amountText').val() * 100
                			    },
                			    function(data, status) {
                			    	 	Materialize.toast(data, 4000);
                			    });
                          }
                        });
                        
                        document.getElementById('customButton').addEventListener('click', function(e) {
                          // Open Checkout with further options:
                          handler.open({
                            name: 'Village X Org',
                            description: 'Monthly Subscription',
                            amount: $('#amountText').val() * 100
                          });
                          e.preventDefault();
                        });
                        
                        // Close Checkout on page navigation:
                        window.addEventListener('popstate', function() {
                          handler.close();
                        });
                        </script>
					</div>
				</div>
			</div>
			<br>
			<div class="row center">
				<h6
					class="header col s12 white-text light text-shadow: 4px 4px 7px #FFFFFF;">
					automatically donate to a project each month,<br> and enjoy impact
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

<?php include('footer.inc'); ?>
