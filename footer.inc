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
				<script>
                		$(document).ready(function(){
                    		$('.modal').modal();
                  	});
                </script>
				<div id="subscriptionModal" class="modal" style='color:black;'>
					<div class="modal-content">
						<h4>Give Monthly</h4>
						<p>A bunch of text</p>
					</div>
					<div class="modal-footer">
						<div class='row'>
							<div class='col'>
								$ <input type='text' id='amountText' value='20' />
							</div>
							<div class='col'>
                        			<button id="customButton">Subscribe!</button>
                        		</div>
                        </div>
                        <script>
                        var handler = StripeCheckout.configure({
                          key: 'pk_test_AXxdOsB0Xz9tOVdCVq8jpkAQ',
                          image: 'https://s3.amazonaws.com/stripe-uploads/acct_14tfQ6EfZscNLAofmerchant-icon-1414779028120-Screen%20Shot%202014-09-29%20at%2012.21.02%20PM.png',
                          locale: 'auto',
                          token: function(token) {
                        	  $.post("subscribe.php", {
                			        stripeToken: token.id,
                			        stripeEmail: token.email,
                			        stripeAmount: $('#amountText').val() * 100
                			    },
                			    function(data, status) {
                			    	 	Materialize.toast(data, 4000);
                			    });
                          }
                        });
                        
                        document.getElementById('customButton').addEventListener('click', function(e) {
                          // Open Checkout with further options:
                          handler.open({
                            name: 'Village X Org',
                            description: 'Monthly Subscription',
                            amount: $('#amountText').val() * 100
                          });
                          e.preventDefault();
                        });
                        
                        // Close Checkout on page navigation:
                        window.addEventListener('popstate', function() {
                          handler.close();
                        });
                        </script>
					</div>
				</div>
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
					<p style="line-height:1.5;"><b>Our technology disrupts extreme poverty by democratizing local development. Aiming to reach 390 million people in rural Africa.</b></p>
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

<!-- jQuery Library -->
    <script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>    
    <!--angularjs-->
    <script type="text/javascript" src="js/plugins/angular.min.js"></script>
    <!--materialize js-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--prism -->
    <script type="text/javascript" src="js/plugins/prism/prism.js"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <!-- chartist -->
    <script type="text/javascript" src="js/plugins/chartist-js/chartist.min.js"></script>
    
    <!-- chartist -->
    <script type="text/javascript" src="js/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="js/plugins/jquery-validation/additional-methods.min.js"></script>
    
    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="js/plugins.min.js"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="js/custom-script.js"></script>
    
    <script type="text/javascript">
    $("#formValidate").validate({
        rules: {
            uname: {
                required: true,
                minlength: 5
            },
            cemail: {
                required: true,
                email:true
            },
            password: {
				required: true,
				minlength: 5
			},
			cpassword: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			curl: {
                required: true,
                url:true
            },
            crole:"required",
            ccomment: {
				required: true,
				minlength: 15
            },
            cgender:"required",
			cagree:"required",
        },
        //For custom messages
        messages: {
            uname:{
                required: "Enter a username",
                minlength: "Enter at least 5 characters"
            },
            curl: "Enter your website",
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
    </script>

</body>

</html>