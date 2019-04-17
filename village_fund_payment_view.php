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

<?php include('header.inc');

?>

           
 <div class="container">
            <br>
    
            <div id="jquery-validation" class="section" style="display:table; width:100%">
            <div class="col-project valign-wrapper" style="vertical-align: middle;">
            <div class="card" style="border-style:solid; border-width:1px; border-color:blue; border-radius:20px; margin: 0px 0px 0px 0px;">
            <div class="card-content blue-text" style="height:100%;">
            <span class="card-title black-text">Give monthly and help many rural villages disrupt extreme poverty!</span>
			<div class="row" style="padding:5% 5% 0% 5%;">
            <h6 class="center-align" style="color:blue;">enter an amount and your name</h6>
            <form class="col s12 donateForm" style="width:100%" id="donateForm" method="post" action="donateWithStripe.php">
            
                <input type='hidden' name='stripeToken' value='' /><input type='hidden' name='stripeEmail' value='' /><input type='hidden' name='stripeAmount' value='' />
                <input type='hidden' name='isSubscription' value='' /><input type='hidden' name='firstName' value='' /><input type='hidden' name='lastName' value='' />
                	<input type='hidden' name='projectId' value='' /><input type='hidden' name='honoreeId' value='' /><input type='hidden' name='honoreeMessage' value='' />
                <input type='hidden' name='gcAmount' value='' /><input type='hidden' name='fundraiserId' value='' /><input type='hidden' name='fundraiserMessage' value='' />
                <div class="row" style="border-style:solid; border-width:2px; border-color:blue; border-radius:20px; padding:3% 3% 3% 3%;">
                <div class="input-field col s12 center-align">
                <i class="material-icons prefix" style="font-size:40px;">attach_money&nbsp;&nbsp;</i>
                <input placeholder="10" style="font-size:40px; color:light-blue;" id="donation_amount">
                <h5 class="center-align">/ month</h5>
                    <div id='donationNameDiv'>
                        <div class="input-field col s6">
                        <input id="donationFirstName" placeholder="first name" type="text" required data-error=".errorTxt1">
                        <div class="errorTxt1"></div>
                        </div>
                        <div class="input-field col s6">
                            <input id="donationLastName" placeholder="last name" type="text" required data-error=".errorTxt2">
                            <div class="errorTxt2"></div>
                        </div>
                        <div class="input-field col s12" style='margin-top:0px;'>
                            <input id="donationEmail" placeholder="email" type="text" required data-error=".errorTxt3">
                            <div class="errorTxt3"></div>
                        </div>
                    </div>
            		</div>
                </div>
            
                <div class="input-field center-align">
                <button id="donationButton" class="center-align light-blue btn-large submit" type="submit" style="width:100%;">
                Donate</button>
                </div>

                <div class="center-align" style="width:100%; padding:5% 5% 0% 5%">
                        <label>
                            <input type="checkbox" class="filled-in" id="anonymousCheckbox" 
                        onclick="if (this.checked) { $('#donationNameDiv').hide(); } else { $('#donationNameDiv').show(); }" />
                            <span for="anonymousCheckbox">Make my donation anonymous</span>
                        </label>

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
            
            <div class="col-project valign-wrapper center-align" style="vertical-align: middle;">
            <img src="images/monthly_giving_donation_page.jpg" width="800" height="800" class="responsive-img">
            <div>Enjoy email updates with pictures and data from the field providing a vivid accounting of how your donations change development outcomes for rural Africans.</div>
		</div>
                
	</div>
</div>

<script>
    function gotoStripe() {
        	amount = $('#donation_amount').val(); 
        	if (!amount) { 
        		amount = $('#donation_amount').attr('placeholder'); 
        	}
        	donateWithStripe(1, amount * 100, '', 0, $('#donationFirstName').val(), $('#donationLastName').val(), $('#donationEmail').val(), 0, 0, "", 0, 0, ""); return false;
    }
</script>

</body>

</html>