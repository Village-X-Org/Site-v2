<?php
require_once("utilities.php");
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
?>	

<div id="index-banner" class="parallax-container valign-wrapper" style="background-color: rgba(0, 0, 0, 0.2); height:100vh;"> 
	<div class="section">
			<p class="center-align text-lighten" style="text-transform:uppercase;font-size:48px;text-shadow: 2px 2px 7px #111111;font-weight:300; color: #00BF96;margin:0;padding:0;line-height:40px;">Labor Day Fundraiser</p>
      <h5 class="center-align white-text">1 week only, FIRST $7,000 MATCHED</h5>
              
        <div class="center-align" id="clockdiv" style="width:100%; padding-top:20px;">
          <div>
            <span class="days"></span>
            <div class="smalltext">Days</div>
          </div>
          <div>
            <span class="hours"></span>
            <div class="smalltext">Hours</div>
          </div>
          <div>
            <span class="minutes"></span>
            <div class="smalltext">Minutes</div>
          </div>
          <div>
            <span class="seconds"></span>
            <div class="smalltext">Secs</div>
          </div>
        </div>
        <div class="row" style='padding-top:20px;'>
          <div class="center-align col s12" style='padding:20px;'>
          <a href="project_tiles.php"><button id="download-button" class="btn-large waves-effect waves-light lighten-1 white black-text" style="background-color:rgba(0, 0, 0, 0);border-radius:5px; 
            border-width: 1px; border-style:solid; border-color: white; font-size:x-large;">DONATE</button></a>
          </div>
          
          <div class="center-align col s12 l2 offset-l4" style='padding-top:10px;'>
          <a href="https://www.facebook.com/dialog/feed?app_id=<?php print FACEBOOK_APP_ID; ?>&display=popup&caption=<?php print urlencode('This website disrupts extreme poverty.  Double your donation - one week only!');?>&link=<?php print BASE_URL;?>" target="_blank"><button id="download-button" class="btn-large waves-effect waves-light lighten-1 social facebook" style="background-color:rgba(0, 0, 0, 0);border-radius:5px; 
            border-width: 1px; border-style:solid; border-color: white; font-size:x-large;"><i class="fa fa-facebook left"></i>Share</button></a>
          </div>
          
          <div class="center-align col s12 l2" style='padding-top:10px;'>
          <a href="https://twitter.com/share?url=<?php print BASE_URL; ?>;text=<?php print urlencode('This website disrupts extreme poverty.  Double your donation - one week only!');?>;hashtags=villagex"
        target="_blank"><button id="download-button" class="btn-large waves-effect waves-light lighten-1" style="background-color:rgba(0, 0, 0, 0);border-radius:5px; 
            border-width: 1px; border-style:solid; border-color: white; font-size:x-large;"><i class="fa fa-twitter left"></i>Tweet</button></a>
          </div>
        </div>  
      </div>
      <!--

    <div class="section row center" style="width:100%;">
      <h2 class="col s12 center-align white-text text-lighten-2" style="padding:3% 20% 3% 20%; text-shadow: 2px 2px 7px #111111;text-transform:uppercase;font-weight:300;font-size:36px;">We Fund Projects That Villages Choose</h2>
        		<div class="center-align col s12 l3 offset-l3" style='padding:10px;'>	
				<a href="project_tiles.php" id="download-button"
					class="btn-large waves-effect waves-light lighten-1 white black-text" style="background-color:rgba(0, 0, 0, 0);border-radius:5px; 
				border-width: 1px; border-style:solid; border-color: white; font-size:x-large;">SEE PROJECTS</a>
			</div>
			
			<div class="center-align col s12 l3" style='padding:10px;'>	
				<a href="add_village.php" id="download-button"
					class="btn-large waves-effect waves-light lighten-1" style="background-color:rgba(0, 0, 0, 0);border-radius:5px; 
				border-width: 1px; border-style:solid; border-color: white; font-size:x-large;">ADD VILLAGES</a>
			</div>
    </div>
            -->
			
			
        <div class="parallax">
			<img src="images/chiyuni_banner.jpg" alt="">
		</div>
	
</div>
      
<script>
  function getTimeRemaining(endtime) {
      var t = Date.parse(endtime) - Date.parse(new Date());
      var seconds = Math.floor((t / 1000) % 60);
      var minutes = Math.floor((t / 1000 / 60) % 60);
      var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
      var days = Math.floor(t / (1000 * 60 * 60 * 24));
    return {
        'total': t,
        'days': days,
        'hours': hours,
        'minutes': minutes,
        'seconds': seconds
      };
  }

  var seconds = <?php print (new DateTime("2019-09-09", new DateTimeZone("Pacific/Honolulu")))->getTimestamp(); ?>;
  endTime = new Date(seconds * 1000);

  function updateClock() {
    var t = getTimeRemaining(endTime);

    var clock = document.getElementById('clockdiv');
    var daysSpan = clock.querySelector('.days');
    var hoursSpan = clock.querySelector('.hours');
    var minutesSpan = clock.querySelector('.minutes');
    var secondsSpan = clock.querySelector('.seconds');

    daysSpan.innerHTML = t.days;
    hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
    minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
    secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

    if (t.total <= 0) {
        clearInterval(timeinterval);
    }
  }
  updateClock();
  var timeinterval = setInterval(updateClock, 1000);
