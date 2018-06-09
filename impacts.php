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
			
			<div class="col s12 m12 l12 center-align" style="padding: 10px 30px 20px 30px">

				<h5 style="text-align: center"><b>Development Scores: <span class="blue-text">Partner Villages</span> v. <span style="color:rgba(192,192,192,1)">Control Villages</span></b></h5>
			<div>
				<canvas id="chart1" width="350" height="350"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart1").getContext('2d');

				var chart1 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ 2014, 2015, 2016, 2017],
						datasets : [ {
							label: "Partner Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 10,
							data : [ 9.92, 10.3, 15, 22.7 ],
							cubicInterpolationMode: 'monotone',
						}, 

						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(192,192,192,1)",
                             pointBackgroundColor: "rgba(192,192,192,1)",
                             pointRadius: 10,
							data : [ 17.3, 13.8, 11.5, 8.77 ],
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

				<h5 style="text-align: center"><b>Waterborne Illness: <span class="blue-text">Partner Villages</span> v. <span style="color:rgba(192,192,192,1)">Control Villages</span></b></h5>
			<div>
				<canvas id="chart2" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart2").getContext('2d');

				var chart2 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ 2014, 2015, 2016, 2017 ],
						datasets : [ {
							label: "Partner Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 10,
							data : [ 8.1, 5.5, 2.4, 1.3 ],
							cubicInterpolationMode: 'monotone',
						}, 

						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(192,192,192,1)",
                             pointBackgroundColor: "rgba(192,192,192,1)",
                             pointRadius: 10,
                             data : [ 10, 9.3, 9.4, 11 ],
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

				<h5 style="text-align: center"><b>Agricultural Output: <span class="blue-text">Partner Villages</span> v. <span style="color:rgba(192,192,192,1)">Control Villages</span></b></h5>
			<div>
				<canvas id="chart5" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart5").getContext('2d');

				var chart5 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ 2014, 2015, 2016, 2017 ],
						datasets : [ {
							label: "Partner Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 10,
							data : [ 9.7, 5.9, 3.9, 7.1 ],
							cubicInterpolationMode: 'monotone',
						}, 

						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(220,220,220,1)",
                             pointBackgroundColor: "rgba(220,220,220,1)",
                             pointRadius: 10,
                             data : [ 10.7, 6, 4.2, 4.3 ],
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
						<h5 style="text-align: center"><b>Remaining Dimensions: <span class="blue-text">Partner Villages</span></b></h5>
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
										          backgroundColor: "rgba(255,99,132,0.1)",
										          borderColor: "rgba(255,99,132,1)",
										          pointBorderColor: "#fff",
										          pointBackgroundColor: "rgba(179,181,198,1)",
										          pointRadius: 2,
										          data: [ 1.3, 1.5, 1.3, 1.5 ]
										        },
											{
										          label: "2015",
										          fill: true,
										          backgroundColor: "rgba(54,162,235,0.4)",
										          borderColor: "rgba(54,162,235,1)",
										          pointBorderColor: "#fff",
										          pointBackgroundColor: "rgba(179,181,198,1)",
										          pointRadius: 2,
										          data: [ 1.9, 1.8, 1.5, 1.7 ]
										        },
											{
										          label: "2016",
										          fill: true,
										          backgroundColor: "rgba(255,206,86,0.4)",
										          borderColor: "rgba(255,206,86,1)",
										          pointBorderColor: "#fff",
										          pointBackgroundColor: "rgba(179,181,198,1)",
										          pointRadius: 2,
										          data: [ 2.7, 2.8, 1.9, 2.2 ]
										        },

										        {
											          label: "2017",
											          fill: true,
											          backgroundColor: "rgba(102,255,102,0.4)",
											          borderColor: "rgba(102,255,102,1)",
											          pointBorderColor: "#fff",
											          pointBackgroundColor: "rgba(179,181,198,1)",
											          pointRadius: 2,
											          data: [ 3.3, 3.6, 2.2, 3.3 ]
											        }
							
									],
									},
									options : {
										responsive : true,
										maintainAspectRatio : false,
										layout: {
									        padding: {
									            bottom: 10
									        }
									    }
									}
								});
					</script>
			</div> 
			
	<div class="col s12 m6 l6" style="padding: 20px 30px 20px 30px">
						<h5 style="text-align: center"><b>Remaining Dimensions: <span style="color:rgba(192,192,192,1)">Control Villages</span></b></h5>
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
										          backgroundColor: "rgba(255,99,132,0.1)",
										          borderColor: "rgba(255,99,132,1)",
										          pointBorderColor: "#fff",
										          pointBackgroundColor: "rgba(179,181,198,1)",
										          pointRadius: 2,
										          data: [ 2, 3.1, 2.7, 3.8 ]
										        },
											{
										          label: "2015",
										          fill: true,
										          backgroundColor: "rgba(54,162,235,0.4)",
										          borderColor: "rgba(54,162,235,1)",
										          pointBorderColor: "#fff",
										          pointBackgroundColor: "rgba(179,181,198,1)",
										          pointRadius: 2,
										          data: [ 2.2, 3.2, 2.6, 3.9 ]
										        },
											{
										          label: "2016",
										          fill: true,
										          backgroundColor: "rgba(255,206,86,0.4)",
										          borderColor: "rgba(255,206,86,1)",
										          pointBorderColor: "#fff",
										          pointBackgroundColor: "rgba(179,181,198,1)",
										          pointRadius: 2,
										          data: [ 2, 3.1, 2.8, 3.2 ]
											},
										        {
											          label: "2017",
											          fill: true,
											          backgroundColor: "rgba(102,255,102,0.4)",
											          borderColor: "rgba(102,255,102,1)",
											          pointBorderColor: "#fff",
											          pointBackgroundColor: "rgba(179,181,198,1)",
											          pointRadius: 2,
											          data: [ 1.7, 3, 2.8, 2.3 ]
											        }
							
									],
									},
									options : {
										responsive : true,
										maintainAspectRatio : false,
										layout: {
									        padding: {
									            bottom: 10
									        }
									    }
									}
								});
					</script>
			</div> 
		
	</div>
	
	<div class="section flow-text" style="width:100%;"> 
		<p>We calculate these dimensional scores from 17 development indicators collected per village (more on that below).  The data show partner and control villages on divergent development paths. Both partner and control villages performed poorly during two bad agricultural years (2015 and 2016). Yet, starting in 2015, partner villages 
		outperformed control villages in terms of waterborne illness, education, lifestyle, livestock, and business.  In 2017, partner villages started outperforming control villages in terms of agricultural output. 
		Do these descriptive statistics contain statistically significant impacts? Find out below.</p>
	</div>
	
	<hr>
	
	<div class="section"><h4 class="header left brown-text text-lighten-2 text-shadow: 2px 2px 7px #111111" style="width:100%">
			Evaluation Results
	</h4></div><br>
	
	<div class="section flow-text" style="width:100%;"> 
		<p>Our most recent impact evaluation occurred in early 2018. Our approach wasn't fancy or expensive (more on that
		below). Instead, it tested a foundational assumption that financing village-led projects without any sort of preconceived 
		development agenda would allow local communities to illuminate development pathways obscured from the outside. In other words, 
		we funded a bunch of projects, collected a bunch of development indicators, and tested whether anything had changed. 
		Did communitites improve and, if so, how? Here's what we found.</p>
	</div>
	
