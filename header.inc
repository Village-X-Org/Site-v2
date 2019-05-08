<?php require_once("utilities.php"); 
$donorId = $donorName = $donorColor = $donorLogo = 0;
if (hasParam('d')) {
	$donorId = paramInt('d');
	$result = doUnprotectedQuery("SELECT donor_first_name, donor_last_name, donor_primary_color, donor_logo FROM donors WHERE donor_id=$donorId");
	if ($row = $result->fetch_assoc()) {
		$donorName = $row['donor_first_name'].' '.$row['donor_last_name'];
		$donorColor = $row['donor_primary_color'];
		$donorLogo = $row['donor_logo'];
	}
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php if (!isset($metaProvided) || !$metaProvided) { ?>
<meta property="fb:appid" content="<?php print FACEBOOK_APP_ID; ?>"/>
<meta property="og:type" content="website" />
<meta property="og:image" content="https://villagex.org/images/header1.jpg"/>
<meta property="og:title" content="This website disrupts extreme poverty in Africa."/>
<meta property="og:url" content="<?php print BASE_URL; ?>"/>
<meta property="og:description" content="Village X Org is like GoFundMe for rural Africa. Fund projects villages choose."/>
<?php } ?>

<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-57585044-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments)};
  gtag('js', new Date());

  gtag('config', 'UA-57585044-1');
</script>

<!-- CSS  -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" media="screen,projection">

<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" rel="stylesheet" media="screen,projection">

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
<script src='https://api.mapbox.com/mapbox-gl-js/v0.46.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v0.46.0/mapbox-gl.css' rel='stylesheet' />

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
(function($){
  $(function(){

    $('.sidenav').sidenav();
    $('.parallax').parallax();
    $(".dropdown-trigger").dropdown();
	M.AutoInit();
  }); // end of document ready
})(jQuery);
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<link rel="stylesheet" href="css/jquery-plugin-progressbar.css">
  <script src="js/jquery-plugin-progressbar.js"></script>
  
<link rel='stylesheet' href='css/lightbox2.css' type='text/css' />
<script src="https://checkout.stripe.com/checkout.js"></script>

<link rel="stylesheet" type="text/css" href="css/slick.css"/>
<link rel="stylesheet" type="text/css" href="css/slick-theme.css"/>
<script type="text/javascript" src="js/slick.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
// Stripe
var handler = StripeCheckout.configure({
  key: '<?php print (isset($_SESSION['test']) && $_SESSION['test'] ? STRIPE_TEST_API_KEY : STRIPE_API_KEY); ?>',
  image: 'https://s3.amazonaws.com/stripe-uploads/acct_14tfQ6EfZscNLAofmerchant-icon-1414779028120-Screen%20Shot%202014-09-29%20at%2012.21.02%20PM.png',
  locale: 'auto',
  token: function(token) {
	  form = document.getElementById('donateForm');
	  form.stripeToken.value = token.id;
	  form.stripeAmount.value = donationAmount;
	  form.gcAmount.value = donationGCAmount;
	  form.isSubscription.value = donationIsSubscription;
	  form.firstName.value = donationFirstName;
	  form.lastName.value = donationLastName;
	  form.stripeEmail.value = donationEmail;
	  form.projectId.value = donationProjectId;
	  form.honoreeId.value = donationHonoreeId;
	  form.honoreeMessage.value = donationHonoreeMessage;
	  form.fundraiserId.value = donationFundraiserId;
	  form.fundraiserMessage.value = donationFundraiserMessage;
	  
	  form.submit();
  }
});

//Close Checkout on page navigation:
window.addEventListener('popstate', function() {
  handler.close();
});

