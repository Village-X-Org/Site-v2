<div id="index-banner" class="parallax-container"
	style="background-color: rgba(0, 0, 0, 0.3); height: 800px">
	<div class="section no-pad-bot valign-wrapper"
		style="height: 100%; width: 100%;">
		<div class="container">
			<div class="row center">
				<h5
					class="header col s12 white-text light text-shadow: 4px 4px 7px #FFFFFF;">
					support the<br> <b>VILLAGE FUND</b>
				</h5>
			</div>
			<div class="row center">
				<a
					id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1 modal-trigger" href='village_fund_payment_view.php' 
					>Give Monthly</a>	
			</div>
			<br>
			<div class="row center">
				<h6
					class="header col s12 white-text light text-shadow: 4px 4px 7px #FFFFFF;" style="padding:0% 5% 0% 5%;">
					automatically donate to a project each<br> month, and enjoy impact
					updates all year long
				</h6>
			</div>
			<div class="row center">
				<h5
					class="header col s12 white-text light text-shadow: 4px 4px 7px #FFFFFF;">
					starting at</h5>
				<h3
					class="header col s12 white-text light text-shadow: 4px 4px 7px #FFFFFF;">
					$5</h3>
				<h5
					class="header col s12 white-text light text-shadow: 4px 4px 7px #FFFFFF;">
					/ month</h5>
			</div>	
				
	
	
				<!-- Modal Trigger -->
	<div class="center-align" style="padding: 5% 0% 0% 0%">
  
  <script>
	
  $(document).ready(function(){
	     $('.modal').modal();
	});
  </script>	
  <a class="modal-trigger" href="#cancelModal">(cancel a subscription)</a>
  	</div>

  <!-- Modal Structure -->
  <div id="cancelModal" class="modal">
    <div class="modal-content" id="jqueryvalidation">
     	<div class="container" style="width:100%">
         <p class="flow-text left-align black-text" style="padding:0% 10% 0% 10%">We are sorry to see you go, but you can re-join the Village Fund at any time by clicking on the "Give Monthly" button on the previous screen.</p>
        </div> 
        <div class="container center-align" id="jqueryvalidation" style="padding:0% 5% 0% 5%;">
        		<form id="cancelForm" method="get" action="cancelStripe.php" class="center-align">
            		<div class="row center-align">
            			<div class="col s12 m12 l12 center-align"> 					
            				<div class="input-field col s12 center-align">
            					<input placeholder="jane@gmail.com" id="cancellation_email" name="email" required data-error=".errorTxt3" style="font-size:20px; color:black;" type="email">
            					<div class="errorTxt3" style="font-size:10px; color:red; padding:1% 0% 0% 0%"></div>
            				</div>
                    </div> 	
                </div>
            
                <div class="row s12 m12 l12 center-align" style="padding:0% 0% 0% 0%;">
                		<div class="input-field">
                			<button id="submitBtn" class="btn-large red submit" type="submit" name="action" style="width:100%;">Cancel My Subscription</button>
            			</div>
            			<div class="progress" style='display:none;' id='cancelProgress'>
                      <div class="indeterminate"></div>
                  </div>
            		</div>
        		</form>		
    		</div>
	</div>	

	<script>
        	$().ready(function() {
        		// validate donatation form on keyup and submit
        		$("#cancelForm").validate({
        			rules: {
        				firstname: "required",
        				lastname: "required",
        				email: {
        			        required: true,
        			        // Specify that email should be validated
        			        // by the built-in "email" rule
        			        email: true
        			      },
        			},
        		messages: {
        		      firstname: "this field is required",
        		      lastname: "this field is required",
        		      email: "please enter a valid email address",
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
            		$('#cancelProgress').show();
            		$('#submitBtn').prop("disabled",true);
				$.get( "cancelStripe.php?email=" + $('#cancellation_email').val())
        			  .done(function(data) {
                  		$('#cancelProgress').hide();
                			$('#submitBtn').prop("disabled", false);
        				  	Materialize.toast(data, 4000); 
        				  	$('#cancelModal').modal('close');
        			  });
        		    }
        		});
        	});
	</script>
  </div>
  
			</div>
		</div>	

	<div class="parallax">
		<img src="images/footer1.jpg" alt="Unsplashed background img 2">
	</div>
