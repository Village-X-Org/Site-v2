<?php
require_once("utilities.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header.inc');
$projectId = paramInt('id');
$result = doQuery("SELECT project_name, project_budget, village_name, country_label, picture_filename FROM projects 
        JOIN villages ON project_village_id=village_id 
        JOIN countries ON village_country=country_id
        JOIN pictures ON project_similar_image_id=picture_id 
        WHERE project_id=$projectId");
if ($row = $result->fetch_assoc()) {
    $projectName = $row['project_name'];
    $villageName = $row['village_name'];
    $projectBudget = $row['project_budget'];
    $similarPicture = $row['picture_filename'];
    $countryName = $row['country_label'];
    $communityContribution = $projectBudget * .05;
}
?>

<div class="container">
<br>

	<div id="jquery-validation" class="section" style="display:table; width:100%">
		<div class="col-project valign-wrapper" style="vertical-align: middle;">
			<div class="card" style="border-style:solid; border-width:1px; border-color:blue; border-radius:20px; margin: 0px 0px 0px 0px;">
            		<div class="card-content blue-text" style="height:100%;">
            		<span class="card-title black-text">You are donating to <?php print $projectName; ?> in <?php print $villageName; ?> Village, <?php print $countryName; ?>.</span>
         				<div class="row" style="padding:5% 5% 5% 5%;">
         				<h6 class="center-align" style="color:blue;">enter an amount and your name</h6>
         				<form class="col s12 formValidate" style="width:100%" id="formValidate" method="get" action="">
         					<div class="row" style="border-style:solid; border-width:2px; border-color:blue; border-radius:20px; padding:3% 3% 3% 3%;">
         						<div class="input-field col s12 center-align">
         							<i class="material-icons prefix" style="font-size:40px;">attach_money&nbsp;&nbsp;</i>
          							<input placeholder="50" style="font-size:40px; color:blue;" id="donation_amount" type="tel">
          							<p class="center-align">The community gave $<?php print $communityContribution; ?>.</p><br>	
                                <div class="input-field col s6">
                                  <label for="uname">First Name</label>
                                  <input id="donationFirstName" name="uname" type="text" data-error=".errorTxt1">
               					 <div class="errorTxt1"></div>
                                </div>
                                <div class="input-field col s6">
                                	 <label for="last_name">Last Name</label>
                                  <input id="donationLastName" name="uname" type="text" data-error=".errorTxt1">
                                  <div class="errorTxt1"></div>
                                </div>
                              </div>
                           </div>
                           
        			<div class="input-field col s12">
        			<a class="button center-align waves-effect waves-light light blue lighten-1 btn-large submit" type="submit" style="width:100%;" href='' onclick="amount = $('#donation_amount').val(); if (!amount) { amount = $('#donation_amount').attr('placeholder'); } donateWithStripe(0, amount * 100, '<?php print $projectName; ?>', <?php print $projectId; ?>, $('#donationFirstName').val(), $('#donationLastName').val()); return false;"
				id="donate-button">Donate
				</a>
				</div>
                     </form>
        			</div>
			</div>
		</div>
	</div>
		
		<div class="col-project valign-wrapper center-align" style="vertical-align: middle;">
			<img src="<?php print PICTURES_DIR.$similarPicture; ?>" class="responsive-img" style="border-radius:20px;">
			<p>Here's a similar project.</p>
		</div>
		
	</div>
</div>
<?php include('footer.inc'); ?>