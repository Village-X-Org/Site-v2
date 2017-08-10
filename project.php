<?php 
require_once("utilities.php");
include('header.inc'); 

$result = doQuery("SELECT project_id, village_id, project_name, picture_filename, project_summary, village_name, project_funded, project_budget, project_type FROM projects JOIN villages ON village_id=project_village_id JOIN pictures ON project_image_id=picture_id");
while ($row = $result->fetch_assoc()) {
    $projectId = $row['project_id'];
    $projectName = $row['project_name'];
    $pictureFilename = $row['picture_filename'];
    $summary = $row['project_summary'];
    $villageId = $row['village_id'];
    $villageName = $row['village_name'];
    $funded = $row['project_funded'];
    $total = $row['project_budget'];
    $projectType = $row['project_type'];
    $villageContribution = $total * .05;
    
    $households = getLatestValueForStat($villageId, "# of HH");
    $population = getLatestValueForStat($villageId, "# of People");
}

?>

<script>
$(document).ready(function(){
    $('.scrollspy').scrollSpy();
  });
</script>

<div id="index-banner" class="parallax-container"
	style="background-color: rgba(0, 0, 0, 0.3); height: 800px">

	<div class="parallax">
		<img src="temp/project banner.jpg">
	</div>
</div>

	<div class="container">
	
		<div><h4 class="header left brown-text text-lighten-2 text-shadow: 2px 2px 7px #111111">
					<a href='https://api.mapbox.com/styles/v1/jdepree/cj37ll51d00032smurmbauiq4/static/35.340250,-15.477861,14.60,-17.60,30.00/800x600?access_token=pk.eyJ1IjoiamRlcHJlZSIsImEiOiJNWVlaSFBBIn0.IxSUmobvVT64zDgEY9GllQ' data-imagelightbox="map" style='font-weight:bold;color:#654321'><?php print $villageName; ?> Village</a> needs $<?php print $total; ?> to <?php print strtolower($projectName); ?>. This project will help <?php print $population; ?> people across <?php print $households; ?> households. <?php print $villageName; ?> has contributed $<?php print $villageContribution; ?>, materials, and labor.
		</h4>

<script>
			var instanceMap = $( 'a[data-imagelightbox="map"]' ).imageLightbox(
			{
				onLoadStart: function() { activityIndicatorOn(); },
				onLoadEnd:	 function() { activityIndicatorOff(); },
				onEnd:		 function() { activityIndicatorOff(); }
			});
</script>	
		</div>
	
  	
  	<div style="display:table; width:100%">
  	     <div class="col-project valign-wrapper center-align" style="vertical-align: middle;">
				<img src="<?php print PICTURES_DIR."/$pictureFilename"; ?>" class="responsive-img">
				<p class="valign-wrapper; center-align">
					<b>Here's a similar project.</b>
				<br>
		</div>
				
		<div class="col-project valign-wrapper center-align" style="vertical-align: middle;">
							
					<div class="progress-bar" style="margin: 0 auto;" data-percent="60" data-duration="1000" data-color="#ccc, #4b86db"></div>
					
					<script>
						$(".progress-bar").loading();
					</script>
				
				<br>
				
		<div class="center-align"><b><font color="#4FC1E9">$<?php print $funded; ?> raised, $<?php print ($total - $funded); ?> to go</font></b></div>
				
					<br>
					
		<div class="center-align">
				<a href="http://materializecss.com/getting-started.html"
				id="download-button"
				class="waves-effect waves-light light blue lighten-1 btn-large">
				<i class="material-icons left">favorite_border</i>Donate</a>
		</div>

					<br>
					
		<div style="margin:auto;" class="center-align">
								<b>10 people have donated!</b>
		</div>
		
			<br><br>
	
			<div class="valign-wrapper center-align" style="vertical-align:middle; margin: 0px 20px 0px 20px;">
						<img src="images/stripe_payments.png" alt=""
							class="circle"
							style="width: 100px; height: 100px; vertical-align:middle; padding: 20px 20px 20px 20px">
							<br><br>
					<span class="black-text" style="margin: 0 auto; vertical-align:middle; padding: 20px 20px 20px 0px;">
							<i>100% tax deductible and securely processed by Stripe</i>
					</span>
			</div>

	</div>
	</div>
	
	<br>

<div class="section">
	<nav class="light blue" role="navigation">
    		<ul class="center-align row">
          <li class="waves-effect col s3">
              <a href='https://api.mapbox.com/styles/v1/jdepree/cj37ll51d00032smurmbauiq4/static/35.340250,-15.477861,14.60,-17.60,30.00/800x600?access_token=pk.eyJ1IjoiamRlcHJlZSIsImEiOiJNWVlaSFBBIn0.IxSUmobvVT64zDgEY9GllQ' data-imagelightbox="map"><i class="material-icons" style="font-size: 30px">place</i></a>           
          </li>
          <li class="waves-effect col s3" style="display: inline">
              <i class="material-icons" style="font-size: 30px">collections</i>
          </li>
          <li class="waves-effect col s3">
              <a href="#costbreakdown"><i class="material-icons" style="font-size: 30px">monetization_on</i></a>
          </li>
          <li class="waves-effect col s3">
              <a href="#databreakdown"><i class="material-icons" style="font-size: 30px">insert_chart</i></a>
          </li>
      	</ul>
  
  	<script>
			var instanceMap = $( 'a[data-imagelightbox="map"]' ).imageLightbox(
			{
				onLoadStart: function() { activityIndicatorOn(); },
				onLoadEnd:	 function() { activityIndicatorOff(); },
				onEnd:		 function() { activityIndicatorOff(); }
			});
	</script>
	
	</nav>
