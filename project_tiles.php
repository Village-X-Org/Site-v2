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
		      
		      print "<div class='col s12 m4 projectCell $projectTypeClass'>
				<div class='card sticky-action hoverable'>
					<div class='card-image waves-effect waves-block waves-light'>
						<img class='activator' src='".PICTURES_DIR."/{$row['picture_filename']}' onclick=\"document.location='project.php?id=$projectId';\">
					</div>
					<div class='card-content'>
						<span class='card-title activator grey-text text-darken-4' onclick=\"document.location='project.php?id=$projectId';\">{$row['village_name']}
							<i class='material-icons right'>more_vert</i>
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
?>			</div><!-- row end -->
		</div> <!-- section end -->
	</div>

		<!-- <div class="row center">
			<a href='ProjectTiles.php' id="download-button"
				class="btn-large waves-effect waves-light white lighten-1"><font color="#4FC1E9">more projects</font></a>
		</div> -->
		
		<br><br>

</div>

<?php include('footer.inc'); ?>