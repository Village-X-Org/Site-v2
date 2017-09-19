<?php
require_once("utilities.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>

<!-- form validation code -->
<script src="https://jqueryvalidation.org/files/lib/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>

<style type="text/css">
  .input-field div.error{
    position: relative;
    top: -1rem;
    left: 0rem;
    font-size: 0.8rem;
    color:#FF4081;
    -webkit-transform: translateY(0%);
    -ms-transform: translateY(0%);
    -o-transform: translateY(0%);
    transform: translateY(0%);
  }
  </style>
  <?php
  if (!hasParam('id')) {
      print "Project id required.";
      die();
  }
  $projectId = paramInt('id');
  $result = doQuery("SELECT project_name, project_budget, project_summary, village_name, country_label, bannerPictures.picture_filename AS bannerPicture, similarPictures.picture_filename AS similarPicture FROM projects
        JOIN villages ON project_village_id=village_id
        JOIN countries ON village_country=country_id
        JOIN pictures AS similarPictures ON project_similar_image_id=similarPictures.picture_id
        JOIN pictures AS bannerPictures ON project_banner_image_id=bannerPictures.picture_id
        WHERE project_id=$projectId");
  if ($row = $result->fetch_assoc()) {
      $projectName = $row['project_name'];
      $villageName = $row['village_name'];
      $projectBudget = $row['project_budget'];
      $summary = $row['project_summary'];
      $similarPicture = $row['similarPicture'];
      $bannerPicture = $row['bannerPicture'];
      $countryName = $row['country_label'];
      $communityContribution = $projectBudget * .05;
  } else {
      print "Project not found";
      die();
 }?>
<meta property="fb:appid" content="<?php print FACEBOOK_APP_ID; ?>"/>
<meta property="og:image" content="<?php print PICTURES_DIR.$bannerPicture; ?>"/>
<meta property="og:title" content="I donated to <?php print $projectName; ?> in <?php print $villageName; ?> Village"/>
<meta property="og:url" content="https://4and.me/<?php print $projectId; ?>"/>
<meta property="og:description" content="Disrupt extreme poverty by funding projects villages choose. <?php print $summary; ?>"/>
<?php $metaProvided = 1;
include('header.inc');
?> 
<div class="container">
<br>

	<div class="section" id="jqueryvalidation" style="display:table; width:100%">
		<div class="col-project valign-wrapper" style="vertical-align: middle;">
			<div class="card" style="border-style:solid; border-width:1px; border-color:blue; border-radius:20px; margin: 0px 0px 0px 0px;">
            		<div class="card-content blue-text" style="height:100%;">
            		<span class="card-title black-text">You are donating to <?php print $projectName; ?> in <?php print $villageName; ?> Village, <?php print $countryName; ?>.</span>
         				<div class="row" style="padding:5% 5% 5% 5%;">
         				<h6 class="center-align" style="color:blue;">enter an amount and your name</h6>
         				<form class="col s12" style="width:100%" id="donateForm">
         					
         					<div class="row" style="border-style:solid; border-width:2px; border-color:blue; border-radius:20px; padding:3% 3% 3% 3%;">
         						<div class="input-field col s12 center-align">
         							<i class="material-icons prefix" style="font-size:40px; color:light-blue">attach_money&nbsp;&nbsp;</i>
          							<input placeholder="50" style="font-size:40px; color:light-blue;" id="donation_amount" type="tel">
          							<p class="center-align">The community gave $<?php print $communityContribution; ?>.</p><br>	
                                <div class="input-field col s6">  
                                  <input id="donationFirstName" name="firstname" placeholder="first name" type="text" required data-error=".errorTxt1">
                                  <div class="errorTxt1"></div>
                                </div>
                                <div class="input-field col s6">
                                  <input id="donationLastName" name="lastname" placeholder="last name" type="text" required data-error=".errorTxt2">
                                  <div class="errorTxt2"></div>
                                </div>
                              </div>
                           </div>
     
                    		   <div class="input-field col s12">
                    		   		
                    				<button id="donationButton" class="btn-large center-align light-blue submit" type="submit" 
                    						name="action" style="width:100%;"> 
                    					Donate 
                    				</button>
            				   </div>
              			</form>
<script>
	$().ready(function() {
		$("#donateForm").validate({
			rules: {
				firstname: "required",
				lastname: "required",
			},
		messages: {
		      firstname: "this field is required",
		      lastname: "this field is required",
		},

        errorElement : 'div',
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error)
          } else {
            error.insertAfter(element);
          }
        },
          submitHandler: function(form) {
        	  gotoStripe();
        }	
		});
	});
</script>

        			</div>
			</div>
		</div>
	</div>
		
		<div class="col-project valign-wrapper center-align" style="vertical-align: middle;">
			<img src="<?php print PICTURES_DIR.$similarPicture; ?>" width="800" height="800" class="responsive-img" style="border-radius:20px;">
			<p>Here's a photo of a similar project.</p>
		</div>
	</div>
</div>

<script>
    function gotoStripe() {
        	amount = $('#donation_amount').val(); 
        	if (!amount) { 
        		amount = $('#donation_amount').attr('placeholder'); 
        	}
        	donateWithStripe(0, amount * 100, '<?php print $projectName; ?>', <?php print $projectId; ?>, $('#donationFirstName').val(), $('#donationLastName').val());
    }
</script>
             
<?php include('footer.inc'); ?>