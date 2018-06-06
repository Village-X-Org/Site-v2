<?php
require_once("utilities.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Village X Org | Fund Projects That Villages Choose</title>
<meta name="description" content="Disrupting extreme poverty in rural Africa with democracy, direct giving, and data."/>
<style>
body, html {
    height: 100%;
    margin: 0;
}

.bg {
    /* The image used */
    background-image: linear-gradient( rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3) ), url("images/villagemtg.jpg");
    opacity:1;

    /* Full height */
    height: 100%; 

    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    
}

.carousel-slider {
    height: 800px !important;
}
</style>
<?php include('header.inc'); 
if (hasParam('code')) {
    $_SESSION['code'] = param('code');
}
if (hasParam('test')) {
    $_SESSION['test'] = param('test');
}
if (hasParam('offline')) {
    $_SESSION['offline'] = param('offline');
}

$alertText = 0;
if (hasParam('gc')) {
    $gcCode = param('gc');

    if ($gcCode === '0') {
    	unset($_SESSION['gc']);
    } else {
	    $stmt = prepare("SELECT gc_id, gc_alert, gc_quantity FROM gift_certificates WHERE gc_code=?");
	    $stmt->bind_param('s', $gcCode);
	    $result = execute($stmt);
	    if ($row = $result->fetch_assoc()) {
	    	if ($row['gc_quantity'] > 0) {	        
	    		$_SESSION['gc'] = $row['gc_id'];
	        	$alertText = $row['gc_alert'];
	        } else {  
	    		unset($_SESSION['gc']);
	        	$alertText = "This gift certificate code has already been used up!  Keep an eye out for future promotions.";
	        }
	    }
	    $stmt->close();
	}
}
?>

<div class="bg valign-wrapper hide-on-med-and-down" style="border-style:solid;">
<div class="center-align" style="height:100%; width:100%">	
	<div class="section no-pad-bot"
		style="opacity:1">
		<div class="row center" style="opacity:1">
			<div style="padding: 5% 5% 1% 5%;text-transform:uppercase;font-size:48px;text-shadow: 0px 2px 3px rgba(255,255,255,0.3);" class="col s12 white-text text-lighten-2" ">
				Fund Projects That Villages Choose
			</div>

			<div style="padding: 0% 8% 0% 8%;font-size:xx-large;font-weight:250;opacity:0.75" class="header white-text center light text-shadow: 2px 2px 4px #000000;">
				
				because everyone deserves democracy and development
					
			</div>

			<div style="padding: 0% 5% 0% 5%;height:120px;">
				<br>
				<br>
				<a href="project_tiles.php" id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1" style="border-radius:5px; font-size:x-large">meet
					the villages</a>
			</div>
		</div>
		</div>
		
			<div class="container" style="padding: 0% 5% 0 5%">
	
		<!--   Icon Section   -->
		 <div class="row center-align" >
			<div class="col s12 m4 l4 center-align">
				<div class="icon-block white-text">
					<i class="material-icons" style="font-size: 50px">people</i>
					<h5 style="padding: 0% 5% 0% 5%">people helped</h5>
					<h4 class="light center">42,145</h4>
					<h6 class="light center">in Malawi, Africa</h6>
					<br> 
				</div>
			</div>

			<div class="col s12 m4 l4 center-align">
				<div class="icon-block white-text">
					<i class="material-icons" style="font-size: 50px">trending_up</i>
					<h5 style="padding: 0% 5% 0% 5%">dev score impact</h5>
					<h4 class="light center">+138%</h4>
					<h6 class="light center">from 2014 to 2017</h6>
					<br> 
				</div>
			</div>

			<div class="col s12 m4 l4 center-align">
				<div class="icon-block white-text">
					<i class="material-icons" style="font-size: 50px">attach_money</i>
					<h5 style="padding: 0% 5% 0% 5%">cost per person</h5>
					<h4 class="light center">$1.08</h4>
					<h6 class="light center">per year</h6>
					<br> 
				</div>
			</div>

		</div>
		<div class="row center-align" style="padding:5%">
			<div class="icon-block white-text">
					<i class="material-icons pulse" style="font-size: 80px">keyboard_arrow_down</i>
			</div>
		</div>
		
	</div>
	</div>
	</div>

