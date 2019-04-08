<?php
require_once("utilities.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Village X | Fund Projects That Villages Choose</title>
<meta name="description" content="Disrupting extreme poverty in rural Africa with democracy, direct giving, and data."/>
<style>
body, html {
    height: 100%;
    margin: 0;
}

.bg {
    /* The image used */
    background-image:  linear-gradient( rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) ), url("images/chiyuni_banner.jpg");
    opacity:1.5;
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

<div class="bg hide-on-med-and-down valign-wrapper" style="border-style:solid;width:100%">
<div class="container center-align" style="width:100%;">	
	<div class="section no-pad-bot">
		<div class="row center">
			<div style="padding: 0% 5% 1% 5%;text-transform:uppercase;font-size:48px;text-shadow: 2px 2px 7px #111111" class="col s12 white-text text-lighten-2 flow-text">
				Fund Projects That Villages Choose
			</div>

			<div style="padding: 0% 12% 5% 12%;font-size:xx-large;font-weight:250;opacity:0.8;text-shadow: 2px 2px 7px #111111;" class="header white-text center light">
				
				because everyone deserves democracy and development
					
			</div>  

			<div style="padding: 0% 5% 10% 5%;height:120px;">
				<br>
				<br>
				<a href="project_tiles.php" id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1" style="border-radius:5px; font-size:x-large;box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);">MEET THE VILLAGES</a>
			</div>
		</div>
		</div>
		
		   <div class="container" style="padding: 2% 5% 0 5%; width:100%"> 
	
		<!--   Icon Section   -->
		 
		 <div class="row center-align" style="width:100%">
			<div class="col s12 m4 l4 center-align">
				<div class="icon-block white-text">
					<i class="material-icons" style="font-size: 50px;text-shadow: 2px 2px 7px #111111"><b>people</b></i>
					<h5 style="padding: 0% 5% 0% 5%;text-shadow: 2px 2px 7px #111111">lives changed</h5>
					<h4 class="light center" style="text-shadow: 2px 2px 7px #111111">56,926</h4>
					<h6 class="light center" style="text-shadow: 2px 2px 7px #111111">in Malawi, Africa</h6>
					<br> 
				</div>
			</div>

			  <div class="col s12 m4 l4 center-align">
				<div class="icon-block white-text">
					<i class="material-icons" style="font-size: 50px;text-shadow: 2px 2px 7px #111111"><b>done_outline</b></i>
					<h5 style="padding: 0% 5% 0% 5%;text-shadow: 2px 2px 7px #111111">projects completed</h5>
					<h4 class="light center" style="text-shadow: 2px 2px 7px #111111">45</h4>
					<h6 class="light center" style="text-shadow: 2px 2px 7px #111111">from 2014 to 2018</h6>
					<br> 
				</div>
			</div>  

			<div class="col s12 m4 l4 center-align">
				<div class="icon-block white-text">
					<i class="material-icons" style="font-size: 50px;text-shadow: 2px 2px 7px #111111""><b>attach_money</b></i>
					<h5 style="padding: 0% 5% 0% 5%;text-shadow: 2px 2px 7px #111111">cost per person</h5>
					<h4 class="light center" style="text-shadow: 2px 2px 7px #111111">$0.66</h4>
					<h6 class="light center" style="text-shadow: 2px 2px 7px #111111">per year</h6>
					<br> 
				</div>
			</div>
			
		</div>
		</div> 
		
		</div>
		
		
	</div>
	

	

