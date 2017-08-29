<?php
require_once ('utilities.php');
include ('header.inc');
?>

<div class="container">
<br>

	<div id="jquery-validation" class="section" style="display:table; width:100%">
		<div class="col-project valign-wrapper" style="vertical-align: middle;">
			<div class="card" style="border-style:solid; border-width:1px; border-color:blue; border-radius:20px; margin: 0px 0px 0px 0px;">
            		<div class="card-content blue-text" style="height:100%;">
            		<span class="card-title black-text">You are donating to Start a Goat Herd in Saiti Village, Malawi.</span>
         				<div class="row" style="padding:5% 5% 5% 5%;">
         				<h6 class="center-align" style="color:blue;">enter an amount and your name</h6>
         				<form class="col s12 formValidate" style="width:100%" id="formValidate" method="get" action="">
         					<div class="row" style="border-style:solid; border-width:2px; border-color:blue; border-radius:20px; padding:3% 3% 3% 3%;">
         						<div class="input-field col s12 center-align">
         							<i class="material-icons prefix" style="font-size:40px;">attach_money&nbsp;&nbsp;</i>
          							<input placeholder="50" style="font-size:40px; color:blue;" id="donation_amount" type="tel">
          							<p class="center-align">The community gave $100.</p><br>	
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
        			<a class="button center-align waves-effect waves-light light blue lighten-1 btn-large submit" type="submit" style="width:100%;" href='' onclick="amount = $('#donation_amount').val(); if (!amount) { amount = $('#donation_amount').attr('placeholder'); } donateWithStripe(false, amount * 100, '<?php print $projectName; ?>', <?php print $projectId; ?>); return false;"
				id="donate-button">Donate
				</a>
				</div>
                     </form>
        			</div>
			</div>
		</div>
	</div>
		
		<div class="col-project valign-wrapper center-align" style="vertical-align: middle;">
			<img src="temp/mlenga 4116.jpg" class="responsive-img" style="border-radius:20px;">
			<p>Here's a similar project.</p>
		</div>
		
	</div>
</div>
<?php include('footer.inc'); ?>