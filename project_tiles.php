<?php
require_once("utilities.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header.inc'); ?>

<div class="container">

	<div class="row" style="padding:3% 1% 1% 1%;">

		<div class="col s12 m4 l4 center-align valign-wrapper" style="vertical-align: middle; height:50px; padding:1% 1% 1% 1%;">		
	
    		    <!-- Dropdown Trigger -->
      		<a class="dropdown-trigger btn donor-background" style="display: block; margin: 0 auto;" href='#' data-target='dropdown3' id='partnerFilter'>Filter by Partner</a>

            <!-- Dropdown Structure -->
          	<ul id="dropdown3" class="dropdown-content" style="margin-left:25px;margin-top:50px;">
          		<li><a href="#!" onclick="partnerFilter=0; $('.projectCell').hide(); className = '' + (statusFilter ? '.' + statusFilter : '') + (typeFilter ? '.' + typeFilter : ''); if (className == '') { $('.projectCell').show(); } else { $(className).show(); } $('#partnerFilter').html('Filter by Partner'); return false;">All</a></li>
          		<?php 
          			$projectPartners = array();
          			$result = doUnprotectedQuery("SELECT COUNT(donation_project_id) AS count, GROUP_CONCAT(donation_project_id) AS projects, donor_first_name, donor_last_name FROM donors JOIN donations ON donor_is_featured_partner=1 AND donor_id=donation_donor_id GROUP BY donor_id ORDER BY count DESC");
          			while ($row = $result->fetch_assoc()) {
          				$partnerName = trim($row['donor_first_name'].' '.$row['donor_last_name']);
          				$stripped = strtolower(str_replace(' ', '', $partnerName));
          				print "<li><a href='' onclick=\"$('.projectCell').hide();partnerFilter='$stripped';className = '.$stripped' + (statusFilter ? '.' + statusFilter : '') + (typeFilter ? '.' + typeFilter : ''); $(className).show(); $('#partnerFilter').html('$partnerName &nbsp;&nbsp;&#10004;'); return false;\">$partnerName</a></li>";
          				$projects = explode(',', $row['projects']);
          				foreach ($projects as $project) {
          					if (isset($projectPartners[$project])) {
          						$projectPartners[$project] .= ' '.$stripped;
          					} else {
          						$projectPartners[$project] = $stripped;
          					}
          				}
          			}
          		?>
          	</ul>
          </div>
		
		<div class="col s12 m4 l4 center-align valign-wrapper" style="vertical-align: middle; height:50px; padding:1% 1% 1% 1%;">		
	
    		    <!-- Dropdown Trigger -->
      		<a class="dropdown-trigger btn donor-background" style="display: block; margin: 0 auto;" href='#' data-target='dropdown1' id='statusFilter'>Filter by Status</a>

            <!-- Dropdown Structure -->
          	<ul id="dropdown1" class="dropdown-content" style="margin-left:25px;margin-top:50px;">
          		<li><a href="" onclick="statusFilter=0; if (typeFilter) { $('.' + typeFilter).show(); } else { $('.projectCell').show(); }  $('#statusFilter').html('Filter by Status'); return false;">All</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();statusFilter='funding';className = '.funding' + (typeFilter ? '.' + typeFilter : '') + (partnerFilter ? '.' + partnerFilter : ''); $(className).show(); $('#statusFilter').html('Seeking Funds &nbsp;&nbsp;&#10004;'); return false;">Seeking Funds</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();statusFilter='funded';className = '.funded' + (typeFilter ? '.' + typeFilter : '') + (partnerFilter ? '.' + partnerFilter : ''); $(className).show(); $('#statusFilter').html('Funded &nbsp;&nbsp;&#10004;'); return false;">Funded</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();statusFilter='completed';className = '.completed' + (typeFilter ? '.' + typeFilter : '') + (partnerFilter ? '.' + partnerFilter : ''); $(className).show(); $('#statusFilter').html('Completed &nbsp;&nbsp;&#10004;'); return false;">Completed</a></li>
          	</ul>
          </div>
	
		 <div class="col s12 m4 l4 center-align valign-wrapper" style="vertical-align: middle; height:50px; padding:1% 1% 1% 1%;">			
    		    <!-- Dropdown Trigger -->
      		<a class="dropdown-trigger btn donor-background" style="display: block; margin: 0 auto;" href='#' data-target='dropdown2' id='typeFilter'>Filter by Type</a>

            <!-- Dropdown Structure -->
          	<ul id="dropdown2" class="dropdown-content" style="margin-left:25px;margin-top:50px;">
          		<li><a href="" onclick="typeFilter=0; if (statusFilter) { $('.' + statusFilter).show(); } else { $('.projectCell').show(); } $('#typeFilter').html('Filter by Type'); return false;">All</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();typeFilter='agriculture';className = '.agriculture' + (statusFilter ? '.' + statusFilter : '') + (partnerFilter ? '.' + partnerFilter : ''); $(className).show(); $('#typeFilter').html('Agriculture &nbsp;&nbsp;&#10004;'); return false;">Agriculture</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();typeFilter='education';className = '.education' + (statusFilter ? '.' + statusFilter : '') + (partnerFilter ? '.' + partnerFilter : ''); $(className).show(); $('#typeFilter').html('Education &nbsp;&nbsp;&#10004;'); return false;">Education</a></li>
           	 	<li><a href="" onclick="$('.projectCell').hide();typeFilter='livestock';className = '.livestock' + (statusFilter ? '.' + statusFilter : '') + (partnerFilter ? '.' + partnerFilter : ''); $(className).show(); $('#typeFilter').html('Livestock &nbsp;&nbsp;&#10004;'); return false;">Livestock</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();typeFilter='water';className = '.water' + (statusFilter ? '.' + statusFilter : '') + (partnerFilter ? '.' + partnerFilter : ''); $(className).show(); $('#typeFilter').html('Water &nbsp;&nbsp;&#10004;'); return false;">Water</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();typeFilter='business';className = '.business' + (statusFilter ? '.' + statusFilter : '') + (partnerFilter ? '.' + partnerFilter : ''); $(className).show(); $('#typeFilter').html('Water &nbsp;&nbsp;&#10004;'); return false;">Business</a></li>
          	</ul>
		</div>
		<script>var statusFilter = 0, typeFilter = 0, partnerFilter = 0;</script>
	</div>
	
		<div class="icon-block" style="width:100%"><i class='material-icons left donor-text' style="font-size:20px;">fiber_new</i> = &nbsp;village's 1st project with Village X
		<br>
		<i class='material-icons left donor-text' style="font-size:20px;">timeline</i> = &nbsp;village previously completed projects with Village X
		</div>
	
	<div class="section"><div class='row'>		
			<?php 
	if (!CACHING_ENABLED || !file_exists(CACHED_LISTING_FILENAME.$donorId)) {
		$query = "SELECT p1.project_id AS project_id, p1.project_name AS project_name, picture_filename, p1.project_summary AS project_summary, 
                village_name, p1.project_funded AS project_funded, p1.project_budget AS project_budget, p1.project_community_contribution AS community_contribution, p1.project_type AS project_type, 
                YEAR(MIN(p2.project_date_posted)) AS previousYear, CONCAT(matchingDonor.donor_first_name, ' ', matchingDonor.donor_last_name) AS matchingDonor, pe_date 
                FROM projects AS p1 
                JOIN villages ON p1.project_village_id=village_id 
                LEFT JOIN projects AS p2 ON p1.project_village_id=p2.project_village_id AND p1.project_id<>p2.project_id AND p2.project_funded>=p2.project_budget 
                LEFT JOIN project_events ON pe_type=4 AND pe_project_id=p1.project_id
                JOIN pictures ON p1.project_profile_image_id=picture_id 
                LEFT JOIN donors AS matchingDonor ON p1.project_matching_donor=matchingDonor.donor_id
                WHERE p1.project_status<>'cancelled' ".($donorId ? " AND $donorId IN (SELECT donation_donor_id FROM donations WHERE donation_project_id=p1.project_id) " : "")
                ."GROUP BY p1.project_id 
                ORDER BY p1.project_status = 'funding' DESC, p1.project_funded < p1.project_budget DESC, IF(p1.project_funded < p1.project_budget, (p1.project_budget - p1.project_funded) / p1.project_budget, 1) ASC, p1.project_date_posted DESC";
        $result = doUnprotectedQuery($query);

		$buffer = '';
		$count = 0;
		while ($row = $result->fetch_assoc()) {
		    $projectId = $row['project_id'];
		    $projectName = $row['project_name'];
		      $funded = round($row['project_funded']);
		      $projectTotal = $row['project_budget'];
		      $previousYear = $row['previousYear'];
		      $matchingDonor = $row['matchingDonor'];
		      $communityContribution = $row['community_contribution'];
		      $fundedPercent = round($funded / $projectTotal * 100);
		      $villageContribution = round($projectTotal * ($communityContribution / 100));
		      $isCompleted = $row['pe_date'];

		      $projectType = $row['project_type'];
		      $projectTypeClass = 'education';
		      if ($projectType == 'farm') {
		          $projectTypeClass = 'agriculture';
		      } elseif ($projectType == 'livestock') {
		          $projectTypeClass = 'livestock';
		      } elseif ($projectType == 'water') {
		          $projectTypeClass = 'water';
		      } elseif ($projectType == 'business') {
		      	  $projectTypeClass = 'business';
		      }
		      
		      $fundedClass = 'funding';
		      if ($fundedPercent >= 100) {
		          $fundedClass = 'funded';
		      }
		      if ($isCompleted) {
		      	$fundedClass = 'completed';
		      }

		      $partnerClass = '';
		      if (isset($projectPartners[$projectId])) {
		      	$partnerClass = $projectPartners[$projectId];
		      }
		      
		      $buffer .= "<div class='col s12 m6 l4 projectCell $projectTypeClass $fundedClass $partnerClass' style='min-width:225px;cursor:pointer;' onclick=\"document.location='project.php?id=$projectId&d=$donorId';\">
				<div class='card sticky-action hoverable'>
					<div class='card-image'>
						<img class='activator' src='".PICTURES_DIR."{$row['picture_filename']}'>
					</div>
					<div class='card-content'>
						<span class='card-title activator grey-text text-darken-4' style='font-size:18px;' onclick=\"document.location='project.php?id=$projectId&d=$donorId';\">$projectName
							<i class='material-icons right donor-text'>".($previousYear != null ? 'timeline' : 'fiber_new')."</i>
						</span>
						<h6 class='brown-text'>
							<b>{$row['village_name']} Village, Malawi</b>
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
					<div class='card-action'>".($matchingDonor && $fundedPercent < 100 ? "
				    <a class='tooltip' style='text-decoration:none;position:absolute;right:-20px;bottom:10px;text-transform:none;text-align:center;'><span class='tooltiptext' style='left:-190%;top:-150%;'>Partner $matchingDonor will match all donations made to this project!</span>
                            <span style='margin:auto 0;position:absolute;top:14%;left:3%;color:black;font-size:15px;z-index:10;line-height:95%'><b>Gift<br>Match</b></span>
                            <!-- <img src='images/matching.png' style='border-radius:25px;padding:2px;border:2px solid black;' />  -->
                            <i class='material-icons center donor-text' style='opacity:0.6;font-size:50px; '>flash_on</i>
                        </a>" : "")."
           	 	     <div class='row center'>
							<div class='col s12'>";
		      
		    if ($fundedPercent < 100) {
               $buffer .= "<a href='one_time_payment_view.php?id=$projectId&d=$donorId'
								id='donate_button'
								class='btn waves-effect waves-light donor-background lighten-1'>Donate".($matchingDonor ? " (2x)" : "")."</a>";
            } else {
            	$buffer .= "<button class='btn grey' >".($isCompleted ? "Completed!" : "Fully Funded!")."</button>";
            }
			$buffer .= "      </div>
                        </div>
					</div>
				</div>
			 </div>";
		      $count++;
		}
		if (CACHING_ENABLED) {
		  $handle = fopen(CACHED_LISTING_FILENAME.$donorId, 'w');
		  fwrite($handle, $buffer);
		  fclose($handle);
		} else {
		    print $buffer;
		}
	}
	if (CACHING_ENABLED) {
	   include(CACHED_LISTING_FILENAME.$donorId);
	}
?>			</div><!-- row end -->
		</div> <!-- section end -->

		<!-- <div class="row center">
			<a href='ProjectTiles.php' id="download-button"
				class="btn-large waves-effect waves-light white lighten-1"><font color="#4FC1E9">more projects</font></a>
		</div> -->
		
		<br><br>

</div>

<?php 
include('footer.inc'); 
?>