<div id="index-banner" class="parallax-container hide-on-large-only" style="background-color: rgba(0, 0, 0, 0.2); height: 500px">
	<div class="section no-pad-bot valign-wrapper" style="height: 100%; width: 100%;">
		<div class="section" style="width:100%;">
				<h2 class="col s12 center-align white-text text-lighten-2 flow-text" style="padding:4% 2% 0% 2%; text-shadow: 2px 2px 7px #111111;text-transform:uppercase;font-size:36px;">Fund Projects That Villages Choose</h2>
        		
        		<div style="padding:0% 8% 0% 8%">
        				<h5 class="center-align light" style="font-size:24px;opacity:0.8; text-shadow: 2px 2px 7px #111111">because everyone deserves democracy and development</h5>
			</div>
			
			<div class="center-align" style="padding:4% 2% 4% 0%">	
				<a href="project_tiles.php" id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1" style="border-radius:5px; font-size: large">FIND YOUR VILLAGE</a>
			</div>
			</div>

			<div class="parallax">
				<img src="images/chiyuni_banner.jpg">
			</div>
			
		</div>
	</div>
	
	<div class="flow-text" style="background-color: #FFF5EE; display: flex">
	<div class="container">
	<div class="center" style="padding:1% 0 0 0"><h3>DEMOCRACY DISRUPTS EXTREME POVERTY.</h3> <br>Nearly 400 million people (and growing) live in extreme poverty in rural Africa. 
	We're changing that with a model that celebrates village democracy, direct giving, and radical transparency. Small transfers of cash make a big difference
	when they target underserved villages on the ground. Read about us in <a href="https://www.nytimes.com/2018/07/17/opinion/development-aid-liberia.html" target="_blank">The New York Times</a>.</div><br>
	</div>
	</div>

<div class="container hide-on-med-and-down"">
			<h4 class="header center light blue-text text-lighten-2" style="padding:2% 0 0 0">How It Works</h4>

				<div class="row">
					<div class="col s12 m4">
						<div class="icon-block">
							<h2 class="center brown-text">
								<img style="border:5px solid rgba(0, 0, 0, .85);" class="circle responsive-img" src="images/how_it_works_democracy.jpg">
							</h2> 
							
							<h5 class="center flow-text" style="font-weight: 600;">Villages choose projects</h5>

							<p class="light center">Search the projects page or interactive map for villages battling extreme poverty in rural
								Africa. Find a village-led development project that speaks to you.</p>
								
							<h5 class="center">#localdemocracy</h5>

						</div>
					</div>

					<div class="col s12 m4">
						<div class="icon-block">
							<h2 class="center brown-text">
								<img style="border:5px solid rgba(0, 0, 0, .85);" class="circle responsive-img" src="images/how_it_works_directgiving.jpg" />
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
								<img style="border:5px solid rgba(0, 0, 0, .85);"class="circle responsive-img" src="images/how_it_works_development.jpg" />
							</h2>
							
							<h5 class="center flow-text" style="font-weight: 600;padding:0% 5% 0% 5%">We send you updates</h5>

							<p class="light center">Enjoy mobile phone updates with pictures, videos, and data from the field providing a vivid accounting
					 of how your donations change the lives of rural Africans.</p>
							 
							 <h5 class="center">#instafeedback</h5>
						</div>
					</div>
				</div>
		</div>

	<script> 
		
		$('.carousel').carousel({
		    padding: 0    
		});

		timer = setInterval(function() { $('.carousel').carousel('next'); }, 5500);
		$('.carousel').mousedown(function() { clearTimeout(timer); });
	</script>


<div class="container valign-wrapper">
<div class="hide-on-large-only">
<h4 class="header center light blue-text text-lighten-2">How It Works</h4>

		<div class="row">
			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center brown-text">
						<img style="border:5px solid rgba(0, 0, 0, .85);" class="circle responsive-img" src="images/how_it_works_democracy.jpg">
					</h2> 
					
					<h5 class="center flow-text" style="font-weight: 600;">Villages choose projects</h5>

					<p class="light center">Search the projects page or interactive map for tenacious villages battling extreme poverty in rural
						Africa. Find a village-led development project that speaks to you.</p>
						
					<h5 class="center">#localdemocracy</h5>

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
						<img style="border:5px solid rgba(0, 0, 0, .85);" class="circle responsive-img" src="images/how_it_works_development.jpg">
					</h2>
					
					<h5 class="center flow-text" style="font-weight: 600;padding:0% 5% 0% 5%">We send you updates</h5>

					<p class="light center">Enjoy mobile phone updates with pictures, videos, and data from the field providing a vivid accounting
					 of how your donations change the lives of rural Africans.</p>
					 
					 <h5 class="center">#instafeedback</h5>
				</div>
			</div>
		</div>
	</div>
	<br>
	
