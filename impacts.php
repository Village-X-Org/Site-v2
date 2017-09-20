<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header.inc'); ?>
<div id="index-banner" class="parallax-container" style="background-color: rgba(0, 0, 0, 0.3); height: 500px;">
	<div class="section no-pad-bot valign-wrapper" style="height: 100%; width:100%;">
		<div class="row center">
			<h2 class="header col s12 white-text text-lighten-2 text-shadow: 2px 2px 7px #111111">Our Impacts</h2>	

			<div class="parallax" style="background-size: cover;">
				<img src="images/reward_good_dev.jpg">
			</div>
		</div>
	</div>
</div>

<div class="container">
	
	<div class="section flow-text" style="width:100%;"> 
		<p>We are data nerds. We believe, as a matter of integrity and intellectual honesty, that organizations claiming
		to help others should support those claims with convincing quantitative evidence of impact. We rely on such evidence
		in law, public policy, medicine, engineering, and other diciplines that affect our daily lives. We should hold well-intentioned 
		charities to the same standard.</p>
	</div>

<div class="row">
			
			<div class="col s12 m12 l12 center-align" style="padding: 20px 30px 20px 30px">

				<h5 style="text-align: center"><b>Development Scores Over Time</b></h5>
				<h6 style="text-align: center"><b>Partner Villages (blue) v. Control Villages (gray)</b></h6>
			<div>
				<canvas id="chart1" width="350" height="350"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart1").getContext('2d');

				var chart1 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ 2014, 2015, 2016],
						datasets : [ {
							label: "Partner Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 10,
							data : [ 11.92, 12.42, 16.93 ],
							cubicInterpolationMode: 'monotone',
						}, 

						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(220,220,220,1)",
                             pointBackgroundColor: "rgba(220,220,220,1)",
                             pointRadius: 10,
							data : [ 13.72, 12.11, 9.5 ],
							cubicInterpolationMode: 'monotone',
						}]
						}, 
					options : {
						responsive : true,
						maintainAspectRatio : false,
						legend : {
							display : false,
						},
					scales : {
						yAxes : [ {
							ticks : {
								beginAtZero : false,
							}
						} ]
					},
					}

				});
			</script>
		</div>
	</div>
	
	<div class="row">
	
	<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">

				<h6 style="text-align: center"><b>Waterborne Illness Over Time Compared to Control Villages</b></h6>
			<div>
				<canvas id="chart2" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart2").getContext('2d');

				var chart2 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ 2014, 2015, 2016 ],
						datasets : [ {
							label: "Partner Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 10,
							data : [ 7.835, 5.287, 2.378 ],
							cubicInterpolationMode: 'monotone',
						}, 

						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(220,220,220,1)",
                             pointBackgroundColor: "rgba(220,220,220,1)",
                             pointRadius: 10,
                             data : [ 9.267, 8.219, 8.299 ],
							cubicInterpolationMode: 'monotone',
						}]
						}, 
					options : {
						responsive : true,
						maintainAspectRatio : false,
						legend : {
							display : false,
						},
					scales : {
						yAxes : [ {
							ticks : {
								beginAtZero : true,
							}
						} ]
					},
					}

				});
			</script>
		</div>
		
	<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">

				<h6 style="text-align: center"><b>Agricultural Output Over Time Compared to Control Villages</b></h6>
			<div>
				<canvas id="chart5" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart5").getContext('2d');

				var chart5 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ 2014, 2015, 2016 ],
						datasets : [ {
							label: "Partner Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 10,
							data : [ 10.30671882, 6.612934498, 4.313312337 ],
							cubicInterpolationMode: 'monotone',
						}, 

						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(220,220,220,1)",
                             pointBackgroundColor: "rgba(220,220,220,1)",
                             pointRadius: 10,
                             data : [ 9.211201343, 5.621902842, 3.832121553 ],
							cubicInterpolationMode: 'monotone',
						}]
						}, 
					options : {
						responsive : true,
						maintainAspectRatio : false,
						legend : {
							display : false,
						},
					scales : {
						yAxes : [ {
							ticks : {
								beginAtZero : true,
							}
						} ]
					},
					}

				});
			</script>
		</div>	
	</div>
	
	<div class="row">
	<div class="col s12 m6 l6" style="padding: 20px 30px 20px 30px">
						<h6 style="text-align: center"><b>Remaining Score Components Over Time for Partner Villages</b></h6>
					<div>
						<canvas id="chart3" width="250" height="250"></canvas>
					</div>

					<script>
						var ctx = document.getElementById("chart3").getContext(
								'2d');
						var chart3 = new Chart(ctx,
								{
									type : 'radar',
									data : {
										labels : [ 'Business', 'Lifestyle',
												'Education', 
												'Livestock'],  
										datasets : [
											{
										          label: "2014",
										          fill: true,
										          backgroundColor: "rgba(255,99,132,0.4)",
										          borderColor: "rgba(179,181,198,1)",
										          pointBorderColor: "#fff",
										          pointBackgroundColor: "rgba(179,181,198,1)",
										          pointRadius: 2,
										          data: [ 1.339496041, 1.884430348, 1.58, 1.440140331 ]
										        },
											{
										          label: "2015",
										          fill: true,
										          backgroundColor: "rgba(54,162,235,0.4)",
										          borderColor: "rgba(179,181,198,1)",
										          pointBorderColor: "#fff",
										          pointBackgroundColor: "rgba(179,181,198,1)",
										          pointRadius: 2,
										          data: [ 1.850773378, 2.057503179, 1.85, 1.693112104 ]
										        },
											{
										          label: "2016",
										          fill: true,
										          backgroundColor: "rgba(255,206,86,0.4)",
										          borderColor: "rgba(179,181,198,1)",
										          pointBorderColor: "#fff",
										          pointBackgroundColor: "rgba(179,181,198,1)",
										          pointRadius: 2,
										          data: [ 2.692370418, 3.014114816, 2.38, 2.126753307 ]
										        }
							
									],
									},
									options : {
										responsive : true,
										maintainAspectRatio : false,
									}
								});
					</script>
			</div> 
			
	<div class="col s12 m6 l6" style="padding: 20px 30px 20px 30px">
						<h6 style="text-align: center"><b>Remaining Score Components Over Time for Control Villages</b></h6>
					<div>
						<canvas id="chart4" width="250" height="250"></canvas>
					</div>

					<script>
						var ctx = document.getElementById("chart4").getContext(
								'2d');
						var chart4 = new Chart(ctx,
								{
									type : 'radar',
									data : {
										labels : [ 'Business', 'Lifestyle',
												'Education',
												'Livestock'],  
										datasets : [
											{
										          label: "2014",
										          fill: true,
										          backgroundColor: "rgba(255,99,132,0.4)",
										          borderColor: "rgba(179,181,198,1)",
										          pointBorderColor: "#fff",
										          pointBackgroundColor: "rgba(179,181,198,1)",
										          pointRadius: 2,
										          data: [ 1.834480394, 2.719112058, 2.06, 3.4373324951 ]
										        },
											{
										          label: "2015",
										          fill: true,
										          backgroundColor: "rgba(54,162,235,0.4)",
										          borderColor: "rgba(179,181,198,1)",
										          pointBorderColor: "#fff",
										          pointBackgroundColor: "rgba(179,181,198,1)",
										          pointRadius: 2,
										          data: [ 1.899622477, 2.581994567, 2.14, 3.782552672 ]
										        },
											{
										          label: "2016",
										          fill: true,
										          backgroundColor: "rgba(255,206,86,0.4)",
										          borderColor: "rgba(179,181,198,1)",
										          pointBorderColor: "#fff",
										          pointBackgroundColor: "rgba(179,181,198,1)",
										          pointRadius: 2,
										          data: [ 1.627114886, 2.51217026, 2.17, 3.334513563 ]
										        }
							
									],
									},
									options : {
										responsive : true,
										maintainAspectRatio : false,
									}
								});
					</script>
			</div> 
		
	</div>
	
	<div class="section flow-text" style="width:100%;"> 
		<p>The data show villages on divergent development paths. Both partner and control villages performed poorly during two bad agricultural years (2015 and 2016) and
		posted similar livestock scores over time. Yet, starting in 2015, partner villages outperformed control villages in terms of waterborne illness, education, lifestyle,
		and business. Do these descriptive statistics contain statistically significant impacts? Find out below.</p>
	</div>
	
	<hr>
	
	<div class="section"><h4 class="header left brown-text text-lighten-2 text-shadow: 2px 2px 7px #111111" style="width:100%">
			Evaluation Results
	</h4></div><br>
	
	<div class="section flow-text" style="width:100%;"> 
		<p>In 2016, after two years of funding projects, we evaluated our impact. Our approach wasn't fancy or expensive (more on that
		below). Instead, it tested a foundational assumption that financing village-led projects without any sort of preconceived 
		development agenda would allow local communities to illuminate development pathways obscured from the outside. In other words, 
		we funded a bunch of projects, collected a bunch of development indicators, and tested whether anything had changed. 
		Did communitites improve and, if so, how? Here's what we found.</p>
	</div>
	
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
					<br> 
				</div>
			</div>
		</div>
	</div>

