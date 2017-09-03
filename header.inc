<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Village X Org - Fund Projects Villages Choose</title>

<!-- CSS  -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
	rel="stylesheet">
<link href="css/materialize.css" type="text/css" rel="stylesheet"
	media="screen,projection">
<link href="css/style.css" type="text/css" rel="stylesheet"
	media="screen,projection">
<link
	href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
	type="text/css" rel="stylesheet" media="screen,projection">

<script
	src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
<script
	src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.37.0/mapbox-gl.js'></script>
<link
	href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.37.0/mapbox-gl.css'
	rel='stylesheet' />
<link rel='stylesheet'
	href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.1.0/mapbox-gl-geocoder.css'
	type='text/css' />
<script
	src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v2.1.0/mapbox-gl-geocoder.min.js'></script>


      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>

<script
	src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="js/morris-0.4.1.min.js"></script>

<link rel="stylesheet" href="css/jquery-plugin-progressbar.css">
  <script src="js/jquery-plugin-progressbar.js"></script>
  
<link rel='stylesheet'
	href='css/lightbox.css'
	type='text/css' />
<script src="js/imagelightbox.min.js"></script>  
<script src="https://checkout.stripe.com/checkout.js"></script>
  
<style>
#imagelightbox {
	position: fixed;
	z-index: 9999;
	 
	-ms-touch-action: none;
	touch-action: none;
}
</style>

<script>
var donationIsSubscription, donationFirstName, donationLastName, donationProjectId, donationAmount;
//Lightbox Begin
var activityIndicatorOn = function()
{
	$( '<div id="imagelightbox-loading"><div></div></div>' ).appendTo( 'body' );
},
activityIndicatorOff = function()
{
	$( '#imagelightbox-loading' ).remove();
},

overlayOn = function()
{
	$( '<div id="imagelightbox-overlay"></div>' ).appendTo( 'body' );
},
overlayOff = function()
{
	$( '#imagelightbox-overlay' ).remove();
},

closeButtonOn = function( instance )
{
	$( '<button type="button" id="imagelightbox-close" title="Close"></button>' ).appendTo( 'body' ).on( 'click touchend', function(){ $( this ).remove(); instance.quitImageLightbox(); return false; });
},
closeButtonOff = function()
{
	$( '#imagelightbox-close' ).remove();
},

captionOn = function()
{
	var description = $( 'a[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"] img' ).attr( 'alt' );
	if( description.length > 0 )
		$( '<div id="imagelightbox-caption">' + description + '</div>' ).appendTo( 'body' );
},
captionOff = function()
{
	$( '#imagelightbox-caption' ).remove();
},