function donateWithStripe(subscribe, amount, title, projectId, firstName, lastName, email, anonymous, honoreeId, honoreeMessage, gcAmount, fundraiserId, fundraiserMessage) {
 	if (<?php print ((isset($_SESSION['offline']) && $_SESSION['offline'] == 1) ? "true" : "false"); ?>
 		|| amount == 0) {
 	  form = document.getElementById('donateForm');
	  form.stripeToken.value = amount == 0 ? 'gcOnly' : 'offline';
	  form.stripeEmail.value = email;
	  form.stripeAmount.value = amount;
	  form.gcAmount.value = gcAmount * 100;
	  form.isSubscription.value = subscribe;
	  form.firstName.value = firstName;
	  form.lastName.value = lastName;
	  form.projectId.value = projectId;
	  form.honoreeId.value = honoreeId;
  	  form.honoreeMessage.value = honoreeMessage;
  	  form.fundraiserId.value = fundraiserId;
  	  form.fundraiserMessage.value = fundraiserMessage;
    	  
      form.submit();		
 	} else {
	  donationIsSubscription = subscribe;
	  donationFirstName = firstName;
	  donationLastName = lastName;
	  donationEmail = email;
	  donationProjectId = projectId;
	  donationAmount = amount;
	  donationGCAmount = gcAmount * 100;
	  donationHonoreeId = honoreeId;
	  donationHonoreeMessage = honoreeMessage;
	  donationFundraiserId = fundraiserId;
	  donationFundraiserMessage = fundraiserMessage;
	  handler.open({
	    name: 'Village X Org',
	    description: (subscribe ? 'Monthly Subscription' : title),
	    amount: amount,
	    email: email
	  });
	}
}
// End Stripe

</script>

<!-- form validation code -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
<script>

	$().ready(function() {
		// validate the comment form when it is submitted
		$("#commentForm").validate();
		
		// validate signup form on keyup and submit
		$("#signupForm").validate({
			rules: {
				firstname: "required",
				lastname: "required",
				username: {
					required: true,
					minlength: 2
				},
				password: {
					required: true,
					minlength: 5
				},
				confirm_password: {
					required: true,
					minlength: 5,
					equalTo: "#password"
				},
				email: {
					required: true,
					email: true
				},
				topic: {
					required: "#newsletter:checked",
					minlength: 2
				},
				agree: "required"
			},
			messages: {
				firstname: "Please enter your firstname",
				lastname: "Please enter your lastname",
				username: {
					required: "Please enter a username",
					minlength: "Your username must consist of at least 2 characters"
				},
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				confirm_password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
				email: "Please enter a valid email address",
				agree: "Please accept our policy",
				topic: "Please select at least 2 topics"
			}
		});
	});
	</script>

</head>

<body>

