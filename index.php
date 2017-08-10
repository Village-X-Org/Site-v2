<?php 
require_once('utilities.php');
include('header.inc');
 ?>

<div id="index-banner" class="parallax-container valign-wrapper"
	style="background-color: rgba(0, 0, 0, 0.3); height: 800px">
	<div class="section no-pad-bot">
		<div class="container">
			<h2
				class="header center white-text text-lighten-2 text-shadow: 2px 2px 7px #111111">Fund
				Projects Villages Choose</h2>
			<div class="row center">
				<h5 class="header center light text-shadow: 2px 2px 7px #111111">because
					everyone deserves local development</h5>
			</div>
			<div class="row center">
				<a href="http://materializecss.com/getting-started.html"
					id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1">meet
					the villages</a>
			</div>
			<br>
		</div>
	</div>
	<div class="parallax">
		<img src="images/header1.jpg">
	</div>
</div>

<div class="container">
	<br>
	<h5 class="header center brown-text text-lighten-2">How It Works</h5>
	<div class="section">
		<!--   Icon Section   -->
		<div class="row">
			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center brown-text">
						<img src="images/icon_village.png" height="75px" width="75px">
					</h2>
					<h5 class="center">Find a village</h5>

					<p class="light center">Our partner villages want to escape
						extreme poverty. They identify their biggest problems and propose
						locally appropriate solutions.</p>

				</div>
			</div>

			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center brown-text">
						<img src="images/icon_heart.png" height="75px" width="75px">
					</h2>
					<h5 class="center">Fund a project</h5>

					<p class="light center">Villages put skin in the game by
						contributing cash, labor, and materials. You invest in their
						development aspirations.</p>
				</div>
			</div>

			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center brown-text">
						<img src="images/icon_pic.png" height="75px" width="75px">
					</h2>
					<h5 class="center">Track your impact</h5>

					<p class="light center">Receive email updates with project
						pictures and data showing exactly how your donation helped. It's
						our 100% transparency guarantee.</p>
				</div>
			</div>
		</div>

	</div>
</div>
<hr width="85%">

<div class="container">
	<br>
	<h5 class="header center brown-text text-lighten-2">100% locally
		owned</h5>
	<div class="section">

		<!--   project section   -->
		<div class="row">
<?php 
		$result = doQuery("SELECT project_id, project_name, picture_filename, project_summary, village_name, project_funded, project_budget FROM projects JOIN villages ON project_village_id=village_id JOIN pictures ON project_image_id=picture_id WHERE project_status = 'funding' LIMIT 3");

		while ($row = $result->fetch_assoc()) {
		  $projectId = $row['project_id'];
    	      $funded = $row['project_funded'];
    	      $projectTotal = $row['project_budget'];
    	      $fundedPercent = $funded / $projectTotal * 100;
    	      $villageContribution = $projectTotal * .05;
	      print "<div class='col s12 m4'>
			<div class='card sticky-action hoverable'>
				<div class='card-image waves-effect waves-block waves-light'>
					<img class='activator' src='".PICTURES_DIR."/{$row['picture_filename']}' onclick=\"document.location='project.php?id=$projectId';\">
				</div>
				<div class='card-content'>
					<span class='card-title activator grey-text text-darken-4'  onclick=\"document.location='project.php?id=$projectId';\">{$row['village_name']}
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
		}
?>			
		</div>
		<br>

		<div class="row center">
			<a href='ProjectTiles.php' id="download-button"
				class="btn-large waves-effect waves-light light blue lighten-1">more
				projects</a>
		</div>
	</div>
</div>

<!-- <hr width="85%">

  <div class="container">
	<br>
	<h5 class="header center brown-text text-lighten-2">Map-Based
		Reporting</h5>
	<p style="text-align: center;">
		<img src="images/map_screenshot.png"
			style="opacity: 0.7; width: 100%; height: auto;">
	</p>
</div> -->

<hr width="85%">

<div class="container">
	<br>
	<h5 class="header center brown-text text-lighten-2">Data-Driven
		Impact</h5>
	<div class="section">

		<!--   Icon Section   -->
		<div class="row center">
			<br>
			<div class="col s12 m3 l3">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">trending_down</i>
					<h5 class="center brown-test">waterborne illness</h5>
					<h4 class="light center">-70%</h4>
					<h6 class="light center">p-value&lt;=0.01</h6>
					<br> <br> <br>
				</div>
			</div>

			<div class="col s12 m3 l3">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">trending_up</i>
					<h5 class="center brown-test">boys/girls in nursery school</h5>
					<h4 class="light center">+66%/60%</h4>
					<h6 class="light center">p-value&lt;=0.05</h6>
					<br> <br> <br>
				</div>
			</div>

			<div class="col s12 m3 l3">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">trending_up</i>
					<h5 class="center brown-test">non-agricultural businesses</h5>
					<h4 class="light center">+100%</h4>
					<h6 class="light center">p-value&lt;=0.05</h6>
					<br> <br> <br>
				</div>
			</div>

			<div class="col s12 m3 l3">
				<div class="icon-block">
					<i class="material-icons" style="font-size: 50px">trending_up</i>
					<h5 class="center brown-test">girls in high school</h5>
					<h4 class="light center">+80%</h4>
					<h6 class="light center">p-value~0.1</h6>
					<br> <br> <br>
				</div>
			</div>
		</div>
		
			<div>
			<h6 class="light center-align">
				*based on difference-in-differences analysis using data, from 2014
				to 2016, on 21 projects and 32 villages (more info <a href="">here</a>)
			</h6>
			</div>
			<br>
	</div>

</div>

<div class="parallax-container valign-wrapper"
	style="background-color: rgba(0, 0, 0, 0.3); height: 800px">
	<div class="section no-pad-bot">
		<div class="container">
			<div class="row center">
				<h5
					class="header col s12 white-text light text-shadow: 4px 4px 7px #FFFFFF;">
					support the<br> <b>VILLAGE FUND</b>
				</h5>
			</div>
			<div class="row center">
				<a href="http://materializecss.com/getting-started.html"
					id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1">Give
					Monthly</a>
			</div>
		</div>
	</div>
	<div class="parallax">
		<img src="images/footer1.jpg" alt="Unsplashed background img 2">
	</div>
</div>
<?php include('footer.inc'); ?>
