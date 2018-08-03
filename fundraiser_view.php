<?php
require_once("utilities.php");

if (!hasParam('id')) {
	if (!isset($id)) {
		print "No fundraiser id specified";
		return;
	}
} else {
	$session_fundraiser_id = $_SESSION['fundraiser_id'] = $id = param('id');
}

$stmt = prepare("SELECT fundraiser_title, donor_first_name, donor_last_name, fundraiser_amount, fundraiser_description, 
		UNIX_TIMESTAMP(fundraiser_deadline) AS fundraiser_deadline, project_name, village_name, country_label,
		project_id, project_budget, project_summary, vs1.stat_value AS peopleCount, vs2.stat_value AS houseCount, 
		pictureSimilar.picture_filename AS similarPicture, pictureBanner.picture_filename AS bannerPicture
		FROM fundraisers JOIN projects ON fundraiser_project_id=project_id 
		JOIN villages ON project_village_id=village_id 
		JOIN countries ON village_country=country_id
		JOIN pictures AS pictureSimilar ON project_similar_image_id=pictureSimilar.picture_id
		JOIN pictures AS pictureBanner ON project_banner_image_id=pictureBanner.picture_id
		LEFT JOIN donors ON fundraiser_subject=donor_id
		LEFT JOIN village_stats AS vs1 ON vs1.stat_village_id=village_id AND vs1.stat_type_id=18 AND YEAR(project_date_posted)=vs1.stat_year
        LEFT JOIN village_stats AS vs2 ON vs2.stat_village_id=village_id AND vs2.stat_type_id=19 AND YEAR(project_date_posted)=vs2.stat_year
		WHERE fundraiser_id=?");
$stmt->bind_param('i', $id);
$result = execute($stmt);
if ($row = $result->fetch_assoc()) {
	$projectId = $row['project_id'];
	$title = $row['fundraiser_title'];
	$amount = $row['fundraiser_amount'];
	$description = $row['fundraiser_description'];
	if (!$description) {
		$description = $row['project_summary'];
	}
	$donorFirstName = $row['donor_first_name'];
	if ($donorFirstName) {
		$subject = "$donorFirstName ".$row['donor_last_name'];
	} else {
		$subject = '';
	}
	$deadline = $row['fundraiser_deadline'];
	$projectName = $row['project_name'];
	$villageName = $row['village_name'];
	$countryName = $row['country_label'];
	$peopleCount = $row['peopleCount'];
	$houseCount = $row['houseCount'];
	$similarPicture = $row['similarPicture'];
	$bannerPicture = $row['bannerPicture'];
	$villageContribution = round($row['project_budget'] * .05);

	$stmt->close();

	$totalDonationAmount = 0;
	$donationNames = array();
	$donationInitials = array();
	$donationAmounts = array();
	$donationDates = array();
	$donationMessages = array();
	$stmt = prepare("SELECT donor_first_name, donor_last_name, donation_amount, UNIX_TIMESTAMP(donation_date) AS donation_date, donation_message 
		FROM donations JOIN donors ON donation_donor_id=donor_id WHERE donation_fundraiser_id=?");
	$stmt->bind_param('i', $id);
	$result = execute($stmt);
	while ($row = $result->fetch_assoc()) {
		$nextAmount = $row['donation_amount'];
		$firstName = $row['donor_first_name'];
		$lastName = $row['donor_last_name'];
    	$donationInitials[] = $firstName[0].(strlen($lastName) > 0 ? $lastName[0] : "");
		$donationNames[] = $firstName.(strlen($lastName) > 0 ? ' '.substr($lastName, 0, 1) : "");
		$donationAmounts[] = $nextAmount;
		$totalDonationAmount += $nextAmount;
		$donationDates[] = $row['donation_date'];
		$donationMessages[] = $row['donation_message'];
	}
	$stmt->close();
} else {
	print "Fundraiser not found";
	return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Support <?php print $title; ?></title>
<meta property="fb:appid" content="<?php print FACEBOOK_APP_ID; ?>"/>
<meta property="og:image" content="<?php print PICTURES_DIR.$bannerPicture; ?>"/>
<meta property="og:title" content="Support <?php print $title; ?>"/>
<meta property="og:url" content="<?php print BASE_URL."fundraiser/$id"; ?>"/>
<meta property="og:description" content="<?php print $description; ?>" />
<?php 
$metaProvided = 1;
include('header.inc'); ?>

<div id="index-banner" class="parallax-container" style="background-color: rgba(0, 0, 0, 0.3); width: 100%; height: 500px">
    
	<div class="container no-pad-bot valign-wrapper" style="height: 100%; width: 100%;>
		<div class="row">
		  <div class="col s6 m6 l2 right-align hide-on-med-and-down" style="padding: 0% 0% 0% 3%;">
			<div style="width:200px; height:200px; border-radius:20%; border-style:solid; background:#008080CC;">
        					<?php print (strlen($subject) > 0 ? 
								"<h1 class=\"header center-align light\" style=\"padding:9% 0 0 0;font-size:96px;\"><b>{$subject[0]}</b></h1>"
        					: "<img src='images/gift.svg' style=\"padding:35px 40px 0 0;width:150px;filter: brightness(0) invert(.97);\" />"); ?>
			</div>
		</div> 
	
		<div class="col s6 m6 l6 left-align hide-on-med-and-down" style="padding: 0% 1% 1% 2%;">
			<div style="padding: 5% 5% 5% 5%">
				<h3 class="header col s12 white-text text-lighten-2"><?php print $title; ?></h3>
			</div>

			<div style="padding: 5% 5% 0% 5%;">
				<h5 class="header light" style="padding:0% 3% 0% 2%">
					<?php print $subject; ?></h5>
			</div>

			<div style="padding: 0% 5% 5% 7%;">
				<br>
				<br>
				<a href="one_time_payment_view.php?fundraiserId=<?php print $id; ?>" id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1" style="border-radius:10px;">donate</a>
			</div>
			<div style="padding: 0% 5% 5% 7%;">
				<?php printShareButtons($projectId, $projectName, $projectName, 60, $id); ?>
			</div>
			</div>
		
		
			<div class="col s12 m12 l6 center-align hide-on-large-only" style="padding: 0% 1% 1% 1%;">
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
			<?php printShareButtons($projectId, $projectName, $projectName, 60, $id); ?>
			</div>
	
			
		<div class="col l4 hide-on-med-and-down" style="padding: 1% 3% 1% 1%;">
      <div class="card z-depth-1" style="padding: 1% 1% 1% 1%; background:#008080CC;">
        <div class="card-content">
	        <h5 class="header white-text text-lighten-2">fundraising to</h5>
	          <p style='font-size:28px;'><b><?php print $projectName; ?></b><br/><span style='margin-top:10px;text-size:24px;'> in <?php print $villageName; ?> Village, <?php print $countryName; ?></span></p>
	          <p style="margin-top:10px;margin-bottom:20px;">Helping <?php print $peopleCount; ?> people across <?php print $houseCount; ?> households. <?php print $villageName; ?> has contributed $<?php print $villageContribution; ?>, materials, and labor.</p>
	        <div class="card-action center-align">
	          <a href="project.php?id=<?php print $projectId; ?>">meet the village</a>
	        </div>
     	</div>
    
  		</div>
  		</div>

			<div class="parallax">
				<img src="uploads/<?php print $bannerPicture; ?>">
			</div>
		</div>
	</div>
</div>
	
<div class="container">
  	<div class="row" style="width:100%; padding: 2% 0% 0% 0%">
  	     
				
		<div class="col s12 m12 l6 left-align" style="vertical-align: middle;padding: 2% 3% 0% 2%">
							
					<h6>
							<b><span style="font-size: xx-large; font-weight: bold">$<?php print $totalDonationAmount; ?></span> &nbsp;<span style="font-size: x-large; font-weight: 300">funded out of $<?php print $amount; ?></span></b>
						</h6>
						<div class='progress'>
							<div class='determinate' style='width: <?php print round(100 * $totalDonationAmount / $amount); ?>%'></div>
						</div>
						<div class="valign-wrapper"><i class="material-icons small" style="padding:0 2% 0 0%">access_time</i>
						<?php $currentTime = time();
						$timeDiff = $deadline - $currentTime;
							if ($timeDiff < 0) {
								print "This fundraiser has ended.";
							} elseif ($timeDiff < 3600) {
								print round($timeDiff / 60)." minutes left to contribute";
							} elseif ($timeDiff < 3600 * 24) {
								print round($timeDiff / 3600)." hours left to contribute";
							} else {
								print round($timeDiff / (24 * 3600))." days left to contribute";
							} ?>
 							</div>
<br>
					
		<div class="left-align">
				
				<a href='one_time_payment_view.php?fundraiserId=<?php print $id; ?>'
				id="donate-button"
				class="waves-effect waves-light donor-background lighten-1 btn-large" style="width:100%; border-radius:10px;font-size: large">Donate</a>
			
				
		</div>

		
		<div class="center-align" style="padding:8% 2% 2% 2%;">
		<div class="responsive-img" style="background-image:url('uploads/<?php print $similarPicture; ?>');background-position:center;background-size:cover;border: black 2px solid; box-shadow: 10px 10px 5px #888888; border-radius:10px;height:400px;"></div>
		<div style="font-weight:thin; font-size:large;margin-top:10px;">here's a similar project</div>
		</div>
		</div>
		
		<div class="col s12 m12 l6 left-align" style="vertical-align: middle;padding: 0% 1% 0% 3%;height:650px;overflow-x:hidden;overflow-y:auto;">
						
      <div class="flow-text" style="padding: 3% 0% 0% 0%; font-size:22px;"><?php print $description;?></div>
            	
            <h5 style="padding: 2% 0% 0% 0%; font-size:20px; font-weight:400;">Fundraising Timeline</h5>
            <div style="width:100%;">
            <?php 
            $donationCount = count($donationAmounts);
            for ($i = 0; $i < $donationCount; $i++) { ?>
            <div style='width:500px;'>
	            <div style="padding 0 0 0 0%;margin: 3% 3% 3% 3%; display:inline-block;background-color: teal;border-radius:50%; border-color:black;border-width:thin; height:80px; width:80px;">
	                 				<span style="height:80px; width:80px; padding: 22px 0% 0 0%; font-size: x-large; color: #ffffff; 
	                                        text-align: center;display:inline-block;"><b><?php print $donationInitials[$i];?></b></span>
	                 			
	 			</div>
	 			<div style="padding:0 0 0% 5%;vertical-align:middle; display: inline-block;width:350px;">
	 				<span style="font-size: 16px; font-weight: 300"><b><?php print $donationNames[$i]; ?></b></span>
	 				<span style="font-size: medium; font-weight: 300; text-color:#efebe9"> donated $<?php print $donationAmounts[$i]; ?></span>
	 				<br/><span style='text-align:right;'>on <?php print date('M j, Y', $donationDates[$i]); ?></span>
	 			
	 				<div style="font-weight: 200; font-size:16px;"><?php print $donationMessages[$i]; ?></div>
 				</div>
 			</div>
 			<?php } 
 			if ($i == 0) {
 				print "<div class='row valign-wrapper'><div style='padding:15px;'>No one has donated to this fundraiser yet.</div></div>";
 			}
 			?>
					
		</div>
		
		</div>
	</div>
</div>
	
</div>
</div>

<?php include('footer.inc'); ?>
