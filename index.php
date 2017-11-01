<?php
require_once("utilities.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Village X Org | Fund Projects That Villages Choose</title>
<meta name="description" content="Disrupting extreme poverty in rural Africa with democracy, direct giving, and data."/>
<?php include('header.inc'); 
if (hasParam('code')) {
    $_SESSION['code'] = param('code');
}
?>

<div id="index-banner" class="parallax-container"
	style="background-color: rgba(0, 0, 0, 0.3); height: 500px">
	<div class="section no-pad-bot valign-wrapper"
		style="height: 100%; width: 100%;">
		<div class="row center">
			<div style="padding: 5% 5% 5% 5%;">
				<h2
					class="header col s12 white-text text-lighten-2 text-shadow: 2px 2px 7px #111111">Disrupt Extreme Poverty in Africa</h2>
			</div>

			<div style="padding: 5% 5% 5% 5%;">
				<br>
				<br>
				<h5 class="header center light text-shadow: 2px 2px 7px #111111" style="padding:0% 3% 0% 3%">
					by funding development projects that villages choose</h5>
			</div>

			<div style="padding: 0% 5% 5% 5%;">
				<br>
				<br>
				<a href="project_tiles.php" id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1" style="border-radius:20px;">meet
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
	<h4 class="header center light blue-text text-lighten-2">How It Works</h4>

	<!--   <h5 class="header center brown-text text-lighten-2">How It Works</h5> -->
	<div class="section">
		<!--   Icon Section   -->
		<div class="row">
			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center brown-text hide-on-large-only">
						<img style="border:5px solid black" class="circle responsive-img" src="temp/Bakili.jpg">
					</h2> 
				
				<h2 class="center brown-text hide-on-med-and-down">
					<video autoplay loop muted height="250px" width="250px" class="circle" style="border:5px solid black; object-fit:cover;">
						<source src="images/nachuma_water_480.mp4" type="video/mp4">
					</video>
				</h2>
					
					<h5 class="center flow-text" style="font-weight: 600;">Villages choose projects</h5>

					<p class="light center">Search the projects page or interactive map for tenacious villages battling extreme poverty in rural
						Africa. Find a village-led development project that speaks to you.</p>
						
					<h5 class="center">#democracy</h5>

				</div>
			</div>

			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center brown-text hide-on-large-only">
						<img style="border:5px solid black" class="circle responsive-img" src="temp/building_school.jpg">
					</h2>
					
					<h2 class="center brown-text hide-on-med-and-down">
					<video autoplay loop muted height="250px" width="250px" class="circle" style="border:5px solid black; object-fit:cover;">
						<source src="images/geyser_spray_480.mp4" type="video/mp4">
					</video>
				</h2>
					
					<h5 class="center flow-text" style="font-weight: 600; padding:0% 10% 0% 10%">You help fund them</h5>

					<p class="light center">Make a donation directly to a rural village that not only identifies local solutions to its
					biggest problems, but also contributes labor, materials, and, importantly, cash.</p>
					
					<h5 class="center">#directgiving</h5>
				</div>
			</div>

			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center black-text hide-on-large-only">
						<img style="border:5px solid black;"class="circle responsive-img" src="temp/kids_on_school_floor.jpg">
					</h2>
					
					<h2 class="center brown-text hide-on-med-and-down">
					<video autoplay loop muted height="250px" width="250px" class="circle" style="border:5px solid black; object-fit:cover;">
						<source src="images/kids_borehole_low.mp4" type="video/mp4">
					</video>
					</h2>
					
					<h5 class="center flow-text" style="font-weight: 600">We compute your impact</h5>

					<p class="light center">Enjoy email updates with pictures and data from the field providing a vivid accounting
					 of how your donations change development outcomes for rural Africans.</p>
					 
					 <h5 class="center">#development</h5>
				</div>
			</div>
		</div>

	</div>
	</div>
<hr style="width:50%">
<div class="container">
	<br>
	<h4 class="header center light blue-text text-lighten-2">How It Helps</h4> 
	
	
	<div class="section">
	
		<!--   Icon Section   -->
		<div class="row center">
			<div class="col s12 m3 l3">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">trending_down</i>
					<h5 class="center brown-test">waterborne illness</h5>
					<h4 class="light center">-70%</h4>
					<h6 class="light center">p-value&lt;=0.01</h6>
					<br> 
				</div>
			</div>

			<div class="col s12 m3 l3">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">trending_up</i>
					<h5 class="center brown-test">boys/girls in nursery school</h5>
					<h4 class="light center">+66% / 60%</h4>
					<h6 class="light center">p-value&lt;=0.05</h6>
					<br> 
				</div>
			</div>

			<div class="col s12 m3 l3">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">trending_up</i>
					<h5 class="center brown-test">non-agricultural businesses</h5>
					<h4 class="light center">+100%</h4>
					<h6 class="light center">p-value&lt;=0.05</h6>
					<br> 
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

<!-- <div>
			  <h6 class="light center-align" style="padding:0% 3% 0% 3%">
				*based on difference-in-differences analysis using data, from 2014
				to 2016, on 21 projects and 32 villages, with an average investment of $5,400 per village over 2 years
			</h6>
		</div> 
		
		<div class="row center" style="padding: 0% 1% 0% 1%; width:100%;">
				
				<a href="impacts.php" id="download-button"
					class="btn-large waves-effect waves-light white lighten-1 light-blue-text" style="border-color:rgba(220,220,220,1);border-radius:20px;">learn more</a>
			</div> -->
		<br>
	</div>

</div>

<div id="index-banner" class="parallax-container"
	style="background-color: rgba(0, 0, 0, 0.3); height: 500px">
	<div class="section no-pad-bot valign-wrapper"
		style="height: 100%; width: 100%;">
		<div class="row" style="width:100%;">
			
			<div class="row center" style="opacity:0.7; width:250px; height:250px; border-radius:50%; border-style:solid;">
        				<h1 class="header center-align light text-shadow: 2px 2px 7px #111111" style="padding:5% 2% 0% 2%"><b>100%</b></h1>
        				<h5 class="header center-align light text-shadow: 2px 2px 7px #111111" style="padding:0% 2% 0% 0%">transparent,</h5>
        				<h5 class="header center-align light text-shadow: 2px 2px 7px #111111" style="padding:0% 2% 2% 2%">by design</h5>
			</div>	
			
			
			<div class="row center" style="padding: 0% 1% 0% 1%; width:100%;">
				
				<a href="model.php" id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1" style="border-radius:20px;">our model</a>
			</div>
			
			<h6 class="header center light text-shadow: 2px 2px 7px #111111" style="width:100%; padding:0% 15% 0% 15%;">deploy cash, retrieve data</h6>

			<div class="parallax">
				<img src="images/woman_with_goat.jpg">
			</div>
			
		</div>
	</div>
</div>

<div class="container">
	<br>
	<h4 class="header center light blue-text text-lighten-2">Featured Projects</h4>
	<h6 class="header center light text-shadow: 2px 2px 7px #111111" style="padding:0% 10% 2% 10%">(100% completion rate)</h6>
	<div class="icon-block" style="width:100%"><i class='material-icons left' style="font-size:20px;color:#03A9F4">timeline</i> = &nbsp;village data trends available
	<br>
	<i class='material-icons left' style="font-size:20px;color:#03A9F4">fiber_new</i> = &nbsp;data trends coming soon</div>
	<div class="section">

		<!--   project section   -->
		<div class="row">
<?php
if (!file_exists(CACHED_HIGHLIGHTED_FILENAME)) {
    $result = doUnprotectedQuery("SELECT p1.project_id AS project_id, p1.project_name AS project_name, picture_filename, p1.project_summary AS project_summary, village_name, p1.project_funded AS project_funded, p1.project_budget AS project_budget, p1.project_type AS project_type, YEAR(MIN(p2.project_date_posted)) AS previousYear FROM projects AS p1 JOIN villages ON p1.project_village_id=village_id LEFT JOIN projects AS p2 ON p1.project_village_id=p2.project_village_id AND p1.project_id<>p2.project_id AND p2.project_funded>=p2.project_budget JOIN pictures ON p1.project_profile_image_id=picture_id GROUP BY p1.project_id ORDER BY (p1.project_status = 'funding' AND p1.project_funded<p1.project_budget) DESC, ABS(p1.project_budget-p1.project_funded)");
    $buffer = '';
    $cells = array();
    while ($row = $result->fetch_assoc()) {
        $projectId = $row['project_id'];
        $projectName = $row['project_name'];
        $projectType = $row['project_type'];
        $funded = round($row['project_funded']);
        $projectTotal = $row['project_budget'];
        $previousYear = $row['previousYear'];
        $fundedPercent = $funded / $projectTotal * 100;
        $villageContribution = $projectTotal * .05;
        if (!isset($cells[$projectType])) {
            $cells[$projectType] = array();
        }
        $nextBuffer = "<div class='col s12 m6 l4 ' style='min-width:225px;cursor:pointer;' onclick=\"document.location='project.php?id=$projectId';\">
    			<div class='card sticky-action hoverable'>
    				<div class='card-image'>
    					<img class='activator' src='" . PICTURES_DIR . "/{$row['picture_filename']}'>
    				</div>
    				<div class='card-content'>
    					<span class='card-title activator grey-text text-darken-4'  style='font-size:18px;'  onclick=\"document.location='project.php?id=$projectId';\">$projectName
    						<i class='material-icons right' style='color:#03A9F4;'>".($previousYear ? 'timeline' : 'fiber_new')."</i>
    					</span>
    					<h6 class='brown-text'>
    						<b>{$row['village_name']} Village</b>".($previousYear ?  " (since $previousYear) " : "")."
    					</h6>
    					<br>
    					<h6>
    						<b>\$$funded out of \$$projectTotal</b>
    					</h6>
    					<div class='progress'>
    						<div class='determinate' style='width: $fundedPercent%'></div>
    					</div>
    					<p>Locals Contributed: \$$villageContribution</p>
    				</div>
    				<div class='card-action'>
    					<div class='row center'>
    						<div class='col s12'>";
        if ($fundedPercent < 100) {
            $nextBuffer .= "<a href='one_time_payment_view.php?id=$projectId'
    								id='donate_button'
    								class='btn waves-effect waves-light light blue lighten-1'>Donate</a>";
        } else {
            $nextBuffer .= "<button href='' class='btn grey'>Fully Funded!</button>";
        }
        $nextBuffer .= "</div>
    					</div>
    				</div>
    			</div>
    	      </div>";
        $cells[$projectType][] = $nextBuffer;
    }
   
    $count = $index = 0;
    while ($count < 3) {
        foreach ($cells as $cell) {
            if (count($cell) > $index) {
                $buffer .= $cell[$index];
                $count++;
            }
            if ($count == 3) {
                break;
            }
        }
        $index++;
    }
    $handle = fopen(CACHED_HIGHLIGHTED_FILENAME, "w");
    fwrite($handle, $buffer);
    fclose($handle);
}
include(CACHED_HIGHLIGHTED_FILENAME);
?>			
		</div>
		<br>

		<div class="row center">
			<a href='project_tiles.php' id="download-button"
				class="btn-large waves-effect waves-light light blue lighten-1" style="border-radius:20px;">more
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

<div id="index-banner" class="parallax-container"
	style="background-color: rgba(0, 0, 0, 0.3); height: 500px">
	<div class="section no-pad-bot valign-wrapper"
		style="height: 100%; width: 100%;">
		
		<div class="row center">
        	<div class="valign-wrapper">
          <div class="card white" style="opacity: 0.7; border-radius:20px;">
            <div class="card-content black-text">
              <span class="card-title"><b>want good stories from Africa?<br> try our quarterly newsletter</b></span>
      		
    		<form action="//villagexapp.us8.list-manage.com/subscribe/post?u=0aa3c6538384ca95760dc6be6&amp;id=2efaede0d4" method="post" target="_blank" class="col s12">
      		<div class="row">
        			<div class="input-field col s12" style="color:#03A9F4">
         			<input value="" name="EMAIL" id="mce-EMAIL" placeholder="enter your email address" id="mcd-email" type="email" class="email validate">
        			</div>
      		</div>
    		
			
        		<div class="center-align" style="width:100%;">
          			<button class="btn-large blue waves-effect waves-light center-align" style="border-radius:20px; margin:0% 0% 5% 0%;" type="submit" name="action">submit
  					</button>
    			</div>
    		
    			<div style="position: absolute; left: -5000px;" aria-hidden="true">
								<input type="text" name="b_0aa3c6538384ca95760dc6be6_2efaede0d4" tabindex="-1" value="">
			</div>
			
			</form>
			
			</div>	
          </div>
        </div>
      
			<div class="parallax">
				<img src="images/newsletter_banner_2.jpg">
			</div>
		</div>
	</div>
</div>

	<h4 class="header center light blue-text text-lighten-2" style="padding:3% 0% 0% 0%">The Big Picture</h4>
	<h6 class="header center" style="padding:0% 0% 1% 0%">(as of October 25, 2017)</h6>

<div class="container">
  
<div class="row">
			
			<div class="col s12 m12 l12 center-align" style="padding: 20px 50px 20px 50px">

				<h5 style="text-align: center"><b>Development Scores: <span class="blue-text">Partner Villages</span> v. <span style="color:#9D8E7F">Control Villages</span></b></h5>
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
							borderColor: "#9D8E7F",
                             pointBackgroundColor: "#9D8E7F",
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
		<h6 style="text-align: center; padding: 20px 10% 20px 10%">*Average scores calculated from 13 data points per village, along 6 dimensions: health, agriculture, business, livestock, lifestyle, and education. Learn more 
				<a style='color:#696969;font-weight:bold;' href='impacts.php'>here</a>.</h6>
	</div>
	
	<?php 

	if (!file_exists(CACHED_CHARTS_FILENAME)) {
	    ob_start();
	   $result = doUnprotectedQuery("SELECT CEIL(AVG(NULLIF(project_elapsed_days, 0))) AS elapsedAverage, SUM(project_people_reached) AS numHelpedTotal, 
                    SUM(case when project_type='water' then 1 else 0 end) as waterCount, SUM(case when project_type='livestock' then 1 else 0 end) as livestockCount,
                    SUM(case when project_type='farm' then 1 else 0 end) as agricultureCount, SUM(case when project_type='school' then 1 else 0 end) as educationCount
            FROM projects WHERE project_funded>=project_budget-1"); 
        if ($row = $result->fetch_assoc()) {
            $numHelpedTotal = number_format($row['numHelpedTotal'], 0, '.', ',');
            $elapsedDaysAverage = $row['elapsedAverage'];
            $waterCount = $row['waterCount'];
            $educationCount = $row['educationCount'];
            $livestockCount = $row['livestockCount'];
            $agricultureCount = $row['agricultureCount'];
        }
    ?>
	
	
	<div class="row">
	
	<div class="col s12 m4 l4 center-align" style="padding: 20px 30px 40px 30px">
	<div class="center-align">
	<div>
		<h5 style="text-align: center"><b>People Helped</b></h5>
	
		<h3 style="text-align: center" class="light blue-text text-lighten-2"><b><?php print $numHelpedTotal; ?></b></h3>
		
		<h6 style="text-align: center; padding: 30px 20% 0px 20%">*each project benefits an entire village community</h6>
	</div>
	</div>
	</div>
	
	<div class="col s12 m4 l4 center-align" style="padding: 20px 30px 0px 30px">

				<h5 style="text-align: center"><b>Types of Projects</b></h5>
			<div>
				<canvas id="chart2" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart2").getContext('2d');

				Chart.defaults.global.defaultFontFamily = "'Roboto', sans-serif";
				Chart.defaults.global.defaultFontSize = 14;
				
				var chart2 = new Chart(ctx, {
					type : 'polarArea',
					data : {

						labels: ["water","livestock","education","agriculture"],
						  datasets: [{
						    data: [<?php print "$waterCount, $livestockCount, $educationCount, $agricultureCount"; ?>],
						    backgroundColor: [
						      "rgba(255, 0, 0, 0.5)",
						      "rgba(100, 255, 0, 0.5)",
						      "rgba(200, 50, 255, 0.5)",
						      "rgba(0, 100, 255, 0.5)"
						    ]
						  }]
						},
						options : {
								  startAngle: -Math.PI / 3,
								  legend: {
								    position: 'left'
								  },
								}
				});
			</script>
		</div>
		
	<div class="col s12 m4 l4 center-align" style="padding: 20px 30px 10px 30px">
	
		
	<div class="center-align">
		<h5 style="text-align: center"><b>Elapsed Time</b></h5>
	
		<h3 style="text-align: center" class="light blue-text text-lighten-2"><b><?php print $elapsedDaysAverage; ?> days</b></h3><span class="light blue-text text-lighten-2" style="font-size:24px;">between project funding and completion</span>
		
		<h6 style="text-align: center;padding: 10px 20% 0px 20%">*based on average (times vary depending on project type)</h6>

	</div>
	
	</div>
		
	</div>
<?php 
        $contents = ob_get_contents();
        ob_end_clean();
        file_put_contents(CACHED_CHARTS_FILENAME,$contents);
    }
    include(CACHED_CHARTS_FILENAME);
    ?>
	<!--  
	<div class="row">
	
	<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">

				<h6 style="text-align: center"><b>Waterborne Illness: <span class="blue-text">Partner Villages</span> v. <span style="color:#9D8E7F">Control Villages</span></b></h6>
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
							borderColor: "#9D8E7F",
                             pointBackgroundColor: "#9D8E7F",
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

				<h6 style="text-align: center"><b>Agricultural Output: <span class="blue-text">Partner Villages</span> v. <span style="color:#9D8E7F">Control Villages</span></b></h6>
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
							borderColor: "#9D8E7F",
                             pointBackgroundColor: "#9D8E7F",
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
						<h6 style="text-align: center"><b>Remaining Dimensions: <span class="blue-text">Partner Villages</span></b></h6>
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
						<h6 style="text-align: center"><b>Remaining Dimensions: <span style="color:#9D8E7F">Control Villages</span></b></h6>
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
										layout: {
									        padding: {
									            bottom: 10
									        }
									    }
									}
								});
					</script>
			</div> 
		
	</div> -->
</div>
<?php include('footer.inc'); ?>