<hr>

<div class="section"><h4 class="header left brown-text text-lighten-2 text-shadow: 2px 2px 7px #111111">
			How We Got These Results
	</h4></div>

<br>

	<div class="section flow-text"> 
		<p>Using community surveys spanning 2014 to 2016, across 21 projects and 32 villages, we tracked the following 13 development 
		indicators pertaining to health, education, business, lifestyle, agriculture, and livestock, both in partner villages and 
		villages that want to partner with Village X. We chose these indicators because they are easy to collect and indicative of
		 village development trends. We then applied a difference-in-differences analysis to detect our model’s impacts, 
		controlling for village population and number of households.</p>
	</div>
	
	<div class="section">
		<!--   Icon Section   -->
		<div class="row center">
			<br>
			<div class="col s12 m2 l2">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">local_hospital</i>
					<h5 class="center brown-test">health</h5>
					<h6 class="light center">waterborne illness</h6>
				</div>
				<br>
			</div>

			<div class="col s12 m2 l2">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">school</i>
					<h5 class="center brown-test">education</h5>
					<h6 class="light center"># of boys/girls in nursery</h6>
					<h6 class="light center"># of boys/girls in primary</h6>
					<h6 class="light center"># of boys/girls in secondary</h6>
					<h6 class="light center"># of boys/girls in tertiary</h6>
				</div>
				<br>
			</div>

			<div class="col s12 m2 l2">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">local_convenience_store</i>
					<h5 class="center brown-test">business</h5>
					<h6 class="light center"># of agricultural businesses</h6>
					<h6 class="light center"># of non-agricultural businesses</h6>
				</div>
				<br>
			</div>

			<div class="col s12 m2 l2">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">tv</i>
					<h5 class="center brown-test">lifestyle</h5>
					<h6 class="light center"># of TVs</h6>
					<h6 class="light center"># of motorcycles</h6>
					<h6 class="light center"># of steel roofs</h6>
				</div>
				<br>
			</div>
			
			<div class="col s12 m2 l2">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">spa</i>
					<h5 class="center brown-test">agriculture</h5>
					<h6 class="light center"># of kilograms of maize</h6>
				</div>
				<br>
			</div>

			<div class="col s12 m2 l2">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">goat</i>
					<h5 class="center brown-test">livestock</h5>
					<h6 class="light center"># of goats</h6>
					<h6 class="light center"># of cows</h6>
				</div>
			</div>
		</div>
	</div>
	
	<div class="section flow-text"> 
		<p>Each project profile on this website has graphs showing how development scores for a given village change
		over time, including an overall village development score and scores for each of the categories above. These scores 
		are not precision instruments. Instead, they capture village development trends over time.</p>
		<p>Want to take a deeper dive? Checkout our dataset <a href="#">here</a>. It's part of our 100% tranparency guarantee.</p>
	</div>

<hr>	

	<div class="section"><h4 class="header left brown-text text-lighten-2 text-shadow: 2px 2px 7px #111111">
			Next Steps
	</h4></div> <br>

	<div class="section flow-text"> 
		<p>We are not satisfied with our impact evaluation. It's a good start, but we can do better. In particular, we could
		track how projects we finance affect individual household spending within a village. How do families modify their
		spending in response to village-led projets? Do the projects make families wealthier?</p>
		<p>Answering these questions requires overcoming two challenges: (1) our current portfolio of partner villages
		is not large enough (we need at least 300 per year); and (2) we do not possess a large monitoring and evaluation budget. 
		We plan to scale our operations to overcome the first challenge and to partner with academic researchers to overcome
		the second one.</p>
	</div>
		
</div>

<?php include('footer.inc'); ?>