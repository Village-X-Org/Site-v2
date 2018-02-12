<?php
require_once("utilities.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Village X Org | Fund Projects That Villages Choose</title>
<meta name="description" content="Disrupting extreme poverty in rural Africa with democracy, direct giving, and data."/>
<?php include('header.inc'); 
if (hasParam('code')) {
    $_SESSION['code'] = param('code');
}
if (hasParam('test')) {
    $_SESSION['test'] = param('test');
}
?>

<div id="index-banner" class="parallax-container fullscreen hide-on-med-and-down" 
	style="background-color: rgba(0, 0, 0, 0.4); height: 800px">
	<div class="section no-pad-bot valign-wrapper"
		style="height: 100%; width: 100%;">
		<div class="row center">
			<div style="padding: 5% 5% 5% 5%;">
				<h2
					class="header col s12 white-text text-lighten-2 text-shadow: 2px 2px 7px #111111">Visit "The Warm Heart of Africa"</h2>
			</div>

			<div style="padding: 5% 5% 5% 5%;">
				<br>
				<br>
				<h5 class="header center light text-shadow: 2px 2px 7px #111111" style="padding:0% 3% 0% 3%">
					discover Malawi's world-class beaches, game parks, mountains, and people</h5>
			</div>

			<div style="padding: 0% 5% 5% 5%;">
				<br>
				<br>
				<a href="#get_started" id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1" style="border-radius:20px;">learn how</a>
			</div>

			<div class="parallax">
				<img src="images/group_sidwell_trip.jpg">
			</div>
		</div>
	</div>
</div>

<div id="index-banner" class="parallax-container fullscreen hide-on-large-only" 
	style="background-color: rgba(0, 0, 0, 0.4); height: 500px">
	<div class="section no-pad-bot valign-wrapper"
		style="height: 100%; width: 100%;">
		<div class="row center">
			<div style="padding: 5% 5% 5% 5%;">
				<h2
					class="header col s12 white-text text-lighten-2 text-shadow: 2px 2px 7px #111111">Visit "The Warm Heart of Africa"</h2>
			</div>

			<div style="padding: 5% 5% 5% 5%;">
				<br>
				<br>
				<h5 class="header center light text-shadow: 2px 2px 7px #111111" style="padding:0% 3% 0% 3%">
					discover Malawi's world-class beaches, game parks, mountains, and people</h5>
			</div>

			<div style="padding: 0% 5% 5% 5%;">
				<br>
				<br>
				<a href="project_tiles.php" id="download-button"
					class="btn-large waves-effect waves-light light blue lighten-1" style="border-radius:20px;">get started</a>
			</div>

			<div class="parallax">
				<img src="images/group_sidwell_trip.jpg">
			</div>
		</div>
	</div>
</div>

<div class="container">
	<br>
	<blockquote class="flow-text">"With more than one billion international tourists now traveling the world each year, tourism has become a powerful and transformative 
	force that is making a genuine difference in the lives of millions of people. ... As one of the world’s 
	leading employment sectors, tourism provides important livelihood opportunities, helping to alleviate poverty and drive inclusive development."
		<div style="width:100%;text-align:right;">-- United Nations Secretary-General, Banki-moon</div></blockquote>
	<br>

	<h4 class="header center light blue-text text-lighten-2">How It Works</h4>

	<!--   <h5 class="header center brown-text text-lighten-2">How It Works</h5> -->
	<div class="section">
		<!--   Icon Section   -->
		<div class="row">
			<div class="col s12 m4" style="padding:0 0 4% 0">
				<div class="icon-block">
					<h2 class="center brown-text">
						<img style="border:5px solid black" class="circle responsive-img" src="images/bakili.jpg">
					</h2> 
					
					<h5 class="center flow-text" style="font-weight: 600;">Villages choose projects</h5>

					<p class="light center">Search the projects page or interactive map for tenacious villages battling extreme poverty in rural
						Africa. Find a village-led development project that speaks to you.</p>
						
					<h5 class="center">#democracy</h5>

				</div>
			</div>

			<div class="col s12 m4" style="padding:0 0 4% 0">
				<div class="icon-block">
					<h2 class="center brown-text">
						<img style="border:5px solid black" class="circle responsive-img" src="images/building_school.jpg">
					</h2>
					
					<h5 class="center flow-text" style="font-weight: 600; padding:0% 10% 0% 10%">You help fund them</h5>

					<p class="light center">Make a donation directly to a rural village that not only identifies local solutions to its
					biggest problems, but also contributes labor, materials, and, importantly, cash.</p>
					
					<h5 class="center">#directgiving</h5>
				</div>
			</div>

			<div class="col s12 m4" style="padding:0 0 4% 0">
				<div class="icon-block">
					<h2 class="center black-text">
						<img style="border:5px solid black;"class="circle responsive-img" src="images/visit_project.jpg">
					</h2>
					
					<h5 class="center flow-text" style="font-weight: 600;padding:0% 5% 0% 5%">We help you visit</h5>

					<p class="light center">Travel to the people and projects helped by your generosity. We serve as your personal travel 
					consultants, sharing insights from over ten years operating in Malawi.</p>
					 
					 <h5 class="center">#development</h5>
				</div>
			</div>
		</div>

	</div>
	</div>
	<br>

<!--  <blockquote class="flow-text">"Beyond the shores of Lake Malawi, known for boutique eco-resorts and well-heeled international tourists, there’s another Malawi — a whole country, 
	if a tiny one, of chaotic and lively urban centers, green hills, tea plantations, high mountains and game parks blessedly free of safari jeep traffic jams." -- The New York Times</blockquote>
	<br>
	
<blockquote class="flow-text">"Malawi's many natural wonders -- from the azure waters of Monkey Bay to the dramatic rock formations of Mulanje Massif -- 
	are made more picturesque when bathed crimson with the help of the setting sun. One thing's for sure: your travel pics will look amazing." -- CNN Travel</blockquote>
	<br>
	
-->

<div id="index-banner" class="parallax-container"
	style="background-color: rgba(0, 0, 0, 0.3); height: 500px">
	<div class="section no-pad-bot valign-wrapper"
		style="height: 100%; width: 100%;">
		<div class="row center" style="width:100%;">
			
			<div style="padding: 0% 5% 5% 5%;">
				<h2 class="header col s12 white-text text-lighten-2 text-shadow: 2px 2px 7px #111111">do good and explore</h2>
			</div>

			<!--  <div style="padding: 15% 10% 5% 10%;">
				
				<h5 class="header center light text-shadow: 2px 2px 7px #111111">
					a tea estate on the slopes of Mulanje Mountain</h5>
			</div> -->
			
			<div class="parallax">
				<img src="images/mulanje_tea.jpg">
			</div>
			
		</div>
	</div>
</div>

<div class="container">
	<br>
	
	<blockquote class="flow-text">"Picture this: mere hours after touching down in Malawi’s second-largest city, Blantyre, you check into superluxe digs (or pitch your tent) at the Majete Wildlife Reserve, 
		which ... last year gained Big Five status thanks to a wildlife relocation project. You get up close to ... elephant, rhino, lion, leopard and 
		buffalo without the pesky 4WD scrum so common in Africa’s best-known parks. Then perhaps it’s off to Lake Malawi for a spot of high-visibility snorkelling, or Mt Mulanje for a hike over hazy peaks in an 
		otherworldly moonscape." <div style="width:100%;text-align:right;">-- Lonely Planet</div></blockquote>
		<br>
 
      <div class="video-container" style="border-style:solid;background-image:url('images/travel_video_preview.jpg');background-size:cover;background-position:center;">
       	<iframe src="https://www.youtube.com/embed/Ycbl5TOK5x8?modestbranding=1&autohide=1&showinfo=0&controls=0&rel=0&fs=0" frameborder="0" gesture="media" allow="encrypted-media" width="480" height="270"></iframe>
      </div>
  </div>
	<h4 class="header center light text-lighten-2" style='margin-top:80px;margin-bottom:15px;font-weight:400;'>From Airport to Nsima</h4>
  
  <div class="row" style='margin-bottom:80px;'>
  	<div class="col s4 center">
  		<img src='images/travelServiceAirplane.jpg' width=300 height=200 style='border: solid 1px;' />
  		<BR /><span class='flow-text'>We know the best flights</span>
  	</div>
  	
  	<div class="col s4 center">
  		<img src='images/travelServiceCar.jpg' width=300 height=200 style='border: solid 1px;'  />
  		<br /><span class='flow-text'>We've got the travel partners</span>
  	</div>

  	<div class="col s4 center">
  		<img src='images/travelServiceVillage.jpg' width=300 height=200  style='border: solid 1px;' />
  		<br /><span class='flow-text'>We can get you in the village</span>
  	</div>
 </div>
 
	<div class="carousel carousel-slider" data-indicators="true" dist="0" style="height:500px;">
	    <div class="carousel-item" style="background-image:url('images/mulanje.jpg');background-size:cover;height:500px;background-position:center;"></div>
	    <div class="carousel-item" style="background-image:url('images/capemac.jpg');background-size:cover;height:500px;background-position:center;"></div>
		<div class="carousel-item" style="background-image:url('images/culture.jpg');background-size:cover;height:500px;background-position:center;"></div>
      	<div class="carousel-item" style="background-image:url('images/blantyre.jpg');background-size:cover;height:500px;background-position:center;"></div>
      	<div class="carousel-item" style="background-image:url('images/kuchawe.jpg');background-size:cover;height:500px;background-position:center;"></div>
	    <div class="carousel-item" style="background-image:url('images/hippos.jpg');background-size:cover;height:500px;background-position:center;"></div>
  </div>
  <script>  $(document).ready(function(){
      $('.carousel').carousel({fullWidth: true, duration: 200});
    });
	</script>
  	
  <br>
<div class="container">
<br>
	<div class="valign-wrapper" id='travelInfoRequestDiv'>
          <div class="card scrollspy" id=get_started style="opacity:1; border-radius:20px;border:black 1px solid;">
            <div class="card-content black-text">
              <span class="card-title center-align" style="padding: 1% 5% 0% 5%;"><b>Interested in travel advice that fights extreme poverty?</b></span> 

              <div class="center-align" style='padding:0 5% 0 5%;'>We're here to help with flights, lodging, ground transport, 
              village stays, meals, and much more. Reach us by submitting the form below. Enjoy free inquires and prompt responses.</div>
      	
      		<br/><br/>

    		<div class="container" id="jqueryvalidation" style="width:100%; margin:0;">
    			<span style='font-size:20px;font-style:bold;'>Contact Info</span>
         		<form id='travelInfoRequestForm' method='post'>
         		
         		<div class="row" style="padding:0;margin:0;">
         		
                         <div class="input-field col s6" style="padding:0 2% 0 5%;margin:0;">  
                           <input id="travelFirstName" name="travelFirstName" style="font-size:20px;" placeholder="first name" type="text" required data-error=".errorTxt1" />
                    	     <div class="errorTxt1" style="font-size:10px; color:red;"></div>
                         </div>
                         <div class="input-field col s6" style="padding:0 5% 0 2%;margin:0;">
                           <input id="travelLastName" name="travelLastName" style="font-size:20px;" placeholder="last name" type="text" required data-error=".errorTxt2" />
                           <div class="errorTxt2" style="font-size:10px; color:red;"></div>
                         </div>
             	</div>         	
         
         		<div class="row" style="padding:0 5% 0 5%;margin:0;">							
     				<div class="input-field col s12" style="padding:0;margin:0;" >
     					<input id="travelEmail" name="travelEmail" style="font-size:20px;" placeholder="email address" type="email" required data-error=".errorTxt3">
     					 <div class="errorTxt3" style="font-size:10px; color:red;"></div>
     				</div>
      			</div>
          	
          		<span style='font-size:20px;font-style:bold;'>Trip Details</span>
          		
	          	<div class="row" style="padding:0 5% 0 5%;margin:0; font-size:20px;">
	          		<div class="input-field col s6" style="padding:0 2% 0 0;margin:0;">
	                        <select name='travelGroupType'>
	                          <option value="">Type of group?</option>
	                          <option value="school">school group</option>
	                          <option value="faith">faith group</option>
	                          <option value="business">business group</option>
	                          <option value="other">other group</option>
	                          <option value="individual">no group -- individual</option>
	                        </select>
	                 </div>
	                 
	                 <div class="input-field col s6" style="padding:0 0 0 2%;margin:0;">
	                        <select name='travelGroupSize'>
	                          <option value="">Number of people?</option>
	                          <option value="1-3">1-3</option>
	                          <option value="4-10">4-10</option>
	                          <option value="11-20">11-20</option>
	                          <option value="20+">20+</option>
	                        </select>
	                 </div>
	                 
	                 <script>
	                 $(document).ready(function() {
	          		    $('select').material_select();
	          			});
	            	    </script>
	                 
	          	</div>
	          		
	          	<div class="row" style="padding:0 5% 0 5%;margin:0;">
	          		<div class="input-field col s6" style="padding:0 2% 0 0;margin:0;">
	          		<input type="text" style="font-size:20px;" class="datepicker" placeholder="departure date" name="travelDepartureDate">
	          		</div>
	          		<div class="input-field col s6" style="padding:0 0 0 2%;margin:0;">
	          		<input type="text" style="font-size:20px;" class="datepicker" placeholder="return date" name="travelReturnDate">
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
	          		
	        	</div>
	          		<br>
          	
          		<span style='font-size:20px;font-style:bold;'>Tell Us More</span>
          		
         		<div class="row" style="padding:0 5% 0 5%;margin:0;"">
         				<div class="input-field col s12" style="border-radius: 5px;padding:0;margin-bottom:5px;">
                   				<textarea style="font-size:20px;height:80px;width:100%;padding:5px;" id="travelMessage" placeholder="message (optional)" name="travelMessage"></textarea>
                	 		</div>
         		</div>
 				
                 <div class="center-align" style="width:100%;">
          			<button class="btn-large blue waves-effect waves-light center-align" style="border-radius:20px; margin:0% 0% 1% 0%;" type="submit">submit</button>
    		</form>
    			
 		</div>
    		</div>
		
				<script>
     		
				$(document).ready(function() {
             		$("#travelInfoRequestForm").validate({
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
                     	},
				        submitHandler: function(form) {
				        	$.post( "travel_request_info.php", $( "#travelInfoRequestForm" ).serialize())
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

<br>
<?php include('footer.inc'); ?>