</script>

	<div class="flow-text section" style="background-color: #FFF5EE; display: flex">
	<div class="container">
	<div class="center" style="padding:1% 0 1% 0"><h3>DEMOCRACY DISRUPTS EXTREME POVERTY</h3> <br>Nearly 400 million people (and growing) live in extreme poverty in rural Africa. 
	We're changing that with a model that celebrates <b>village democracy, direct giving, and data analysis</b>. Small transfers of cash make a big difference
	when they target public goods chosen by underserved villages. Read about us in <a href="https://www.nytimes.com/2018/07/17/opinion/development-aid-liberia.html" target="_blank">The New York Times</a>.</div><br>
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
					
							<h5 class="center">#direct</h5>  
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
        <h4 class="header center light white-text text-lighten-2" style="text-transform:uppercase; padding:0% 0 0 0">our guarantee</h4>
         
         <div class="row center-align" style="width:100%;">
        
         
         <div class="col 12" style="width:100%">
                        <div class="row valign-wrapper" style="vertical-align:middle; display:inline-block;margin: 0 auto;width:100%">
                        <div class="right-align" style="vertical-align:middle; display:inline-block;"><h5 class="header light" style="padding:0% 0% 0% 0%;text-shadow: 4px 4px 7px #111111;">   give and<br>follow<br>  projects</h5></div>
                         <div class="center-align" style="vertical-align:middle;display:inline-block; width:100px;padding: 6px 0 0 0"><i class="material-icons large">phone_iphone</i></div>
                         <div class="left-align" style="vertical-align:middle;display:inline-block;"><h5 class="header light" style="padding:0% 0% 0% 0%;text-shadow: 4px 4px 7px #111111;">easily<br>from your<br>phone</h5></div>
                         </div> 
            </div>
   
            </div>
          
    <div class="row center-align" style="text-shadow: 4px 4px 7px #111111;width:350px; border-style:solid; border-width:thin; border-radius: 15px; padding:0 0 0 0%; overflow: auto;">
    <ul class="list center-align">
      <li class="waves-effect" style="width:100%">
        <div class="valign-wrapper">
        <i class="material-icons left circle white-text">place</i>
          <div class="white-text flow-text" style="font-size: large; padding:0 0 0 0%;text-shadow: 4px 4px 7px #111111;">
            <a href="https://villagex.org/map.php" target="_blank"><span class="white-text"><b>every project mapped</b></span></a>
          </div>
        </div>
      </li>
      <li class="waves-effect" style="width:100%">
        <div class="valign-wrapper">
          <i class="material-icons left circle white-text">attach_money</i>
          <div class="flow-text white-text" style="font-size: large;text-shadow: 4px 4px 7px #111111;">
            <a href="https://villagex.org/finances.php" target="_blank"><span class="white-text"><b>clear financial breakdowns</b></span></a>
          </div>
        </div>
      </li>
      <li class="waves-effect" style="width:100%">
        <div class="valign-wrapper">
          <i class="material-icons left circle white-text">show_chart</i>
          <div class="flow-text white-text" style="font-size: large;text-shadow: 4px 4px 7px #111111;">
            <a href="https://villagex.org/impacts.php" target="_blank"><span class="white-text"><b>village-level impact data</b></span></a>
          </div>
        </div>
      </li>
      <li class="waves-effect" style="width:100%">
        <div class="valign-wrapper">
          <i class="material-icons left circle white-text">insert_photo</i>
          <div class="flow-text white-text" style="font-size: large;text-shadow: 4px 4px 7px #111111;">
            <a href="https://villagex.org/track.php" target="_blank"><span class="white-text"><b>same-day project updates</b></span></a>
          </div>
        </div>
      </li>
      <li class="waves-effect" style="width:100%">
        <div class="valign-wrapper">
          <i class="material-icons left circle white-text">person</i>
          <div class="flow-text white-text" style="font-size: large;text-shadow: 4px 4px 7px #111111;">
            <a href="https://villagex.org/user_login.php" target="_blank"><span class="white-text"><b>user profiles track giving</b></span></a>
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
        $nextBuffer = "<div class='col s12 m12 l4 ' style='min-width:225px;cursor:pointer;' onclick=\"document.location='project.php?id=$projectId';\">
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
              <span class="card-title"><b>like disrupting extreme poverty?<br> sign up to stay in the loop</b></span>
      		
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
