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
    background-image: url("images/newsletter_banner_2.jpg");

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

<div class="bg" style='height:100%;'>

<div class="container" style="padding:0 10% 0 10%">
	<div class="section" id="jqueryvalidation" style="width:100%">
		
			<div class="card donor-border" style="border-style:solid; border-width:3px; border-radius:20px; border-color: black; margin: 0px 0px 0px 0px;">
            		<div class="card-content donor-text" style="height:100%;">
<div class="black-text container flow-text center-align"><b>Ready.  Set.  Fundraise.</b></div>
            		
         				<div class="row donor-text" style="padding:2% 0% 0% 0%;">
          				
         				<form class="col s12" style="width:100%" id="fundraiser_form" method='post' action="fundraiser_save.php">
                         
         						<div class="row" style="padding:0% 3% 0 3%;margin:0;">
         						<div class="black-text" style="font-size:large; padding:0 0 0 3%"><b>1. FUNDRAISER NAME</b></div>
         						<div class="input-field col s12 donor-text">
          							<input placeholder="e.g., Sally's 25th Birthday" class='text' type="text" style="padding:0% 1% 0% 1%; font-size:20px; border-style:solid; border-width:thin;border-radius:5px" 
                        name="fundraiser_title" required data-error=".errorTxt1"/>
          							<div class="errorTxt1 center-align" style="padding:0 0 0% 0; font-size:10px; color:red;"></div>
          						</div>
          						
          						</div>
          						
          						
                             
                             <div class="row" style="padding:0% 3% 0 3%;margin:0;">
                             <div class="black-text" style="font-size:large; padding:0 0 0 3%"><b>2. CHOOSE A PROJECT</b></div>
                                <div class="input-field col s12 donor-text" style="padding:0% 3% 1% 3%; font-size:20px;">
            	                        <select name="fundraiser_project_id" required data-error=".errorTxt1">
            	                        	  <?php $result = doUnprotectedQuery("SELECT project_id, picture_filename, project_name, project_budget, project_funded, village_name 
                                            FROM projects JOIN pictures ON picture_id=project_profile_image_id JOIN villages ON village_id=project_village_id 
                                            WHERE project_funded < project_budget ORDER BY (project_funded / project_budget) ASC");
                                          while ($row = $result->fetch_assoc()) {
                                            $projectId = $row['project_id'];
                                            $pictureFilename = $row['picture_filename'];
                                            $projectName = $row['project_name'];
                                            $projectBudget = $row['project_budget'];
                                            $projectFunded = $row['project_funded'];
                                            $villageName = $row['village_name'];
                                            $percent = round(100 * $projectFunded / $projectBudget);
                                            $remaining = $projectBudget - $projectFunded;

                                            print "<option data-icon='uploads/$pictureFilename' class='left circle' value='$projectId'>$projectName in $villageName ($percent% funded, $$remaining needed)</option>";
                                          }
                                          ?>
                                      </select>
            	                     
	                 			</div>
	                 		
	                 			
	                 			</div>
	                 			
	                 			  
	                 			
	                 			<script>
	                 $(document).ready(function() {
	          		    $('select').material_select();
	          			});
	            	    </script>
	                 			
	                 		
              
                <div class="row valign-wrapper" style="padding:0% 3% 0 3%;">
                    <div class="col m6 s12">
                      <div class="black-text center-align" style="font-size:large; padding:0 0 0 3%"><b>3. FUNDING GOAL</b>
                      </div>
         							<i class="material-icons prefix left-align" style="font-size:30px">attach_money</i>
          						<input placeholder="350" class='donor-text' style="font-size:35px;width:80%;" name="fundraiser_amount"/>
          					</div>

          					
              			<div class="col m6 s12">
              				<div class="black-text center-align" style="font-size:large; padding:0 0 0 3%"><b>4. ENDING WHEN?</b>
                      </div>
              				<i class="material-icons prefix left-align" style="font-size:30px">date_range</i>
              				<input type="text" style="font-size:20px;width:80%;" class="datepicker" placeholder="e.g., March 20" name="fundraiser_deadline" id="end_date" required data-error=".errorTxt3">
                    </div>
                    
                    <div class="errorTxt3 center-align" style="font-size:10px; color:red;"></div>
                </div>
          		
          		
	          		<script>$('.datepicker').pickadate({
                    format: 'mm/dd/yyyy',
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
	          		<div class="black-text left-align" style="font-size:large; padding:0 0 0% 3%"><b>5. TELL YOUR STORY</b></div>
                                      
                      <div class="input-field col s12 donor-text" style="padding:0% 1% 0% 1%;height:50px;">
                        <textarea name="fundraiser_description" class="materialize-textarea" data-length="300" style="font-size:16px;" placeholder="OPTIONAL: Share what inspired you to fundraise."></textarea>
                      </div>
       
      				</div>   
	          		
          			
                              </div>
                        
                           <div class="center-align valign-wrapper hide-on-med-and-down" style="width:100%; padding:0 3% 0% 3%;">
                    		   <div class="input-field center-align" style="width:100%;">
                    		   		
                    				<button id="donationButton" class="btn-large donor-background center-align submit" type="submit" style="width:100%;height:70px;font-size:25px"> 
                    					Create Fundraiser 
                    				</button>
                    			</div>
                    			</div>
                    			
                    		<div class="center-align valign-wrapper hide-on-large-only" style="width:100%; padding:0 2% 0% 3%;">		
                    		   <div class="input-field center-align" style="width:100%;">	
                    				<button id="donationButton" class="btn-large donor-background center-align submit" type="submit" style="width:100%;height:70px;font-size:25px;"> 
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


</div>
