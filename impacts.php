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
		<p><b>We are data nerds.</b> We believe, as a matter of integrity and intellectual honesty, that organizations claiming
		to help others should support those claims with convincing quantitative evidence of impact. We rely on such evidence
		in law, public policy, medicine, engineering, and other disciplines that affect our daily lives. We should hold well-intentioned 
		charities to the same standard.</p> 
		<p>Our evaluation method is to collect 25 development indicators per village per year and run a statistical analysis (more on that below). 
		The data show partner and control villages on divergent development paths, with the former outperforming the latter. To get a sense of this, we graph partner v. control villages over time in terms of
		average overall development scores and the dimensional scores (health, education, business, lifestyle, agriculture, and livestock) that constitute the overall development scores.</p> 
		<p>Do these graphs reveal statistically significant impacts? Find out below.</p>
	</div>

<div class="row">
			
			<div class="col s12 m12 l12 center-align" style="padding: 10px 30px 20px 30px">

				<h5 style="text-align: center"><b>Overall Development: <span class="blue-text">Partner Villages</span> v. <span style="color:rgba(192,192,192,1)">Control Villages</span></b> (higher scores are better)</h5>
			<div>
				<canvas id="chart1" width="350" height="350"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart1").getContext('2d');

				var chart1 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ 2014, 2015, 2016, 2017, 2018],
						datasets : [ {
							label: "Partner Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 10,
							data : [ 17, 19, 22, 28, 30],
							cubicInterpolationMode: 'monotone',
						}, 

						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(192,192,192,1)",
                             pointBackgroundColor: "rgba(192,192,192,1)",
                             pointRadius: 10,
							data : [ 26, 28, 27, 26, 31 ],
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

				<h5 style="text-align: center"><b>Health Burden: <span class="blue-text">Partner Villages</span> v. <span style="color:rgba(192,192,192,1)">Control Villages</span></b> (lower scores are better)</h5>
			<div>
				<canvas id="chart2" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart2").getContext('2d');

				var chart2 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ 2014, 2015, 2016, 2017, 2018 ],
						datasets : [ {
							label: "Partner Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 10,
							data : [ 54, 43, 32, 30, 24 ],
							cubicInterpolationMode: 'monotone',
						}, 

						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(192,192,192,1)",
                             pointBackgroundColor: "rgba(192,192,192,1)",
                             pointRadius: 10,
                             data : [ 38, 39, 38, 44, 41 ],
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
			<h6 style="padding:0 3% 0 3%">*Scores based on # of waterborne illnesses, malaria cases, maternal deaths, and infant deaths per capita.</h6>
		</div>
		
		
	<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">

				<h5 style="text-align: center"><b>Local Education: <span class="blue-text">Partner Villages</span> v. <span style="color:rgba(192,192,192,1)">Control Villages</span></b> (higher scores are better)</h5>
			<div>
				<canvas id="chart3" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart3").getContext('2d');

				var chart3 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ 2014, 2015, 2016, 2017, 2018 ],
						datasets : [ {
							label: "Partner Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 10,
							data : [ 75, 81, 92, 102, 103 ],
							cubicInterpolationMode: 'monotone',
						}, 

						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(220,220,220,1)",
                             pointBackgroundColor: "rgba(220,220,220,1)",
                             pointRadius: 10,
                             data : [ 93, 100, 100, 103, 104 ],
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
			<h6 style="padding:0 3% 0 3%">*Scores based on school enrollment and national exam passage rates per capita.</h6>
		</div>	
	</div>
	
<div class="row">
	
	<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">

				<h5 style="text-align: center"><b>Business Activity: <span class="blue-text">Partner Villages</span> v. <span style="color:rgba(192,192,192,1)">Control Villages</span></b> (higher scores are better)</h5>
			<div>
				<canvas id="chart4" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart4").getContext('2d');

				var chart4 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ 2014, 2015, 2016, 2017, 2018 ],
						datasets : [ {
							label: "Partner Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 10,
							data : [ 14, 17, 21, 25, 19 ],
							cubicInterpolationMode: 'monotone',
						}, 

						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(192,192,192,1)",
                             pointBackgroundColor: "rgba(192,192,192,1)",
                             pointRadius: 10,
                             data : [ 16, 19, 18, 19, 20 ],
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
				<h6 style="padding:0 3% 0 3%">*Scores based on # of agriculural and non-agricultural village businesses per capita.</h6>
		</div>
		
	<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">

				<h5 style="text-align: center"><b>Lifestyle Hacks: <span class="blue-text">Partner Villages</span> v. <span style="color:rgba(192,192,192,1)">Control Villages</span></b> (higher scores are better)</h5>
			<div>
				<canvas id="chart5" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart5").getContext('2d');

				var chart5 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ 2014, 2015, 2016, 2017, 2018 ],
						datasets : [ {
							label: "Partner Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 10,
							data : [ 23, 26, 33, 41, 47 ],
							cubicInterpolationMode: 'monotone',
						}, 

						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(220,220,220,1)",
                             pointBackgroundColor: "rgba(220,220,220,1)",
                             pointRadius: 10,
                             data : [ 24, 28, 31, 34, 44 ],
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
				<h6 style="padding:0 3% 0 3%">*Scores based on # of roofs with iron sheets, TVs, motorcycles, and smartphones per capita.</h6>
		</div>	
	</div>
	
	<div class="row">
	
	<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">

				<h5 style="text-align: center"><b>Agricultural Production: <span class="blue-text">Partner Villages</span> v. <span style="color:rgba(192,192,192,1)">Control Villages</span></b> (higher scores are better)</h5>
			<div>
				<canvas id="chart6" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart6").getContext('2d');

				var chart6 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ 2014, 2015, 2016, 2017, 2018 ],
						datasets : [ {
							label: "Partner Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 10,
							data : [ 464, 310, 209, 316, 250 ],
							cubicInterpolationMode: 'monotone',
						}, 

						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(192,192,192,1)",
                             pointBackgroundColor: "rgba(192,192,192,1)",
                             pointRadius: 10,
                             data : [ 431, 349, 274, 227, 282 ],
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
							<h6 style="padding:0 3% 0 3%">*Scores based on # of 60 kg bags of maize produced per capita.</h6>
		</div>
		
	<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">

				<h5 style="text-align: center"><b>Livestock Holdings: <span class="blue-text">Partner Villages</span> v. <span style="color:rgba(192,192,192,1)">Control Villages</span></b> (higher scores are better)</h5>
			<div>
				<canvas id="chart7" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart7").getContext('2d');

				var chart7 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ 2014, 2015, 2016, 2017, 2018 ],
						datasets : [ {
							label: "Partner Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 10,
							data : [ 32, 32, 32, 40, 62 ],
							cubicInterpolationMode: 'monotone',
						}, 

						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(220,220,220,1)",
                             pointBackgroundColor: "rgba(220,220,220,1)",
                             pointRadius: 10,
                             data : [ 78, 88, 81, 73, 87 ],
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
				<h6 style="padding:0 3% 0 3%">*Scores based on # of goats and cows per capita.</h6>
		</div>	
	</div>	
	
	<hr>
	
	<div class="section"><h4 class="header left brown-text text-lighten-2 text-shadow: 2px 2px 7px #111111" style="width:100%">
			Evaluation Results
	</h4></div>
	
	<div class="section flow-text" style="width:100%;"> 
		<p>Our most recent impact evaluation occurred in early 2019. Our approach wasn't fancy or expensive (more on that
		below). Instead, it tested a foundational assumption that financing village-led projects without any sort of preconceived 
		development agenda would allow local communities to illuminate development pathways obscured from the outside. In other words, 
		we funded a bunch of projects, collected a bunch of development indicators, and tested whether anything had changed.</p>
		<p>Did communitites improve and, if so, how? Here's what we found. For starters, treatment villages posted a 9-point increase 
		in overall development score over control villages, and this result was statistically significant at the 1% level.
		The table below reveals which of the individual development metrics contributed to this development surge by treatment villages.</p>
	</div>
	
