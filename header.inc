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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="Cache-Control" content="max-age=3153600, public" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta property="fb:app_id" content="<?php print FACEBOOK_APP_ID; ?>"/>
<meta property="og:type" content="website" />
<?php
	if (!isset($pageImage)) {
		$pageImage = "https://villagex.org/images/header1.jpg";
	}	
	if (!isset($pageTitle)) {
		$pageTitle = "This website disrupts extreme poverty.  Double your donation - one week only!";
	}
	if (!isset($pageUrl)) {
		$pageUrl = BASE_URL;
	}
	if (!isset($pageDescription)) {
		$pageDescription = "Make your donation count with data-verified direct giving.";
	}
?>
<meta property="og:image" content="<?php print $pageImage; ?>" />
<meta property="og:title" content="<?php print $pageTitle; ?>" />
<meta property="og:url" content="<?php print $pageUrl; ?>" />
<meta property="og:description" content="<?php print $pageDescription; ?>" />
<title><?php print $pageTitle; ?></title>
<meta name="description" content="<?php print $pageDescription; ?>"/>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" ></script>
<script src='https://api.mapbox.com/mapbox-gl-js/v0.46.0/mapbox-gl.js' ></script>
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

<link rel="stylesheet" type="text/css" href="css/slick.css" />
<link rel="stylesheet" type="text/css" href="css/slick-theme.css" />
<script type="text/javascript" src="js/slick.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>

<!-- form validation code -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
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

<?php if (!$donorId && !hasParam('hideHeader')) { 
	$rebranded = isset($rebranded) ? $rebranded : 0; ?>

	<nav class="white hide-on-large-only" role="navigation">
		<div class="nav-wrapper container">
				<a id="logo-container" href="<?php print ($rebranded ? $url : 'index.php'); ?>" class='brand-logo <?php print ($rebranded ?  "left'" : "' style='padding: 3px 0 0 0'"); ?>><img
				src='<?php print ($rebranded ? "$logo' style='height:75px;" : "images/villagex_short_logo.png"); ?>'></a>

			<?php if ($rebranded == 0) { ?>	
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
				<li><a href="shop.php"><i class="material-icons">shopping_cart</i>Shop</a></li>
  				<li><a href="https://medium.com/village-x-org" target="_blank"><i class="material-icons">library_books</i>Blog</a></li>
				<?php if ($session_donor_id) {
					print "
					<li><a class='waves-effect waves-light' href='user_profile.php?id=$session_donor_id'><i class='material-icons'>person</i>View Profile</a></li>
					<li><a class='waves-effect waves-light' href='user_logout.php'><i class='material-icons'>exit_to_app</i>Logout</a></li>";
				} else {
					print "<li><a class='waves-effect waves-light btn' href='user_login.php'>SIGN IN <i class='material-icons right'  style='color:white;'>person</i></a></li>";
				} ?> 
				<?php if (!isset($updates)) { ?>
					<li><a class="waves-effect waves-light btn" href='track.php'>Add Villages<i class='material-icons right' style='color:white;'>add_circle_outline</i></a></li>
				<?php } ?>

			</ul>
			<?php } else { ?>
				<a href="add_village.php" class="right">
                    <div style="vertical-align:middle; display:inline-block;margin: 0 auto;width:100%;">
                        <div style="vertical-align:middle; display:inline-block;font-size:20px;color:gray;">add a village</div>
                         <div style="vertical-align:middle;display:inline-block;"><i class="material-icons" style='font-size:48px;color:gray;'>add_circle_outline</i></div>
                         <div style="vertical-align:middle;display:inline-block;font-size:20px;color:gray;">to our map</div>
                     </div>
	            </a>
	        <?php } ?> 
		</div>
	</nav>
				
	<div class="navbar-fixed hide-on-med-and-down">
		<nav class="white" role="navigation">
			<div class="nav-wrapper container">
			<a id="logo-container" href="<?php print ($rebranded ? $url : 'index.php'); ?>"class='brand-logo <?php print ($rebranded ?  "left'" : "' style='padding: 3px 0 0 0'"); ?>><img
				src='<?php print ($rebranded ? "$logo' style='height:75px;" : "images/villagex_short_logo.png"); ?>'></a>
				<?php if ($rebranded == 0) { ?>	
				<ul class="right">
					
					<li><a class="waves-effect waves-light btn light blue" href="project_tiles.php">DONATE</a></li>
					<li><a class="waves-effect waves-light btn light blue" href="fundraiser_create.php">FUNDRAISE</a></li>
					<li><a class="dropdown-trigger" href="#!" data-target="Menu"><i class="material-icons" style="font-size: 50px">menu</i></a></li>
				<?php if (!isset($updates)) { ?>

					<li><a class="waves-effect waves-light btn white blue-text" href="add_village.php" style="border-radius:20px"><i class="material-icons right">add_circle_outline</i>Add Villages</a></li>
				<?php } ?>
					<ul id="Menu" class="dropdown-content" style="margin-left:25px;margin-top:50px;">
							<li><a href="project_tiles.php">Projects</a></li>
				          <li><a href="about.php">Mission &amp; Team</a></li>
				          <li><a href="model.php">Model</a></li>
				          <li><a href="impacts.php">Impacts</a></li>
				          <li><a href="map.php">Map</a></li>
		          		  <li><a href="finances.php">Finances</a></li>
				          <li><a href="travel.php">Travel</a></li>
				          <li><a href="shop.php">Shop</a></li>
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
				<?php } else { ?>
				<a href="add_village.php" class="right">
                    <div style="vertical-align:middle; display:inline-block;margin: 0 auto;width:100%;">
                        <div style="vertical-align:middle; display:inline-block;font-size:20px;color:gray;">add a village</div>
                         <div style="vertical-align:middle;display:inline-block;"><i class="material-icons" style='font-size:48px;color:gray;'>add_circle_outline</i></div>
                         <div style="vertical-align:middle;display:inline-block;font-size:20px;color:gray;">to our map</div>
                     </div>
	            </a>
	        	<?php } ?> 
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
