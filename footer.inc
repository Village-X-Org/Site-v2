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

				<div id="subscriptionModal" class="modal" style='color:black;'>
					<div class="modal-content">
						<h4>Give Monthly</h4>
						<p>A bunch of text</p>
					</div>
					<div class="modal-footer">
						<div class='row'>
							<div class='col'>
								$ <input type='text' id='footerAmountText' value='20' />
							</div>
							<div class='col'>
                        			<button id="customButton">Subscribe!</button>
                        		</div>
                        </div>
                        <script>

                        document.getElementById('customButton').addEventListener('click', function(e) {
                          // Open Checkout with further options:
                          handler.open({
                            name: 'Village X Org',
                            description: 'Monthly Subscription',
                            amount: $('#footerAmountText').val() * 100
                          });
                          e.preventDefault();
                        });
                        </script>
					</div>
				</div> --->
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
					
				<br><br><br>
	
	
				<!-- Modal Trigger -->
	<div style="padding: 20% 0% 0% 0%">
  <script>
	
  $(document).ready(function(){
	     $('.modal').modal({
	      dismissible: true, // Modal can be dismissed by clicking outside of the modal
	      opacity: .5, // Opacity of modal background
	      inDuration: 300, // Transition in duration
	      outDuration: 200, // Transition out duration
	      startingTop: '4%', // Starting top style attribute
	      endingTop: '10%', // Ending top style attribute
	   });
	});
  </script>	
  <a class="modal-trigger" href="#modal1"><i>cancel a subscription</i></a>
  	</div>

  <!-- Modal Structure -->
  <div id="modal1" class="modal modal-fixed-footer" style="border-style:solid; border-width:1px; border-color:blue; border-radius:20px;">
    <div class="modal-content">
      <h4 class="flow-text black-text" style="padding:10% 5% 0% 5%"><b>Subscription Cancellation</b></h4>
      <p class="flow-text left-align black-text" style="padding:0% 10% 0% 10%">To cancel your subscription, please enter your email address below and click on the "Submit" button.</p>
      <p class="flow-text left-align black-text" style="padding:0% 10% 0% 10%">We are sorry to see you go, but you can rejoin the Village Fund at any time by clicking on the "Give Monthly" button on the previous screen.</p>
    
    <div class="section" id="jqueryvalidation" style="display:table; width:100%; padding:0% 10% 0% 10%">
		<form style="width:100%" id="donateForm" method="get" action="">
		<div class="col-project valign-wrapper" style="vertical-align: middle;">
			
         					<div class="row" style="padding:3% 3% 3% 3%; width:100%">
         						<div class="input-field col s12 m12 l12 center-align">
         							<i class="material-icons prefix" style="font-size:20px;">email&nbsp;&nbsp;</i>
          							<input placeholder="jane@gmail.com" id="email" name="email" data-error=".errorTxt1" style="font-size:20px; color:blue;" id="email" type="email">
          							<div class="errorTxt1"></div>
          						</div>
							</div>
         </div>	   
         <div class="col-project valign-wrapper" style="vertical-align: middle; width:100%">
        			<div class="input-field col s12 m12 l12">
        			<button id="myBtn" class="btn-large center-align waves-effect waves-light light-blue submit" type="submit" name="action" style="width:100%;">Submit</button>
				</div>

	<script>
document.getElementById("myBtn").onclick = function() {gotoStripe()};
				
	<script type="text/javascript">

	$().ready(function() {
		// validate donatation form on keyup and submit
		$("#donateForm").validate({
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
            $(placement).append(error)
          } else {
            error.insertAfter(element);
          }
        }	
		});
	});
	</script>
				</div>
              </form>
			
		</div>
	</div>	
    
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close light-blue waves-effect waves-blue btn-flat ">close</a>
    </div>
  </div>
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
  									&link=https://www.4and.me"
							target="_blank"> <img
							src="https://simplesharebuttons.com/images/somacro/facebook.png"
							alt="Facebook" align="middle" height="30" width="30" />
						</a>
						&nbsp;&nbsp;&nbsp;
						<a
							href="https://twitter.com/share?url=https://www.4and.me;text=This site disrupts extreme Poverty in Africa&amp;hashtags=villagex"
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