<?php if (!$donorId && !hasParam('hideHeader')) { ?>

	<nav class="white hide-on-large-only" role="navigation">
		<div class="nav-wrapper container">
				<a id="logo-container" href="index.php" class="brand-logo hide-on-medium-only"><img
				src="images/villagex_short_logo.png"></a>
				<a id="logo-container" href="index.php" class="brand-logo hide-on-small-only" style="padding: 3px 0 0 0"><img
				src="images/villagex_short_logo.png"></a>
			<a href="#" data-target="nav-mobile" class="button-collapse sidenav-trigger"><i
			class="material-icons">menu</i></a>
			<ul id="nav-mobile" class="sidenav">
				<li><a class="waves-effect waves-light btn" href="project_tiles.php">DONATE</a></li>
				<li><a class="waves-effect waves-light btn" href="fundraiser_create.php">FUNDRAISE</a></li>
				<li><a href="project_tiles.php"><i class="material-icons">view_module</i>Projects</a></li>
				<li><a href="impacts.php"><i class="material-icons">timeline</i>Impacts</a></li>
				<li><a href="map.php"><i class="material-icons">public</i>Map</a></li>
				<li><a href="about.php"><i class="material-icons">info</i>Mission &amp; Team</a></li>
  				<li><a href="model.php"><i class="material-icons">transform</i>Model</a></li>
  				<li><a href="finances.php"><i class="material-icons">attach_money</i>Finances</a></li>
				<li><a href="travel.php"><i class="material-icons">airplanemode_active</i>Travel</a></li>
  				<li><a href="https://medium.com/village-x-org" target="_blank"><i class="material-icons">library_books</i>Blog</a></li>
				<?php if ($session_donor_id) {
					print "
					<li><a class='waves-effect waves-light' href='user_profile.php?id=$session_donor_id'><i class='material-icons'>person</i>View Profile</a></li>
					<li><a class='waves-effect waves-light' href='user_logout.php'><i class='material-icons'>exit_to_app</i>Logout</a></li>";
				} else {
					print "<li><a class='waves-effect waves-light btn' href='user_login.php'>SIGN IN <i class='material-icons right'  style='color:white;'>person</i></a></li>";
				} ?> 
				<?php if (!isset($updates)) { ?>
					<li><a class="waves-effect waves-light btn" href='track.php'>Latest Pics <i class='material-icons right' style='color:white;'>rss_feed</i></a></li>
				<?php } ?>
			</ul>
		</div>
	</nav>
			
	<div class="navbar-fixed hide-on-med-and-down">
		<nav class="white" role="navigation">
			<div class="nav-wrapper container">
			<a id="logo-container" href="index.php" class="brand-logo hide-on-small-only" style="padding: 5px 0 0 0"><img
				src="images/villagex_short_logo.png"></a>
				<ul class="right">
					
					<li><a class="waves-effect waves-light btn light blue" href="project_tiles.php">DONATE</a></li>
					<li><a class="waves-effect waves-light btn light blue" href="fundraiser_create.php">FUNDRAISE</a></li>
					<li><a class="dropdown-trigger" href="#!" data-target="Menu"><span style="font-size: 18px">Info/Tools</span><i class="material-icons right" style="font-size: 35px">arrow_drop_down</i></a></li>
				<?php if (!isset($updates)) { ?>
					<li><a class="waves-effect waves-light btn white blue-text" href="track.php" style="border-radius:20px"><i class="material-icons right">rss_feed</i>Latest Pics</a></li>
				<?php } ?>
					<ul id="Menu" class="dropdown-content" style="margin-left:25px;margin-top:50px;">
							<li><a href="project_tiles.php">Projects</a></li>
				          <li><a href="about.php">Mission &amp; Team</a></li>
				          <li><a href="model.php">Model</a></li>
				          <li><a href="impacts.php">Impacts</a></li>
				          <li><a href="map.php">Map</a></li>
		          		  <li><a href="finances.php">Finances</a></li>
				          <li><a href="travel.php">Travel</a></li>
				          <li><a href="https://medium.com/village-x-org" target="_blank">Blog</a></li>
				          <li class="divider" tabindex="-1"></li>

						<?php if ($session_donor_id) {
							?>
						   		<li><a href="user_profile.php?id=<?php print $session_donor_id; ?>">View Profile</a></li>
						        <li><a href="user_logout.php">Logout</a></li>
					        <?php
						} else {
							?>
							<li><a href='user_login.php'>Sign In</a></li>
							<?php
						} ?>
				   </ul>
				</ul>
			</div>
		</nav>
	</div>

	<div style="width:100%;border-style:solid; border-width:1px;">
	</div>
	
		<div id="donationModal" class="modal">
        		<div class="modal-content" style='color:black;'>
        			<h4>Make a Donation</h4>
        			<p>Define all the parameters here.</p>
        		</div>
        		<div class='row'>
					<div class="modal-footer">
						<div class='row'>
							<div class='col'>
								$ <input type='text' id='headerAmountText' value='20' />
							</div>
							<div class='col'>
                        			<button id="modalDonateButton">Donate!</button>
                        		</div>
                        </div>
                        <script>
                        
                        document.getElementById('modalDonateButton').addEventListener('click', function(e) {
                          // Open Checkout with further options:
                          handler.open({
                            name: 'Village X Org',
                            description: 'Monthly Subscription',
                            amount: $('#headerAmountText').val() * 100
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
<?php } // Not donorId end. ?>
