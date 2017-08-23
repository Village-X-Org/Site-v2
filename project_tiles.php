<?php require_once('utilities.php');
include('header.inc');
?>

<div class="container">
	
	<div class="row" style="padding:2% 1% 1% 1%;">
		<div class="col s12 m6 l6; valign-wrapper" style="vertical-align: middle; height:50px;">
			<h5 class="left brown-text text-lighten-2 text-shadow: 2px 2px 7px #111111">
				Choose a project to fund
			</h5>
		</div>

		<div class="col s12 m3 l3 valign-wrapper" style="vertical-align: middle; height:50px; padding:1% 1% 1% 1%;">		
	
    		    <!-- Dropdown Trigger -->
      		<a class="dropdown-button btn light blue" style="display: block; margin: 0 auto;" href='#' data-activates='dropdown1'>Filter by Status</a>

            <!-- Dropdown Structure -->
          	<ul id="dropdown1" class="dropdown-content">
          		<li><a href="" onclick="$('.projectCell').show(); return false;">All</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();$('.funding').show(); return false;">Seeking Funds</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();$('.funded').show(); return false;">Funded</a></li>
          	</ul>
          </div>
	
		 <div class="col s12 m3 l3 center-align valign-wrapper" style="vertical-align: middle; height:50px; padding:1% 1% 1% 1%;">			
    		    <!-- Dropdown Trigger -->
      		<a class="dropdown-button btn light blue" style="display: block; margin: 0 auto;" href='#' data-activates='dropdown2'>Filter by Type</a>

            <!-- Dropdown Structure -->
          	<ul id="dropdown2" class="dropdown-content">
          		<li><a href="" onclick="$('.projectCell').show(); return false;">All</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();$('.agriculture').show(); return false;">Agriculture</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();$('.education').show(); return false;">Education</a></li>
           	 	<li><a href="" onclick="$('.projectCell').hide();$('.livestock').show(); return false;">Livestock</a></li>
            		<li><a href="" onclick="$('.projectCell').hide();$('.water').show(); return false;">Water</a></li>
          	</ul>
		</div>
	</div>
	
	<div class="section"><div class='row'>		
			<?php 
		$result = doQuery("SELECT project_id, project_name, picture_filename, project_summary, village_name, project_funded, project_budget, project_type FROM projects JOIN villages ON project_village_id=village_id JOIN pictures ON project_image_id=picture_id ORDER BY project_status = 'funding' DESC, project_funded DESC");

		$count = 0;
		while ($row = $result->fetch_assoc()) {
		    $projectId = $row['project_id'];
		      $funded = $row['project_funded'];
		      $projectTotal = $row['project_budget'];
		      $fundedPercent = $funded / $projectTotal * 100;
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
		      
		      print "<div class='col s12 m4 projectCell $projectTypeClass $fundedClass' style='min-width:350px;'>
				<div class='card sticky-action hoverable'>
					<div class='card-image waves-effect waves-block waves-light'>
						<img class='activator' src='".PICTURES_DIR."/{$row['picture_filename']}' onclick=\"document.location='project.php?id=$projectId';\">
					</div>
					<div class='card-content'>
						<span class='card-title activator grey-text text-darken-4' onclick=\"document.location='project.php?id=$projectId';\">{$row['project_name']}
							<i class='material-icons right'>more_vert</i>
						</span>
						<h6 class='brown-text'>
							<b>{$row['village_name']} Village</b>
						</h6>
						<br>
						<h6>
							<b>\$$funded funded out of \$$projectTotal</b>
						</h6>
						<div class='progress'>
							<div class='determinate' style='width: $fundedPercent%'></div>
						</div>
						<p>Locals Contributed: \$$villageContribution</p>
					</div>
					<div class='card-action'>
						<div class='row center'>
							<div class='col s12'>
								<a href='http://materializecss.com/getting-started.html'
									id='download-button'
									class='btn waves-effect waves-light light blue lighten-1'>Donate</a>
							</div>
						</div>
					</div>
				</div>
			 </div>";
		      $count++;
		}
?>			</div><!-- row end -->
		</div> <!-- section end -->

		<!-- <div class="row center">
			<a href='ProjectTiles.php' id="download-button"
				class="btn-large waves-effect waves-light white lighten-1"><font color="#4FC1E9">more projects</font></a>
		</div> -->
		
		<br><br>

</div>

<?php include('footer.inc'); ?>
