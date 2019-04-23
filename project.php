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

$donorId = 0;
if (hasParam('d')) {
  $donorId = paramInt('d');
}

if (!CACHING_ENABLED || !file_exists(CACHED_PROJECT_PREFIX.$projectId.'d'.$donorId)) {
    ob_start();
$stmt = prepare("SELECT project_id, village_id, project_name, similar_pictures.picture_filename AS similar_picture, banner_pictures.picture_filename AS banner_picture, 
                project_summary, project_community_problem, project_community_solution, project_community_partners, project_community_contribution, project_impact, village_name, village_lat, village_lng, 
                project_funded, project_budget, project_type, project_staff_id, COUNT(DISTINCT peAll.pe_id) AS eventCount, COUNT(DISTINCT donation_donor_id) AS donorCount,
                MONTHNAME(peEnd.pe_date) AS monthCompleted, YEAR(peEnd.pe_date) AS yearCompleted, 
                CONCAT(donor_first_name, ' ', donor_last_name) AS matchingDonor, project_completion, project_youtube_id, exemplary_pictures.picture_filename AS exemplaryPicture, pu_description
                FROM projects JOIN villages ON village_id=project_village_id 
                LEFT JOIN pictures AS similar_pictures ON project_similar_image_id=similar_pictures.picture_id 
                LEFT JOIN pictures AS banner_pictures ON project_banner_image_id=banner_pictures.picture_id 
                LEFT JOIN project_events AS peAll ON peAll.pe_project_id=project_id 
                LEFT JOIN project_events AS peEnd ON peEnd.pe_project_id=project_id AND peEnd.pe_type=4
                LEFT JOIN donors ON project_matching_donor=donor_id 
                LEFT JOIN project_updates ON pu_project_id=project_id AND pu_exemplary=1 LEFT JOIN pictures AS exemplary_pictures ON pu_image_id=exemplary_pictures.picture_id
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
    $completion = $row['project_completion'];
    $videoId = $row['project_youtube_id'];
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
    $exemplaryPicture = $row['exemplaryPicture'];
    $exemplaryDescription = $row['pu_description'];
    $monthCompleted = $row['monthCompleted'];
    $yearCompleted = $row['yearCompleted'];
    $communityContribution = $row['project_community_contribution'];
    
    $villageContribution = round($total * ($communityContribution / 100));
    $percentFunded = max($communityContribution, round($funded * 100 / $total));
    
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
<title>Fund Projects Villages Choose: <?php print $projectName; ?> in <?php print $villageName; ?> Village</title>
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

<?php
  $stmt = prepare("SELECT project_id, YEAR(peStart.pe_date) AS yearPosted, YEAR(peEnd.pe_date) AS yearCompleted,
      exemplary_pictures.picture_filename AS exemplaryPicture, 
      similar_pictures.picture_filename AS similar_picture
      FROM projects JOIN project_events AS peStart ON project_village_id=? AND project_id<>? 
      AND peStart.pe_project_id=project_id AND peStart.pe_type=1
      LEFT JOIN project_events AS peEnd ON peEnd.pe_project_id=project_id AND peEnd.pe_type=4
      LEFT JOIN pictures AS similar_pictures ON project_similar_image_id=similar_pictures.picture_id 
      LEFT JOIN project_updates ON pu_project_id=project_id AND pu_exemplary=1
      LEFT JOIN pictures AS exemplary_pictures ON pu_image_id=exemplary_pictures.picture_id
      ORDER BY yearPosted DESC");
  $stmt->bind_param('ii', $villageId, $projectId);
  $result = execute($stmt);
  $count = 0;
  while ($row = $result->fetch_assoc()) {
    $otherYearProjectId = $row['project_id'];
    $otherYearPosted = max($row['yearCompleted'], $row['yearPosted']);
    $otherYearPictureFilename = $row['similar_picture'];
    $otherYearExemplaryPicture = $row['exemplaryPicture'];
?>

  <div onclick="document.location='<?php print $otherYearProjectId; ?>';" style="position:absolute; border: 2px solid #55C4F5; border-radius:75px; width:80px;height:80px;right:<?php print ($count * 100 + 10); ?>px;
        bottom:10px;cursor:pointer;box-shadow: 10px 10px 60px -10px #55C4F5;
        background:url('<?php print PICTURES_DIR.($otherYearExemplaryPicture ? $otherYearExemplaryPicture : $otherYearPictureFilename); ?>');background-size:80px 80px;">
    <span style='position:absolute;font-weight:bolder;font-size:24px;top:40px;left:10px;color:#DDDDDD'><?php print $otherYearPosted; ?></span>  
  </div>
   
 
<?php 
  $count++;
} 
$stmt->close(); 

$mapFilename = "uploads/map$projectId.jpg";
if (!file_exists($mapFilename)) {
   $url = "https://api.mapbox.com/styles/v1/jdepree/cj37ll51d00032smurmbauiq4/static/$villageLng,$villageLat,15,0,60.00/800x600?access_token=".MAPBOX_API_KEY; 
  file_put_contents($mapFilename, file_get_contents($url));
}
?>  
</div>

<script type="text/javascript" src="js/imagelightbox2.js"></script>
<div class="container">
	
		<div><h4 class="header left brown-text text-lighten-2" style="padding: 0 0 2% 0;">
					   <b><?php print $villageName; ?> Village </b>
            <?php print ($monthCompleted ? "used" : "needs"); ?> $<?php print $total; ?> <?php print ($monthCompleted ? "in <b>$monthCompleted, $yearCompleted</b>" : ""); ?> 
            to <?php print strtolower($projectName); ?>. This project <?php print ($monthCompleted ? "helped" : "will help"); ?> <?php print $population; ?> people across <?php print $households; ?> households. 
            <?php print $villageName; ?> <?php print ($monthCompleted ? "" : "has "); ?>contributed $<?php print $villageContribution; ?>, materials, and labor.
		</h4>

<script>
      var attrs = {};
      var classes = $("a[data-imagelightbox]").map(function(index, element) {
        var key = $(element).attr("data-imagelightbox");
        attrs[key] = true;
        return attrs;
      });
      var attrsName = Object.keys(attrs);

      attrsName.forEach(function(entry) {
          $( "[data-imagelightbox='" + entry + "']" ).imageLightbox({
              overlay: true
          });
      });
  </script>
		</div>
	
  	
  	<div style="display:table; width:100%">
  	     <div class="col-project valign-wrapper center-align" style="vertical-align: middle;">
      <?php if ($donorId) { ?>
        <span class='flow-text'>A cooperation between<BR><b class='donor-text'><?php print $donorName; ?></b> and <b class='donor-text'>Village X</b></span>
      <?php } ?>
				<img src="<?php print PICTURES_DIR.($exemplaryPicture ? $exemplaryPicture : $pictureFilename); ?>" class="responsive-img" style='width:400px; border: black 2px solid; box-shadow: 10px 10px 5px #888888; border-radius:10px;'>
				<p class="center-align">
					<b><?php print ($exemplaryPicture ? "Project complete!" : "Here's a similar project."); ?></b>
				<br>
		</div>
				
		<div class="col-project valign-wrapper center-align" style="vertical-align: middle;">
							
					<div class="progress-bar" style="margin: 0 auto;" data-percent="<?php print $percentFunded; ?>" data-duration="1000" data-color="#ccc, #4b86db"></div>
					
					<script>
						$(".progress-bar").loading();
					</script>
				
				<br>
				
		<div class="center-align donor-text"><b><font>$<?php print $funded; ?> raised, $<?php print max(0, $total - $funded); ?> to go</font></b></div>
				
					<br>
				
				
<?php if ($funded < $total) { ?>					
<div>
     <p class="center-align">
        <label>
          <input type="checkbox" class="filled-in" id="honoreeCheckbox" onclick="showHonoreeModal();" />
          <span for="honoreeCheckbox">honor someone special</span>
        </label>
     </p>
  </div>
    
      <!-- Modal Structure -->
   <div id="honoreeModal" class="modal" style="z-index:10;">
     <div class="modal-content" id="jqueryvalidation">
      	<div class="container" style="width:100%; padding:0 10% 0 10%">
          <p class="flow-text left-align black-text">Please enter the <b>honoree's details</b>. They'll be notified of your gift by email and included on project update emails.</p>
          
         <div class="container center-align" id="jqueryvalidation" style="width:100%; padding:0;margin:0;">
         		<form id="honoree_details" method="post" action="one_time_payment_view.php">
             		<input type='hidden' name='id' value='<?php print $projectId; ?>' />
                <input type='hidden' name='d' value='<?php print $donorId; ?>' />
             		<div class="row" style="padding:0;margin:0;">
             		
                             <div class="input-field col s6" style="padding:0;margin:0;">  
                               <input id="honoreeFirstName" name="honoreeFirstName" style="border-style:none;font-size:20px;" placeholder="first name" type="text" required data-error=".errorTxt1"/>
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
             			<button id="submitBtn" class="btn-large donor-background" type="submit" name="action" style="width:100%;">Donate<?php print ($matchingDonor ? " (2x)" : ""); ?></button>
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
				<a href='one_time_payment_view.php?id=<?php print $projectId; ?>&d=<?php print $donorId; ?>'
				id="donate-button"
				class="waves-effect waves-light donor-background lighten-1 btn-large">
				<i class="material-icons left">favorite_border</i>Donate<?php print ($matchingDonor ? " (2x)" : ""); ?></a>
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
                        ((SELECT donation_donor_id AS f_donor_id, 0 AS isSubscription FROM donations WHERE donation_project_id=? AND donation_is_test=0 ORDER BY donation_amount DESC) 
                        UNION (SELECT sd_donor_id AS f_donor_id, 1 AS isSubscription FROM subscription_disbursals WHERE sd_project_id=? ORDER BY sd_amount DESC)) AS derived 
                    JOIN donors ON f_donor_id=donor_id GROUP BY donor_id ORDER BY (LENGTH(donor_first_name) > 0 AND donor_last_name <> donor_first_name) DESC");
		     $stmt->bind_param('ii', $projectId, $projectId);
		     $result = execute($stmt);
         $col = $bubbleRow = 1;
		     while ($row = $result->fetch_assoc()) {
        	         $firstName = $row['donor_first_name'];
        	         $lastName = $row['donor_last_name'];
        	         $isSubscription = $row['isSubscription'];
        	         if ($firstName != $lastName && strlen($firstName) > 0 && strlen($lastName) > 0 
        	             && $firstName[0] >= 'A' && $firstName[0] <= 'Z' && $lastName[0] >= 'A' && $lastName[0] <= 'Z') {
        	           $initials = $firstName[0].$lastName[0];
        	           $fullName = $firstName.' '.$lastName[0];
        	         } else {
                    if ($bubbleRow > 3 && $col == 1) {
                      break;
                    }
        	           $initials = 'A';
        	           $fullName = 'Anonymous';
        	         }
                ?>
 				<div style="display:inline-block;position:relative; background-color: rgba(220,220,220,0.8);border-radius:50%; border-color:rgba(100,149,237,1.0);border-width:thin; height:40px; width:40px; margin-top:-12px;">
         				<a class="tooltip" style='text-decoration:none;'><span class="tooltiptext">Thanks <?php print $fullName; ?>!</span><span class="donor-text" style="height:40px; margin: auto; text-align: center;display: table-cell;vertical-align:middle;"><b><?php print $initials; ?></b></span></a>
         				<?php print ($isSubscription ? "<div style='position:absolute; top:-8px; right:-8px;'><i class='material-icons' style='font-size: 25px'>star</i></div>" : ""); ?>
 				</div>
 				<?php
            if (($col == 6 && $bubbleRow % 2 == 1) || ($col == 5 && $bubbleRow % 2 == 0)) {
              $col = 0;
              $bubbleRow++;
              print "<br/>";
            }
            $col++;
			}
			
			$stmt->close();
      if ($bubbleRow > 1 && $col > 1) {
          print "<div style='width:".((($bubbleRow % 2 == 0 ? 6 : 7) - $col) * 44)."px;display:inline-block;position:relative;'></div>";
      }
			
		    } 
		       
		    print ($matchingDonor ?
		        "<a class='tooltip' style='margin:4% 2% 2% 4%;text-decoration:none;position:text-transform:none;text-align:center;'><span class='tooltiptext' style='left:-300%;top:-150%;'>$matchingDonor will match all donations made to this project!</span>
		        <span style='position:absolute;top:-45%;left:-10%;color:black;font-size:12px;line-height:1.7'><b> &nbsp;100%<BR><BR>Match</b></span>
		        <img src='images/matching.png' style='width:28px;border-radius:25px;border:2px solid black;' />
		        </a>" : "");

		      
		    if ($donorCount > 0 || $matchingDonor) {
		    ?>
				</div>
			<?php } ?>
		</div>
	</div>
	
		<div class="valign-wrapper center-align" style="vertical-align:middle; margin: 0px 20px 0px 20px; opacity:0.5">
						
					<span class="black-text" style="margin: 0 auto; vertical-align:middle; padding: 0% 20% 5% 20%;">
							100% tax deductible and securely processed by Stripe
					</span>
			</div>
    
    <div class="section">
      <div class="card-tabs">
        <ul class="tabs tabs-fixed-width z-depth-0.5">
          <li class="tab"><a class="active" href="#infotab"><span class="flow-text light">Info</span></a></li>
          <li class="tab"><a href="#updatestab"><span class="flow-text light">Updates</span></a></li>
          <li class="tab"><a href="#maptab"><span class="flow-text light">Map</span></a></li>
          <li class="tab"><a href="#datatab"><span class="flow-text light">Data</span></a></li>
        </ul>
      </div>
    </div>

    <div id="infotab" class="col s12">
      <?php include("project_info.php"); ?>
    </div>


    <div id="updatestab" class="col s12">
      <iframe style='width:100%;height:1000px;' src='project_updates.php?projectId=<?php print $projectId; ?>' ></iframe>
    </div>
    
     <div id="maptab" class="col s12">
     	  <?php include("project_map.php"); ?>
     </div>
    
    <div id="datatab" class="col s12">
		    <?php include("project_data.php"); ?>
	 </div>
	
    
    
    <script> 
      var instance = M.Tabs.init($('.tabs'));
    </script>
    </div>
  </div>
	
</div></div></div>
<?php 
    include('footer.inc');
    $contents = ob_get_contents();
    ob_end_clean();
    if (CACHING_ENABLED) {
        file_put_contents(CACHED_PROJECT_PREFIX.$projectId.'d'.$donorId,$contents);
    } else {
        print $contents;
    }
} 
if (CACHING_ENABLED) {
    include(CACHED_PROJECT_PREFIX.$projectId.'d'.$donorId); 
} ?>
