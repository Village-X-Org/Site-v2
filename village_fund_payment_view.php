<!DOCTYPE html>
<html lang="en">
<head>
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
                            src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
                            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                            <script src="http://cdn.oesmith.co.uk/morris-0.4.1.min.js"></script>
                            
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
        $.post("donateWithStripe.php", {
            stripeToken: token.id,
            stripeEmail: token.email,
            stripeAmount: $('#amountText').val() * 100
        },
        function(data, status) {
            Materialize.toast(data, 4000);
        });
    }
});
    
    //Close Checkout on page navigation:
    window.addEventListener('popstate', function() {
        handler.close();
    });
        
        function donateWithStripe(subscribe, donationAmount, title, projectId) {
            handler.open({
                name: 'Village X Org',
                description: (subscribe ? 'Monthly Subscription' : title),
                amount: donationAmount,
                isSubscription: subscribe
            });
        }
        // End Stripe
        
        </script>
        
        <link href="js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
        <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
        <link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">
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
            
            </head>
            
            <body>
            
            <div class="container">
            <br>
            
            <div id="jquery-validation" class="section" style="display:table; width:100%">
            <div class="col-project valign-wrapper" style="vertical-align: middle;">
            <div class="card" style="border-style:solid; border-width:1px; border-color:blue; border-radius:20px; margin: 0px 0px 0px 0px;">
            <div class="card-content blue-text" style="height:100%;">
            <span class="card-title black-text">Give monthly and disrupt extreme poverty all year long</span>
            <div class="row" style="padding:5% 5% 5% 5%;">
            <h6 class="center-align" style="color:blue;">enter an amount and your name</h6>
            <form class="col s12 formValidate" style="width:100%" id="formValidate" method="get" action="">
            <div class="row" style="border-style:solid; border-width:2px; border-color:blue; border-radius:20px; padding:3% 3% 3% 3%;">
            <div class="input-field col s12 center-align">
            <i class="material-icons prefix" style="font-size:40px;">attach_money&nbsp;&nbsp;</i>
            <input placeholder="10" style="font-size:40px; color:blue;" id="donation_amount" type="tel">
            <h5 class="center-align">/ month</h5>
            <div class="input-field col s6">
            <label for="uname">First Name</label>
            <input id="uname" name="uname" type="text" data-error=".errorTxt1">
            <div class="errorTxt1"></div>
            </div>
            <div class="input-field col s6">
            <label for="last_name">Last Name</label>
            <input id="uname" name="uname" type="text" data-error=".errorTxt1">
            <div class="errorTxt1"></div>
            </div>
            </div>
            </div>
            
            <div class="input-field col s12">
            <button class="center-align waves-effect waves-light light blue lighten-1 btn-large submit" type="submit" style="width:100%;" onclick="amount = $('#donation_amount').val(); if (!amount) { amount = $('#donation_amount').attr('placeholder'); } donateWithStripe(false, amount * 100, '<?php print $projectName; ?>', <?php print $projectId; ?>); return false;">Donate</button>
    
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
                			        stripeAmount: $('#donation_amount').val() * 100
                			    },
                			    function(data, status) {
                			    	 	Materialize.toast(data, 4000);
                			    });
                          }
                        });
                        
                        // Close Checkout on page navigation:
                        window.addEventListener('popstate', function() {
                          handler.close();
                        });
            </script>
            
            </form>
            </div>
            </div>
            </div>
            </div>
            
            <div class="col-project valign-wrapper center-align" style="vertical-align: middle;">
            <img src="images/monthly_giving_donation_page.jpg" class="responsive-img">
            <p>You'll receive rolling updates of your impact on the ground.</p>
		</div>
                
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
					<p>©Village X Org, 501(c)(3) nonprofit, 2017. EIN: 47&#65279;-1845825&#65279;</p>
				</div>
				<div class="col s12 m4 l4" align="left">
					<p><b>Our technology disrupts extreme poverty by democratizing local development. Aiming to reach 390 million people in rural Africa.</b></p>
				</div>
				<div class="col s12 m4 l4" align="left">
					<p>
						<a href="tos.php">Terms of Service</a><br> <a href="privacy_policy.php">Privacy Policy</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</footer>

</body>
</html>