</div>	

<div id="index-banner" class="parallax-container" style="background-color: rgba(0, 0, 0, 0.3); height: 500px">
            
            <div class="parallax">
                <img src="images/woman_with_goat.jpg">
            </div>
    <div class="section no-pad-bot valign-wrapper"
        style="height: 100%; width: 100%;">
        <div class="row" style="width:100%;">
            
            <div class="row center" style="opacity:0.7; width:250px; height:250px; border-radius:50%; border-style:solid;">
                        <h1 class="header center-align light" style="padding:5% 2% 0% 2%;text-shadow: 2px 2px 7px #111111;"><b>100%</b></h1>
                        <h5 class="header center-align light" style="padding:0% 2% 0% 0%;text-shadow: 2px 2px 7px #111111;">radically</h5>
                        <h5 class="header center-align light" style="padding:0% 2% 2% 2%;text-shadow: 2px 2px 7px #111111">transparent</h5>
            </div>  
            
            
            <div class="row center" style="padding: 0% 1% 0% 1%; width:100%;">
                
                <a href="track.php" id="download-button"
                    class="btn-large waves-effect waves-light light blue lighten-1" style="border-radius:20px;">latest updates</a>
            </div>
            
         <h6 class="header center light text-shadow: 2px 2px 7px #111111" style="width:100%; padding:0% 15% 0% 15%;">straight from the ground</h6>
            
        </div>
    </div>
</div>

<div class="container">
	<br>
	<h4 class="header center light blue-text text-lighten-2">Featured Projects</h4>
	<h6 class="header center light text-shadow: 2px 2px 7px #111111" style="padding:0% 10% 2% 10%">(100% completion rate)</h6>
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
        $villageContribution = round($projectTotal * .05);
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
              <span class="card-title"><b>like disrupting extreme poverty?<br> sign up for our newsletter</b></span>
      		
    		<form action="//villagexapp.us8.list-manage.com/subscribe/post?u=0aa3c6538384ca95760dc6be6&amp;id=2efaede0d4" method="post" target="_blank" class="col s12">
      		<div class="row">
        			<div class="input-field col s12" style="color:#03A9F4">
         			<input value="" name="EMAIL" id="mce-EMAIL" placeholder="enter your email address" style="font-size:20px; text-color:#000000" id="mcd-email" type="email" class="email validate">
        			</div>
      		</div>
    		
			
        		<div class="center-align" style="width:100%; padding: 0 0 5% 0">
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

	<br><br>

<div class="container">
<h4 class="header center light blue-text text-lighten-2">How It Helps</h4> 
	<h6 class="header center light text-shadow: 2px 2px 7px #111111" style="padding:0% 10% 2% 10%">(proving impact with data)</h6>
<table class="highlight centered responsive-table striped flow-text" style="table-layout: fixed;">
		        <thead>
		          <tr>
		              <th>Metric</th>
		              <th>Boys in nursery</th>
		              <th>Girls in nursery</th>
		              <th>Goat assets</th>
		              <th>Waterborne illness</th>
		              <th>Infant deaths</th>
		              <th>Agri business</th>
		              <th>Other business</th>
		              <th>Homes w/ metal roofs</th>
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
		      <div class="flow-text center" style="padding:2% 5% 0 5%;font-size:20px;">*Table shows development impacts (changes in treatment v. control villages) after two projects and a total investment of $7,000 per village, on average. 
		      25 development metrics collected annually in each treatment and control village from 2014 (baseline) to 2018, with statistics calculated 
				using a difference-in-differences model.  More info <a href="impacts.php">here</a>.  
		      </div>
		      </div>
<br/><br/>
<?php include('footer.inc'); ?>