<div id="index-banner" class="parallax-container hide-on-large-only" style="background-color: rgba(0, 0, 0, 0.3); height: 500px">
	<div class="section no-pad-bot valign-wrapper" style="height: 100%; width: 100%;">
		<div class="section" style="width:100%;">
			<div>
        				<h2 class="header center-align light text-shadow: 2px 2px 7px #111111" style="padding:4% 2% 5% 2%"><b>Fund Projects That Villages Choose</b></h2>
        		</div>
        		
        		<div style="padding:0% 8% 0% 8%">
        				<h5 class="header center-align light text-shadow: 2px 2px 7px #111111" style="opacity:0.7;">because everyone deserves democracy and development</h5>
			</div>
			
			<div class="center-align" style="padding:4% 2% 4% 0%">	
				<a href="model.php" id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1" style="border-radius:5px; font-size: large">MEET THE VILLAGES</a>
			</div>
			</div>

			<div class="parallax">
				<img src="images/villagemtg.jpg">
			</div>
			
		</div>
	</div>
</div>

	<br>
	<div class="container">
	<blockquote class="flow-text">Nearly 400 million people (and growing) live in extreme poverty in rural Africa. We're changing that with a model that celebrates village democracy, direct giving, and data analysis.</blockquote>
	<br> 
	</div>

<div class="container valign-wrapper">
<div class="carousel carousel-slider center hide-on-med-and-down">	

<div class="carousel-item white" href="#one!">
	<h4 class="header center light blue-text text-lighten-2">How It Works</h4>

	<!--   <h5 class="header center brown-text text-lighten-2">How It Works</h5> -->
	
		<!--   Icon Section   -->
		<div class="row">
			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center brown-text">
						<img style="border:5px solid rgba(0, 0, 0, .85);" class="circle responsive-img" src="images/how_it_works_democracy.jpg">
					</h2> 
					
					<h5 class="center flow-text" style="font-weight: 600;">Villages choose projects</h5>

					<p class="light center">Search the projects page or interactive map for villages battling extreme poverty in rural
						Africa. Find a village-led development project that speaks to you.</p>
						
					<h5 class="center">#democracy</h5>

				</div>
			</div>

			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center brown-text">
						<img style="border:5px solid rgba(0, 0, 0, .85);" class="circle responsive-img" src="images/how_it_works_directgiving.jpg">
					</h2>

					<h5 class="center flow-text" style="font-weight: 600; padding:0% 10% 0% 10%">You help fund them</h5>

					<p class="light center">Make a donation directly to a rural village that not only identifies local solutions to its
					biggest problems, but also contributes labor, materials, and, importantly, cash.</p>
					
					<h5 class="center">#directgiving</h5>
				</div>
			</div>

			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center black-text">
						<img style="border:5px solid rgba(0, 0, 0, .85);"class="circle responsive-img" src="images/how_it_works_development.jpg">
					</h2>
					
					<h5 class="center flow-text" style="font-weight: 600;padding:0% 5% 0% 5%">We send you updates</h5>

					<p class="light center">Enjoy email updates with pictures and data from the field providing a vivid accounting
					 of how your donations change development outcomes for rural Africans.</p>
					 
					 <h5 class="center">#development</h5>
				</div>
			</div>
		</div>
</div>
	

