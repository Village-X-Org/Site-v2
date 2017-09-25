<?php
require_once("utilities.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header.inc'); ?>

<div class="container">

	<div class="row" style="padding:2% 1% 1% 1%;">
		<div class="col s12 m4 l4; valign-wrapper" style="vertical-align: middle; height:50px;">
			<h5 class="left brown-text text-lighten-2 text-shadow: 2px 2px 7px #111111">
				Choose a project
			</h5>
		</div>
		<script>var statusFilter = 0, typeFilter = 0;</script>
		<div class="col s12 m4 l4 valign-wrapper" style="vertical-align: middle; height:50px; padding:1% 1% 1% 1%;">		
	
    		    <!-- Dropdown Trigger -->
      		<a class="dropdown-button btn light blue" style="display: block; margin: 0 auto;" href='#' data-activates='dropdown1' id='statusFilter'>Filter by Status</a>

            <!-- Dropdown Structure -->
          	<ul id="dropdown1" class="dropdown-content">
          		<li><a href="" onclick="statusFilter=0; if (typeFilter) { $('.' + typeFilter).show(); } else { $('.projectCell').show(); }  $('#statusFilter').html('Filter by Status'); return false;">All</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();statusFilter='funding';className = '.funding' + (typeFilter ? '.' + typeFilter : ''); $(className).show(); $('#statusFilter').html('Seeking Funds &nbsp;&nbsp;&#10004;'); return false;">Seeking Funds</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();statusFilter='funded';className = '.funded' + (typeFilter ? '.' + typeFilter : ''); $(className).show(); $('#statusFilter').html('Funded &nbsp;&nbsp;&#10004;'); return false;">Funded</a></li>
          	</ul>
          </div>
	
		 <div class="col s12 m4 l4 center-align valign-wrapper" style="vertical-align: middle; height:50px; padding:1% 1% 1% 1%;">			
    		    <!-- Dropdown Trigger -->
      		<a class="dropdown-button btn light blue" style="display: block; margin: 0 auto;" href='#' data-activates='dropdown2' id='typeFilter'>Filter by Type</a>

            <!-- Dropdown Structure -->
          	<ul id="dropdown2" class="dropdown-content">
          		<li><a href="" onclick="typeFilter=0; if (statusFilter) { $('.' + statusFilter).show(); } else { $('.projectCell').show(); } $('#typeFilter').html('Filter by Type'); return false;">All</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();typeFilter='agriculture';className = '.agriculture' + (statusFilter ? '.' + statusFilter : ''); $(className).show(); $('#typeFilter').html('Agriculture &nbsp;&nbsp;&#10004;'); return false;">Agriculture</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();typeFilter='education';className = '.education' + (statusFilter ? '.' + statusFilter : ''); $(className).show(); $('#typeFilter').html('Education &nbsp;&nbsp;&#10004;'); return false;">Education</a></li>
           	 	<li><a href="" onclick="$('.projectCell').hide();typeFilter='livestock';className = '.livestock' + (statusFilter ? '.' + statusFilter : ''); $(className).show(); $('#typeFilter').html('Livestock &nbsp;&nbsp;&#10004;'); return false;">Livestock</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();typeFilter='water';className = '.water' + (statusFilter ? '.' + statusFilter : ''); $(className).show(); $('#typeFilter').html('Water &nbsp;&nbsp;&#10004;'); return false;">Water</a></li>
          	</ul>
		</div>
	</div>
	
	<div class="section"><div class='row'>		
			<?php 
	if (!file_exists(CACHED_LISTING_FILENAME)) {
		$result = doUnprotectedQuery("SELECT project_id, project_name, picture_filename, project_summary, village_name, project_funded, project_budget, project_type FROM projects JOIN villages ON project_village_id=village_id JOIN pictures ON project_profile_image_id=picture_id WHERE project_status<>'cancelled' ORDER BY project_status = 'funding' DESC, project_funded < project_budget DESC, project_funded DESC");

		$buffer = '';
		$count = 0;
		while ($row = $result->fetch_assoc()) {
		    $projectId = $row['project_id'];
		    $projectName = $row['project_name'];
		      $funded = round($row['project_funded']);
		      $projectTotal = $row['project_budget'];
		      $fundedPercent = round($funded / $projectTotal * 100);
		      $villageContribution = $projectTotal * .05;

		      $projectType = $row['project_type'];
		      $projectTypeClass = 'education';
		      if ($projectType == 'farm') {
		          $projectTypeClass = 'agriculture';
		      } elseif ($projectType == 'livestock') {
		          $projectTypeClass = 'livestock';
		      } elseif ($projectType == 'water') {
		          $projectTypeClass = 'water';
		      }
		      
		      $fundedClass = 'funding';
		      if ($fundedPercent >= 100) {
		          $fundedClass = 'funded';
		      }
		      
		      $buffer .= "<div class='col s12 m6 l4 projectCell $projectTypeClass $fundedClass' style='min-width:225px;cursor:pointer;' onclick=\"document.location='project.php?id=$projectId';\">
				<div class='card sticky-action hoverable'>
					<div class='card-image'>
						<img class='activator' src='".PICTURES_DIR."{$row['picture_filename']}'>
					</div>
					<div class='card-content'>
						<span class='card-title activator grey-text text-darken-4' style='font-size:18px;' onclick=\"document.location='project.php?id=$projectId';\">$projectName
							<i class='material-icons right'>more_vert</i>
						</span>
						<h6 class='brown-text'>
							<b>{$row['village_name']} Village</b>
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
               $buffer .= "<a href='one_time_payment_view.php?id=$projectId'
								id='donate_button'
								class='btn waves-effect waves-light light blue lighten-1'>Donate</a>";
            } else {
                $buffer .= "<button class='btn grey' >Fully Funded!</button>";
            }
			$buffer .= "      </div>
                        </div>
					</div>
				</div>
			 </div>";
		      $count++;
		}
		$handle = fopen(CACHED_LISTING_FILENAME, 'w');
		fwrite($handle, $buffer);
		fclose($handle);
	}
	include(CACHED_LISTING_FILENAME);
?>			</div><!-- row end -->
		</div> <!-- section end -->

		<!-- <div class="row center">
			<a href='ProjectTiles.php' id="download-button"
				class="btn-large waves-effect waves-light white lighten-1"><font color="#4FC1E9">more projects</font></a>
		</div> -->
		
		<br><br>

</div>

<?php include('footer.inc'); ?>
