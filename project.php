<?php 
require_once("utilities.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php

if (hasParam('id')) {
    $projectId = paramInt('id');
} else {
    include('project_tiles.php');
    return;
}

if (!CACHING_ENABLED || !file_exists(CACHED_PROJECT_PREFIX.$projectId)) {
    ob_start();
$stmt = prepare("SELECT project_id, village_id, project_name, similar_pictures.picture_filename AS similar_picture, banner_pictures.picture_filename AS banner_picture, 
                project_summary, project_community_problem, project_community_solution, project_community_partners, project_impact, village_name, village_lat, village_lng, 
                project_funded, project_budget, project_type, project_staff_id, COUNT(DISTINCT pe_id) AS eventCount, COUNT(DISTINCT donation_donor_id) AS donorCount,
                CONCAT(donor_first_name, ' ', donor_last_name) AS matchingDonor
                FROM projects JOIN villages ON village_id=project_village_id 
                LEFT JOIN pictures AS similar_pictures ON project_similar_image_id=similar_pictures.picture_id 
                LEFT JOIN pictures AS banner_pictures ON project_banner_image_id=banner_pictures.picture_id 
                LEFT JOIN project_events ON pe_project_id=project_id 
                LEFT JOIN donors ON project_matching_donor=donor_id 
                LEFT JOIN ((SELECT donation_donor_id, donation_project_id FROM donations WHERE donation_project_id=? AND donation_is_test=0) 
                        UNION (SELECT sd_donor_id AS donation_donor_id, sd_project_id AS donation_project_id FROM subscription_disbursals WHERE sd_project_id=?)) AS derived ON donation_project_id=project_id
                WHERE project_id=? GROUP BY project_id");
$stmt->bind_param('iii', $projectId, $projectId, $projectId);
$result = execute($stmt);
if ($row = $result->fetch_assoc()) {
    $projectName = $row['project_name'];
    $pictureFilename = $row['similar_picture'];
    $bannerPicture = $row['banner_picture'];
    $summary = $row['project_summary'];
    $problem = $row['project_community_problem'];
    $solution = $row['project_community_solution'];
    $partners = $row['project_community_partners'];
    $impact = $row['project_impact'];
    $villageId = $row['village_id'];
    $villageName = $row['village_name'];
    $villageLat = $row['village_lat'];
    $villageLng = $row['village_lng'];
    $funded = round($row['project_funded']);
    $total = $row['project_budget'];
    $projectType = $row['project_type'];
    $staffId = $row['project_staff_id'];
    $hasEvents = $row['eventCount'] > 0;
    $donorCount = $row['donorCount'];
    $matchingDonor = $row['matchingDonor'];
    
    $villageContribution = round($total * .05);
    $percentFunded = max(5, round($funded * 100 / $total));
    
    $households = getLatestValueForStat($villageId, "# of HH");
    $population = getLatestValueForStat($villageId, "# of People");
} else {
    print "The requested project could not be found.";
    die(1);
}
$stmt->close();

?>
<meta property="fb:appid" content="<?php print FACEBOOK_APP_ID; ?>"/>
<meta property="og:image" content="<?php print PICTURES_DIR.$bannerPicture; ?>"/>
<meta property="og:title" content="Fund Projects Villages Choose: <?php print $projectName; ?> in <?php print $villageName; ?> Village"/>
<meta property="og:url" content="<?php print BASE_URL.$projectId; ?>"/>
<meta property="og:description" content="Disrupt extreme poverty by funding projects villages choose. <?php print $summary; ?>"/>
<?php 
$metaProvided = 1;
include('header.inc'); 
?>
<script>
$(document).ready(function(){
    $('.scrollspy').scrollSpy();
  });
</script>

<div id="index-banner" class="parallax-container"
	style="background-color: rgba(0, 0, 0, 0.3); height: 500px">

	<div class="parallax">
		<img style="object-fit: cover; height:100%" src="<?php print PICTURES_DIR.$bannerPicture; ?>">
	</div>
</div>

<div class="container">
	
		<div><h4 class="header left brown-text text-lighten-2 text-shadow: 2px 2px 7px #111111">
					<a href='https://api.mapbox.com/styles/v1/jdepree/cj37ll51d00032smurmbauiq4/static/<?php print "$villageLng,$villageLat"; ?>,17,0,60.00/800x600?access_token=<?php print MAPBOX_API_KEY; ?>' data-imagelightbox="map" style='font-weight:bold;color:#654321'><?php print $villageName; ?> Village</a> needs $<?php print $total; ?> to <?php print strtolower($projectName); ?>. This project will help <?php print $population; ?> people across <?php print $households; ?> households. <?php print $villageName; ?> has contributed $<?php print $villageContribution; ?>, materials, and labor.
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
				<img src="<?php print PICTURES_DIR.$pictureFilename; ?>" class="responsive-img" style='width:400px;'>
				<p class="valign-wrapper; center-align">
					<b>Here's a similar project.</b>
				<br>
		</div>
				
		<div class="col-project valign-wrapper center-align" style="vertical-align: middle;">
							
					<div class="progress-bar" style="margin: 0 auto;" data-percent="<?php print $percentFunded; ?>" data-duration="1000" data-color="#ccc, #4b86db"></div>
					
					<script>
						$(".progress-bar").loading();
					</script>
				
				<br>
				
		<div class="center-align"><b><font color="#4FC1E9">$<?php print $funded; ?> raised, $<?php print max(0, $total - $funded); ?> to go</font></b></div>
				
					<br>
				
				
<?php if ($funded < $total) { ?>					
<div>
	<form action="#">
     <p class="center-align">
      <input type="checkbox" class="filled-in" id="honoreeCheckbox" onclick="showHonoreeModal();" /><label for="honoreeCheckbox">honor someone special</label>
     </p>
     </form>
  </div>
    
      <!-- Modal Structure -->
   <div id="honoreeModal" class="modal" style="z-index:10;">
     <div class="modal-content" id="jqueryvalidation">
      	<div class="container" style="width:100%; padding:0 10% 0 10%">
          <p class="flow-text left-align black-text">Please enter the <b>honoree's details</b>. They'll be notified of your gift by email and included on project update emails.</p>
          
         <div class="container center-align" id="jqueryvalidation" style="width:100%; padding:0;margin:0;">
         		<form id="honoree_details" method="post" action="one_time_payment_view.php">
             		<input type='hidden' name='id' value='<?php print $projectId; ?>' />
             		<div class="row" style="padding:0;margin:0;">
             		
                             <div class="input-field col s6" style="padding:0;margin:0;">  
                               <input id="honoreeFirstName" name="honoreeFirstName" style="border-style:none;font-size:20px;" placeholder="first name" type="text" required data-error=".errorTxt1" />
                        	     <div class="errorTxt1" style="font-size:10px; color:red;"></div>
                             </div>
                             <div class="input-field col s6" style="padding:0;margin:0;">
                               <input id="honoreeLastName" name="honoreeLastName" style="border-style:none;font-size:20px;" placeholder="last name" type="text" />
                             </div>
                 </div>         	
             
             		<div class="row" style="padding:0;margin:0;">							
         				<div class="input-field col s12" style="padding:0;margin:0;" >
         					<input id="honoreeEmail" name="honoreeEmail" style="border-style:none; font-size:20px;" placeholder="email address" type="email">
         				</div>
          		</div>
          		
         		<div class="row" style="padding:0;margin:0;"">
         				<div class="input-field col s12" style="border-radius: 5px;padding:0;margin-bottom:5px;">
                   				<textarea style="border-style:none;font-size:20px; height:80px; width:100%" id="honoreeMessage" placeholder="message for honoree" name="honoreeMessage"></textarea>
                	 		</div>
         		</div>
 				
                 <div class="row center-align" style="margin:0;">
             		<div class="input-field col s12" style="padding:0;margin:0;">
             			<button id="submitBtn" class="btn-large blue submit" type="submit" name="action" style="width:100%;">Donate</button>
         			</div>
         		</div>
    			</form>
    			
 		</div>
    			</div>
    			
    			
    			
    			
 		
     		<script>
         		$(document).ready(function(){ 
         			$('#honoreeModal').modal(); 
         		}); 
				function showHonoreeModal() {
					if (document.getElementById('honoreeCheckbox').checked) { 
						setTimeout(function() { 
							document.getElementById('honoreeCheckbox').checked = false; 
							$('#honoreeModal').modal('open'); 
						}, 500); 
					}
				}
     		
             	$(document).ready(function() {
             		// validate donatation form on keyup and submit
             		$("#honoree_details").validate({
             			rules: {
             				firstname: "required",
             			},
             		messages: {
             		      firstname: "this field is required",
             		},
             
                     errorElement : 'div',
                     errorPlacement: function(error, element) {
                       var placement = $(element).data('error');
                       if (placement) {
                         $(placement).append(error)
                       } else {
                         error.insertAfter(element);
                       }
                     },
            		});
 
             	});
 		</script>
 	</div>
     		
 </div>	
    
<br>
<?php } ?>					
		<div class="center-align">
		
				<?php if ($funded < $total) { ?>
				<a href='one_time_payment_view.php?id=<?php print $projectId; ?>'
				id="donate-button"
				class="waves-effect waves-light light blue lighten-1 btn-large">
				<i class="material-icons left">favorite_border</i>Donate</a>
				<?php } else { ?>
				<button 
				class="btn-large grey">
				Fully Funded!</button>
				<?php } ?>
		</div>

					<br>
				
		<?php if ($donorCount > 0) { ?>	
		<div style="margin:auto;" class="center-align">
								<b><?php print $donorCount.($donorCount > 1 ? " people have" : " person has"); ?> donated!</b> 
								
		</div><br>
		<div class='center-align' style="margin:auto;max-width:300px;height:<?php print (min(3, ceil($donorCount / 5)) * 60 + 40); ?>px;">
		<?php 
		     $stmt = prepare("SELECT donor_id, donor_first_name, donor_last_name, isSubscription FROM 
                        ((SELECT donation_donor_id AS f_donor_id, 0 AS isSubscription FROM donations WHERE donation_project_id=? AND donation_is_test=0) 
                        UNION (SELECT sd_donor_id AS f_donor_id, 1 AS isSubscription FROM subscription_disbursals WHERE sd_project_id=?)) AS derived 
                    JOIN donors ON f_donor_id=donor_id GROUP BY donor_id");
		     $stmt->bind_param('ii', $projectId, $projectId);
		     $result = execute($stmt);
		     while ($row = $result->fetch_assoc()) {
        	         $firstName = $row['donor_first_name'];
        	         $lastName = $row['donor_last_name'];
        	         $isSubscription = $row['isSubscription'];
        	         if ($firstName != $lastName && strlen($firstName) > 0 && strlen($lastName) > 0 
        	             && $firstName[0] >= 'A' && $firstName[0] <= 'Z' && $lastName[0] >= 'A' && $lastName[0] <= 'Z') {
        	           $initials = $firstName[0].$lastName[0];
        	           $fullName = $firstName.' '.$lastName[0];
        	         } else {
        	           $initials = 'A';
        	           $fullName = 'Anonymous';
        	         }
                ?>
 				<div style="display:inline-block;position:relative; background-color: rgba(220,220,220,0.8);border-radius:50%; border-color:rgba(100,149,237,1.0);border-width:thin; height:40px; width:40px;margin:2% 2% 2% 2%">
         				<a class="tooltip" style='text-decoration:none;'><span class="tooltiptext">Thanks <?php print $fullName; ?>!</span><span class="blue-text" style="height:40px; margin: auto; text-align: center;display: table-cell;vertical-align:middle;"><b><?php print $initials; ?></b></span></a>
         				<?php print ($isSubscription ? "<div style='position:absolute; top:-8px; right:-8px;'><i class='material-icons' style='font-size: 25px'>star</i></div>" : ""); ?>
 				</div>
 				<?php
			}
			
			$stmt->close();
			
		    } 
		       
		    print ($matchingDonor ?
		        "<a class='tooltip' style='text-decoration:none;text-transform:none;text-align:center;'>
                                <span class='tooltiptext'>$matchingDonor will match all donations made to this project!</span>
                                <span style='position:absolute;top:-35%;left:-10%;color:black;font-size:16px;'><b> &nbsp;100%<BR><BR>Match</b></span>
                                <img src='images/matching.png' style='border-radius:25px;padding:2px;border:2px solid black;' />
                            </a>" : "");
		      
		    if ($donorCount > 0 || $matchingDonor) {
		    ?>
				</div>
			<?php } ?>
		</div>
	</div>
	
		<div class="valign-wrapper center-align" style="vertical-align:middle; margin: 0px 20px 0px 20px; opacity:0.5">
						
					<span class="black-text" style="margin: 0 auto; vertical-align:middle; padding: 1% 20% 0px 20%;">
							100% tax deductible and securely processed by Stripe
					</span>
			</div>

<!--  <div class="section">
	<nav class="light blue" role="navigation">
    		<ul class="center-align row">
          <li class="waves-effect col s3">
              <a href='https://api.mapbox.com/styles/v1/jdepree/cj37ll51d00032smurmbauiq4/static/<?php print "$villageLng,$villageLat"; ?>,17,0,60.00/800x600?access_token=<?php print MAPBOX_API_KEY; ?>' data-imagelightbox="map"><i class="material-icons" style="font-size: 30px">place</i></a>           
          </li>
          <li class="waves-effect col s3" style="display: inline">
              <a href="#pics"><i class="material-icons" style="font-size: 30px">collections</i></a>
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
</div>  -->

	<?php if (strlen($summary) > 2) { ?>
	<div class="section" style="text-align:center">
		<h5 class="light blue-text text-lighten-2" style="padding:2% 0% 0% 0%;">Project Info</h5>
	</div>
	
	<div class="section">	
		<div class="row">
				<div class="col s12 <?php print ($hasEvents ? "m9 l9" : "m12 l12"); ?>">
				<div class="card grey lighten-5 z-depth-1">
					<div class="card-content brown-text text-lighten-2">

							<p class="flow-text"><?php print $summary; ?>
							</p>

							<?php if (strlen($problem) > 1) { ?> <br>
							<p>
								<b>Community Problem:</b> <?php print $problem; ?>
							</p> 
							<?php } ?>
							
							<?php if (strlen($solution) > 1) { ?> <br>
						
							<p>
								<b>Community Solution:</b> <?php print $solution; ?>
							</p>
							<?php } ?>
							
							<?php if (strlen($partners) > 1) { ?> <br>
					
							<p>
								<b>Partners:</b> <?php print $partners; ?>
							</p>
							<?php } ?>
							
							<?php if (strlen($impact) > 1) { ?> <br>
					
							<p>
								<b>Outcome:</b> <?php print $impact; ?>
							</p>
							<?php } ?>
						
					</div>
				</div>

			</div>
			<?php 
		
			$stmt = prepare("SELECT pe_date, pet_label FROM project_events JOIN project_event_types ON pe_type=pet_id WHERE pe_project_id=?");
			$stmt->bind_param('i', $projectId);
        		$result = execute($stmt);
        	    $count = 0;
        	    while ($row = $result->fetch_assoc()) {
        	        if ($count == 0) {
        	            ?>
        	            <div class="col s12 m3 l3">
		
					<div class="timeline-container" style="textalign:center">
					<?php
        	        } 
			     ?>
    	        			<div class="timeline-block timeline-block-right">
						<div class="marker"></div>
						<div class="timeline-content">
							<h6><?php print date("M Y", strtotime($row['pe_date'])); ?></h6>
							<span><?php print $row['pet_label']; ?></span>
						</div>
					</div>
		  <?php $count++; 
        	  }
        	  $stmt->close();
		  if ($count > 0) { ?>
				</div>
			</div>
		  <?php } ?>
		</div>
		
			<?php } ?>
			<?php 
			
			$result = doUnprotectedQuery("SELECT fo_first_name, fo_last_name, picture_filename, fo_email, fo_phone FROM field_officers JOIN pictures ON picture_id=fo_picture_id WHERE fo_id=$staffId");
			if ($row = $result->fetch_assoc()) {        
			?>
    			<div class="row">
    				<div class="col s12 m9 l9">
    					<div class="grey lighten-5 z-depth-1">
    						<div class="row valign-wrapper" style="padding: 2% 2% 2% 2%">
    							<div class="col s12 m4 l4 center-align">
    							<img src="<?php print PICTURES_DIR.$row['picture_filename']; ?>"
    								alt="" class="responsive-img circle"
    								style="width: 100px; height: 100px;">
    							<!-- notice the "circle" class -->
    							</div>
    							<div class="col s12 m8 l8 black-text">
    								<b>Field Officer <?php print "{$row['fo_first_name']} {$row['fo_last_name']}"; ?></b>
    								<p/>
    								<b>Email:</b> <?php print $row['fo_email']; ?><b><br>Phone Number:</b>
    									<?php print $row['fo_phone']; ?>
    							</div>
    						</div>
    					</div>
    				</div>
            <?php } ?>
     			
				<div class="col s12 m3 l3 center-align">
					<h6 class="brown-text">
						<b>Share <?php print $villageName; ?>'s Story</b>
					</h6>
					<br>
					<?php printShareButtons($projectId, $projectName, $projectName, 60); ?>
				</div>
			</div>

		<?php 
		$stmt = prepare("SELECT pc_label, pc_amount, ct_icon FROM project_costs JOIN cost_types ON pc_type=ct_id WHERE pc_project_id=?");
		$stmt->bind_param('i', $projectId);
		$result = execute($stmt);
	    $count = 0;
	    while ($row = $result->fetch_assoc()) {
	    		if ($count == 0) { ?>
			<div id="costbreakdown" class="section scrollspy">
				<h5 class="light blue-text text-lighten-2" style="text-align: center">Cost Breakdown</h5>
			<br>
			<div class="row">
			<?php } 
			$icon = $row['ct_icon'];
			$label = $row['pc_label'];
			$amount = $row['pc_amount']; 
			?>
				<div class="col s12 m2 l2">
					<div class="icon-block center brown-text">
						<i class="material-icons" style="font-size: 30px"><?php print $icon; ?></i>
						<h5><?php print $label; ?></h5>
						<h5 class="light center">
							$<?php print $amount; ?>
						</h5>
							<br>
					</div>
				</div>
		<?php $count++; 
	    }
	    $stmt->close();
		if ($count > 0) { ?>
		
			<br>
			</div>	
			</div>
		<?php } ?>
		
    <?php
        $stmt = prepare("SELECT picture_filename, pu_description FROM project_updates JOIN pictures ON pu_project_id=? AND pu_image_id=picture_id ORDER BY pu_timestamp ASC");
        $stmt->bind_param('i', $projectId);
        $result = execute($stmt);
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            if ($count == 0) {
                print "<hr width='85%'><div id='pics' class='section scrollspy'>
				           <h5 style='text-align: center; color:#4FC3F7; font-weight:300;'>Field Updates</h5>
                                <div class='carousel'>";
            }
            print "<a class='carousel-item' href='' onclick=\"$('#pictureCaption').text('".addslashes($row['pu_description'])."'); return false;\"><img src='".PICTURES_DIR."{$row['picture_filename']}' /></a>";
            $count++;
        }
        $stmt->close();
        if ($count > 0) {
            ?>
                  <script>
                  $(document).ready(function(){
                      $('.carousel').carousel();
                    });
                  </script>
                  </div>
                  
                <h6 style="text-align: center" id='pictureCaption'>(swipe to view on mobile)</h6>
                <hr width="85%">
            <?php 
        }
    ?>
   
		<?php
		  $years = array();
		  $values = array();
		  $result = doStatQuery($villageId, "Comp Score");
		  while ($row = $result->fetch_assoc()) {
		      $years[] = $row['stat_year'];
		      $values[] = $row['stat_value'];
		  }
		  if (count($years) > 1) {
		?>
		<div id="databreakdown" class="section scrollspy">
			<h5 class="light blue-text text-lighten-2" style="text-align: center">Data Trends in <?php print $villageName; ?> Village</h5>
				<!--  <p style="font-size: 20px; text-align: center;" class="brown-text text-lighten-2 line-height: 120%">
					<b>We track the quantitative impact of your donation. In
					particular, we collect data on several development indicators,
					calculate an annual village development score, and observe how
					that score changes over time. You can learn more about our
					methodology <a href="impacts.php">here</a>.
					</b>
				</p>  -->
					
		<div class="row">
			
			<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">

				<h6 style="text-align: center"><b>Development Scores: <span class="blue-text"><?php print $villageName; ?> Village</span> v. <span style="color:rgba(220,220,220,1)">Control Villages</span></b></h6>
			<div>
				<canvas id="chart2" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart2").getContext('2d');

				var chart2 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ <?php print join(',', $years); ?> ],
						datasets : [ {
							label: "<?php print $villageName; ?>",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 10,
							data : [ <?php print join(',', $values); ?> ],
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
								beginAtZero : true,
							}
						} ]
					},
					}

				});
			</script>
		</div>
			
			<?php 
			$stmt = prepare("SELECT project_id, project_name, project_budget, YEAR(pe_date) AS yearPosted FROM projects JOIN project_events ON project_village_id=? AND pe_project_id=project_id AND pe_type=4 ORDER BY yearPosted ASC");
			$stmt->bind_param('i', $villageId);
			$result = execute($stmt);
			$count = 0;
			$labels = '';
			$amounts = '';
			$ids = '';
			$accum = 0;
			$firstYear = 0;
			while ($row = $result->fetch_assoc()) {
			     if ($count > 0) {
			         $labels .= ", ";
			         $amounts .= ", ";
			         $ids .= ", ";
			     } else {
			         $firstYear = $row['yearPosted'];
			     }
			     $ids .= $row['project_id'];
			     $labels .= $row['yearPosted'];
			     $accum += $row['project_budget'];
			     $amounts .= $accum;
			     $count++;
			}
			$stmt->close();
			
			if ($count > 0) {
			    if ($count == 1) {
			     $ids = "0, ".$ids;
			     $labels = ($firstYear - 1).", ".$labels;
			     $amounts = "0, ".$amounts;
			    }
			?>
			
				<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">
						<h6 style="text-align: center"><b>Dollars Invested (cumulative)</b></h6>
					 <div>
						<canvas id="chart1" width="250" height="250"></canvas>
					</div>
					
					<script>
				var ctx = document.getElementById("chart1").getContext('2d');

				var chart1 = new Chart(ctx, {
					type : 'line',
					data : {
						ids: [<?php print $ids; ?>],
						labels : [ <?php print $labels; ?> ],
						datasets : [ {
							fill : false,
							backgroundColor : "#ffce56",
							pointBackgroundColor: "#6495ED",
                            	pointRadius: 10,
                            	borderColor: "#6495ED",
							data : [ <?php print $amounts; ?> ],
							cubicInterpolationMode: 'monotone',
							
						} ]
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
									stacked:true,
								}
							} ]
						},
						onClick: function(event, active) {
							if (active && active.length > 0) {
								id = active[0]._chart.data.ids[active[0]._index];
								if (id != <?php print $projectId; ?> && id > 0) {
									window.location.href = "project.php?id=" + id;
								}
							}
						}
					}
				});
				
			</script>	
					
					
					<br>
				</div>
		<?php } ?>
	</div>
	
	<div class="row">
		<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">
				
		<h6 style="text-align: center"><b>Cases of Waterborne Illness</b></h6>
			<div>
				<canvas id="chart3" width="250" height="250"></canvas>
			</div>

		<?php
		  $years = array();
		  $values = array();
		  $result = doStatQuery($villageId, "Waterborne Illness");
		  while ($row = $result->fetch_assoc()) {
		      $years[] = $row['stat_year'];
		      $values[] = $row['stat_value'];
		  }
		?>
			<script>
				var ctx = document.getElementById("chart3").getContext('2d');

				var chart3 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ <?php print join(',', $years); ?> ],
						datasets : [ {
							fill : false,
							backgroundColor : "#6495ED",
							pointBackgroundColor: "#6495ED",
                        		pointRadius: 10,
                        		borderColor: "#6495ED",
							data : [ <?php print join(',', $values); ?> ],
						} ]
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
	
		<div class="col s12 m6 l6" style="padding: 20px 30px 20px 30px">
						<h6 style="text-align: center"><b>Remaining Dimensions</b></h6>
					<div>
						<canvas id="chart4" width="250" height="250"></canvas>
					</div>

		<?php
		  $business = getStatYearAssociative($villageId, "Biz Score");
		  $lifestyle = getStatYearAssociative($villageId, "Lifestyle Score");
		  $education = getStatYearAssociative($villageId, "Edu Score");
		  $agriculture = getStatYearAssociative($villageId, "Ag Score");
		  $livestock = getStatYearAssociative($villageId, "Livestock Score");
		?>

					<script>
						var ctx = document.getElementById("chart4").getContext(
								'2d');
						var chart4 = new Chart(ctx,
								{
									type : 'radar',
									data : {
										labels : [ 'Business', 'Lifestyle',
												'Education', 'Agriculture',
												'Livestock'],
										datasets : [<?php 
										  $count = 0;
										  $keys = array_keys($business);
										  $colors = array('rgba(255,99,132,0.6)', 'rgba(54,162,235,0.6)', 'rgba(255,206,86,0.6)', 'rgba(187,174,204,0.6)', 'rgba(221,119,51,0.6)');
										  foreach ($keys as $year) {
										      if ($count > 0) {
										          print ", \n";
										      }
										      print "{
        											fill : true,
        											backgroundColor : '{$colors[$count]}',
                                                 pointRadius: 2,
        											label : '$year',
        											data : [ ".round($business[$year]).", ".round($lifestyle[$year]).", ".round($education[$year] * .2).", ".round($agriculture[$year] * .05).", ".round($livestock[$year])."],
										      }";
										      $count++;
										  }
										?>],
									},
									options : {
										responsive : true,
										maintainAspectRatio : false,
									}
								});
					</script>
			</div> 
		</div>
	</div>
	<?php } ?>
</div></div></div>
<?php include('footer.inc'); 
    $contents = ob_get_contents();
    ob_end_clean();
    if (CACHING_ENABLED) {
        file_put_contents(CACHED_PROJECT_PREFIX.$projectId,$contents);
    } else {
        print $contents;
    }
} 
if (CACHING_ENABLED) {
    include(CACHED_PROJECT_PREFIX.$projectId); 
} ?>