<div class="carousel-item white" href="#two!">
	<br>
	<h4 class="header center light blue-text text-lighten-2" style="padding: 0 0 6% 0">How It Helps</h4> 
	
		<!--   Icon Section   -->
		<!--  <div class="row center">
			<div class="col s12 m3 l3">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">trending_down</i>
					<h5 class="center brown-test" style="padding: 0% 5% 0% 5%">waterborne illness</h5>
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
		</div> -->
		
		<div class="flow-text">
		<table class="highlight centered responsive-table">
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
      <div style="padding:3% 0 0 0"><h6>*based on data collected from 2014 (baseline) to 2017 across treatment and control villages, with statistics calculated using a difference-in-differences model</h6></div>
      </div>

		
	
	</div>

<script> 
	
	$('.carousel').carousel({
	    padding: 0    
	});
	autoplay()   
	function autoplay() {
	    $('.carousel').carousel('next');
	    setTimeout(autoplay, 5500);
	}
</script>

</div>

</div>

<div class="icon-block center-align black-text hide-on-med-and-down" style="padding: 0 0 2% 0">
			<i class="material-icons" style="font-size: 50px">pause_circle_outline</i>
	</div>
	<div class="icon-block center-align black-text hide-on-med-and-down" style="padding: 0 0 2% 0">
			<i class="material-icons" style="font-size: 50px">play_circle_outline</i>
	</div>

