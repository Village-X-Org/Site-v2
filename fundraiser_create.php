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
    background-attachment: scroll; 
    
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    
}


</style>
<?php include('header.inc'); ?>

<div class="bg" style="background-color: rgba(0, 0, 0, 0.2); height: 1000px; width:100%">

<div class="container" style="padding:0 2% 0 2%; width:100%;">
	<div class="section" id="jqueryvalidation" style="width:100%">
		    <div class="white-text center-align" style="font-weight:800;padding:2% 0 2% 0;font-size:xx-large;text-shadow: black 0.1em 0.1em 0.4em;">Ready.  Set.  Fundraise.
    </div>
			<div class="card donor-border" style="border-style:solid; border-width:3px; border-radius:20px; border-color: black; margin: 0px 0px 0px 0px;">
            		<div class="card-content donor-text" style="height:100%;">
            		
         				<div class="row donor-text" style="padding:2% 0% 0% 0%;">
          				
         				<form class="col s12" style="width:90%" id="fundraiser_form" method='post' action="fundraiser_save.php">

         						<div class="row" style="padding:0 3% 0 3%;margin:0;">
         						 <div class="black-text" style="font-size:large; padding:0 0 0 3%"><b>FUNDRAISER NAME</b></div>
         						 <div class="input-field col s12 donor-text" style="padding:0% 3% 0% 3%; font-size:20px;">
          							<input placeholder="e.g., Sally's 25th Birthday" class='text' type="text" style="padding:0% 0% 0% 0%; font-size:20px;" 
                        name="fundraiser_title" required data-error=".errorTxt1"/>
          							<div class="errorTxt1 center-align" style="padding:0 0 0% 0; font-size:10px; color:red;"></div>
          					 </div>
          						
          					</div>
          						
          						
                             
                             <div class="row" style="padding:2% 3% 0 3%;margin:0;">
                             <div class="black-text" style="font-size:large; padding:0 0 0 3%"><b>CHOOSE A PROJECT</b></div>
                                <div class="input-field col s12 donor-text" style="padding:0% 3% 0% 3%; font-size:20px;">
            	                        <select name="fundraiser_project_id">
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
	                 			
	                 		
              
                <div class="row" style="padding:2% 3% 0 4%">
                    <div class="col l6 m12 s12" style="padding:0% 0% 0 2%">
                      <div class="black-text left-align" style="font-size:large; padding:0 0% 3% 3%"><b>FUNDING GOAL?</b>
                      </div>
                      	<div style="padding:2% 0% 0 0%">
         							<i class="material-icons prefix left-align" style="font-size:30px;">attach_money</i>
          						<input placeholder="350" class='donor-text' style="font-size:25px;width:80%;" name="fundraiser_amount" required data-error=".errorTxt2" />
          						</div>
                    <div class="errorTxt2 center-align" style="font-size:10px; color:red;"></div>
          					</div>

          					
              			<div class="col l6 m12 s12" style="padding:0% 0% 0 2%">
              				<div class="black-text left-align" style="font-size:large; padding:0% 0 3% 3%"><b>ENDING WHEN?</b>
                      </div>
                      <div style="padding:2% 0% 0 0%">
              				  <i class="material-icons prefix left-align" style="font-size:30px;">date_range</i>
              				  <input type="text" style="font-size:20px;width:80%;" class="datepicker" placeholder="e.g., March 20" name="fundraiser_deadline" id="end_date" required data-error=".errorTxt3" />
                    	</div>
                      <div class="errorTxt3 center-align" style="font-size:10px; color:red;"></div>
                    </div>
                    
                </div>
          		
          		
	          		<script>$('.datepicker').pickadate({
                    format: 'yyyy-mm-dd',
	          		    selectMonths: true,
	          		    selectYears: 2,
	          		    clear: 'Clear',
	          		    close: 'Select',
	          		    today: '',
                        min: new Date(),
	          		    closeOnSelect: true
	          		  });
	          		</script>
	          		
	          		<div class="row" style="padding:1% 3% 0% 5%;">
	          		   <div class="black-text" style="font-size:large; padding:0 0 0% 2%"><b>TELL YOUR STORY</b>
                   </div>
                                   
                      <div class="input-field col s12" style="padding:1% 1% 0% 2%;">
                        <textarea name="fundraiser_description" class="materialize-textarea donor-text" data-length="300" style="font-size:20px;" placeholder="optional: what inspired you?"></textarea>
                      </div>
              
      				  </div>

                    <?php if (!$session_donor_id) { ?>
                      <div class="row" style="padding:1% 3% 0% 5%;">
                        <div class="black-text" style="font-size:large; padding:0 0 0 2%" >Contact Email:
                        </div> 
                        <div class="input-field col s12 donor-text" style="padding:0% 3% 0% 2%; font-size:20px;">
                          <input class='text' name="fundraiser_email" placeholder="How can we reach you?" style="padding:0% 0% 0% 0%;" required data-error=".errorTxt4" />
                          <div class="errorTxt4 center-align" style="padding:0 0 0% 0; font-size:10px; color:red;">
                          </div>
                        </div>
                      </div>
                    <?php } ?>   
	          		
          			
                              </div>
                        
                           <div class="center-align hide-on-med-and-down valign-wrapper" style="width:100%; padding:0% 3% 1% 3%">
                    		   <div class="input-field center-align" style="width:100%;">
                    		   		
                    				<button id="donationButton" class="btn-large donor-background center-align submit" type="submit" style="width:100%;height:70px;font-size:25px"> 
                    					Create Fundraiser 
                    				</button>
                    			</div>
                    			</div>
                    			
                    		<div class="center-align hide-on-large-only valign-wrapper" style="width:100%; padding:7% 3% 1% 3%;">		
                    		   <div class="input-field center-align" style="width:100%;">	
                    				<button id="donationButton" class="btn-large donor-background center-align submit" type="submit" style="width:70%;height:70px;font-size:25px;"> 
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
				fundraiser_title: "required",
        fundraiser_amount: "required",
				fundraiser_deadline: "required"<?php print (!$session_donor_id ? ", fundraiser_email: { required: true, email: true}" : ""); ?>
			},
		messages: {
		      fundraiser_title: "this field is required",
		      fundraiser_amount: "this field is required",
		      fundraiser_deadline: "this field is required"<?php print (!$session_donor_id ? ", \"a valid email is required\"" : ""); ?>
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


</div>
