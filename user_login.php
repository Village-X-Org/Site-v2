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
    z-index: -1;
  -webkit-transform: translate3d(0, 0, 0);
          transform: translate3d(0, 0, 0);
    
}
</style>
<?php
include('header.inc');
?>

<div class="bg" style='height:100%;'>

  <div class="container" style="padding:2% 10% 0 10%">

    <div class="white-text center-align" style="font-weight:800;font-size:xx-large;text-shadow: black 0.1em 0.1em 0.4em;">WELCOME BACK
    </div>
    <div class="white-text center-align" style="font-weight:500;font-size:large; font-stretch:condensed;text-shadow: black 0.1em 0.1em 0.6em;padding:0 0 2% 0">
      <span class="white-text">your profile. your impact. your fundraisers.</span>
    </div>
  
        
      <div class="card donor-border" style="border-style:solid; border-width:3px; border-radius:20px; border-color: black; margin: 20px 0px 20px 0px;">
          <div class="card-content donor-text" style="height:100%;">
              <form class="col s12" style="width:100%" id="login_form" method='post'>
                <div class="section" style="width:100%">
                  <input type='hidden' name='d' value=""/>
                  <input type='hidden' name='stripeToken' value='' /><input type='hidden' name='stripeEmail' value='' /><input type='hidden' name='stripeAmount' value='' />
                  <input type='hidden' name='isSubscription' value='' /><input type='hidden' name='firstName' value='' /><input type='hidden' name='lastName' value='' />
                  <input type='hidden' name='projectId' value='' /><input type='hidden' name='honoreeId' value='' /><input type='hidden' name='honoreeMessage' value='' />
                  
                  <div class="row" style="padding:2% 3% 0 3%;margin:0;">
                    <div class="black-text" style="font-size:large; padding:0 0 0 3%"><b>EMAIL</b>
                    </div>
                    <div class="input-field col s12 donor-text">
                        <input placeholder="enter your email address" class='email' type="email" style="padding:0% 1% 1% 1%;font-size:20px; border-style:solid; border-width:thin;border-radius:5px" id="login_email" name="login_email" required data-error=".errorTxt3"/>
                        <div class="errorTxt3 center-align" style="font-size:10px; color:red;">
                        </div>
                      </div>
                    </div>
                  </row>
                            
                  <div class="row" style="padding:2% 3% 0 3%;margin:0;">
                    <div class="black-text" style="font-size:large; padding:0 0 0 3%"><b>PASSWORD</b>
                    </div>
                    <div class="input-field col s12 donor-text">
                      <input placeholder="enter your password" class='text' type="password" style="padding:0% 1% 1% 1%;font-size:20px; border-style:solid; border-width:thin;border-radius:5px" id="login_password" required data-error=".errorTxt4" name="login_password" />
                      <div class="errorTxt4 center-align" style="font-size:10px; color:red;">
                      </div>
                    </div>
                  </div>
 
              </div>
                  
              <div class="center-align valign-wrapper" style="width:100%; padding:0 3% 0% 3%;">
                 <div class="input-field center-align" style="width:100%;">
                         
                      <button id="loginButton" style="width:100%;height:70px;font-size:25px"
                          class="g-recaptcha btn-large donor-background center-align submit"
                          data-sitekey="<?php print CAPTCHA_SITEKEY; ?>"
                          data-callback="onSubmit">
                          SIGN IN 
                      </button>
                    <div id='loginErrorText' style='margin-top:10px;color:red;'></div>
                 </div>    
             </div>
          </div>
        </form>
        <script>
            function onSubmit(token) {
                $('#login_form').submit();
            }

            $().ready(function() {
                $("#login_form").validate({
                    rules: {
                        email: "required",
                        password: "required",
                        
                    },
                messages: {
                      email: "a valid email address is required",
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
                      grecaptcha.reset();
                 },
                submitHandler: function(form) {
                    $.post( "user_check.php", $( "#login_form" ).serialize())
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
             
        <div class="black-text container center-align" style="font-weight:400;font-size:x-large;padding:2% 0 0% 0">
          Don't have an account? <a href="user_register.php"><span class="blue-text" style='font-weight:bold;'>Sign up</span></a>
        </div>
                               
        <div class="black-text center-align" style="padding:1% 0 1% 0; width:100%;font-weight:400;font-size:x-large;">
          Forgot your password? <a class='modal-trigger blue-text' style='font-weight:bold;' href="#passwordModal">Reset it</a>
        </div>              
      </div> 
    </div>
  </div>               
</div>      

  <div id="passwordModal" class="modal">
    <div class="modal-content">
        <div class="container" style="width: 100%">
            <p class="flow-text left-align black-text"
                style="padding: 0% 10% 0% 10%">No worries.  We'll send you an email with instructions for resetting your password.  Please enter your email below.</p>
        </div>
        <div class="container center-align"
            style="padding: 0% 5% 0% 5%;">
            <form id="resetPassword_form" method="get" class="center-align">
                <div class="row center-align">
                    <div class="col s12 m12 l12 center-align">
                        <div class="input-field col s12 center-align">
                            <input placeholder="jane@gmail.com" id="resetPW_email"
                                name="email" required data-error=".errorTxt3"
                                style="font-size: 20px; color: black;" type="email">
                            <div class="errorTxt3"
                                style="font-size: 10px; color: red; padding: 1% 0% 0% 0%">
                              </div>
                        </div>
                    </div>
                </div>

                <div class="row s12 m12 l12 center-align"
                    style="padding: 0% 0% 0% 0%;">
                    <div class="input-field">
                        <button id="submitBtn" class="btn-large red submit" type="submit"
                            name="action" style="width: 100%;">Reset My Password</button>
                    </div>
                    <div class="progress" style='display: none;' id='cancelProgress'>
                        <div class="indeterminate"></div>
                    </div>
                </div>
            </form>
        </div>     
    </div>
  </div>      
                    
</body>