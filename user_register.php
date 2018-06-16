<?php
require_once("utilities.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Village X Org | Fund Projects That Villages Choose</title>
<meta name="description" content="Disrupting extreme poverty in rural Africa with democracy, direct giving, and data."/>
<style>
body, html {
    height: 100%;
    width: 100%;
    margin: 0;
}

.bg {
    /* The image used */
    background-image: url("images/khwalala_market.jpg");

    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
}
</style>
<?php include('header.inc'); ?>

<div class="bg valign-wrapper" style='height:100%;width:100%'>

<div class="container" style="padding:2% 10% 0 10%; width:100%">
  <div class="white-text container center-align" style="font-weight:800;font-size:xx-large;text-shadow: black 0.1em 0.1em 0.2em">SIGN UP TODAY</div>
  <div class="container center-align" style="font-weight:500;font-size:medium;text-shadow: black 0.1em 0.1em 0.2em"><span class="white-text">your profile. your impact. your fundraisers.</span></div>

  <div class="section" id="jqueryvalidation" style="width:100%">
		
			<div class="card donor-border" style="border-style:solid; border-width:3px; border-radius:20px; border-color: black; margin: 0px 0px 0px 0px;">
      		<div class="card-content donor-text" style="height:100%;">
      				
     				   <form class="col s12" style="width:100%" id="register_form" method='post'>
                     
     					    <div class="row" style="padding:0% 3% 0 3%;margin:0;">
       						   <div class="input-field col s12 donor-text">
        							 <input placeholder="First Name" class='text' type="text" style="padding:0% 1% 1% 1%;font-size:20px; border-style:solid; border-width:thin;border-radius:5px" name="register_first_name" required data-error=".errorTxt1"/>
        						  <div class="errorTxt1 center-align" style="font-size:10px; color:red;">
                      </div>
        					   </div>
        			    </div>
                           
                  <div class="row" style="padding:2% 3% 0 3%;margin:0;">
       						 <div class="input-field col s12 donor-text">
        						<input placeholder="Last Name" class='text' type="text" style="padding:0% 1% 1% 1%;font-size:20px; border-style:solid; border-width:thin;border-radius:5px" name="register_last_name" required data-error=".errorTxt2"/>
        						<div class="errorTxt2 center-align" style="font-size:10px; color:red;">
                    </div>
        					 </div>
        				  </div>
        						
        					<div class="row" style="padding:2% 3% 0 3%;margin:0;">
       						 <div class="input-field col s12 donor-text">
        						<input placeholder="Email" class='text' type="email" style="padding:0% 1% 1% 1%;font-size:20px; border-style:solid; border-width:thin;border-radius:5px" name="register_email" required data-error=".errorTxt3"/>
        						<div class="errorTxt3 center-align" style="font-size:10px; color:red;">
                    </div>
        					 </div>
        					</div>
        						
        					<div class="row" style="padding:2% 3% 0 3%;margin:0;">
       						 <div class="input-field col s12 donor-text">
        						<input placeholder="Password" class='text' type="password" style="padding:0% 1% 1% 1%;font-size:20px; border-style:solid; border-width:thin;border-radius:5px" name="register_password" required data-error=".errorTxt4"/>
        						<div class="errorTxt4 center-align" style="font-size:10px; color:red;">
                    </div>
        					 </div>
        				  </div>
                    
                  <div class="center-align valign-wrapper" style="width:100%; padding:0 3% 0% 3%;">
                		<div class="input-field center-align" style="width:100%;">
                		   		
                      <button id="donationButton" style="width:100%;height:70px;font-size:25px"
                          class="g-recaptcha btn-large donor-background center-align submit"
                          data-sitekey="<?php print CAPTCHA_SITEKEY; ?>"
                          data-callback="onSubmit">
                          SIGN UP 
                      </button>
                    <div id='loginErrorText' style='margin-top:10px;color:red;'></div>
        				   </div>
        				  </div> 
        			</form>  

            </div>

            <div class="black-text container center-align" style="width:70%;border-radius:10px; font-weight:600;font-size:x-large;padding-bottom:10px;">
                Already have an account? <a href="user_login.php"><span class="blue-text">Sign in</span></a>
            </div>

            <script>
              function onSubmit(token) {
                $('#register_form').submit();
              }

              $().ready(function() {
                $("#register_form").validate({
                  rules: {
                    firstname: "required",
                    lastname: "required",
                    email: "required",
                  },
                messages: {
                      firstname: "this field is required",
                      lastname: "this field is required",
                      email: "this field is required",
                },

                errorElement : 'div',
                  errorPlacement: function(error, element) {
                      var placement = $(element).data('error');
                      if (placement) {
                        $(placement).append(error);
                      } else {
                        error.insertAfter(element);
                      }
                      grecaptcha.reset();
                  },
                    submitHandler: function(form) {
                      $.post( "user_save.php", $( "#register_form" ).serialize())
                        .done(function( data ) {
                          if (data == 'success') {
                            document.location = 'user_profile.php';
                          } else {
                            $( "#loginErrorText" ).html( data );
                            grecaptcha.reset();
                          }
                        });
                      }    
                });
              });
            </script>  
            
			 </div>
			
		</div>
	
	</div>
</div>


</div>