</div>

<br>

	<div class="section" style="text-align:center">
		<h5>Project Info</h5>
	</div>
	
	<div class="section">	
		<div class="row">
				<div class="col s12 m9 l9">
				<div class="card grey lighten-5 z-depth-1">
					<div class="card-content brown-text text-lighten-2 line-height: 120%">

							<p class="flow-text">Likoswe wants to build a nursery school
								to solve a persistent problem involving early childhood
								education.
							</p> <br>

							<p>
								<b>Community Problem:</b> Parents in Likoswe Village work long
								days on remote farms, making it difficult for them to supervise
								and educate their young children. Consequently, children receive
								very little formal education before the age of five.
							</p> 
							
							<br>

							<p>
								<b>Community Solution:</b> Likoswe will construct a small
								nursery school that will serve as a daycare and pre-school
								education facility. The school will provide a safe and
								educational environment for kids! After building the nursery
								school and stocking it with materials like a blackboard, chalk
								and books, community members will hire a teacher and pay that
								teacher with contributions provided by parents of children in
								attendance. The community has raised 5% of the project cost in
								cash (about $100) and will contribute labor, cement, bricks and
								sand to make it happen!
							</p> <br>

							<p>
								<b>Partners:</b> National Peace Corps Association
							</p>
						
					</div>
				</div>

			</div>

			<div class="col s12 m3 l3">
		
					<div class="timeline-container" style="textalign:center">
						<div class="timeline-block timeline-block-right">
							<div class="marker"></div>
							<div class="timeline-content">
								<h6>Dec 2016</h6>
								<span>village raises cash contribution</span>
							</div>
						</div>

						<div class="timeline-block timeline-block-left">
							<div class="marker"></div>
							<div class="timeline-content">
								<h6>Jan 2017</h6>
								<span>project posted</span>
							</div>
						</div>

						<div class="timeline-block timeline-block-right">
							<div class="marker"></div>
							<div class="timeline-content">
								<h6>March 2017</h6>
								<span>project funded</span>
							</div>
						</div>

						<div class="timeline-block timeline-block-left">
							<div class="marker"></div>
							<div class="timeline-content">
								<h6>May 2017</h6>
								<span>project completed</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col s12 m9 l9">
					<div class="card-panel grey lighten-5 z-depth-1">
						<div class="row valign-wrapper">
							<div class="col s12 m3 l3">
							<img src="temp/myson_profile.png"
								alt="" class="circle responsive-img"
								style="width: 100px; height: 100px;">
							<!-- notice the "circle" class -->
							</div>
							<div class="col s12 m9 l9 black-text">
								<b>Field Officer Myson Jambo</b>
								<p/>
								<b>Email:</b> mysonjambo@gmail.com, <b>Phone Number:</b>
									+2659783408
							</div>
						</div>
					</div>
				</div>
     			
				<div class="col s12 m3 l3 center-align">
					<h6 class="brown-text">
						<b>Share Likoswe's Story</b>
					</h6>
					<br>
					
						<a
							href="http://www.facebook.com/sharer.php?u=https://simplesharebuttons.com"
							target="_blank"> <img
							src="https://simplesharebuttons.com/images/somacro/facebook.png"
							alt="Facebook" align="middle" height="60" width="60" />
						</a>
						&nbsp;&nbsp;&nbsp;
						<a
							href="https://twitter.com/share?url=https://simplesharebuttons.com&amp;text=Simple%20Share%20Buttons&amp;hashtags=simplesharebuttons"
							target="_blank"> <img
							src="https://simplesharebuttons.com/images/somacro/twitter.png"
							alt="Twitter" align="middle" height="60" width="60" />
						</a>
				</div>
			</div>
			
	</div>

		<div id="costbreakdown" class="section scrollspy">
				<h5 style="text-align: center">Cost Breakdown</h5>
			<br>

			<div class="row">
				<div class="col s12 m2 l2">
					<div class="icon-block center brown-text">
						<i class="material-icons" style="font-size: 30px">directions_run</i>
						<h5>labor</h5>
						<h5 class="light center">
							$400
							</h5>
							<br>
					</div>
				</div>

				<div class="col s12 m2 l2">
					<div class="icon-block center brown-text">
						<i class="material-icons" style="font-size: 30px">domain</i>
						<h5 class="center brown-test">materials</h5>
						<h5 class="light center">
							$1100
							</h5>
							<br>
					</div>
				</div>

				<div class="col s12 m2 l2">
					<div class="icon-block center brown-text">
						<i class="material-icons" style="font-size: 30px">all_inclusive</i>
						<h5 class="center brown-test">admin</h5>
						<h5 class="light center">
							$200
							</h5>
							<br>
					</div>
				</div>

				<div class="col s12 m2 l2">
					<div class="icon-block center brown-text">
						<i class="material-icons" style="font-size: 30px">directions_bus</i>
						<h5 class="center brown-test">transport</h5>
						<h5 class="light center">
							$100
							</h5>
							<br>
					</div>
				</div>

				<div class="col s12 m2 l2">
					<div class="icon-block center brown-text">
						<i class="material-icons" style="font-size: 30px">account_balance</i>
						<h5 class="center brown-test">fees</h5>
						<h5 class="light center">
							$100
							</h5>
							<br>
					</div>
				</div>
				
				<div class="col s12 m2 l2">
					<div class="icon-block center brown-text">
						<i class="material-icons" style="font-size: 30px">camera_alt</i>
						<h5 class="center brown-test">pics/data</h5>
						<h5 class="light center">
							$0
							</h5>
							<br>
					</div>
				</div>
				
				<br>
			</div>

		</div>

		<hr width="85%">
	
		<div id="databreakdown" class="section scrollspy"></div>
			<h5 style="text-align: center">Data Trends</h5>
				<p style="font-size: 20px; text-align: center;" class="brown-text text-lighten-2 line-height: 120%">
					<b>We track the quantitative impact of your donation. In
					particular, we collect data on several development indicators,
					calculate an annual village development score, and observe how
					that score changes over time. You can learn more about our
					methodolody <a href="#!">here</a>.
					</b>
				</p>
					
			<div class="row">
				<div class="col s12 m6 l6" style="padding: 20px 30px 20px 30px">
						<h6 style="text-align: center"><b>Dollars Invested Over Time</b></h6>
					<div>
						<canvas id="chart1" width="250" height="250"></canvas>
					</div>
					<script>
						var ctx = document.getElementById("chart1").getContext(
								'2d');
						Chart.defaults.global.defaultFontFamily = "'Roboto', 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif";
						var chart1 = new Chart(ctx, {

							type : 'bar',
							data : {

								labels : [ 'Well, 2015', 'School, 2016',
										'Goats, 2017' ],
								datasets : [ {
									data : [ 6000, 2000, 2000 ],
									backgroundColor : [ '#ff6384', '#36a2eb',
											'#ffce56' ]
								} ]
							},
							options : {
								responsive : true,
								maintainAspectRatio : false,
								scales : {
									yAxes : [ {
										ticks : {
											beginAtZero : true
										}
									} ]
								},
								legend : {
									display : false,
								},
							}
						});
					</script>
					<br>
				</div>


				<div class="col s12 m6 l6" style="padding: 20px 30px 20px 30px">
						<h6 style="text-align: center"><b>Select Score Components Over Time</b></h6>
					<div>
						<canvas id="chart2" width="250" height="250"></canvas>
					</div>

					<script>
						var ctx = document.getElementById("chart2").getContext(
								'2d');
						var chart2 = new Chart(ctx,
								{
									type : 'radar',
									data : {
										labels : [ 'Business', 'Lifestyle',
												'Education', 'Agriculture',
												'Livestock'],
										datasets : [ {

											fill : true,
											backgroundColor : "#ff6384",
											label : '2014',
											data : [ 3, 5, 3, 5, 6 ],

										}, {
											fill : true,
											backgroundColor : "#36a2eb",
											label : '2015',
											data : [ 4, 7, 3, 3, 6 ],
										}, {
											fill : true,
											backgroundColor : "#ffce56",
											label : '2016',
											data : [ 6, 9, 5, 6, 8 ],
										} ],
									},
									options : {
										responsive : true,
										maintainAspectRatio : false,
									}
								});
					</script>
				</div>

	</div>
	
	<div class="row">
		<div class="col s12 m6 l6" style="padding: 20px 30px 20px 30px">
				
		<h6 style="text-align: center"><b>Waterborne Illness Over Time</b></h6>
			<div>
				<canvas id="chart3" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart3").getContext('2d');

				var chart3 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ '2014', '2015', '2016' ],
						datasets : [ {
							fill : true,
							backgroundColor : "#6495ED",
							data : [ 130, 50, 20 ],
						} ]
					},
					options : {
						responsive : true,
						maintainAspectRatio : false,
						legend : {
							display : false,
						}
					}

				});
			</script>
				
		</div>
	
		<div class="col s12 m6 l6" style="padding: 20px 30px 20px 30px">

				<h6 style="text-align: center"><b>Overall Score Over Time</b></h6>
			<div>
				<canvas id="chart4" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart4").getContext('2d');

				var chart4 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ '2014', '2015', '2016' ],
						datasets : [ {
							fill : true,
							backgroundColor : "#ffce56",
							data : [ -5, 10, 15 ],
						} ]
					},
					options : {
						responsive : true,
						maintainAspectRatio : false,
						legend : {
							display : false,
						}
					}

				});
			</script>
		</div>
	</div>
</div>

<br/>
<?php include('footer.inc'); ?>
