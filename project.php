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

$result = doQuery("SELECT project_id, village_id, project_name, similar_pictures.picture_filename AS similar_picture, banner_pictures.picture_filename AS banner_picture, project_summary, project_community_problem, project_community_solution, project_community_partners, village_name, project_funded, project_budget, project_type, project_staff_id, COUNT(pe_id) AS eventCount FROM projects JOIN villages ON village_id=project_village_id JOIN pictures AS similar_pictures ON project_image_id=similar_pictures.picture_id JOIN pictures AS banner_pictures ON project_banner_id=banner_pictures.picture_id LEFT JOIN project_events ON pe_project_id=project_id WHERE project_id=$projectId GROUP BY project_id");
while ($row = $result->fetch_assoc()) {
    $projectName = $row['project_name'];
    $pictureFilename = $row['similar_picture'];
    $bannerPicture = $row['banner_picture'];
    $summary = $row['project_summary'];
    $problem = $row['project_community_problem'];
    $solution = $row['project_community_solution'];
    $partners = $row['project_community_partners'];
    $villageId = $row['village_id'];
    $villageName = $row['village_name'];
    $funded = $row['project_funded'];
    $total = $row['project_budget'];
    $projectType = $row['project_type'];
    $staffId = $row['project_staff_id'];
    $hasEvents = $row['eventCount'] > 0;
    
    $villageContribution = $total * .05;
    
    $households = getLatestValueForStat($villageId, "# of HH");
    $population = getLatestValueForStat($villageId, "# of People");
}

?>
<meta property="og:image" content="<?php print PICTURES_DIR.$bannerPicture; ?>"/>
<meta property="og:title" content="<?php print $projectName; ?>"/>
<meta property="og:url" content="https://4and.me/project.php?id=<?php print $projectId; ?>"/>
<meta property="og:description" content="<?php print $summary; ?>"/>
<?php 
include('header.inc'); 
?>
<script>
$(document).ready(function(){
    $('.scrollspy').scrollSpy();
  });
</script>

<div id="index-banner" class="parallax-container"
	style="background-color: rgba(0, 0, 0, 0.3); height: 800px">

	<div class="parallax">
		<img src="<?php print PICTURES_DIR.$bannerPicture; ?>">
	</div>
</div>

<div class="container">
	
		<div><h4 class="header left brown-text text-lighten-2 text-shadow: 2px 2px 7px #111111">
					<a href='https://api.mapbox.com/styles/v1/jdepree/cj37ll51d00032smurmbauiq4/static/35.340250,-15.477861,14.60,-17.60,30.00/800x600?access_token=pk.eyJ1IjoiamRlcHJlZSIsImEiOiJNWVlaSFBBIn0.IxSUmobvVT64zDgEY9GllQ' data-imagelightbox="map" style='font-weight:bold;color:#654321'><?php print $villageName; ?> Village</a> needs $<?php print $total; ?> to <?php print strtolower($projectName); ?>. This project will help <?php print $population; ?> people across <?php print $households; ?> households. <?php print $villageName; ?> has contributed $<?php print $villageContribution; ?>, materials, and labor.
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
				<img src="<?php print PICTURES_DIR."/$pictureFilename"; ?>" class="responsive-img">
				<p class="valign-wrapper; center-align">
					<b>Here's a similar project.</b>
				<br>
		</div>
				
		<div class="col-project valign-wrapper center-align" style="vertical-align: middle;">
							
					<div class="progress-bar" style="margin: 0 auto;" data-percent="60" data-duration="1000" data-color="#ccc, #4b86db"></div>
					
					<script>
						$(".progress-bar").loading();
					</script>
				
				<br>
				
		<div class="center-align"><b><font color="#4FC1E9">$<?php print $funded; ?> raised, $<?php print ($total - $funded); ?> to go</font></b></div>
				
					<br>
					
		<div class="center-align">
				<a href='one_time_payment_view.php'
				id="donate-button"
				class="waves-effect waves-light light blue lighten-1 btn-large">
				<i class="material-icons left">favorite_border</i>Donate</a>
		</div>

					<br>
					
		<div style="margin:auto;" class="center-align">
								<b>10 people have donated!</b>
		</div>
		
			<br>
	
			<div class="valign-wrapper center-align" style="vertical-align:middle; margin: 0px 20px 0px 20px; opacity:0.5">
						
					<span class="black-text" style="margin: 0 auto; vertical-align:middle; padding: 5% 20% 0px 20%;">
							<i>100% tax deductible and securely processed by Stripe</i>
					</span>
			</div>

		</div>
	</div>
	
	<br>

