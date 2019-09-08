<!DOCTYPE html>
<html lang="en">
<head>

<?php 
$stmt = prepare("SELECT project_name, project_summary, village_name, country_label, picture_filename, peopleStats.stat_value AS peopleCount, hhStats.stat_value AS householdCount, 
            CONCAT(donor_first_name, ' ', donor_last_name) AS matchingDonor 
        FROM projects JOIN villages ON project_id=? AND project_village_id=village_id
        JOIN countries ON country_id=village_country
        LEFT JOIN donors ON donor_id=project_matching_donor
        JOIN village_stats AS peopleStats ON peopleStats.stat_type_id=18 AND peopleStats.stat_village_id=village_id
        JOIN village_stats AS hhStats ON hhStats.stat_type_id=19 AND hhStats.stat_village_id=village_id
        JOIN pictures ON picture_id=project_banner_image_id ORDER BY hhStats.stat_year DESC, peopleStats.stat_year DESC LIMIT 1"); 
$stmt->bind_param('i', $projectId);
$result = execute($stmt);
if ($row = $result->fetch_assoc()) {
    $projectName = $row['project_name'];
    $matchingDonor = trim($row['matchingDonor']);
    $villageName = $row['village_name'];
    $bannerPicture = $row['picture_filename'];
    $summary = $row['project_summary'];
    $peopleCount = $row['peopleCount'];
    $householdCount = $row['householdCount'];
    $countryLabel = $row['country_label'];
    $stmt->close();
?>

<?php 
$pageImage = PICTURES_DIR.$bannerPicture;
$pageTitle = "My purchase supported $projectName in $villageName Village";
$pageUrl = BASE_URL.$projectId;
$pageDescription = "Disrupt extreme poverty by funding projects villages choose. $summary";
include('header.inc'); ?>

<div class="parallax-container" style="background-color: rgba(0, 0, 0, 0.3); height: 500px;">
	<div class="section no-pad-bot valign-wrapper" style="height: 100%; width:100%;">
		<div class="container">
        		<div class="row center">
        			<h2 class="header col s12 white-text text-lighten-2 text-shadow: 2px 2px 7px #111111">Thanks for your purchase!</h2> 
        		</div>
                <div class="row center">
                    <?php foreach ($products as $product) {
                        print "<div style=\"border:1px solid white; display:inline-block; height:150px;width:150px;background-size:150px; background-repeat:no-repeat;background-color:black;background-position:center; 
                            background-image:url('".PICTURES_DIR.$product[3]."');margin-left:20px;margin-right:20px;margin-top:20px;\"></div>";
                    } ?>
                </div>
		</div>
	</div>
	<div class="parallax">
		<img src="<?php print PICTURES_DIR.$bannerPicture; ?>">
	</div>
</div>
<br>

<div class="container">

	<div class="row">
      <div class="col s12 m12 l12">
        
          	<div class="black-text flow-text"><p class="flow-text">
              <?php if ($donorFirstName) { ?>
              	<p><?php print $donorFirstName; ?>,</p>
              <?php } ?> 
    				<p>We have processed your purchase and will ship out your selection(s) as soon as possible!  From the total you paid, $<?php print $donationAmountDollars; ?> will be donated to <?php print $projectName; ?> in <?php print $villageName; ?> Village! 
    				<?php print ($matchingDonor ? "With the match from $matchingDonor, this is worth $".($donationAmountDollars * 2)."! " : ""); ?>You have disrupted 
    				extreme poverty for <?php print $peopleCount; ?> people and <?php print $householdCount ?> households in <?php print $countryLabel; ?>.</p>
            		<p>Sincerely,</p>
            		<p> The Village X Team and <?php print $villageName; ?> Village</p>
    			</div>
      
    		</div>
	</div>
</div>
<?php } 

unset($_SESSION['session_user_cart']);
?>
<?php include('footer.inc'); ?>