<div class="container valign-wrapper">
<div class="hide-on-large-only">
<h4 class="header center light blue-text text-lighten-2">How It Works</h4>

	<!--   <h5 class="header center brown-text text-lighten-2">How It Works</h5> -->
	
		<!--   Icon Section   -->
		<div class="row">
			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center brown-text">
						<img style="border:5px solid rgba(0, 0, 0, .85);" class="circle responsive-img" src="images/how_it_works_democracy.jpg">
					</h2> 
					
					<h5 class="center flow-text" style="font-weight: 600;">Villages choose projects</h5>

					<p class="light center">Search the projects page or interactive map for tenacious villages battling extreme poverty in rural
						Africa. Find a village-led development project that speaks to you.</p>
						
					<h5 class="center">#democracy</h5>

				</div>
			</div>

			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center brown-text">
						<img style="border:5px solid rgba(0, 0, 0, .85);" class="circle responsive-img" src="images/how_it_works_directgiving.jpg">
					</h2>

					<h5 class="center flow-text" style="font-weight: 600; padding:0% 10% 0% 10%">You help fund them</h5>

					<p class="light center">Make a donation directly to a rural village that not only identifies local solutions to its
					biggest problems, but also contributes labor, materials, and, importantly, cash.</p>
					
					<h5 class="center">#directgiving</h5>
				</div>
			</div>

			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center black-text">
						<img style="border:5px solid rgba(0, 0, 0, .85);"class="circle responsive-img" src="images/how_it_works_development.jpg">
					</h2>
					
					<h5 class="center flow-text" style="font-weight: 600;padding:0% 5% 0% 5%">We send you updates</h5>

					<p class="light center">Enjoy email updates with pictures and data from the field providing a vivid accounting
					 of how your donations change development outcomes for rural Africans.</p>
					 
					 <h5 class="center">#development</h5>
				</div>
			</div>
		</div>
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
    								class='btn waves-effect waves-light light blue lighten-1'>Donate".($matchingDonor ? " (2x)" : "")."</a>";
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

	    $result = doUnprotectedQuery("SELECT project_id, project_completion, picture_filename, pu_description, project_name, village_name,  pu_timestamp 
                FROM projects JOIN villages ON project_completion IS NOT NULL AND project_village_id=village_id JOIN project_updates ON pu_project_id=project_id AND pu_exemplary=1 
                JOIN pictures ON pu_image_id=picture_id GROUP BY project_id ORDER BY pu_timestamp DESC LIMIT 5");
	?>    
	<br>
	<h4 class="header center light blue-text text-lighten-2">Project Updates</h4>
        <div class="section"><div class="slickContainer" style='outline:none;max-width:900px;margin: auto;'>
        		<?php 
        		$count = $lastDate = $previousDate = 0;
        		while (true) {
        		    if ($row = $result->fetch_assoc()) {
        		        $date = (new DateTime($row['pu_timestamp']))->format("F jS");
        		    } else {
        		        $date = 0;
        		    }
        		    if ($count > 0) {
        		        ?>
            		    <div class="slickSlide" style='outline:0;'>
            		    <div class='row'>
            		    <div class='col s12 m12 l6' style='position:relative;'>
                            <span class='flow-text' style='color:black;font-size:20px;cursor:pointer;width:400px;margin:auto;' id='newsCompletionSpan' 
                            		onclick="document.location='project.php?id=<?php print $projectId; ?>';"><?php print $completion; ?></span>
                     <table style='width:100%;'>
                     		<tr><td style='width:50%;'>
                     			<a href='' onclick="$('.slickContainer').slick('slickPrev'); return false;" style='color:#2F4F4F;font-size:18px;font-weight:bold;'><?php print ($previousDate ? "<< $previousDate" : ""); ?></a></td>
                     		<td style='text-align:right;width:50%;'>
                     			<a href='' onclick="$('.slickContainer').slick('slickNext'); return false;" style='color:#2F4F4F;font-size:18px;font-weight:bold;'><?php print ($date ? "$date >>" : ""); ?></a></td></tr></table>
                    	
                        </div>
        					<div class='col s12 m12 l6 center-align'>
        					 	<div style="margin:auto;width:100%;max-width:400px;height:400px;cursor:pointer;background-size:cover;background-position:center;background-image:url('<?php print (PICTURES_DIR . $picture); ?>');border:solid black 2px;" 
        							onclick="document.location='project.php?id=<?php print $projectId; ?>';"></div>
                			</div>
                		</div>
                  </div></a>
        		   	<?php }
        		   	if (!$date) {
        		   		break;
        		   	}
        		    $projectId = $row['project_id'];
        		  	$projectName = $row['project_name'];
        		  	$villageName = $row['village_name'];
        		  	$completion = $row['project_completion'];
        		  	$picture = $row['picture_filename'];
        		  	$description = $row['pu_description'];
        		  	
        		  	$indexOfPeriod = strpos($completion, '.');
        		  	$firstSentence = substr($completion, 0, $indexOfPeriod);
        		  	
        		  	if ($lastDate) {
        		  	    $previousDate = $lastDate;
        		  	}
        		  	$lastDate = $date;
        		  	$count++;
            } ?>
        	</div></div>
        <script>	$('.slickContainer').slick({
          focusOnSelect: false,
        	  infinite: false 
        	});</script>

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
	
	
	
	
	<!--  <div class="row">
	
        	<div class="col s12 m4 l4 center-align" style="margin:auto;">
            	<div>
            		<h5 style="text-align: center;"><b>People Helped*</b></h5>
            	
            		<h3 style="text-align: center" class="light blue-text text-lighten-2"><b><?php print $numHelpedTotal; ?></b></h3>
            		
            		<h6 style="text-align: center; padding: 30px 20% 0px 20%">*each project benefits an entire village community</h6>
            	</div>
        	</div>
	
        	<div class="col s12 m4 l4 center-align" style="margin:auto;">
        
    			<h5><b>Types of Projects</b></h5>
    			<center><canvas id="chart2" style="max-width:250px;min-width:250px;margin:auto;"></canvas></center>
    
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
        		
        	<div class="col s12 m4 l4 center-align" style='margin:auto;'>
            	<h5 style="text-align: center"><b>Elapsed Time*</b></h5>
        		<h3 style="text-align: center" class="light blue-text text-lighten-2"><b><?php print $elapsedDaysAverage; ?> days</b></h3>
        		<p style="margin:-5%"><span class="light blue-text text-lighten-2" style="font-size:16px;padding: 0px 0% 0px 0%">project funding to completion</span></p>
        		
        		<h6 style="text-align: center;padding: 7% 20% 0px 20%">*based on average, times vary depending on project type</h6>
        	</div>

	</div>  -->
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