<div class="section">
	<nav class="light blue" role="navigation">
    		<ul class="center-align row">
          <li class="waves-effect col s3">
              <a href='https://api.mapbox.com/styles/v1/jdepree/cj37ll51d00032smurmbauiq4/static/35.340250,-15.477861,14.60,-17.60,30.00/800x600?access_token=pk.eyJ1IjoiamRlcHJlZSIsImEiOiJNWVlaSFBBIn0.IxSUmobvVT64zDgEY9GllQ' data-imagelightbox="map"><i class="material-icons" style="font-size: 30px">place</i></a>           
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
</div>

<br>

	<div class="section" style="text-align:center">
		<h5>Project Info</h5>
	</div>
	
	<div class="section">	
		<div class="row">
				<div class="col s12 <?php print ($hasEvents ? "m9 l9" : "m12 l12"); ?>">
				<div class="card grey lighten-5 z-depth-1">
					<div class="card-content brown-text text-lighten-2 line-height: 120%">

							<p class="flow-text"><?php print $summary; ?>
							</p> <br>

							<p>
								<b>Community Problem:</b><?php print $problem; ?>
							</p> 
							
							<br>

							<p>
								<b>Community Solution:</b> <?php print $solution; ?>
							</p> <br>

							<p>
								<b>Partners:</b> <?php print $partners; ?>
							</p>
						
					</div>
				</div>

			</div>
			<?php 
		
        		$result = doQuery("SELECT pe_date, pe_description FROM project_events WHERE pe_project_id=$projectId");
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
							<span><?php print $row['pe_description']; ?></span>
						</div>
					</div>
		  <?php $count++; 
        	  }
		  if ($count > 0) { ?>
				</div>
			</div>
		  <?php } ?>
			
			<?php $result = doQuery("SELECT fo_first_name, fo_last_name, picture_filename, fo_email, fo_phone FROM field_officers JOIN pictures ON picture_id=fo_picture_id WHERE fo_id=$staffId");
			if ($row = $result->fetch_assoc()) {        
			?>
    			<div class="row">
    				<div class="col s12 m9 l9">
    					<div class="card-panel grey lighten-5 z-depth-1">
    						<div class="row valign-wrapper">
    							<div class="col s12 m4 l4">
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
						<b>Share Likoswe's Story</b>
					</h6>
					<br>
					
						<a
							href="https://www.facebook.com/dialog/feed?
  									app_id=<?php print FACEBOOK_APP_ID; ?>
  									&display=popup&caption=<?php print $projectName; ?>
  									&link=https://4and.me/project.php?id=<?php print $projectId; ?>"
							target="_blank"> <img
							src="https://simplesharebuttons.com/images/somacro/facebook.png"
							alt="Facebook" align="middle" height="60" width="60" />
						</a>
						&nbsp;&nbsp;&nbsp;
						<a
							href="https://twitter.com/share?url=https://4and.me/project.php?id=<?php print $projectId; ?>;text=<?php print $projectName; ?>&amp;hashtags=villagex"
							target="_blank"> <img
							src="https://simplesharebuttons.com/images/somacro/twitter.png"
							alt="Twitter" align="middle" height="60" width="60" />
						</a>
				</div>
			</div>
		</div>	
	

		<?php $result = doQuery("SELECT pc_label, pc_amount, ct_icon FROM project_costs JOIN cost_types ON pc_type=ct_id WHERE pc_project_id=$projectId");
	    $count = 0;
	    while ($row = $result->fetch_assoc()) {
	    		if ($count == 0) { ?>
			<div id="costbreakdown" class="section scrollspy">
				<h5 style="text-align: center">Cost Breakdown</h5>
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
		if ($count > 0) { ?>
		
			<br>
			</div>	
			</div>
		<?php } ?>
		
    <?php 
        $result = doQuery("SELECT picture_filename, pu_description FROM project_updates JOIN pictures ON pu_project_id=$projectId AND pu_image_id=picture_id");
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            if ($count == 0) {
                print "<hr width='85%'><div id='pics' class='section scrollspy'>
				           <h5 style='text-align: center;'>Field Updates</h5>
                                <div class='carousel'>";
            }
            print "<a class='carousel-item' href='' onclick=\"$('#pictureCaption').text('{$row['pu_description']}'); return false;\"><img src='".PICTURES_DIR."{$row['picture_filename']}' /></a>";
            $count++;
        }
        if ($count > 0) {
            ?>
                  <script>
                  $(document).ready(function(){
                      $('.carousel').carousel();
                    });
                  </script>
            <?php 
        }
    ?>
    </div>
    
  
                      <h6 style="text-align: center" id='pictureCaption'>(swipe to view on mobile)</h6>
                 


		<hr width="85%">
	
		<div id="databreakdown" class="section scrollspy">
			<h5 style="text-align: center">Data Trends</h5>
				<p style="font-size: 20px; text-align: center;" class="brown-text text-lighten-2 line-height: 120%">
					<b>We track the quantitative impact of your donation. In
					particular, we collect data on several development indicators,
					calculate an annual village development score, and observe how
					that score changes over time. You can learn more about our
					methodolody <a href="#!">here</a>.
					</b>
				</p>
					
			<div class="row">
			
			<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">

				<h6 style="text-align: center"><b>Development Score Over Time Compared to Control Villages</b></h6>
			<div>
				<canvas id="chart2" width="250" height="250"></canvas>
			</div>

			<script>
				var ctx = document.getElementById("chart2").getContext('2d');

				var chart2 = new Chart(ctx, {
					type : 'line',
					data : {
						labels : [ '2014', '2015', '2016' ],
						datasets : [ {
							label: "Mlenga Village",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "#6495ED",
                             pointBackgroundColor: "#6495ED",
                             pointRadius: 10,
							data : [ -5, 10, 15 ],
							cubicInterpolationMode: 'monotone',
						}, 

						{
							label: "Control Villages Average",
							fill : false,
							backgroundColor : "#ffce56",
							borderColor: "rgba(220,220,220,1)",
                             pointBackgroundColor: "rgba(220,220,220,1)",
                             pointRadius: 10,
							data : [ 13, 12.2, 12.7 ],
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
			
			<?php $result = doQuery("SELECT project_name, project_budget, YEAR(project_date_posted) AS yearPosted FROM projects WHERE project_village_id=$villageId AND project_id<>$projectId");
			$count = 0;
			$labels = '';
			$amounts = '';
			$accum = 0;
			while ($row = $result->fetch_assoc()) {
			     if ($count > 0) {
			         $labels .= ", ";
			         $amounts .= ", ";
			     }
			     $labels .= "'{$row['project_name']}, {$row['yearPosted']}'";
			     $accum += $row['project_budget'];
			     $amounts .= $accum;
			     $count++;
			}
			
			if ($count > 1) {
			?>
			
				<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">
						<h6 style="text-align: center"><b>Dollars Invested Over Time (cumulative)</b></h6>
					 <div>
						<canvas id="chart1" width="250" height="250"></canvas>
					</div>
					
					<script>
				var ctx = document.getElementById("chart1").getContext('2d');

				var chart1 = new Chart(ctx, {
					type : 'line',
					data : {
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
					}

				});
			</script>	
					
					
					<br>
				</div>
		<?php } ?>
	</div>
	
	<div class="row">
		<div class="col s12 m6 l6 center-align" style="padding: 20px 30px 20px 30px">
				
		<h6 style="text-align: center"><b>Waterborne Illness Over Time</b></h6>
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
						<h6 style="text-align: center"><b>Remaining Score Components Over Time</b></h6>
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
        											data : [ {$business[$year]}, {$lifestyle[$year]}, {$education[$year]} * .2, {$agriculture[$year]} * .05, {$livestock[$year]}],
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
</div>	
<?php include('footer.inc'); ?>
