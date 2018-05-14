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
    margin: 0;
}

.bg {
    /* The image used */
    background-image: url("images/sunflowers.jpg");

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

<div class="container" style="padding:0 15% 0 15%">
<div class="black-text container center-align" style="font-weight:800;font-size:xx-large">SIGN UP TODAY</div>
<div class="black-text container center-align" style="font-weight:500;font-size:medium;text-shadow: black 0.1em 0.1em 0.2em"><span class="blue-text">your profile. your impact. your fundraisers.</span></div>  <!-- make this conditional on a user coming from the fundraiser page -->
	<div class="section" id="jqueryvalidation" style="width:100%">
		
			<div class="card donor-border" style="border-style:solid; border-width:3px; border-radius:20px; border-color: black; margin: 0px 0px 0px 0px;">
            		<div class="card-content donor-text" style="height:100%;">
            		
        
         				<div class="row donor-text" style="padding:5% 0% 0% 0%;">
          				
         				<form class="col s12" style="width:100%" id="signup_form" method='post' action="">
                         
         						<div class="row" style="padding:0% 3% 0 3%;margin:0;">
         						<div class="black-text" style="font-size:large; padding:0 0 0 3%"><b>FIRST NAME</b></div>
         						<div class="input-field col s12 donor-text">
          							<input placeholder="enter your first name" class='text' type="text" style="padding:0% 1% 1% 1%;font-size:20px; border-style:solid; border-width:thin;border-radius:5px" id="signup_first_name" required data-error=".errorTxt1"/>
          							<div class="errorTxt1 center-align" style="font-size:10px; color:red;"></div>
          						</div>
          						</div>
                             
                             <div class="row" style="padding:2% 3% 0 3%;margin:0;">
         						<div class="black-text" style="font-size:large; padding:0 0 0 3%"><b>LAST NAME</b></div>
         						<div class="input-field col s12 donor-text">
          							<input placeholder="enter your last name" class='text' type="text" style="padding:0% 1% 1% 1%;font-size:20px; border-style:solid; border-width:thin;border-radius:5px" id="signup_last_name" required data-error=".errorTxt2"/>
          							<div class="errorTxt2 center-align" style="font-size:10px; color:red;"></div>
          						</div>
          						</div>
          						
          						<div class="row" style="padding:2% 3% 0 3%;margin:0;">
         						<div class="black-text" style="font-size:large; padding:0 0 0 3%"><b>EMAIL</b></div>
         						<div class="input-field col s12 donor-text">
          							<input placeholder="enter your email address" class='text' type="email" style="padding:0% 1% 1% 1%;font-size:20px; border-style:solid; border-width:thin;border-radius:5px" id="signup_email" required data-error=".errorTxt3"/>
          							<div class="errorTxt3 center-align" style="font-size:10px; color:red;"></div>
          						</div>
          						</div>
          						
          						<div class="row" style="padding:2% 3% 0 3%;margin:0;">
         						<div class="black-text" style="font-size:large; padding:0 0 0 3%"><b>PASSWORD</b></div>
         						<div class="input-field col s12 donor-text">
          							<input placeholder="create a password" class='text' type="password" style="padding:0% 1% 1% 1%;font-size:20px; border-style:solid; border-width:thin;border-radius:5px" id="signup_password" required data-error=".errorTxt4"/>
          							<div class="errorTxt4 center-align" style="font-size:10px; color:red;"></div>
          						</div>
          						</div>
       
       
          				
                             
                              
                              </div>
                        
                           <div class="center-align valign-wrapper" style="width:100%; padding:0 3% 0% 3%;">
                    		   <div class="input-field center-align" style="width:100%;">
                    		   		
                    				<button id="donationButton" class="btn-large donor-background center-align submit" type="submit" style="width:100%;height:70px;font-size:25px"> 
                    					SIGN UP 
                    				</button>
            				   </div>
            				   </div>
            				   </div>
            				  
              			</form>
<script>
	$().ready(function() {
		$("#signup_form").validate({
			rules: {
				firstname: "required",
				lastname: "required",
				email: "required",
			},
		messages: {
		      firstname: "this field is required",
		      lastname: "this field is required",
		      end_date: "this field is required",
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
        	$.post( "travel_request_info.php", $( "#fundraiser_form" ).serialize())
        			.done(function( data ) {
					$( "#travelInfoRequestDiv" ).html( data );
					document.getElementById("travelInfoRequestDiv").scrollIntoView();
			});
        }	
		});
	});
</script>

        			</div>
			</div>
			
			<div class="black-text container center-align" style="width:70%;border-radius:10px; font-weight:600;font-size:x-large;">Already have an account? <a href=""><span class="blue-text">Sign in</span></a></div>
			
		</div>
	
	</div>
</div>


</div>

