<?php
require_once ('utilities.php');
include ('header.inc');
?>

<div class="container">
<br><br>

<div class="row" style="border-style:solid; border-width:1px; border-color:blue; border-radius:20px; width:250px; height:60px;">
<form class="col s6" style="border-style:solid; border-radius:20px; margin: 0px 0px 0px 0px; height:60px;">
         					<div class="row" style="border-style:solid; border-width:2px; border-color:blue; border-radius:20px; margin: 0px 0px 0px 0px; height:60px;  padding: 0px 0px 0px 0px;">
         						<div class="input-field col s12 valign-wrapper" style="vertical-align: middle; border-style:solid; border-radius:20px; margin: 0px 0px 0px 0px; height:60px;">
         							<i class="material-icons prefix" style="font-size:40px; border-style:solid; border-radius:20px; height:50px;">attach_money</i>
          							<input placeholder="50" style="height:50px; font-size:30px; color:blue; border-style:solid; border-radius:20px;" id="donation_amoumnt" type="text" class="center-align validate" required>
          						</div>
          					</div>
</form>
        						
<div class="right-align col s6" style="border-radius:20px; padding:1% 1% 1% 1%;"><button class="btn btn-large blue btn-register waves-effect waves-light" style="border-radius:20px;" type="submit" name="action">Donate
                </button>
                </div>
                
                </div>


<a class="waves-effect waves-light btn modal-trigger" style="border-radius:20px;" href="#modal1">Modal</a>

<script>
  $(document).ready(function(){
    // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
  });
</script>
  
<div id="modal1" class="modal" style="border-radius:20px;">
    <div class="modal-content">
		<div class="row" style="width:100%;">
		<div class="flow-text align-center" style="padding:0% 2% 0% 2%;">You're donating to Start a Goat Herd in Saiti Village, Malawi. The community contributed $100.</div>
	
		<div class="input-field col s6">
		<div class="card" style="border-radius:20px;">
            	<div class="card-content black-text">
		<div class="col s12" style="border-style:solid; border-width:2px; border-color:blue; border-radius:20px;">
          <i class="material-icons prefix">attach_money</i>
          <input id="donation_amount" type="text" class="validate" required>
          <label for="donation_amount">50</label>
        </div>
        <div class="input-field col s12">
          <i class="material-icons prefix">email</i>
          <input id="email" type="email" class="validate" required>
          <label for="icon_telephone">enter your email</label>
        </div>
       
		
		
			<!--  
        			<div class="col s6 m6 l6">
        			
        				<form class="col s12" id="reg-form">
                			<div class="row">
         
                <div class="col s12 valign-wrapper" style="border-style:solid; border-width:1px; border-color:blue; border-radius:20px;">
                <h4 style="align-left">$</h4>
                <div class="input-field col s6">
                <input id="donation_amount" type="text" class="validate" required>
                <label for="donation_amount" style="font-size:30px;">50</label>
                </div>
                </div>
                </div>
                <div class="row">
                <div class="input-field col s12">
                <input id="email" type="email" class="validate" required>
                <label for="email">Email</label>
                </div>
                </div>
  				</form>
  		-->
  				
  				<div class="row">
                <div class="input-field col s12">
                <button class="btn btn-large btn-register waves-effect waves-light" type="submit" name="action">Register
                <i class="material-icons right">done</i>
                </button>
                </div>
                </div>
                </div>
                </div>
                </div>
               
                <div class="col s6 center-align">
                		<img class="activator responsive" style="border-radius:20px;" width="100%" height="100%" src="temp/mlenga 4116.jpg"> 
                		<h6><b>Here's a similar project.</b></h6>
                </div>
                </div>
               </div>
						
  				</div>
  			</div>
  			
<div class="container">

<a class="waves-effect waves-light btn modal-trigger" style="border-radius:20px;" href="#modal2">Modal</a>

<script>
  $(document).ready(function(){
    // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
  });
</script>
  
<div id="modal2" class="modal" style="border-radius:20px;">
    <div class="modal-content">
		<div class="row" style="width:100%;">
		<div class="flow-text align-center" style="padding:0% 2% 0% 2%;">You're donating to Start a Goat Herd in Saiti Village, Malawi. The community contributed $100.</div>
	
		<div class="col s6">
		<img class="activator responsive" style="border-radius:20px;" width="100%" height="100%" src="temp/mlenga 4116.jpg"> 
                		<h6><b>Here's a similar project.</b></h6>
                </div>
               
                <div class="col s6 center-align">
                		<img class="activator responsive" style="border-radius:20px;" width="100%" height="100%" src="temp/mlenga 4116.jpg"> 
                		<h6><b>Here's a similar project.</b></h6>
                </div>
                </div>
               </div>
						
  				</div>
  			</div>
  	