<div class="section"><br>

<table class="highlight centered responsive-table striped flow-text">
		        <thead>
		          <tr>
		              <th>Metric</th>
		              <th>Boys in nursery</th>
		              <th>Girls in nursery</th>
		              <th>Live goats</th>
		              <th>Waterborne illness</th>
		              <th>Infant deaths</th>
		              <th>Agri biz</th>
		              <th>Other biz</th>
		              <th>Homes with 
		              metal roofs</th>
		          </tr>
		        </thead>

		        <tbody>
		          <tr>
		            <td>% change</td>
		            <td>+50%</td>
		            <td>+67%</td>
		            <td>+83%</td>
		            <td>-64%</td>
		            <td>-100%</td>
		            <td>+81%</td>
		            <td>+100%</td>
		            <td>+50%</td>
		          </tr>
		          <tr>
		            <td>impact per village</td>
		            <td>+7 boys</td>
		            <td>+12 girls</td>
		            <td>+45 goats</td>
		            <td>-109 cases</td>
		            <td>-2 deaths</td>
		            <td>+13 biz</td>
		            <td>+8 biz</td>
		            <td>+13 homes</td>
		          </tr>
		          <tr>
		            <td>p-value</td>
		            <td>p&lt;0.05</td>
		            <td>p&lt;0.01</td>
		            <td>p&lt;0.01</td>
		            <td>p&lt;0.01</td>
		            <td>p&lt;0.05</td>
		            <td>p&lt;0.01</td>
		            <td>p&lt;0.01</td>
		            <td>p&lt;0.05</td>
		          </tr>
		      
		          <tr>
		            <td>total impact (all villages)</td>
		            <td>+133 boys</td>
		            <td>+228 girls</td>
		            <td>+855 goats</td>
		            <td>-2071 cases</td>
		            <td>-38 deaths</td>
		            <td>+247 biz</td>
		            <td>+152 biz</td>
		            <td>+247 homes</td>
		          </tr>
		        </tbody>
		      </table>
		      <div class="flow-text center" style="padding:5% 5% 0 5%;font-size:20px;">*Table shows development impacts (changes in treatment v. control villages) after two projects and a total investment of $7,000 per treatment village, on average.  
		      Not shown are small but statistically significant increases in motorcycles (+2 per village) and TVs (+2 per village). In the table above, % change is based on 2014 treatment village average.  
		      </div>
		      </div>

