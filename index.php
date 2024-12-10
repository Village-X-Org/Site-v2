<?php require_once("utilities.php"); 
$hasCookies = 0;
if (!$session_donor_id && isset($_COOKIE['username'])) {
  $username = $email = $_COOKIE ['username'];
  $password = $_COOKIE ['password'];
  $hideOutput = 1;
  include('user_check.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Village X | Fund Projects That Villages Choose</title>
<meta name="description" content="Disrupting extreme poverty in rural Africa with democracy, direct giving, and data."/>
<script src='js/modernizr-custom.js'></script>

<style>
body, html {
    height: 100%;
    margin: 0;
}

.carousel-slider {
    height: 800px !important;
}

.card {
  overflow: auto;
}


.subheader {
  font-size: 1rem;
  font-weight: 500;
  line-height: 1.5rem;
  margin: 0.75rem 16px;
}

.list-divider {
  border: 0;
  height: 1px;
  overflow: hidden;
  background-color: #e0e0e0;
  margin-right: 16px;
  margin-left: 75px;
}

.list {
  margin: 0;
}

.list li {
  padding: 0 16px;
}

.list li .valign-wrapper {
  min-height: 72px;
}

.list i.circle {
  padding: 10px;
  background-color: rgba(255, 255, 255, 0.5);
}

.list .title span {
  color: rgba(0, 0, 0, 0.54);
}

.ml-auto {
  margin-left: auto;
}

i.ml-auto {
  color: rgba(0, 0, 0, 0.26);
}

#clockdiv{
  color: #fff;
  display: inline-block;
  font-weight: 100;
  text-align: center;
  font-size: 30px;
}

#clockdiv > div{
  padding: 10px;
  border-radius: 3px;
  background: #00BF96;
  display: inline-block;
}

#clockdiv div > span{
  padding: 15px;
  border-radius: 3px;
  background: #00816A;
  display: inline-block;
}

