<?php
require_once("utilities.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header.inc');
?>

           
 <div class="container">
            <br>
            
            <div id="jquery-validation" class="section" style="display:table; width:100%">
            <div class="col-project valign-wrapper" style="vertical-align: middle;">
            <div class="card" style="border-style:solid; border-width:1px; border-color:blue; border-radius:20px; margin: 0px 0px 0px 0px;">
            <div class="card-content blue-text" style="height:100%;">
            <span class="card-title black-text">Give monthly and disrupt extreme poverty all year long</span>
            <div class="row" style="padding:5% 5% 5% 5%;">
            <h6 class="center-align" style="color:blue;">enter an amount and your name</h6>
            <form class="col s12 formValidate" style="width:100%" id="formValidate" method="get" action="">
            <div class="row" style="border-style:solid; border-width:2px; border-color:blue; border-radius:20px; padding:3% 3% 3% 3%;">
            <div class="input-field col s12 center-align">
            <i class="material-icons prefix" style="font-size:40px;">attach_money&nbsp;&nbsp;</i>
            <input placeholder="10" style="font-size:40px; color:blue;" id="donation_amount" type="tel">
            <h5 class="center-align">/ month</h5>
            <div class="input-field col s6">
            <label for="uname">First Name</label>
            <input id="uname" name="uname" type="text" data-error=".errorTxt1">
            <div class="errorTxt1"></div>
            </div>
            <div class="input-field col s6">
            <label for="last_name">Last Name</label>
            <input id="uname" name="uname" type="text" data-error=".errorTxt1">
            <div class="errorTxt1"></div>
            </div>
            </div>
            </div>
            
            <div class="input-field col s12">
            <button class="center-align waves-effect waves-light light blue lighten-1 btn-large submit" type="submit" style="width:100%;" onclick="amount = $('#donation_amount').val(); if (!amount) { amount = $('#donation_amount').attr('placeholder'); } donateWithStripe(false, amount * 100, '<?php print $projectName; ?>', <?php print $projectId; ?>); return false;">Donate</button>
    
            </div>
            
            <script>
                        var handler = StripeCheckout.configure({
                          key: 'pk_test_AXxdOsB0Xz9tOVdCVq8jpkAQ',
                          image: 'https://s3.amazonaws.com/stripe-uploads/acct_14tfQ6EfZscNLAofmerchant-icon-1414779028120-Screen%20Shot%202014-09-29%20at%2012.21.02%20PM.png',
                          locale: 'auto',
                          token: function(token) {
                        	  $.post("subscribe.php", {
                			        stripeToken: token.id,
                			        stripeEmail: token.email,
                			        stripeAmount: $('#donation_amount').val() * 100
                			    },
                			    function(data, status) {
                			    	 	Materialize.toast(data, 4000);
                			    });
                          }
                        });
                        
                        // Close Checkout on page navigation:
                        window.addEventListener('popstate', function() {
                          handler.close();
                        });
            </script>
            
            </form>
            </div>
            </div>
            </div>
            </div>
            
            <div class="col-project valign-wrapper center-align" style="vertical-align: middle;">
            <img src="images/monthly_giving_donation_page.jpg" class="responsive-img">
            <p>You'll receive rolling updates of your impact on the ground.</p>
		</div>
                
	</div>
</div>
<?php include('footer.inc'); ?>