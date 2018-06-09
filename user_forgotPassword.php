<?php
require_once("utilities.php");

$id = param('id');
$code = param('code');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Village X Org | Fund Projects That Villages Choose</title>
<meta name="description" content="Disrupting extreme poverty in rural Africa with democracy, direct giving, and data."/>
<style>
body, html {
    height: 100%;
    margin: 0;
}

.bg {
    /* The image used */
    background-image: linear-gradient( rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) ), url("images/khwalala_market.jpg");
    
    /* Full height */
    height: 100%; 

    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    
}


</style>
<?php include('header.inc'); ?>

<div class="bg valign-wrapper">

	<div class="container" id="form_style" style="padding:0 15% 0 15%;">
		<div class="white-text center-align" style="font-weight:800;font-size:xx-large;text-shadow: black 0.1em 0.1em 0.4em;">
			REJOIN THE ACTION
		</div>
		<div class="white-text center-align" style="font-weight:500;font-size:large; font-stretch:condensed;text-shadow: black 0.1em 0.1em 0.6em;padding:0 0 2% 0">
			<span class="white-text">choose something fun and memorable</span>
		</div>
	
		
		<div class="card donor-border" style="border-style:solid; border-width:3px; border-radius:20px; border-color: black; margin: 0px 0px 0px 0px;">
        	<div class="card-content donor-text" style="height:100%;">
        		<div class="section" id="jqueryvalidation" style="width:100%">
        			<form class="col s12" style="width:100%" id="forgot_password_form" method='post' action="user_changePassword.php">
        				<input type='hidden' name='id' value='<?php print $id; ?>' />
        				<input type='hidden' name='code' value='<?php print $code; ?>' />
     					<div class="row donor-text" style="padding:0% 0% 0% 0%;">
      						<div class="row" style="padding:2% 3% 0 3%;margin:0;">
     							<div class="black-text" style="font-size:large; padding:0 0 0 3%"><b>NEW PASSWORD</b></div>
     							<div class="input-field col s12 donor-text">
      								<input placeholder="enter your password" class='text' type="password" style="padding:0% 1% 1% 1%;font-size:20px; border-style:solid; border-width:thin;border-radius:5px" id="newPassword" name="newPassword" required data-error=".errorTxt4"/>
      								<div class="errorTxt4 center-align" style="font-size:10px; color:red;"></div>
      							</div>
      						</div>
   
                        </div>
                    
                       	<div class="center-align valign-wrapper" style="width:100%; padding:0 3% 0% 3%;">
                		   	<div class="input-field center-align" style="width:100%;">
                		   		
                				<button id="resetButton" class="btn-large donor-background center-align submit" type="submit" style="width:100%;height:70px;font-size:25px"> 
                					RESET YOUR PASSWORD 
                				</button>
        				   </div>
        				   
        				</div>
        			</form>

        			<script>
						$().ready(function() {
							$("#forgot_password_form").validate({
								rules: {
									password: "required",
									
								},
							messages: {
							      password: "a valid password is required",
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
					        	form.submit();
					        }	
							});
						});
					</script>
        		</div>
      
			</div>
		
		</div>
	
	</div>
</div>

