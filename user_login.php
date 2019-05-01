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
<?php
include('header.inc');
?>

<div class="bg" style='height:1100px;width:100%'>
<div class="valign-wrapper" style="height:100%">
  <div class="section" style="width:100%;">

    <div class="white-text center-align" style="font-weight:800;font-size:xx-large;text-shadow: black 0.1em 0.1em 0.2em">WELCOME BACK
    </div>
    <div class="center-align" style="font-weight:500;font-size:medium;text-shadow: black 0.1em 0.1em 0.2em">
      <span class="white-text">your profile. your impact. your fundraisers.</span>
    </div>
       

      <div class="section center-align" style="width:100%">
        <div class="z-depth-8 grey lighten-4 row" style="display: inline-block; padding: 20px 40px 0px 40px; border: 4px solid #EEE;">
              <form class="col s12" style="width:100%" id="login_form" method='post'>
                
                  <div class="row" style="padding:5% 0% 0 0%; width:300px">
                    <div class="black-text left-align" style="font-size:large; padding:0 0 0 4%"><b>EMAIL</b>
                    </div>
                    <div class="input-field col s12 donor-text">
                        <input placeholder="enter your email address" class='email' type="email" style="padding:0% 0% 0% 0%;font-size:18px;" id="login_email" name="login_email" required data-error=".errorTxt3"/>
                        <div class="errorTxt3 center-align" style="font-size:10px; color:red;">
                        </div>
                      </div>
                  </div>
                            
                  <div class="row" style="padding:1% 0% 0 0%;width:300px;">
                    <div class="black-text left-align" style="font-size:large; padding:0 0 0 4%"><b>PASSWORD</b>
                    </div>
                    <div class="input-field col s12 donor-text">
                      <input placeholder="enter your password" class='text' type="password" style="padding:0% 0% 0% 0%;font-size:18px;" id="login_password" required data-error=".errorTxt4" name="login_password" />
                      <div class="errorTxt4 center-align" style="font-size:10px; color:red;">
                      </div>
                    </div>
                  </div>
                    
                     <div class="input-field center-align" style="width:100%;padding:0 0 2% 0%">
                             
                          <button id="loginButton" style="width:100%;height:50px;font-size:20px"
                              class="g-recaptcha btn-large donor-background center-align submit"
                              data-sitekey="<?php print CAPTCHA_SITEKEY; ?>"
                              data-callback="onSubmit">
                              SIGN IN 
                          </button>
                        <div id='loginErrorText' style='margin-top:10px;color:red;'></div>
                     </div>    
                  
                
            </form>
          <div class="section" style="height:100%;padding:4% 0 0% 0">
          <div class="black-text center-align" style="font-weight:400;">
            No account yet? <a href="user_register.php"><span class="blue-text" style='font-weight:bold;'>Sign up</span></a>
          </div>
                               
          <div class="black-text center-align" style="padding:2% 0 10% 0; width:100%;font-weight:400;">
            Forgot your password? <a class='modal-trigger blue-text' style='font-weight:bold;' href="#passwordModal">Reset it</a>
          </div>  
          </div> 
          </div>  
          </div>         
        </div> 
        
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
                              if (data === 'success') {
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

  <div id="passwordModal" class="modal">
    <div class="modal-content">
        <div class="container" style="width: 100%">
            <p class="flow-text left-align black-text"
                style="padding: 0% 10% 0% 10%">No worries.  We'll send you an email with instructions for resetting your password.  Please enter your email below.</p>
        </div>
        <div class="container center-align"
            style="padding: 0% 5% 0% 5%;">
            <form id="reset_password_form" method="get" class="center-align">
                <div class="row center-align">
                    <div class="col s12 m12 l12 center-align">
                        <div class="input-field col s12 center-align">
                            <input placeholder="jane@gmail.com" id="reset_password_email"
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
                      <button id="resetButton" style="width:100%;height:70px;font-size:25px"
                          class="g-recaptcha btn-large red center-align submit"
                          data-sitekey="<?php print CAPTCHA_SITEKEY; ?>"
                          data-callback="onReset">
                          Reset My Password
                      </button>
                    </div>
                    <div class="progress" style='display: none;' id='cancelProgress'>
                        <div class="indeterminate"></div>
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div>
      <div id='passwordResetConfirmation' class='modal'>
        <div class="modal-content"> 
            <h4>Account Found!</h4>
            <p>An email with instructions has been mailed to the address you provided.</p>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-green btn-flat donor-background white-text" style='text-transform:none;'>Sounds good!</a>
        </div>
      </div>

      <div id='passwordResetFailed' class='modal'>
        <div class="modal-content"> 
            <h4>There was a problem...</h4>
            <p>We could not find the supplied email in our system.</p>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-green btn-flat donor-background">Ok</a>
        </div>
      </div>

    <script>
    function onReset(token) {
      $("#reset_password_form").submit();
    }
    $().ready(function() {
      $('.modal').modal();

      $("#reset_password_form").validate({
        rules: {
          email: "required",
          
        },
      messages: {
            email: "a valid email address is required"
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
            $.post( "user_resetPassword.php", $( "#reset_password_form" ).serialize())
                .done(function( data ) {
                  if (data == 'success') {
                    $('#passwordModal').modal('close');
                    $("#passwordResetConfirmation").modal('open');
                  } else {
                    
                    $('#passwordModal').modal('close');
                    $("#passwordResetFailed").modal('open');
                  }
            });
          } 
      });
    });
  </script>
                    
</body>