<hr>

<div class="section"><h4 class="header left brown-text text-lighten-2 text-shadow: 2px 2px 7px #111111">
			How We Got These Results
	</h4></div>

<br>

	<div class="section flow-text"> 
		<p>Using community surveys spanning 2014 (baseline) to 2018, across 41 projects and 56 villages, we tracked the following 25 development 
		indicators pertaining to health, education, business, lifestyle, agriculture, and livestock, both in partner villages and 
		control villages that want to partner with Village X. We chose these indicators because they are easy to collect and indicative of
		 village development trends. We then applied a difference-in-differences analysis to detect our model’s impacts, 
		controlling for village population, number of households, and surrounding district.</p>
	</div>
	
	<div class="section">
		<!--   Icon Section   -->
		<div class="row center">
			<br>
			<div class="col s12 m2 l2">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">local_hospital</i>
					<h5 class="center brown-test">health</h5>
					<h6 class="light center"># of waterborne illnesses</h6>
					<h6 class="light center"># of malaria cases</h6>
					<h6 class="light center"># of maternal deaths</h6>
					<h6 class="light center"># of infant deaths</h6>
				</div>
				
			</div>

			<div class="col s12 m2 l2">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">school</i>
					<h5 class="center brown-test">education</h5>
					<h6 class="light center"><b>enrollment:</b> # of boys/girls in nursery, primary, secondary, and tertiary</h6>
					<h6 class="light center"><b>test scores:</b> # of boys/girls passing PLSCE (end of primary exam) and # of boys/girls passing MSCE (end of secondary exam)</h6>
				</div>
				
			</div>

			<div class="col s12 m2 l2">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">local_convenience_store</i>
					<h5 class="center brown-test">business</h5>
					<h6 class="light center"># of agricultural businesses</h6>
					<h6 class="light center"># of non-agricultural businesses</h6>
				</div>
				
			</div>

			<div class="col s12 m2 l2">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">tv</i>
					<h5 class="center brown-test">lifestyle</h5>
					<h6 class="light center"># of TVs</h6>
					<h6 class="light center"># of motorcycles</h6>
					<h6 class="light center"># of steel roofs</h6>
					<h6 class="light center"># of smartphones</h6>
				</div>
				
			</div>
			
			<div class="col s12 m2 l2">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">spa</i>
					<h5 class="center brown-test">agriculture</h5>
					<h6 class="light center"># of (60 kg) bags of maize</h6>
				</div>
				
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
		<p>Project profiles on this website have graphs showing how development scores for a given village change
		over time, including an overall village development score and scores for each of the dimensions set forth above. These scores 
		are not precision instruments. Instead, they capture village development trends over time.</p>
		<p>Want to take a deeper dive? Checkout our dataset <a href="https://docs.google.com/spreadsheets/d/1Ga1Wzh4e8nrXX3gY1x3mflR8a2wnAKUbuxVvLcNGE-8/edit?usp=sharing" target='_blank'>here</a>. It's part of our 100% tranparency guarantee.</p>
	</div>

<hr>	

	<div class="section"><h4 class="header left brown-text text-lighten-2 text-shadow: 2px 2px 7px #111111">
			Next Steps
	</h4></div> <br>

	<div class="section flow-text"> 
		<p>We are not satisfied with our impact evaluation. It's a good start, but we can do better. In particular, we could
		track how projects we finance affect individual household spending within a village. How do families modify their
		spending in response to village-led projets? Do the projects make families wealthier? We could check our data against development trends revealed by satellite imagery.</p>
		<p>Answering these questions requires overcoming two challenges: (1) our current portfolio of partner villages
		is not large enough (we need at least 100 per year); and (2) we do not possess a large monitoring and evaluation budget. 
		We plan to scale our operations to overcome the first challenge and to partner with academic researchers to overcome
		the second one.</p>
	</div>
		
</div>

<?php include('footer.inc'); ?>