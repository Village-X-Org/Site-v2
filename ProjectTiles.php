<?php 
require_once("utilities.php");
include('header.inc');
?>

<div class="container">
	
	<div class="row">
		<div class="col s12 m8 l8;">
			<h4 class="header left brown-text text-lighten-2 text-shadow: 2px 2px 7px #111111">
				Choose a project to fund
			</h4>
		</div>
	
		<div class="col s12 m4 l4; valign-wrapper; center-align" style="vertical-align: middle; padding: 20px;">		
	
    		    <!-- Dropdown Trigger -->
      		<a class="dropdown-button btn light blue" href='#' data-activates='dropdown1'>Filter by Project Category</a>

            <!-- Dropdown Structure -->
          	<ul id="dropdown1" class="dropdown-content">
            		<li><a href="#!">Agriculture</a></li>
            		<li><a href="#!">Education</a></li>
           	 	<li><a href="#!">Livestock</a></li>
            		<li><a href="#!">Water</a></li>
          	</ul>
		</div>
	</div>
		
		
		
	<div class="section">		
			<?php 
		$result = doQuery("SELECT project_id, project_name, picture_filename, project_summary, village_name, project_funded, project_budget FROM projects JOIN villages ON project_village_id=village_id JOIN pictures ON project_image_id=picture_id ORDER BY project_status = 'funding' DESC, project_funded DESC");

		$count = 0;
		while ($row = $result->fetch_assoc()) {
		      $funded = $row['project_funded'];
		      $projectTotal = $row['project_budget'];
		      $fundedPercent = $funded / $projectTotal * 100;
		      $villageContribution = $projectTotal * .05;
		      
		      if ($count % 3 == 0) {
		          if ($count > 0) {
		              print "</div>";
		          }
		          print "<div class='row'>";
		      }
		      print "<div class='col s12 m4'>
				<div class='card sticky-action hoverable'>
					<div class='card-image waves-effect waves-block waves-light'>
						<img class='activator' src='".PICTURES_DIR."/{$row['picture_filename']}'>
					</div>
					<div class='card-content'>
						<span class='card-title activator grey-text text-darken-4'>{$row['village_name']}
							<a href='project.php'><i class='material-icons right'>more_vert</i></a>
						</span>
						<h6 class='brown-text'>
							<b>{$row['project_name']}</b>
						</h6>
						<br>
						<h6 class='center'>
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
?>			
		</div>
	</div>

		<!-- <div class="row center">
			<a href='ProjectTiles.php' id="download-button"
				class="btn-large waves-effect waves-light white lighten-1"><font color="#4FC1E9">more projects</font></a>
		</div> -->
		
		<br><br>

</div>

<?php include('footer.inc'); ?>