<?php
require_once("utilities.php");

if (!hasParam('id')) {
	print "No fundraiser id specified";
	return;
}
$id = param('id');

$stmt = prepare("SELECT fundraiser_title, fundraiser_subject, fundraiser_amount, fundraiser_description, fundraiser_deadline, project_name, village_name, country_label,
		project_budget, vs1.stat_value AS peopleCount, vs2.stat_value AS houseCount, picture_filename
		FROM fundraisers JOIN projects ON fundraiser_project_id=project_id 
		JOIN villages ON project_village_id=village_id 
		JOIN countries ON village_country=country_id
		JOIN pictures ON project_similar_image_id=picture_id
		LEFT JOIN village_stats AS vs1 ON vs1.stat_village_id=village_id AND vs1.stat_type_id=18 AND YEAR(project_date_posted)=vs1.stat_year
        LEFT JOIN village_stats AS vs2 ON vs2.stat_village_id=village_id AND vs2.stat_type_id=19 AND YEAR(project_date_posted)=vs2.stat_year
		WHERE fundraiser_id=?");
$stmt->bind_param('i', $id);
$result = execute($stmt);
if ($row = $result->fetch_assoc()) {
	$title = $row['fundraiser_title'];
	$amount = $row['fundraiser_amount'];
	$description = $row['fundraiser_description'];
	$subject = $row['fundraiser_subject'];
	$deadline = $row['fundraiser_deadline'];
	$projectName = $row['project_name'];
	$villageName = $row['village_name'];
	$countryName = $row['country_label'];
	$peopleCount = $row['peopleCount'];
	$houseCount = $row['houseCount'];
	$similarPicture = $row['picture_filename'];
	$villageContribution = round($row['project_budget'] * .05);
} else {
	print "Fundraiser not found";
	return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Village X Org | Fund Projects That Villages Choose</title>
<meta name="description" content="Disrupting extreme poverty in rural Africa with democracy, direct giving, and data."/>
<?php include('header.inc'); ?>

<div id="index-banner" class="parallax-container" style="background-color: rgba(0, 0, 0, 0.3); height: 500px">
    
	<div class="container no-pad-bot" style="height: 100%; width: 100%; padding: 2% 0% 0% 0%">
		<div class="row">
		  <div class="col s6 m6 l2 right-align hide-on-med-and-down" style="padding: 9% 0% 0% 3%;">
			<div style="width:200px; height:200px; border-radius:20%; border-style:solid; background:#008080CC;">
        				<h1 class="header center-align light" style="padding:9% 0 0 0;font-size:96px;"><b><?php print $subject[0]; ?></b></h1>
			</div>
		</div> 
	
		<div class="col s6 m6 l6 left-align hide-on-med-and-down" style="padding: 5% 1% 1% 2%;">
			<div style="padding: 5% 5% 5% 5%">
				<h3 class="header col s12 white-text text-lighten-2"><?php print $title; ?></h3>
			</div>

			<div style="padding: 5% 5% 5% 5%;">
				<h5 class="header light" style="padding:0% 3% 0% 2%">
					<?php print $subject; ?></h5>
			</div>

			<div style="padding: 0% 5% 5% 7%;">
				<br>
				<br>
				<a href="project_tiles.php" id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1" style="border-radius:10px;">donate</a>
			</div>
			
			</div>
		
		
			<div class="col s12 m12 l6 center-align hide-on-large-only" style="padding: 12% 1% 1% 1%;">
			<div style="padding: 5% 5% 5% 5%">
				<h3 class="header col s12 white-text text-lighten-2 text-shadow: 2px 2px 7px #111111"><?php print $title; ?></h3>
			</div>

			<div style="padding: 5% 5% 5% 5%;">
				<h5 class="header light text-shadow: 2px 2px 7px #111111" style="padding:0% 3% 0% 3%">
					<?php print $subject; ?></h5>
			</div>

			<div style="padding: 0% 5% 5% 5%;">
				<br>
				<br>
				<a href="project_tiles.php" id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1" style="border-radius:10px;">donate</a>
			</div>
			
			<div style="padding: 5% 20% 5% 20%;">
				<h6 class="header light text-shadow: 2px 2px 7px #111111" style="font-weight:thin">fundraising to <span style="font-size: large; font-weight: bold"><?php print $projectName; ?></span></h6>
				<h6>in <?php print $villageName; ?> Village, <?php print $countryName; ?></h6>
			</div>
			
			</div>
	
			
		<div class="col l4 hide-on-med-and-down" style="padding: 1% 3% 1% 1%;">
      <div class="card z-depth-1" style="padding: 1% 1% 1% 1%; background:#008080CC;">
        <!-- <div class="card-image">
          <img src="images/woman_with_goat">
          <span class="card-title">Card Title</span>
        </div> -->
        <div class="card-content">
	        <h5 class="header white-text text-lighten-2">fundraising to</h5>
	          <p style='font-size:28px;'><b><?php print $projectName; ?></b><br/><span style='margin-top:10px;text-size:24px;'> in <?php print $villageName; ?> Village, <?php print $countryName; ?></span></p>
	          <p style="margin-top:10px;margin-bottom:20px;">Helping <?php print $peopleCount; ?> people across <?php print $houseCount; ?> households. <?php print $villageName; ?> has contributed $<?php print $villageContribution; ?>, materials, and labor.</p>
	        <div class="card-action center-align">
	          <a href="#">meet the village</a>
	        </div>
     	</div>
    
  		</div>
  		</div>

			<div class="parallax">
				<img src="images/header1.jpg">
			</div>
		</div>
	</div>
</div>
	
<div class="container">
  	<div class="row" style="width:100%; padding: 2% 0% 2% 0%">
  	     
				
		<div class="col s12 m12 l6 left-align" style="vertical-align: middle;padding: 2% 3% 2% 2%">
							
					<h6>
							<b><span style="font-size: xx-large; font-weight: bold">$200</span> <span style="font-size: x-large; font-weight: 300">funded out of $400</span></b>
						</h6>
						<div class='progress'>
							<div class='determinate' style='width: 50%'></div>
						</div>
						<div class="valign-wrapper"><i class="material-icons small" style="padding:0 2% 0 0%">access_time</i>10 days left to contribute</div>
<br>
					
		<div class="left-align">
				
				<a href=''
				id="donate-button"
				class="waves-effect waves-light donor-background lighten-1 btn-large" style="width:100%; border-radius:10px;font-size: large">Donate</a>
			
				
		</div>

		
		<div class="center-align" style="padding:8% 2% 2% 2%;">
		<img src="uploads/<?php print $similarPicture; ?>" class="responsive-img" style='border: black 2px solid; box-shadow: 10px 10px 5px #888888; border-radius:10px;'>	
		<div style="font-weight:thin; font-size:large">here's a similar project</div>
		</div>
		</div>
		
		<div class="col s12 m12 l6 left-align" style="vertical-align: middle;padding: 0% 2% 2% 3%">
						
      <div class="flow-text" style="padding: 3% 0% 0% 0%; font-size:22px;"><?php print $description;?></div>
            	
            <h5 style="padding: 2% 0% 0% 0%; font-size:20px; font-weight:400;">Fundraising Timeline</h5>
            <div style="overflow-x:scroll; height:200px;width:100%;">
            <div class="row valign-wrapper">
            <div style="padding 0 0 0 0%;margin: 3% 3% 3% 3%; display:inline-block;background-color: teal;border-radius:50%; border-color:black;border-width:thin; height:80px; width:80px;">
                 				<a class="tooltip" style='text-decoration:none;color:#EEEEEE;'><span class="tooltiptext">Thanks, Jeff D!</span><span style="height:80px; width:80px; padding: 0 0% 0 0%; font-size: x-large; font-color: #ffffff; 
                                    text-align: center;display: table-cell;vertical-align:middle;"><b>JD</b></span></a>
                 			
 			</div>
 			<div style="padding:0 0 0% 5%;vertical-align:middle; display: inline-block;"><span style="font-size: 16px; font-weight: 300"><b>Tom and Patty Smith</b></span><span style="font-size: medium; font-weight: 300; text-color:#efebe9"> donated $50</span><br/><span style='text-align:right;'>3 hours ago</span>
 			
 			<div style="font-weight: 200; font-size:16px;">Happy birthday, Bryan! We love you.</div>
 			</div>
					
		</div>
		
		</div>
		
	</div>
</div>
	
</div>
</div>

<?php include('footer.inc'); ?>