navigationOn = function( instance, selector )
{
	var images = $( selector );
	if( images.length )
	{
		var nav = $( '<div id="imagelightbox-nav"></div>' );
		for( var i = 0; i < images.length; i++ )
			nav.append( '<button type="button"></button>' );

		nav.appendTo( 'body' );
		nav.on( 'click touchend', function(){ return false; });

		var navItems = nav.find( 'button' );
		navItems.on( 'click touchend', function()
		{
			var $this = $( this );
			if( images.eq( $this.index() ).attr( 'href' ) != $( '#imagelightbox' ).attr( 'src' ) )
				instance.switchImageLightbox( $this.index() );

			navItems.removeClass( 'active' );
			navItems.eq( $this.index() ).addClass( 'active' );

			return false;
		})
		.on( 'touchend', function(){ return false; });
	}
},
navigationUpdate = function( selector )
{
	var items = $( '#imagelightbox-nav button' );
	items.removeClass( 'active' );
	items.eq( $( selector ).filter( '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ).index( selector ) ).addClass( 'active' );
},
navigationOff = function()
{
	$( '#imagelightbox-nav' ).remove();
},

arrowsOn = function( instance, selector )
{
	var $arrows = $( '<button type="button" class="imagelightbox-arrow imagelightbox-arrow-left"></button><button type="button" class="imagelightbox-arrow imagelightbox-arrow-right"></button>' );

	$arrows.appendTo( 'body' );

	$arrows.on( 'click touchend', function( e )
	{
		e.preventDefault();

		var $this	= $( this ),
			$target	= $( selector + '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ),
			index	= $target.index( selector );

		if( $this.hasClass( 'imagelightbox-arrow-left' ) )
		{
			index = index - 1;
			if( !$( selector ).eq( index ).length )
				index = $( selector ).length;
		}
		else
		{
			index = index + 1;
			if( !$( selector ).eq( index ).length )
				index = 0;
		}

		instance.switchImageLightbox( index );
		return false;
	});
},
arrowsOff = function()
{
	$( '.imagelightbox-arrow' ).remove();
};
// Lightbox End

// Stripe
var handler = StripeCheckout.configure({
  key: 'pk_test_AXxdOsB0Xz9tOVdCVq8jpkAQ',
  image: 'https://s3.amazonaws.com/stripe-uploads/acct_14tfQ6EfZscNLAofmerchant-icon-1414779028120-Screen%20Shot%202014-09-29%20at%2012.21.02%20PM.png',
  locale: 'auto',
  token: function(token) {
	  console.log(token);
	  $.post("donateWithStripe.php", {
	        stripeToken: token.id,
	        stripeEmail: token.email,
	        stripeAmount: donationAmount,
	        isSubscription: donationIsSubscription,
	        firstName: donationFirstName,
	        lastName: donationLastName,
	        projectId: donationProjectId
	    },
	    function(data, status) {
	    	 	Materialize.toast(data, 4000);
	    	 	setTimeout(function(){ document.location = 'project.php'; }, 500);
	    });
  }
});

//Close Checkout on page navigation:
window.addEventListener('popstate', function() {
  handler.close();
});

function donateWithStripe(subscribe, amount, title, projectId, firstName, lastName) {
  donationIsSubscription = subscribe;
  donationFirstName = firstName;
  donationLastName = lastName;
  donationProjectId = projectId;
  donationAmount = amount;
  handler.open({
    name: 'Village X Org',
    description: (subscribe ? 'Monthly Subscription' : title),
    amount: donationAmount
  });
}
// End Stripe

</script>
<style type="text/css">
  .input-field div.error{
    position: relative;
    top: -1rem;
    left: 0rem;
    font-size: 0.8rem;
    color:#FF4081;
    -webkit-transform: translateY(0%);
    -ms-transform: translateY(0%);
    -o-transform: translateY(0%);
    transform: translateY(0%);
  }
  .input-field label.active{
      width:100%;
  }
  .left-alert input[type=text] + label:after, 
  .left-alert input[type=password] + label:after, 
  .left-alert input[type=email] + label:after, 
  .left-alert input[type=url] + label:after, 
  .left-alert input[type=time] + label:after,
  .left-alert input[type=date] + label:after, 
  .left-alert input[type=datetime-local] + label:after, 
  .left-alert input[type=tel] + label:after, 
  .left-alert input[type=number] + label:after, 
  .left-alert input[type=search] + label:after, 
  .left-alert textarea.materialize-textarea + label:after{
      left:0px;
  }
  .right-alert input[type=text] + label:after, 
  .right-alert input[type=password] + label:after, 
  .right-alert input[type=email] + label:after, 
  .right-alert input[type=url] + label:after, 
  .right-alert input[type=time] + label:after,
  .right-alert input[type=date] + label:after, 
  .right-alert input[type=datetime-local] + label:after, 
  .right-alert input[type=tel] + label:after, 
  .right-alert input[type=number] + label:after, 
  .right-alert input[type=search] + label:after, 
  .right-alert textarea.materialize-textarea + label:after{
      right:70px;
  }
</style>
</head>

<body>
	<nav class="white" role="navigation">
		<div class="nav-wrapper container">
			<a id="logo-container" href="index.php" class="brand-logo"><img
				src="images/logo.png"></a>
			<ul class="right hide-on-med-and-down">
				<li><a href="project_tiles.php">Projects</a></li>
				<li><a href="map.php">Map</a></li>
				<li><a href="model.php">Model</a></li>
				<li><a href="impacts.php">Impacts</a></li>
				<li><a href="about.php">About</a></li>
			</ul>

			<ul id="nav-mobile" class="side-nav">
				<li><a href="project_tiles.php">Projects</a></li>
				<li><a href="map.php">Map</a></li>
				<li><a href="model.php">Model</a></li>
				<li><a href="impacts.php">Impacts</a></li>
				<li><a href="about.php">About</a></li>
			</ul>
			<a href="#" data-activates="nav-mobile" class="button-collapse"><i
				class="material-icons">menu</i></a>
		</div>
	</nav>
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
				<script>
		  $(document).ready(function(){
		    $('#donationModal').modal();
		  });
		</script>
		</div>