.smalltext{
  padding-top: 5px;
  font-size: 10px;
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

if (!CACHING_ENABLED || !file_exists(CACHED_STATUS_FILENAME)) {
	$statusBuffer = '';
	$currentYear = date('Y');
	if (date('m') < 4) {
		$currentYear--;
	}
	$result = doUnprotectedQuery("SELECT COUNT(pe_id) AS count FROM project_events WHERE pe_type=4 AND YEAR(pe_date)=$currentYear;");
	if ($row = $result->fetch_assoc()) {
		$thisYearCount = $row['count'];
		if ($thisYearCount > 1) {
			$statusBuffer .= "<div style='height:60px;font-size:18px;text-shadow: 2px 2px 7px #111111;'><b>$thisYearCount</b> projects completed in $currentYear.</div>";
		}
		mysqli_free_result($result);
	}

	$result = doUnprotectedQuery("SELECT COUNT(maxDate) AS count FROM (SELECT MAX(pe_type) AS maxType, MAX(pe_date) AS maxDate FROM project_events GROUP BY pe_project_id) AS summarized WHERE maxType=3 AND YEAR(maxDate)=$currentYear;");
	if ($row = $result->fetch_assoc()) {
		$inProgressCount = $row['count'];
		if ($inProgressCount > 1) {
			$statusBuffer .= "<div style='height:60px;font-size:18px;text-shadow: 2px 2px 7px #111111;'><b>$inProgressCount</b> are currently under construction.</div>";
		}
		mysqli_free_result($result);
	}

	$result = doUnprotectedQuery("SELECT UNIX_TIMESTAMP(MAX(ru_date)) AS latest FROM raw_updates");
	if ($row = $result->fetch_assoc()) {
		$latest = $row['latest'];
		$statusBuffer .= "<div style='height:60px;font-size:18px;text-shadow: 2px 2px 7px #111111;'>Latest village update on <b>".date("F jS", $latest)."</b></div>";
		mysqli_free_result($result);
	}

	if (CACHING_ENABLED) {
        $handle = fopen(CACHED_STATUS_FILENAME, "w");
        fwrite($handle, $statusBuffer);
        fclose($handle);
    }
} else {
	$statusBuffer = file_get_contents(CACHED_STATUS_FILENAME);
}

?>	

<div id="index-banner" class="parallax-container valign-wrapper" style="background-color: rgba(0, 0, 0, 0.1);"> 
    <div class="section row center hide-on-small-only" style="width:100%;">
     	<div class="section row center" style="width:100%;">
      		<h2 class="col s12 center-align white-text text-lighten-2" style="padding: 3% 20% 2% 20%; text-shadow: 2px 2px 7px #111111;text-transform:uppercase;font-weight:300;font-size:50px;">Fund Projects That Villages Choose</h2>
        	<div class="right-align col s12 m6 l6" style='padding:10px 1% 0 1%;'>	
				<a href="project_tiles.php" id="download-button"
					class="btn-large waves-effect waves-light lighten-1 white black-text" style="background-color:rgba(0, 0, 0, 0);border-radius:5px; 
				border-width: 1px; border-style:solid; border-color: white; font-size:x-large;">FIND PROJECTS</a>
			</div>
			
			<div class="left-align col s12 m6 l6" style='padding:10px 1% 0 1%;'>	
				<a href="track.php" id="download-button"
					class="btn-large waves-effect waves-light lighten-1" style="background-color:rgba(0, 0, 0, 0);border-radius:5px; 
				border-width: 1px; border-style:solid; border-color: white; font-size:x-large;">VIEW UPDATES</a>
			</div>
		</div>
			
			<div class="section row center" style="width:100%; padding: 2% 0% 2% 0%;">
				<div class="col s12">
						<?php print $statusBuffer; ?>
						<!--<div style='height:187px;'>placeholder for guidestar badge </div>-->
						<!--<div class="icon-block"><img style="border:5px solid rgba(0, 0, 0, .85);" class="circle responsive-img" src="images/guidestar_2019.webp"></div>-->
						
				</div>
			</div>
			
		</div>
			
			
	<div class="section row center hide-on-med-and-up" style="width:100%;">
     	<div class="section row center" style="width:100%;">
      		<h2 class="col s12 center-align white-text text-lighten-2" style="padding: 6% 20% 2% 20%; text-shadow: 2px 2px 7px #111111;text-transform:uppercase;font-weight:300;font-size:50px;">Fund Projects That Villages Choose</h2>
			<div class="center-align col s12 m6 l6" style='padding:1% 0 0 0;'>	
				<a href="project_tiles.php" id="download-button"
					class="btn-large waves-effect waves-light lighten-1 white black-text" style="background-color:rgba(0, 0, 0, 0);border-radius:5px; 
				border-width: 1px; border-style:solid; border-color: white; font-size:x-large;">FIND PROJECTS</a>
			</div>
			
			<div class="center-align col s12 m6 l6" style='padding:10px 1% 0 1%;'>	
				<a href="track.php" id="download-button"
					class="btn-large waves-effect waves-light lighten-1" style="background-color:rgba(0, 0, 0, 0);border-radius:5px; 
				border-width: 1px; border-style:solid; border-color: white; font-size:x-large;">VIEW UPDATES</a>
			</div>
			</div>
			
			<div class="section row center" style="width:100%; padding: 2% 0% 2% 0%;">
				<div class="col s12">
					<div class="icon-block">
						<?php print $statusBuffer; ?>
						<!--<img style="border:5px solid rgba(0, 0, 0, .85);" class="circle responsive-img" src="images/guidestar_2019.webp">-->
						<!-- <div style='height:187px;'> placeholder for guidestar badge</div>-->
					</div>
				</div>
			</div>
			
		</div>
			
					
			
        <div class="parallax">
			<img src="images/chiyuni_banner.jpg" alt="">
		</div>
    </div>

      
	<div class="flow-text section" style="background-color: #FFF5EE; display: flex">
	<div class="container">
	<div class="center" style="padding:1% 0 1% 0; width:100%"><h3>DIRECT DONATIONS DRIVE LOCAL CHANGE</h3>
		<div class="section row center" style="width:100%; padding: 1% 0% 1% 0%;opacity: .9">Disrupt extreme poverty in rural Africa with a radically transparent model that celebrates <b>village 
	democracy, direct giving, and data analysis</b>. Small transfers of cash make a big difference when they target community-led projects.</div>
	</div>
	
	<div class="section row center" style="width:100%; padding: 0% 0% 1% 0%;opacity: .7">
			<div class="col s12">
						
							  <a href="https://www.nytimes.com/2018/07/17/opinion/development-aid-liberia.html" target="_blank"><img class="responsive-img" src="images/nyt_logo.svg"></a>
						
					</div>
				</div>
	
	</div>
	
	</div>

<div class="container">
			<h4 class="header center light blue-text text-lighten-2" style="text-transform:uppercase; padding:1% 0 0 0">How It Works</h4>

				<div class="row">
					<div class="col s12 m12 l4">
						<div class="icon-block">
							<h2 class="center brown-text">
							  
							  <img style="border:5px solid rgba(0, 0, 0, .85);" class="circle responsive-img" src="images/how_it_works_democracy.jpg">
							
							</h2> 
							
							<h5 class="center flow-text" style="font-weight: 300;padding:0% 0 2% 0%">Bakili Village votes to build a nursery school to improve early childhood education.</h5>
			
							<h5 class="center">#democracy</h5> 

						</div>
					</div>

					<div class="col s12 m12 l4">
						<div class="icon-block">
							<h2 class="center brown-text">
				
								  <img style="border:5px solid rgba(0, 0, 0, .85);" class="circle responsive-img" src="images/how_it_works_directgiving.jpg">
								
							</h2>

							<h5 class="center flow-text" style="font-weight: 300; padding:0% 10% 2% 10%">Alice, a teacher in New York City, donates to Bakili's project.</h5>
					
							<h5 class="center">#directgiving</h5>  
						</div>
					</div>

					<div class="col s12 m12 l4">
						<div class="icon-block">
							<h2 class="center black-text">
								
								  <img style="border:5px solid rgba(0, 0, 0, .85);" class="circle responsive-img" src="images/how_it_works_development.jpg">
								
							</h2>
							
							<h5 class="center flow-text" style="font-weight: 300;padding:0% 5% 2% 5%">The completed school increases nursery enrollment in Bakili by 60%.</h5>

							 <h5 class="center">#data</h5>  
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

<div id="index-banner" class="parallax-container" style="background-color: rgba(0, 0, 0, 0.1); height: 700px">
            
            <div class="parallax">
            	
				  <img src="images/water_celebration.jpg" alt="">
				
            </div>
    <div class="section no-pad-bot valign-wrapper"
        style="height: 100%; width: 100%;">
        <div class="center-align valign-wrapper" style="width:100%">
        <div class="row center-align" style="width:100%;height:100%;padding:0% 0% 0% 0%;">
        <h4 class="header center light white-text text-lighten-2" style="text-transform:uppercase; padding:0% 0 0 0">Our Guarantee</h4>
         
         <div class="row center-align" style="width:100%;">
        
         
         <div class="col 12" style="width:100%">
                        <div class="row valign-wrapper" style="vertical-align:middle; display:inline-block;margin: 0 auto;width:100%">
                        <div class="right-align" style="vertical-align:middle; display:inline-block;"><h5 class="header light" style="padding:0% 0% 0% 0%;text-shadow: 4px 4px 7px #111111;">   give and<br>follow<br>  projects</h5></div>
                         <div class="center-align" style="vertical-align:middle;display:inline-block; width:100px;padding: 6px 0 0 0"><i class="material-icons large">phone_iphone</i></div>
                         <div class="left-align" style="vertical-align:middle;display:inline-block;"><h5 class="header light" style="padding:0% 0% 0% 0%;text-shadow: 4px 4px 7px #111111;">easily<br>from a<br>phone</h5></div>
                         </div> 
            </div>
   
            </div>            
   
          
    <div class="row center-align" style="text-shadow: 4px 4px 7px #111111;width:325px; border-style:solid; border-width:thin; border-radius: 15px; padding:0 0 0 0%; overflow: auto;">
    <ul class="list center-align" style="padding: 0 0 0 4%">
      <li class="waves-effect" style="width:100%">
        <div class="valign-wrapper">
        <i class="material-icons left circle white-text">place</i>
          <div class="white-text" style="font-size: 25px;text-shadow: 4px 4px 7px #111111; padding: 0 0 0 2%">
            <a href="https://villagex.org/map.php" target="_blank"><span class="white-text">projects mapped</span></a>
          </div>
        </div>
      </li>
      <li class="waves-effect" style="width:100%">
        <div class="valign-wrapper">
          <i class="material-icons left circle white-text">attach_money</i>
          <div class="flow-text white-text" style="font-size: 25px; text-shadow: 4px 4px 7px #111111;padding: 0 0 0 2%">
            <a href="https://villagex.org/finances.php" target="_blank"><span class="white-text">cost breakdowns</span></a>
          </div>
        </div>
      </li>
      <li class="waves-effect" style="width:100%">
        <div class="valign-wrapper">
          <i class="material-icons left circle white-text">show_chart</i>
          <div class="flow-text white-text" style="font-size: 25px; text-shadow: 4px 4px 7px #111111;padding: 0 0 0 2%">
            <a href="https://villagex.org/impacts.php" target="_blank"><span class="white-text">impact data</span></a>
          </div>
        </div>
      </li>
      <li class="waves-effect" style="width:100%">
        <div class="valign-wrapper">
          <i class="material-icons left circle white-text">insert_photo</i>
          <div class="flow-text white-text" style="font-size: 25px; text-shadow: 4px 4px 7px #111111;padding: 0 0 0 2%">
            <a href="https://villagex.org/track.php" target="_blank"><span class="white-text">same-day updates</span></a>
          </div>
        </div>
      </li>
      <li class="waves-effect" style="width:100%">
        <div class="valign-wrapper">
          <i class="material-icons left circle white-text">person</i>
          <div class="flow-text white-text" style="font-size: 25px; text-shadow: 4px 4px 7px #111111;padding: 0 0 0 2%">
            <a href="https://villagex.org/user_login.php" target="_blank"><span class="white-text">user profiles</span></a>
          </div>
        </div>
      </li>
    </ul>
    </div> 
    
    </div>
    
            
            </div>
        </div>
    </div>
</div>

<div class="container">
	<h4 class="header center light blue-text text-lighten-2" style="text-transform:uppercase;padding:1% 0 0 0">Featured Projects</h4>
	<h6 class="header center light" style="padding:0% 10% 2% 10%;">(100% completion rate)</h6>
	<div class="section">

		<!--   project section   -->
		<div class="row">
<?php
if (!CACHING_ENABLED || !file_exists(CACHED_HIGHLIGHTED_FILENAME)) {
    $result = doUnprotectedQuery("SELECT p1.project_id AS project_id, p1.project_name AS project_name, p1.project_type_id AS project_type_id, picture_filename, p1.project_summary AS project_summary, 
                village_name, p1.project_funded AS project_funded, p1.project_budget AS project_budget, p1.project_community_contribution AS community_contribution, pt_label, 
                YEAR(MIN(p2.project_date_posted)) AS previousYear, CONCAT(matchingDonor.donor_first_name, ' ', matchingDonor.donor_last_name) AS matchingDonor, pe_date, 
				UNIX_TIMESTAMP(MAX(ru_date)) AS latestUpdate
                FROM projects AS p1 
                JOIN villages ON p1.project_village_id=village_id 
                LEFT JOIN projects AS p2 ON p1.project_village_id=p2.project_village_id AND p1.project_id<>p2.project_id AND p2.project_funded>=p2.project_budget 
                LEFT JOIN project_events ON pe_type=4 AND pe_project_id=p1.project_id
                JOIN project_types ON p1.project_type_id=pt_id
                JOIN pictures ON p1.project_profile_image_id=picture_id 
                LEFT JOIN donors AS matchingDonor ON p1.project_matching_donor=matchingDonor.donor_id
				LEFT JOIN raw_updates ON ru_project_id=p1.project_id
                WHERE p1.project_org_id=0 AND p1.project_budget > 0 AND p1.project_funded > 0 AND p1.project_status<>'cancelled'
                GROUP BY p1.project_id 
                ORDER BY pe_date IS NOT NULL, p1.project_status = 'funding' DESC, p1.project_funded < p1.project_budget DESC, 
				IF(p1.project_funded < p1.project_budget, p1.project_funded - (p1.project_budget * .1), 0) DESC, 
				latestUpdate DESC, p1.project_date_posted ASC");
    $buffer = '';
    $cells = array();
    while ($row = $result->fetch_assoc()) {
        $projectId = $row['project_id'];
        $projectName = $row['project_name'];
        $projectType = $row['project_type_id'];
        $projectTotal = $row['project_budget'];
		$latestUpdate = $row['latestUpdate'];
        $funded = min($projectTotal, round($row['project_funded']));
        $previousYear = $row['previousYear'];
        $matchingDonor = $row['matchingDonor'];
        $fundedPercent = $funded / max(1, $projectTotal) * 100;
        $villageContribution = round($projectTotal * .05);
        if (!isset($cells[$projectType])) {
            $cells[$projectType] = array();
        }
        $nextBuffer = "<div class='col s12 m12 l4 ' style='min-width:225px;cursor:pointer;' onclick=\"document.location='project.php?id=$projectId';\">
    			<div class='card sticky-action hoverable'>
    				<div class='card-image'>
    					<div class='activator' style=\"width:100%;height:370px;background-position:center;background-size:cover;background-image:url('".PICTURES_DIR."{$row['picture_filename']}');\"></div>
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
    					<p>Locals Contributed: \$$villageContribution</p>";
						if ($latestUpdate) {
							$nextBuffer .= "<i style='font-size:smaller;'>Latest Update: ".date("F jS, Y", $latestUpdate)."</i>";
						} else {
							$nextBuffer .= "&nbsp;";
						}

    				$nextBuffer .= "</div>
    				<div class='card-action'>".($matchingDonor ? "
				    <a class='tooltip' style='text-decoration:none;position:absolute;right:-15px;bottom:10px;text-transform:none;text-align:center;'><span class='tooltiptext' style='left:-190%;top:-150%;'>$matchingDonor will match all donations!</span>
                            <span style='margin:auto 0;position:absolute;top:14%;left:3%;color:black;font-size:15px;z-index:10;line-height:95%'><b>100%<br>Match</b></span>
                            
                            <i class='material-icons center' style='opacity:0.6;font-size:50px; color:#03A9F4;'>flash_on</i>

                        </a>" : "")."
    					<div class='row center'>
    						<div class='col s12'>";
        if ($fundedPercent < 100) {
            $nextBuffer .= "<a id='donate_button'
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

		<div class="row center" style="padding:0 0 1% 0">
			<a href='project_tiles.php' id="download-button"
				class="btn-large waves-effect waves-light light blue-text lighten-1" style="background-color:rgba(0, 0, 0, 0);border-radius:5px; 
				border-width: 1px; border-style:solid; border-color: light blue; font-size:large;">more
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
        	<div>
                  	<h4 class="header center light white-text text-lighten-2" style="text-transform:uppercase; padding:1% 0 1% 0">newsletter</h4> 
          <div class="card white" style="opacity: 0.7; border-radius:20px;">
            <div class="card-content black-text">
              <span class="card-title"><b>sign up to stay in the loop</b></span>
      		
    		<form action="//villagexapp.us8.list-manage.com/subscribe/post?u=0aa3c6538384ca95760dc6be6&amp;id=2efaede0d4" method="post" target="_blank" class="col s12">
      		<div class="row">
        			<div class="input-field col s12" style="color:#03A9F4">
         			<input value="" name="EMAIL" id="mce-EMAIL" placeholder="enter your email address" style="font-size:20px; text-color:#000000" id="mcd-email" type="email" class="email validate">
        			</div>
      		</div>
    		
			
        		<div class="center-align" style="width:100%; padding: 0 0 5% 0">
          			<button class="btn-large blue waves-effect waves-light center-align" style="font-size:large;border-radius:5px; margin:0% 0% 5% 0%;" type="submit" name="action">submit
  					</button>
    			</div>
    		
    			<div style="position: absolute; left: -5000px;" aria-hidden="true">
								<input type="text" name="b_0aa3c6538384ca95760dc6be6_2efaede0d4" tabindex="-1" value="">
			</div>
			
			</form>
			
			</div>	
			</div>
          </div>
        </div>
      
			<div class="parallax">
				
				  <img src="images/newsletter_banner_2.jpg" alt="">
				
			</div>
		</div>
	</div>
</div>

<div class="container">
<h4 class="header center light blue-text text-lighten-2" style="text-transform:uppercase; padding:1% 0 0 0">Verified Impacts</h4> 
	<div class="row">
					<div class="col s12 m12 l4">
						<div class="icon-block">
							<h2 class="center brown-text">
							 
							  <img style="border:5px solid rgba(0, 0, 0, .85);" class="circle responsive-img" src="images/school_impacts.jpg">
							  
							</h2> 
							<h5 class="light center" style="padding:0% 10% 0% 10%;">Kids in nursery school</h5>
							<h4 class="center" style="font-weight: 300;padding:0% 0 2% 0%">+60%</h4>
							<h5 class="center flow-text light blue-text" style="font-weight: 300;padding:0% 0 2% 0%">increase</h5>

							
								
							 

						</div>
					</div>

					<div class="col s12 m12 l4">
						<div class="icon-block">
							<h2 class="center brown-text">
								
								  <img style="border:5px solid rgba(0, 0, 0, .85);" class="circle responsive-img" src="images/goat_impacts.jpg">
								
							</h2>

							<h5 class="light center" style="padding:0% 10% 0% 10%;">Goats owned by families</h5>
							<h4 class="center" style="font-weight: 300;padding:0% 0 2% 0%">+83%</h4>
							<h5 class="center flow-text light blue-text" style="font-weight: 300;padding:0% 0 2% 0%">increase</h5>  
						</div>
					</div>

					<div class="col s12 m12 l4">
						<div class="icon-block">
							<h2 class="center black-text">
								
								  <img style="border:5px solid rgba(0, 0, 0, .85);" class="circle responsive-img" src="images/water_impacts.jpg">
								
							</h2>
							
							<h5 class="light center" style="padding:0% 12% 0% 12%;">Waterborne illnesses</h5>
							<h4 class="center" style="font-weight: 300;padding:0% 0 2% 0%">-64%</h4>
							<h5 class="center flow-text light blue-text" style="font-weight: 300;padding:0% 0 2% 0%">decrease</h5>  
						</div>
					</div>
				</div>
				<div class="row center" style="padding:1% 0 0 0">
			<a href='impacts.php' id="download-button"
				class="btn-large waves-effect waves-light blue-text lighten-1" style="background-color:rgba(0, 0, 0, 0);border-radius:5px; 
				border-width: 1px; border-style:solid; border-color: light blue; font-size:large;">more
				impacts</a>
		</div>
		     
		      </div>
<br/>
<?php include('footer.inc'); ?>
