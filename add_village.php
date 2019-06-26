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
    background-image: url("images/globe_africa.jpg");

    /* Full height */

    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    
}


</style>
<?php include('header.inc'); ?>

<div class="bg" style="height:1400px;width:100%;padding-top:20px;">
	  <div class="white-text center-align" style="font-weight:800;padding:1% 0 1% 0;font-size:xx-large;text-shadow: black 0.1em 0.1em 0.4em;">Add your village to our map.
    </div>
		<div class="container center-align" id="jqueryvalidation" style='margin-top:20px;'>
      <div class="z-depth-8 grey lighten-4 row" style="display: inline-block; padding: 20px 5px 20px 30px; border: 4px solid #EEE;">
          				
         				<form class="col s12" style="width:100%" id="add_village_form" method='post' action="village_save.php">

         						<div class="row" style="padding:2% 14% 0 0%;margin:0;max-width:600px">
         						 <div class="black-text left-align" style="font-size:large; padding:0 0 0 3%"><b>YOUR NAME</b></div>
         						 <div class="input-field col s12 donor-text" style="padding:0% 0% 0% 3%; font-size:20px;">
         						 <i class="material-icons prefix">account_circle</i>
          							<input placeholder="e.g., Myson Jambo" class='donor-text' type="text" style="padding:0% 0% 0% 0%; font-size:20px;" 
                        id="village_advocate" required data-error=".errorTxt1"/>
          							<div class="errorTxt1 center-align" style="padding:0 0 0% 0; font-size:10px; color:red;"></div>
          					 </div>
          						
          					</div>
          					
          					<div class="row" style="padding:2% 14% 0 0%;margin:0;max-width:600px">
         						 <div class="black-text left-align" style="font-size:large; padding:0 0 0 3%"><b>YOUR EMAIL ADDRESS</b></div>
         						 <div class="input-field col s12 donor-text" style="padding:0% 0% 0% 3%; font-size:20px;">
         						 <i class="material-icons prefix">email</i>
          							<input placeholder="e.g., Myson Jambo" class='donor-text' type="email" style="padding:0% 0% 0% 0%; font-size:20px;" 
                        id="advocate_email" required data-error=".errorTxt1"/>
          							<div class="errorTxt1 center-align" style="padding:0 0 0% 0; font-size:10px; color:red;"></div>
          					 </div>
          						
          					</div>
          					
          					<div class="row" style="padding:2% 14% 0 0%;margin:0;max-width:600px">
          					<div class="black-text left-align" style="font-size:large; padding:0 0 0 3%"><b>YOUR TELEPHONE # (WHATSAPP IF POSSIBLE)</b></div>
          					<div class="input-field col s12 donor-text" style="padding:0% 0% 0% 3%; font-size:20px;">
          						<i class="material-icons prefix">phone</i>
          						<input id="advocate_phone" placeholder="[+] [country code] [phone number]"  type="tel" class="validate" style="padding:0% 0% 0% 0%; font-size:20px;" required data-error=".errorTxt1">
          						<div class="errorTxt1 center-align" style="padding:0 0 0% 0; font-size:10px; color:red;"></div>
          					</div>
     
       						 </div>
          						
          						<div class="row" style="padding:2% 14% 0 0%;margin:0;max-width:600px">
         						 <div class="black-text left-align" style="font-size:large; padding:0 0 0 3%"><b>VILLAGE NAME</b></div>
         						 <div class="input-field col s12 donor-text" style="padding:0% 0% 0% 3%; font-size:20px;">
          							<i class="material-icons prefix">location_on</i>
          							<input placeholder="e.g., Chimphepo Village" class='donor-text' type="text" style="padding:0% 0% 0% 0%; font-size:20px;" 
                        id="village_name" required data-error=".errorTxt1"/>
          							<div class="errorTxt1 center-align" style="padding:0 0 0% 0; font-size:10px; color:red;"></div>
          					 </div>
          						
          					</div>
                       		  
	                 			
	                 			<div class="row" style="padding:2% 14% 0 0%;margin:0;max-width:600px">
                    
                      <div class="black-text left-align" style="font-size:large; padding:0 0 0% 3%;"><b>VILLAGE POPULATION</b></div>
                     <div class="input-field col s12 donor-text" style="padding:0% 8% 0% 3%; font-size:20px;">
         							  <i class="material-icons prefix">group</i>
          						  <input placeholder="number of people (e.g., 1200)" type="number" class='donor-text' style="font-size:20px;width:100%;" id="village_pop" required data-error=".errorTxt2" />
          						<div class="errorTxt1 center-align" style="font-size:10px; color:red; padding:0 0 0% 9%"></div>
          						</div>
          					</div>
	                 			
	             
          					
          					<div class="row" style="padding:2% 0% 1% 0%;margin:0;max-width:600px">
          					<div class="black-text left-align" style="font-size:large; padding:0 0 2% 3%;"><b>PICTURES OF YOUR VILLAGE</b></div>
          					
    							<div class="file-field input-field s12 donor-text" style="padding:0 13% 0 2%;font-size:20px;"> 
      							
      							<div class="btn" style="background-color: Transparent;outline:none">
        							<i class="material-icons" style="color:black;font-size:20px">photo_library</i>
        							
        						<input type="file" multiple>
      						</div>
     			 			<div class="file-path-wrapper">
        							<input class="file-path validate" type="text" placeholder="click to upload pics" style="padding:0% 0% 0% 0%; font-size:20px;" id="village_pics" required data-error=".errorTxt2">
      						</div>
      						<div class="errorTxt1 center-align" style="font-size:10px; color:red;"></div>
    							</div>
    							
    							<div class="black-text center-align" style="max-width:600px;border-radius:10px; font-weight:600;padding: 0 10% 2% 5%;">
                				NOTE:  Your picture(s) must contain GPS coordinates.  Smartphones usually take pictures with GPS coordinates.
            					</div>
    							
    							</div>				
	          		
	          		<div class="row" style="padding:2% 0% 0% 0%;margin:0;max-width:600px">
	          		   <div class="black-text left-align" style="font-size:large; padding:0 0 0% 3%"><b>BIGGEST DEVELOPMENT PROBLEM</b>
                   </div>
                            
                      <div class="input-field col s12" style="padding:0% 13% 0% 3%;">
                      <i class="material-icons prefix">favorite</i>
                        <textarea id="village_prob" required class="materialize-textarea donor-text" style="font-size:20px;" data-length="300" placeholder="e.g., lack of clean water" data-error=".errorTxt2"></textarea>
  						<div class="errorTxt1 center-align" style="font-size:10px; color:red;"></div>
                      </div>
                 
                      
              </div>
					
                      
	          		
                           <div class="center-align valign-wrapper" style="width:100%; padding:0% 9% 1% 3%;max-width:600px">
                    		   <div class="input-field center-align" style="width:100%;">
                    		   		
                    				<button id="donationButton" class="btn-large donor-background center-align submit" type="submit" style="width:100%;height:70px;font-size:25px"> 
                    					Submit 
                    				</button>
                    			</div>
                    			</div>
                    			
            				   <div class="black-text center-align" style="max-width:600px;border-radius:10px; font-weight:600;padding: 0 10% 20px 5%;">
                If your picture has GPS coordinates, clicking this button will add your village to our map and take you to the map.  If your picture does not have GPS
                coordinates, an error message will appear.
            </div>
            				   
            				  
        </form>
			</div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('textarea#village_prob').characterCounter();
  });

  $().ready(function() {
    $("#add_village_form").validate({
      rules: {
    	  village_advocate: "required",
    	  advocate_phone: "required",
    	  village_name: "required",
    	  village_pop: "required",
    	  village_pics: "required",
        village_prob: "required"
      },
    messages: {
    	village_advocate: "this field is required",
    	advocate_phone: "this field is required",
    	village_name: "this field is required",
    		village_pop: "this field is required",
    		village_pics: "this field is required",
    		village_prob: "this field is required"
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