</div>

<footer class="page-footer light blue">
	<div class="container">
		<div class="row">
			<div class="col l4 s12">
				<h6 class="white-text">
					<b><a class="white-text" href="index.php">Village X Org</a></b>
				</h6>
				<ul>
					<li><a class="white-text" href="project_tiles.php">Projects</a></li>
					<li><a class="white-text" href="map.php">Map</a></li>
					<li><a class="white-text" href="model.php">Model</a></li>
					<li><a class="white-text" href="impacts.php">Impacts</a></li>
					<li><a class="white-text" href="faq.php">FAQ</a></li>
					<li><a class="white-text" href="about.php">About</a></li>
				</ul>
			</div>

			<div class="col l4 s12">
				<h6 class="white-text">
					<b>Connect</b>
				</h6>
				<ul>
					<li><a class="white-text"
						href="https://www.instagram.com/villagexorg/" target="_blank"><i
							style="font-size: 15px" class="fa">&#xf16d;</i> Instagram</a></li>
					<li><a class="white-text"
						href="https://www.facebook.com/villagexorg/" target="_blank"><i
							style="font-size: 15px" class="fa">&#xf082;</i> Facebook</a></li>
					<li><a class="white-text"
						href="https://twitter.com/villagexorg" target="_blank"><i
							style="font-size: 15px" class="fa">&#xf081;</i> Twitter</a></li>
				</ul>
				
				<h6 class="white-text">
						<b>Share Our Mission</b>
					</h6>
					
					
						<a
							href="https://www.facebook.com/dialog/feed?
  									app_id=<?php print FACEBOOK_APP_ID; ?>
  									&display=popup&caption=This site disrupts extreme poverty in Africa
  									&link=<?php print BASE_URL; ?>"
							target="_blank"> <img
							src="https://simplesharebuttons.com/images/somacro/facebook.png"
							alt="Facebook" align="middle" height="30" width="30" />
						</a>
						&nbsp;&nbsp;&nbsp;
						<a
							href="https://twitter.com/share?url=<?php print BASE_URL; ?>;text=This site disrupts extreme Poverty in Africa&amp;hashtags=villagex"
							target="_blank"> <img
							src="https://simplesharebuttons.com/images/somacro/twitter.png"
							alt="Twitter" align="middle" height="30" width="30" />
						</a>
			
				<br><br>
			</div>
			

			<div class="col l4 s12">
				<h6 class="white-text">
					<b>Contact</b>
				</h6>
				<ul>
					<li><a class="white-text">Village X Org</a></li>
					<li><a class="white-text">3717 W Street NW</a></li>
					<li><a class="white-text">Washington, DC 20007</a></li>
					<li><a class="white-text">202&#65279;-360&#65279;-9931</a></li>
					<li><a class="white-text">chat@villagex.org</a></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="footer-copyright">
		<div class="container">
			<div class="row">
				<div class="col s12 m4 l4" align="left">
					<p style="line-height:1.5;">©Village X Org, 2017 <br>501(c)(3) nonprofit <br>EIN: 47&#65279;-1845825&#65279;</p>
				</div>
				<div class="col s12 m4 l4" align="left">
					<p style="line-height:1.5;"><b>Our technology disrupts extreme poverty with data and direct giving. Aiming to reach 390 million people in rural Africa.</b></p>
				</div>
				<div class="col s12 m4 l4" align="left">
					<p style="line-height:1.5;">
						<a href="tos.php">Terms of Service</a><br> <a href="privacy_policy.php">Privacy Policy</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</footer>

</body>

</html>