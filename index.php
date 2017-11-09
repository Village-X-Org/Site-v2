<?php
require_once("utilities.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- SLICK -->
<title>Village X Org | Fund Projects That Villages Choose</title>
<meta name="description" content="Disrupting extreme poverty in rural Africa with democracy, direct giving, and data."/>
<?php include('header.inc'); 
if (hasParam('code')) {
    $_SESSION['code'] = param('code');
}
if (hasParam('test')) {
    $_SESSION['test'] = param('test');
}
?>

<div id="index-banner" class="parallax-container"
	style="background-color: rgba(0, 0, 0, 0.3); height: 500px">
	<div class="section no-pad-bot valign-wrapper"
		style="height: 100%; width: 100%;">
		<div class="row center">
			<div style="padding: 5% 5% 5% 5%;">
				<h2
					class="header col s12 white-text text-lighten-2 text-shadow: 2px 2px 7px #111111">Fund Projects That Villages Choose</h2>
			</div>

			<div style="padding: 5% 5% 5% 5%;">
				<br>
				<br>
				<h5 class="header center light text-shadow: 2px 2px 7px #111111" style="padding:0% 3% 0% 3%">
					to disrupt extreme poverty in rural Africa</h5>
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
        				<h5 class="header center-align light text-shadow: 2px 2px 7px #111111" style="padding:0% 2% 0% 0%">radically</h5>
        				<h5 class="header center-align light text-shadow: 2px 2px 7px #111111" style="padding:0% 2% 2% 2%">transparent</h5>
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
if (!CACHING_ENABLED || !file_exists(CACHED_HIGHLIGHTED_FILENAME)) {
    $result = doUnprotectedQuery("SELECT p1.project_id AS project_id, p1.project_name AS project_name, picture_filename, p1.project_summary AS project_summary, village_name, p1.project_funded AS project_funded, p1.project_budget AS project_budget, p1.project_type AS project_type, YEAR(MIN(p2.project_date_posted)) AS previousYear, CONCAT(donor_first_name, ' ', donor_last_name) AS matchingDonor 
                FROM projects AS p1 
                JOIN villages ON p1.project_village_id=village_id 
                LEFT JOIN projects AS p2 ON p1.project_village_id=p2.project_village_id AND p1.project_id<>p2.project_id AND p2.project_funded>=p2.project_budget 
                JOIN pictures ON p1.project_profile_image_id=picture_id 
                LEFT JOIN donors ON p1.project_matching_donor=donor_id 
                GROUP BY p1.project_id ORDER BY (p1.project_status = 'funding' AND p1.project_funded<p1.project_budget) DESC, ABS(p1.project_budget-p1.project_funded)");
    $buffer = '';
    $cells = array();
    while ($row = $result->fetch_assoc()) {
        $projectId = $row['project_id'];
        $projectName = $row['project_name'];
        $projectType = $row['project_type'];
        $funded = round($row['project_funded']);
        $projectTotal = $row['project_budget'];
        $previousYear = $row['previousYear'];
        $matchingDonor = $row['matchingDonor'];
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
    				<div class='card-action'>".($matchingDonor ? "
				    <a class='tooltip' style='text-decoration:none;position:absolute;right:-15px;bottom:10px;text-transform:none;text-align:center;'><span class='tooltiptext' style='left:-190%;top:-150%;'>Partner $matchingDonor will match all donations!</span>
                            <span style='margin:auto 0;position:absolute;top:14%;left:3%;color:black;font-size:15px;z-index:10;line-height:95%'><b>100%<br>Match</b></span>
                            <!-- <img src='images/matching.png' style='border-radius:25px;padding:2px;border:2px solid black;' />  -->
                            <i class='material-icons center' style='opacity:0.6;font-size:50px; color:#03A9F4;'>flash_on</i>

                        </a>" : "")."
    					<div class='row center'>
    						<div class='col s12'>";
        if ($fundedPercent < 100) {
            $nextBuffer .= "<a href='one_time_payment_view.php?id=$projectId'
    								id='donate_button'
    								class='btn waves-effect waves-light light blue lighten-1'>Donate</a>";
        } else {
            $nextBuffer .= "<button href='' class='btn grey'>Fully Funded!</button>";
        }
        $nextBuffer .= "
                        </div>
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
    if (CACHING_ENABLED) {
        $handle = fopen(CACHED_HIGHLIGHTED_FILENAME, "w");
        fwrite($handle, $buffer);
        fclose($handle);
    } else {
        print $buffer;
    }
}

if (CACHING_ENABLED) {
    include(CACHED_HIGHLIGHTED_FILENAME);
}
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
         			<input value="" name="EMAIL" id="mce-EMAIL" placeholder="enter your email address" style="font-size:20px" id="mcd-email" type="email" class="email validate">
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

	<?php 

	if (!CACHING_ENABLED || !file_exists(CACHED_CHARTS_FILENAME)) {
	    ob_start();

	    $result = doUnprotectedQuery("SELECT project_id, project_completion, picture_filename, pu_description, project_name, village_name,  pu_timestamp FROM projects JOIN villages ON project_completion IS NOT NULL AND project_village_id=village_id JOIN project_updates ON pu_project_id=project_id JOIN pictures ON pu_image_id=picture_id GROUP BY project_id ORDER BY pu_timestamp DESC");
	?>    
	<h4 class="header center light blue-text text-lighten-2">News from the Villages</h4>
        <div class="slickContainer">
        		<?php while ($row = $result->fetch_assoc()) {
        		    $projectId = $row['project_id'];
        		  $projectName = $row['project_name'];
        		  $villageName = $row['village_name'];
        		  $date = (new DateTime($row['pu_timestamp']))->format("F j, Y");
        		  $completion = $row['project_completion'];
        		  $picture = $row['picture_filename'];
        		  $description = $row['pu_description'];
        		?>
              <div class="slickSlide" style='border:0;'>
                	<div class='row'>
    					<div class='col m8 s12'>
                			<span style='color:black;font-weight:bold;'><?php print "$projectName in $villageName - $date" ?></span>
                        <p/><span class='flow-text' style='color:black;font-size:16px;' id='newsCompletionSpan'><?php print $completion; ?></span>
                    </div>
    					<div class='col m4 s12'>
            					<img src='<?php print (PICTURES_DIR . $picture); ?>' class="align-center" style='border:solid black 2px;width:300px' />
            			</div>
                	</div>
              </div>
                	<?php } ?>
        	</div>
        <script>	$('.slickContainer').slick({
          arrows: true,
          focusOnSelect: false,
        	  infinite: false 
        	});</script>
	
	<h4 class="header center light blue-text text-lighten-2">By the Numbers</h4>

	<div class="container">
	<?php 
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
	
	<div class="col s12 m4 l4 center-align">
	<div class="center-align">
	<div>
		<h5 style="text-align: center"><b>People Helped*</b></h5>
	
		<h3 style="text-align: center" class="light blue-text text-lighten-2"><b><?php print $numHelpedTotal; ?></b></h3>
		
		<h6 style="text-align: center; padding: 30px 20% 0px 20%">*each project benefits an entire village community</h6>
	</div>
	</div>
	</div>
	
	<div class="col s12 m4 l4 center-align" style="padding: 20px 30px 15% 30px;margin:0 0 -15% 0">

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
								    display:true,
					    				position: 'top'
								  },
								}
				});
			</script>
		</div>
		
	<div class="col s12 m4 l4 center-align" style="padding: 20px 30px 10px 30px">
	
		
	<div class="center-align">
		<h5 style="text-align: center"><b>Elapsed Time*</b></h5>
	
		<h3 style="text-align: center" class="light blue-text text-lighten-2"><b><?php print $elapsedDaysAverage; ?> days</b></h3>
		<p style="margin:-5%"><span class="light blue-text text-lighten-2" style="font-size:16px;padding: 0px 0% 0px 0%">project funding to completion</span></p>
		
		<h6 style="text-align: center;padding: 7% 20% 0px 20%">*based on average, times vary depending on project type</h6>

	</div>
	
	</div>

	</div>
<?php 
        $contents = ob_get_contents();
        ob_end_clean();
        
        if (CACHING_ENABLED) {
            file_put_contents(CACHED_CHARTS_FILENAME, $contents);
        } else {
            print $contents;
        }
    }
    if (CACHING_ENABLED) {
        include(CACHED_CHARTS_FILENAME);
    }
    ?>

</div>

<br><br>
<?php include('footer.inc'); ?>
