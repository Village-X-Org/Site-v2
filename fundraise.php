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
    background-image: url("images/namphungo_teacher_house.jpg");

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
<div class="white-text container flow-text center-align"><b>READY.  SET.  FUNDRAISE.</b></div>
	<div class="section" id="jqueryvalidation" style="width:100%">
		
			<div class="card donor-border" style="border-style:solid; border-width:3px; border-radius:20px; border-color: black; margin: 0px 0px 0px 0px;">
            		<div class="card-content donor-text" style="height:100%;">
            		
         				<div class="row donor-text" style="padding:5% 0% 0% 0%;">
          				
         				<form class="col s12" style="width:100%" id="fundraiser_form" method='post' action="">
                         
         						<div class="row" style="padding:0% 3% 0 3%;margin:0;">
         						<div class="black-text" style="font-size:large; padding:0 0 0 3%"><b>1. FUNDRAISER NAME</b></div>
         						<div class="input-field col s12 donor-text">
          							<input placeholder="e.g., Sally's 25th Birthday" class='text' type="text" style="padding:0% 1% 1% 1%; font-size:20px; border-style:solid; border-width:thin;border-radius:5px" id="campaign_name" required data-error=".errorTxt1"/>
          							<div class="errorTxt1 center-align" style="padding:0 0 3% 0; font-size:10px; color:red;"></div>
          						</div>
          						
          						</div>
          						
          						
                             
                             <div class="row" style="padding:2% 3% 0 3%;margin:0;">
                             <div class="black-text" style="font-size:large; padding:0 0 0 3%"><b>2. CHOOSE A PROJECT</b></div>
                                <div class="input-field col s12 donor-text" style="padding:0% 8% 1% 8%; font-size:20px;">
            	                        <select name='projectSelect' id="project_choice" required data-error=".errorTxt1">
            	                        	  
            	                          <option data-icon="images/borehole_donors.jpg" class="left circle truncate">Start a Goat Herd in Saiti (20% funded)</option>
            	                          <option data-icon="images/building_school.jpg" class="left circle">Provide Clean Water in Mlenga (30% funded)</option>
            	                          <option data-icon="images/building_school.jpg" class="left circle">Build a Nursery School in Likoswe (10% funded)</option>
            	                          <option data-icon="images/building_school.jpg" class="left circle">Grow More Food in Kazembe (60% funded)</option>
            	                        </select>
            	                     
	                 			</div>
	                 			
	                 			<div class="center-align black-text" style="font-size: small;">This project needs $____.</div>
	                 			
	                 			</div>
	                 			
	                 			  
	                 			
	                 			<script>
	                 $(document).ready(function() {
	          		    $('select').material_select();
	          			});
	            	    </script>
	                 			
	                 		
              
                            <div class="row valign-wrapper hide-on-med-and-down" style="padding:7% 3% 0 3%;">
                            <div class="col s6">
                            <div class="black-text center-align" style="font-size:large; padding:0 0 0 3%"><b>3. FUNDING GOAL</b></div>
         						<div class="input-field col s12 donor-text">	
         							<i class="material-icons prefix left-align" style="font-size:30px">attach_money</i>
          							<input placeholder="350" class='donor-text' style="font-size:35px;" id="campaign_goal"/>
          						</div>
          					
          					</div>
          					
          					<div class="col s6">
          					<div class="black-text center-align" style="font-size:large; padding:0 0 0 3%"><b>4. ENDING WHEN?</b></div>
          						<div class="input-field col s12">	
          							<i class="material-icons prefix left-align" style="font-size:30px">date_range</i>
	          						<input type="text" style="font-size:20px;" class="datepicker" placeholder="e.g., March 20" name="fundraiserEndDate" id="end_date" required data-error=".errorTxt3">
          						</div>
          						<div class="errorTxt3 center-align" style="font-size:10px; color:red;"></div>
          					</div>
          					</div>
          					
          					
          					<div class="row valign-wrapper hide-on-large-only" style="padding:7% 3% 0 3%;">
                            <div class="col s12">
                            <div class="black-text left-align" style="font-size:large; padding:0 0 0 3%"><b>3. FUNDING GOAL</b></div>
         						<div class="input-field col s12 donor-text">	
         							<i class="material-icons prefix left-align" style="font-size:30px">attach_money</i>
          							<input placeholder="350" class='donor-text' style="font-size:35px;" id="campaign_goal"/>
          						</div>
          					
          					</div>
          					</div>
          					
          					<div class="row valign-wrapper hide-on-large-only" style="padding:7% 3% 0 3%;">
          					<div class="col s12">
          					<div class="black-text left-align" style="font-size:large; padding:0 0 0 3%"><b>4. ENDING WHEN?</b></div>
          						<div class="input-field col s12">	
          							<i class="material-icons prefix left-align" style="font-size:30px">date_range</i>
	          						<input type="text" style="font-size:20px;" class="datepicker" placeholder="e.g., March 20" name="fundraiserEndDate" id="end_date" required data-error=".errorTxt3">
          						</div>
          						<div class="errorTxt3 center-align" style="font-size:10px; color:red;"></div>
          					</div>
          					</div>
          		
          		
	          		<script>$('.datepicker').pickadate({
	          		    selectMonths: true,
	          		    selectYears: 2,
	          		    clear: 'Clear',
	          		    close: 'Select',
	          		    today: '',
                        min: new Date(),
	          		    closeOnSelect: true
	          		  });
	          		</script>
	          		
	          		<div class="row" style="padding:0 5% 0 5%;margin:0;">
	          		<div class="black-text center-align hide-on-med-and-down" style="font-size:large; padding:0 0 0% 3%"><b>5. TELL YOUR STORY</b></div>
	          		<div class="black-text left-align hide-on-large-only" style="font-size:large; padding:0 0 0% 3%"><b>5. TELL YOUR STORY</b></div>
        							<div class="input-field col s12 donor-text hide-on-med-and-down" style="padding:0% 1% 0% 1%;">
         						 	<textarea id="describe_fundraiser" class="materialize-textarea" data-length="300" style="font-size:20px;" placeholder="OPTIONAL: Add a few sentences about what inspired you and why people should give."></textarea>
        							</div>
        							<div class="input-field col s12 donor-text hide-on-large-only" style="padding:0% 1% 0% 1%;">
         						 	<textarea id="describe_fundraiser" class="materialize-textarea" data-length="300" style="font-size:16px;" placeholder="OPTIONAL: Share what inspired you to fundraise."></textarea>
        							</div>
        							
        							<script>$(document).ready(function(){

        								  //This does set the label to the active position.
        								  setTimeout(function(){ $('.input-field label').addClass('active'); }, 1);
        								  
        								});</script>
        							
      				</div>   
	          		
          			
                              </div>
                        
                           <div class="center-align valign-wrapper hide-on-med-and-down" style="width:100%; padding:0 3% 0% 3%;">
                    		   <div class="input-field center-align" style="width:100%;">
                    		   		
                    				<button id="donationButton" class="btn-large donor-background center-align submit" type="submit" style="width:100%;height:70px;font-size:25px"> 
                    					Create Fundraiser 
                    				</button>
                    			</div>
                    			</div>
                    			
                    		<div class="center-align valign-wrapper hide-on-large-only" style="width:100%; padding:0 3% 0% 3%;">		
                    		   <div class="input-field center-align" style="width:100%;">	
                    				<button id="donationButton" class="btn-large donor-background center-align submit" type="submit" style="width:100%;height:70px;font-size:25px"> 
                    					Create 
                    				</button>
            				   </div>
            				   </div>
            				   </div>
            				  
              			</form>
<script>
	$().ready(function() {
		$("#fundraiser_form").validate({
			rules: {
				firstname: "required",
				lastname: "required",
				end_date: "required",
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
		</div>
	
	</div>
</div>


</div>