<div class="section">
		<!--   Icon Section   -->
		<table class="highlight centered responsive-table flow-text">
		        <thead>
		          <tr>
		              <th>Metric</th>
		              <th>Boys in nursery</th>
		              <th>Girls in nursery</th>
		              <th>Girls in secondary</th>
		              <th>Goats</th>
		              <th>Waterborne illness</th>
		              <th>Non-ag businesses</th>
		          </tr>
		        </thead>

		        <tbody>
		          <tr>
		            <td>% change</td>
		            <td>+93%</td>
		            <td>+109%</td>
		            <td>+63%</td>
		            <td>+77%</td>
		            <td>-68%</td>
		            <td>+123%</td>
		          </tr>
		          <tr>
		            <td>actual change</td>
		            <td>+11 boys</td>
		            <td>+14 girls</td>
		            <td>+4 girls</td>
		            <td>+23 goats</td>
		            <td>-133 cases</td>
		            <td>+11 businesses</td>
		          </tr>
		          <tr>
		            <td>p-value</td>
		            <td>p<0.01</td>
		            <td>p<0.01</td>
		            <td>p<0.05</td>
		            <td>p<0.05</td>
		            <td>p<0.01</td>
		            <td>p<0.01</td>
		          </tr>
		        </tbody>
		      </table>
		      <div class="flow-text center-align" style="padding:3% 5% 0 5%;font-size:20px;">*Not shown are small but statistically significant increases in motorcycles, TVs, and men and women in college.  
		      </div>
	</div>

<hr>

<div class="section"><h4 class="header left brown-text text-lighten-2 text-shadow: 2px 2px 7px #111111">
			How We Got These Results
	</h4></div>

<br>

	<div class="section flow-text"> 
		<p>Using community surveys spanning 2014 (baseline) to 2017, across 27 projects and 39 villages, we tracked the following 17 development 
		indicators pertaining to health, education, business, lifestyle, agriculture, and livestock, both in partner villages and 
		control villages that want to partner with Village X. We chose these indicators because they are easy to collect and indicative of
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
		<p>Project profiles on this website for repeat village parters (those that have completed at least one project) have graphs showing how development scores for a given village change
		over time, including an overall village development score and scores for each of the dimensions set forth above. These scores 
		are not precision instruments. Instead, they capture village development trends over time.</p>
		<p>Want to take a deeper dive? Checkout our dataset <a href="https://docs.google.com/spreadsheets/d/1ND8Szlfg9tVfFNSAajiK6enKRlfZoXIayFCbB-WGYj4/edit?usp=sharing" target='_blank'>here</a>. It's part of our 100% tranparency guarantee.</p>
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