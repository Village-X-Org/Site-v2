<?php
require_once("utilities.php");

$prepopAmount=0;
if (hasParam('amount')) {
  $prepopAmount = param('amount');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

<!-- form validation code -->
<script src="https://jqueryvalidation.org/files/lib/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<?php include("stripe_donation_code.php"); ?>
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
  $fundraiserId = 0;

  if (hasParam('fundraiserId') || $session_fundraiser_id) {
    if (hasParam('fundraiserId')) {    
      $fundraiserId = param('fundraiserId');
    } else {
      $fundraiserId = $session_fundraiser_id;
      $_SESSION['fundraiser_id'] = 0;
    }
    $stmt = prepare("SELECT fundraiser_id, fundraiser_title, fundraiser_project_id, fundraiser_amount, SUM(donation_amount) AS raised FROM fundraisers LEFT JOIN donations ON donation_fundraiser_id=fundraiser_id WHERE fundraiser_id=? GROUP BY fundraiser_id");
    $stmt->bind_param('i', $fundraiserId);
    $result = execute($stmt);
    if ($row = $result->fetch_assoc()) {
      $fundraiserId = $row['fundraiser_id'];
      $fundraiserTitle = $row['fundraiser_title'];
      $projectId = $row['fundraiser_project_id'];
      $fundraiserTarget = $row['fundraiser_amount'];
      $fundraiserRaised = $row['raised'];
      if (hasParam('id')) {
        $projectId = paramInt('id');
      }
    }
  }
  if (!isset($projectId)) {
    if (!hasParam('id')) {
      print "Project id required.";
      die();
    } else {
      $projectId = paramInt('id');
    }
  }

  $honoreeId = 0;
  $honoreeMessage = "";
  if (hasParam('honoreeEmail')) {
      $honoreeEmail = param('honoreeEmail');
      $honoreeFirstName = param('honoreeFirstName');
      $honoreeLastName = param('honoreeLastName');
      $honoreeMessage = param('honoreeMessage');
      
      $stmt = prepare("SELECT donor_id FROM donors WHERE donor_email=? AND donor_first_name=? AND donor_last_name=?");
      $stmt->bind_param('sss', $honoreeEmail, $honoreeFirstName, $honoreeLastName);
      $result = execute($stmt);
      if ($row = $result->fetch_assoc()) {
          $honoreeId = $row['donor_id'];
      } else {
          $stmt->close();
          $stmt = prepare("INSERT INTO donors (donor_email, donor_first_name, donor_last_name) VALUES (?, ?, ?)");
          $stmt->bind_param('sss', $honoreeEmail, $honoreeFirstName, $honoreeLastName);
          execute($stmt);
          $honoreeId = $link->insert_id;
      }
      $stmt->close();
  }
  $stmt = prepare("SELECT project_name, project_funded, project_budget, project_summary, project_community_contribution, village_name, country_label, project_matching_donor, bannerPictures.picture_filename AS bannerPicture, similarPictures.picture_filename AS similarPicture FROM projects
        JOIN villages ON project_village_id=village_id
        JOIN countries ON village_country=country_id
        JOIN pictures AS similarPictures ON project_similar_image_id=similarPictures.picture_id
        JOIN pictures AS bannerPictures ON project_banner_image_id=bannerPictures.picture_id
        WHERE project_id=?");
  $stmt->bind_param('i', $projectId);
  $result = execute($stmt);
  if ($row = $result->fetch_assoc()) {
      $projectName = $row['project_name'];
      $villageName = $row['village_name'];
      $matchingDonor = $row['project_matching_donor'];
      $projectFunded = $row['project_funded'];
      $projectBudget = $row['project_budget'];
      $summary = $row['project_summary'];
      $similarPicture = $row['similarPicture'];
      $bannerPicture = $row['bannerPicture'];
      $countryName = $row['country_label'];
      $communityContribution = $projectBudget * ($row['project_community_contribution'] / 100);
      
      $remaining = ceil($projectBudget - $projectFunded);
  } else {
      print "Project not found";
      die();
  }
  $stmt->close();
  
  $gcValue = 0;
  if (isset($_SESSION['gc'])) {
      $gcId = $_SESSION['gc'];
      $result = doUnprotectedQuery("SELECT gc_value FROM gift_certificates WHERE gc_id=$gcId");
      if ($row = $result->fetch_assoc()) {
          $gcValue = $row['gc_value'];
      }
  }
 ?>
<meta property="fb:appid" content="<?php print FACEBOOK_APP_ID; ?>"/>
<meta property="og:image" content="<?php print PICTURES_DIR.$bannerPicture; ?>"/>
<meta property="og:title" content="I donated to <?php print $projectName; ?> in <?php print $villageName; ?> Village"/>
<meta property="og:url" content="<?php print BASE_URL.$projectId; ?>"/>
<meta property="og:description" content="Disrupt extreme poverty by funding projects villages choose. <?php print $summary; ?>"/>
<?php $metaProvided = 1;
include('header.inc');
?> 
<div class="container">
<br>

	<div class="section row" id="jqueryvalidation" style="display:table; width:100%">
		<div class="col s12 m12 l6" style="vertical-align: middle;">
			<div class="card donor-border" style="border-style:solid; border-width:1px; border-radius:20px; margin: 0px 0px 0px 0px;">
            		<div class="card-content donor-text" style="height:100%;">
            		<span class="card-title black-text">You are donating to <?php print $projectName; ?> in   
                  <?php if ($fundraiserId) {
                    print "support of <span style='font-weight:400;'>$fundraiserTitle</span>";
                  } else { 
                    print "$villageName Village, $countryName"; 
                  } 
                  print ($honoreeId > 0 ? " in honor of $honoreeFirstName $honoreeLastName" : "" );
                  ?>.</span>
         				<div class="row" style="padding:5% 5% 0% 5%;">
                  <?php if ($fundraiserId) { ?>
                  <p class="center-align black-text">The fundraiser needs $<?php print ($fundraiserTarget - $fundraiserRaised); ?>.</p>
          				<?php } else { ?>
                    <p class="center-align black-text">The project needs <?php print ($matchingDonor ? "$".ceil($remaining / 2).", matched to " : ""); ?>$<?php print $remaining; ?>.</p>
                  <?php } ?>
         				<form class="col s12" style="width:100%" id="donateForm" method='post' action="donateWithStripe.php">
                            <input type='hidden' name='d' value='<?php print $donorId; ?>' />
                             <input type='hidden' name='stripeToken' value='' /><input type='hidden' name='stripeEmail' value='' /><input type='hidden' name='stripeAmount' value='' />
                            <input type='hidden' name='isSubscription' value='' /><input type='hidden' name='firstName' value='' /><input type='hidden' name='lastName' value='' />
                            	<input type='hidden' name='projectId' value='' /><input type='hidden' name='honoreeId' value='' /><input type='hidden' name='honoreeMessage' value='' />
                              <input type='hidden' name='gcAmount' value='' /><input type='hidden' name='fundraiserId' value='' /><input type='hidden' name='fundraiserMessage' value='' />
         					<div class="row donor-border" style="border-style:solid; border-width:2px; border-radius:20px; padding:3% 3% 3% 1%;">
         						<div class="input-field col s12 center-align">
         							<i class="material-icons prefix donor-text" style="font-size:40px;">attach_money&nbsp;&nbsp;</i>
                      <?php if (!$gcValue) { ?>
          							<input placeholder="50" class='donor-text' style="font-size:40px;" id="donation_amount" value='<?php print ($prepopAmount ? $prepopAmount : ''); ?>' />
                      <?php } else { ?>
                        <input placeholder="<?php print $gcValue; ?>" class='donor-text' style='font-size:40px;width:90px;display:inline;' 
                            id='donation_amount' /><span style='font-size:30px;font-color:#48a7f2;display:inline;text-decoration;:underline;'>
                        <?php print "+ $gcValue"; ?></span>
                    </div>
                  </div>
                      <?php } ?>
                      <div><div class="input-field col s12 center-align">
                      <?php if ($fundraiserId) { ?>
                        <textarea style="border-radius:15px;padding:10px;outline-width: 0;font-size:20px; height:80px; width:100%" id="fundraiserMessage" placeholder="leave a comment" name="fundraiserMessage"></textarea>
                      <?php } else { ?>
          							The community gave $<?php print $communityContribution; ?>.<input type='hidden' name='fundraiserComment' id='fundraiserMessage' value='' />
                      <?php } ?>
                    </div></div>
          					<div id='donationNameDiv'>
                                <div class="input-field col s6">  
                                  <input id="donationFirstName" placeholder="first name" type="text" required data-error=".errorTxt1">
                                  <div class="errorTxt1"></div>
                                </div>
                                <div class="input-field col s6">
                                  <input id="donationLastName" placeholder="last name" type="text" required data-error=".errorTxt2">
                                  <div class="errorTxt2"></div>
                                </div>
                              </div>
                                <div class="input-field col s12" style='margin-top:0px;'>
                                  <input id="donationEmail" placeholder="email" type="text" required data-error=".errorTxt3">
                                  <div class="errorTxt3"></div>
                                </div>
                              </div>
                           </div>
                           
                    		   <div class="input-field center-align" style="width:100%;">
                    		   		
                    				<button id="donationButton" class="btn-large donor-background center-align submit" type="submit" style="width:100%;"> 
                    					Donate <?php print ($matchingDonor ? " (2x)" : ""); ?>
                    				</button>
            				   </div>
            				   <?php if ($gcValue) { ?>
            				   	<div class='center-align' style='margin-top:15px;'><i class='material-icons' style='width:20px;'>checkmark</i> Your $<?php print $gcValue; ?> credit has been applied!</div>
            				   <?php } else { ?>
            				   <div class="center-align" style="width:100%; padding:5% 5% 0% 5%">
                          <label>
                            <input type="checkbox" class="filled-in" id="anonymousCheckbox" 
                            onclick="if (this.checked) { $('#donationNameDiv').hide(); } else { $('#donationNameDiv').show(); }" />
                            <span for="anonymousCheckbox">Make my donation anonymous</span>
                          </label>
        						 	</div>
						 	<?php } ?>
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
            gotoStripe(document.getElementById("anonymousCheckbox") && document.getElementById("anonymousCheckbox").checked);
            return false;
        }	
		});
	});
</script>

        			</div>
			</div>
		</div>
	</div>
		
		<div class="col s12 m12 l6 center-align" style="vertical-align: middle;margin-top:20px;">
			<img src="<?php print PICTURES_DIR.$similarPicture; ?>" width="800" height="800" class="responsive-img" style="border-radius:20px;">
			<p>Here's a similar project.</p>
		</div>
	</div>
</div>

<script>
    function gotoStripe(anonymous) {
        	amount = $('#donation_amount').val(); 
        	if (!amount) { 
        		amount = $('#donation_amount').attr('placeholder'); 
        	}
        	donateWithStripe(0, amount * 100, '<?php print $projectName; ?>', <?php print $projectId; ?>, 
                	$('#donationFirstName').val(), $('#donationLastName').val(), $('#donationEmail').val(), anonymous, <?php print $honoreeId; ?>, <?php print json_encode($honoreeMessage); ?>, <?php print $gcValue; ?>, <?php print $fundraiserId; ?>, $('#fundraiserMessage').val());
    }
</script>
             
<?php include('footer.inc'); ?>