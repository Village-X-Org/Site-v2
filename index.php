<?php
require_once("utilities.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header.inc'); ?>
<script>
function addSubscription() {
	
}
</script>
<div id="index-banner" class="parallax-container"
	style="background-color: rgba(0, 0, 0, 0.3); height: 500px">
	<div class="section no-pad-bot valign-wrapper"
		style="height: 100%; width: 100%;">
		<div class="row center">
			<div style="padding: 5% 5% 5% 5%;">
				<h2
					class="header col s12 white-text text-lighten-2 text-shadow: 2px 2px 7px #111111">Fund
					Projects That Villages Choose</h2>
			</div>

			<div style="padding: 5% 5% 5% 5%;">
				<br>
				<br>
				<h5 class="header center light text-shadow: 2px 2px 7px #111111">because
					everyone deserves a voice in development</h5>
			</div>

			<div style="padding: 0% 5% 5% 5%;">
				<br>
				<br>
				<a href="project_tiles.php" id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1" style="border-radius:20px;">meet
					the villages</a>
			</div>

			<div class="parallax">
				<img src="images/header1.jpg">
			</div>
		</div>
	</div>
</div>

<div class="container">
	<br>
	<h5 class="header center light blue-text text-lighten-2">Support African villages disrupting extreme poverty</h5>

	<!--   <h5 class="header center brown-text text-lighten-2">How It Works</h5> -->
	<div class="section">
		<!--   Icon Section   -->
		<div class="row">
			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center brown-text">
						<img src="images/icon_village.png" height="75px" width="75px">
					</h2>
					<h5 class="center">Find a village</h5>

					<p class="light center">Our partner villages are located in rural
						Africa, where extreme poverty is on the rise. Our model and
						technology elevate their voices in international development.</p>

				</div>
			</div>

			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center brown-text">
						<img src="images/icon_heart.png" height="75px" width="75px">
					</h2>
					<h5 class="center">Fund a project</h5>

					<p class="light center">Villages identify their biggest problems
						and propose locally appropriate solutions. They also put skin in
						the game by contributing cash, labor, and materials.</p>
				</div>
			</div>

			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center brown-text">
						<img src="images/icon_pic.png" height="75px" width="75px">
					</h2>
					<h5 class="center">See your impact</h5>

					<p class="light center">Donors receive email updates with project
						pictures and data showing exactly how each donation has helped.
						It's our 100% transparency guarantee.</p>
				</div>
			</div>
		</div>

	</div>
</div>
<hr width="85%">

<div class="container">
	<br>
	<h5 class="header center brown-text text-lighten-2">Featured Projects</h5>
	<div class="section">

		<!--   project section   -->
		<div class="row">
<?php
$result = doQuery("SELECT project_id, project_name, picture_filename, project_summary, village_name, project_funded, project_budget FROM projects JOIN villages ON project_village_id=village_id JOIN pictures ON project_image_id=picture_id WHERE project_status = 'funding' LIMIT 3");

while ($row = $result->fetch_assoc()) {
    $projectId = $row['project_id'];
    $projectName = $row['project_name'];
    $funded = $row['project_funded'];
    $projectTotal = $row['project_budget'];
    $fundedPercent = $funded / $projectTotal * 100;
    $villageContribution = $projectTotal * .05;
    print "<div class='col s12 m6 l4' style='min-width:225px;'>
			<div class='card sticky-action hoverable'>
				<div class='card-image waves-effect waves-block waves-light'>
					<img class='activator' src='" . PICTURES_DIR . "/{$row['picture_filename']}' onclick=\"document.location='project.php?id=$projectId';\">
				</div>
				<div class='card-content'>
					<span class='card-title activator grey-text text-darken-4'  style='font-size:18px;'  onclick=\"document.location='project.php?id=$projectId';\">$projectName
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
        print "<a href='one_time_payment_view.php'
								id='donate_button'
								class='btn waves-effect waves-light light blue lighten-1'>Donate</a>";
    } else {
        print "<button href='' class='btn grey'>Fully Funded!</button>";
    }
    print "</div>
					</div>
				</div>
			</div>
	      </div>";
}
?>			
		</div>
		<br>

		<div class="row center">
			<a href='project_tiles.php' id="download-button"
				class="btn-large waves-effect waves-light light blue lighten-1" style="border-radius:20px;">more
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

<div id="index-banner" class="parallax-container"
	style="background-color: rgba(0, 0, 0, 0.3); height: 500px">
	<div class="section no-pad-bot valign-wrapper"
		style="height: 100%; width: 100%;">
		
		<div class="row center">
        	<div class="valign-wrapper">
          <div class="card white" style="opacity: 0.7; border-radius:20px;">
            <div class="card-content black-text">
              <span class="card-title"><b>want good stories from Africa?<br> try our quarterly newsletter</b></span>
      		
    		<form action="//villagexapp.us8.list-manage.com/subscribe/post?u=0aa3c6538384ca95760dc6be6&amp;id=2efaede0d4" method="post" target="_blank" class="col s12">
      		<div class="row">
        			<div class="input-field col s12">
         			<input value="" name="EMAIL" id="mce-EMAIL" placeholder="enter your email address" id="mcd-email" type="email" class="email validate">
        			</div>
      		</div>
    		
			
        		<div class="center-align" style="width:100%;">
          			<button class="btn-large blue waves-effect waves-light center-align" style="border-radius:20px; margin:0% 0% 5% 0%;" type="submit" name="action">yes, please
  					</button>
    			</div>
    		
    			<div style="position: absolute; left: -5000px;" aria-hidden="true">
								<input type="text" name="b_0aa3c6538384ca95760dc6be6_2efaede0d4" tabindex="-1" value="">
			</div>
			
			</form>
			
			</div>	
          </div>
        </div>
      
			<div class="parallax">
				<img src="images/newsletter_banner_2.jpg">
			</div>
		</div>
	</div>
</div>

<div class="container">
	<br>
	<h5 class="header center brown-text text-lighten-2">Our Impact</h5>
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
				to 2016, on 21 projects and 32 villages, with an average investment of $5,400 per village over 2 years (more info <a
					href='impacts.php'>here</a>)
			</h6>
		</div>
		<br>
	</div>

</div>

<?php include('footer.inc'); ?>
