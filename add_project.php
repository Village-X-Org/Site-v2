<?php
require_once("utilities.php");

if (hasParam('upload_file')) {
  $img = param('upload_file');
  $smallFile = param("upload_file_small");
  $filename = uniqid() . '.jpg';
  $smallFilename = uniqId() . '.jpg';

  if (hasParam('g-recaptcha-response')) {
    $captcha = param('g-recaptcha-response');
  } else {
    die(1);
  }

  if (!verifyRecaptcha3($captcha, 'addVillage')) {
    print "Google has decided you are a robot.  If you think this is an error, please tell the site administrator, or maybe just try again.";
      emailAdmin("Robot detected in add project", "Someone tried to add a project with projectName: $projectName");
      die(1);
  }

  $ifp = fopen('uploads/'.$filename, 'wb');
    $data = explode(',', $img);
  fwrite($ifp, base64_decode($data[1]));
  fclose( $ifp ); 
  chmod('uploads/'.$filename, 0777);

  $ifp = fopen('uploads/'.$smallFilename, 'wb');
    $data = explode(',', $smallFile);
  fwrite($ifp, base64_decode($data[1]));
  fclose($ifp); 
  chmod('uploads/'.$smallFilename, 0777);

  $orientation = $_POST['orientation'];
  if ($orientation == 3 || $orientation == 6 || $orientation == 8) {
      $image = imagecreatefromjpeg('uploads/'.$filename);
      $smallImage = imagecreatefromjpeg('uploads/'.$smallFilename);
    switch($orientation) {
      case 3: // 180 rotate left
              $newImage = imagerotate($image, 180, 0);
              break;
      case 6: // 90 rotate right
              $newImage = imagerotate($image, -90, 0);
              break;
      case 8:    // 90 rotate left
              $newImage = imagerotate($image, 90, 0);
              break;
      }
      imagejpeg($newImage, 'uploads/'.$filename, 100);
      imagedestroy($image);
      imagedestroy($newImage);
  }

  $stmt = prepare("INSERT INTO pictures (picture_filename) VALUES (?)");
  $stmt->bind_param('s', $filename);
  execute($stmt);
  $picId = $link->insert_id;
  print $picId;
  $stmt->close();

  rename("uploads/$filename", "uploads/$picId.jpg");
  rename("uploads/$smallFilename", "uploads/s$picId.jpg");
  doUnprotectedQuery("UPDATE pictures SET picture_filename='$picId.jpg' WHERE picture_id=$picId");

  return;
} elseif (isset($_POST['village_name'])) {
  $advocateName = $_POST['advocate_name'];
  $advocatePhone = $_POST['advocate_phone'];
  $advocateEmail = $_POST['advocate_email'];
  $villageName = $_POST['village_name'];

  if (hasParam('g-recaptcha-response')) {
    $captcha = param('g-recaptcha-response');
  } else {
    die(1);
  }

  if (!verifyRecaptcha3($captcha, 'addProject')) {
    print "Google has decided you are a robot.  If you think this is an error, please tell the site administrator, or maybe just try again.";
      emailAdmin("Robot detected in add project", "Someone tried to add a project with name: $projectName");
      die(1);
  }

  $lat = $_POST['lat'];
  $lng = $_POST['lng'];
  $pictureIds = $_POST['pictureIds'];
  $villagePopulation = $_POST['village_population'];
  $villageProblem = $_POST['village_problem'];
  $stmt = prepare("INSERT INTO proposed_villages (pv_name, pv_submitter_name, pv_submitter_email, pv_submitter_phone, pv_population, pv_dev_problem, pv_lat, pv_lng, pv_images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param('ssssisdds', $villageName, $advocateName, $advocateEmail, $advocatePhone, $villagePopulation, $villageProblem, $lat, $lng, $pictureIds);

  execute($stmt);
  $stmt->close();
  $proposedId = $link->insert_id;

  $pictures = explode(',', $pictureIds);
  $pictureStr = '';
  foreach ($pictures as $next) {
    if (strlen($next) > 1) {
      $pictureStr .= "<img src='".ABS_PICTURES_DIR."$next.jpg' /> ";
    }
  }
  $output = "Advocate Name: $advocateName<br/>AdvocateEmail: $advocateEmail<br/>Advocate Phone: $advocatePhone<br/>Village Name: $villageName<br/>Location: $lat, $lng<br/>Village Population: $villagePopulation<br/>Village Problem: $villageProblem<br/><br/>$pictureStr";
  sendMail(getCustomerServiceEmail(), "Village $villageName uploaded by $advocateName",
    $output, getCustomerServiceEmail());
  sendMail(getAdminEmail(), "Village $villageName uploaded by $advocateName",
    $output, getCustomerServiceEmail());
  include("generateProposedJson.php");
  include('proposed_thanks.php');
  
  return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://www.google.com/recaptcha/api.js?render=<?php print CAPTCHA_SITEKEY_V3; ?>"></script>
<?php
    $pageTitle = "Village X | Map Your Project";
    $pageDescription = "Add your village and its development needs to our map.  We want to connect you with organizations that might be able to help.";
    $pageUrl = getBaseURL()."add_village.php";
    include('header.inc'); 
?>
<script>
  grecaptcha.ready(function() {
    grecaptcha.execute('<?php print CAPTCHA_SITEKEY_V3; ?>', {action: 'addVillage'}).then(function(token) {
      $('#g-recaptcha-response').val(token);
      captchaResult = token
    });
  });
</script>
<style>
body, html {
    height: 100%;
    width: 100%;
    margin: 0;
}

.bg {

    /* The image used */
    background-image: url("images/globe_africa.jpg");

    /* Full height */

    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    
}


</style>
<script src="js/exif.js"></script>
    <script>
    var uploading = 0;
    var captchaResult;
    function uploadFile(file, smallFile, lat, lng, orientation, image){
        var xhr = new XMLHttpRequest();
        var fd = new FormData();
        xhr.open("POST", 'update.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
              document.getElementById('pictureIds').value += xhr.responseText + ',';
              image.style.opacity = 1;
              uploading--;
            }
        };
        fd.append("upload_file", file);
        fd.append("upload_file_small", smallFile);
        fd.append("g-recaptcha-response", captchaResult)
        if (lat) {
          document.getElementById('lat').value = lat;
          document.getElementById('lng').value = lng;
          document.getElementById('addVillageButton').disabled = false;
        }
        fd.append("orientation", orientation);
        xhr.send(fd);
    }
    function toDecimal(number) {
         return number[0].numerator + number[1].numerator /
             (60 * number[1].denominator) + number[2].numerator / (3600 * number[2].denominator);
    }

    function resizeAndUpload(file) {              
      var reader = new FileReader();  
      reader.onload = function(e) {
        var image =  document.createElement('img');
            image.onload = function () {
              latDec = lngDec = orientation = 0;

              EXIF.getData(image, function() {
                var allMetaData = EXIF.getAllTags(this);
                console.log(JSON.stringify(allMetaData, null, "\t"));
                var longitude = EXIF.getTag(this, 'GPSLongitude');
                var latitude = EXIF.getTag(this, 'GPSLatitude');

                if (longitude) {
                latDec = toDecimal(latitude);
                if (EXIF.getTag(this, 'GPSLatitudeRef') == 'S') {
                  latDec *= -1;
                }
                lngDec = toDecimal(longitude);
                if (EXIF.getTag(this, 'GPSLongitudeRef') == 'W') {
                  lngDec *= -1;
                }
              }
              orientation = EXIF.getTag(this, "Orientation");
              });

          var canvas = document.createElement('canvas');

          var MAX_WIDTH = 1024;
          var MAX_HEIGHT = 1024;
          var width = this.width;
          var height = this.height;

          if (width > height) {
            if (width > MAX_WIDTH) {
              height *= MAX_WIDTH / width;
              width = MAX_WIDTH;
            }
          } else {
            if (height > MAX_HEIGHT) {
              width *= MAX_HEIGHT / height;
              height = MAX_HEIGHT;
            }
          }
          canvas.width = width;
          canvas.height = height;
          var context = canvas.getContext("2d");
          context.drawImage(this, 0, 0, width, height);
          dataUrlLarge = canvas.toDataURL('image/jpeg');

          var MIN_SIDE_LENGTH = 400;
          if (width > height) {
            smallWidth = (width / height) * MIN_SIDE_LENGTH;
            smallHeight = MIN_SIDE_LENGTH;
          } else {
            smallHeight = (height / width) * MIN_SIDE_LENGTH;
            smallWidth = MIN_SIDE_LENGTH;
          }
          canvas.width = smallWidth;
          canvas.height = smallHeight;
          context = canvas.getContext("2d");
          context.drawImage(this, 0, 0, smallWidth, smallHeight);
          dataUrlSmall = canvas.toDataURL('image/jpeg');

          uploadFile(dataUrlLarge, dataUrlSmall, latDec, lngDec, orientation, image);

          image.style.width='300px';
          image.style.opacity=.5;
          uploading++;
          document.getElementById('example_image').style.display = 'none';
          document.getElementById('imageContainer').appendChild(image);
        };
            image.src = e.target.result;
      }
      reader.readAsDataURL(file);
    }
</script>

<div class="bg" style="height:1850px;width:100%;padding-top:40px;">
	  <div class="white-text center-align" style="font-weight:300;padding:1% 0 1% 0;font-size:xx-large;text-shadow: black 0.1em 0.1em 0.4em;padding: 0 10% 0 10%">Add your project to our map.
    </div>
		<div class="container center-align" id="jqueryvalidation" style='margin-top:20px;'>
      <div class="z-depth-8 grey lighten-4 row" style="display: inline-block; padding: 20px 5px 20px 30px; border: 4px solid #EEE;">
          				
         				<form class="col s12" style="width:100%" id="add_village_form" method='post' action="add_village.php">

         						
          						
      						  <div class="row" style="padding:2% 14% 0 0%;margin:0;max-width:600px">
           						 <div class="black-text left-align" style="font-size:large; padding:0 0 0 3%"><b>Village Name</b></div>
           						 <div class="input-field col s12 donor-text" style="padding:0% 0% 0% 3%; font-size:20px;">
          							<i class="material-icons prefix">location_on</i>
          							<input placeholder="e.g., Chimphepo Village" class='donor-text' type="text" style="padding:0% 0% 0% 0%; font-size:20px;" 
                        id="village_name" name="village_name" required data-error=".errorTxt4"/>
          							<div class="errorTxt4 center-align" style="padding:0 0 0% 0; font-size:10px; color:red;"></div>
          					   </div>	
          					</div>

                    <div class="row" style="padding:2% 14% 0 0%;margin:0;max-width:600px">
                     <div class="black-text left-align" style="font-size:large; padding:0 0 0 3%"><b>Project Name</b></div>
                     <div class="input-field col s12 donor-text" style="padding:0% 0% 0% 3%; font-size:20px;">
                        <i class="material-icons prefix">location_on</i>
                        <input placeholder="e.g., Start a Goat Herd" class='donor-text' type="text" style="padding:0% 0% 0% 0%; font-size:20px;" 
                        id="project_name" name="project_name" required data-error=".errorTxt4"/>
                        <div class="errorTxt4 center-align" style="padding:0 0 0% 0; font-size:10px; color:red;"></div>
                     </div>
                      
                    </div>
                            
                       		  
	                 			
	                 			<div class="row" style="padding:2% 14% 0 0%;margin:0;max-width:600px">
                    
                      <div class="black-text left-align" style="font-size:large; padding:0 0 0% 3%;"><b>VILLAGE POPULATION</b></div>
                     <div class="input-field col s12 donor-text" style="padding:0% 8% 0% 3%; font-size:20px;">
         							  <i class="material-icons prefix">group</i>
          						  <input placeholder="number of people (e.g., 1200)" type="number" class='donor-text' style="font-size:20px;width:100%;" id="village_population" name="village_population" required data-error=".errorTxt5" />
          						<div class="errorTxt5 center-align" style="font-size:10px; color:red; padding:0 0 0% 9%"></div>
          						</div>
          					</div>
	                 			
	             
          					<div class="row" style="padding:2% 14% 0 0%;margin:0;max-width:600px">
         						 <div class="black-text left-align" style="font-size:large; padding:0 0 0 3%"><b>In-Country Agent's Name</b></div>
         						 <div class="input-field col s12 donor-text" style="padding:0% 0% 0% 3%; font-size:20px;">
         						 <i class="material-icons prefix">account_circle</i>
          							<input placeholder="e.g., Myson Jambo" class='donor-text' type="text" style="padding:0% 0% 0% 0%; font-size:20px;" 
                        id="advocate_name" name="advocate_name" required data-error=".errorTxt1"/>
          							<div class="errorTxt1 center-align" style="padding:0 0 0% 0; font-size:10px; color:red;"></div>
          					 </div>
          						
          					</div>
          					
          					<div class="row" style="padding:2% 14% 0 0%;margin:0;max-width:600px">
         						 <div class="black-text left-align" style="font-size:large; padding:0 0 0 3%"><b>Agent's email (optional)</b></div>
         						 <div class="input-field col s12 donor-text" style="padding:0% 0% 0% 3%; font-size:20px;">
         						 <i class="material-icons prefix">email</i>
          							<input placeholder="e.g., myson@gmail.com" class='donor-text' type="email" style="padding:0% 0% 0% 0%; font-size:20px;" id="advocate_email" name='advocate_email' required data-error=".errorTxt2"/>
          							<div class="errorTxt2 center-align" style="padding:0 0 0% 0; font-size:10px; color:red;"></div>
          					 </div>
          						
          					</div>
          					
          					<div class="row" style="padding:2% 14% 0 0%;margin:0;max-width:600px">
          					<div class="black-text left-align" style="font-size:large; padding:0 0 0 3%"><b>Agent's WhatsApp/Phone (optional)</b></div>
          					<div class="input-field col s12 donor-text" style="padding:0% 0% 0% 3%; font-size:20px;">
          						<i class="material-icons prefix">phone</i>
          						<input id="advocate_phone" name='advocate_phone'  placeholder="[+] [country code] [phone number]"  type="tel" class="validate" style="padding:0% 0% 0% 0%; font-size:20px;" required data-error=".errorTxt3">
          						<div class="errorTxt3 center-align" style="padding:0 0 0% 0; font-size:10px; color:red;"></div>
          					</div>
     
       						 </div>

        					<div class="row" style="padding:2% 0% 1% 0%;margin:0;max-width:600px">
        					 <div class="black-text left-align" style="font-size:large; padding:0 0 2% 3%;"><b>PICTURES OF YOUR VILLAGE</b>
                   </div>
          					
      							 <div class="file-field input-field col s12" style="padding:0% 20% 0% 3%;font-size:20px;"> 
          						  <input id='fileinput' type="file" multiple />
                          <i class="material-icons prefix" style="color:black;font-size:20px;">photo_library</i>
          							 <input class="file-path validate donor-text" type="text" placeholder="click to upload pics" style="padding:0% 0% 0% 0%; font-size:20px;" id="village_pics" required data-error=".errorTxt6" />
        						    </div>
                        <img id='example_image' src='images/saiti_project_request.jpg' style='width:600px;opacity:.6' />
                      <div id='imageContainer'>
                        </div>
                        <input type='hidden' id='pictureIds' name='pictureIds' value=',' />
                        <input type='hidden' id='lat' name='lat' value='' />
                        <input type='hidden' id='lng' name='lng' value='' />
                        <input type='hidden' id='g-recaptcha-response' name='g-recaptcha-response' value='' />
                        <script>
                          var uploadfiles = document.getElementById('fileinput');
                          uploadfiles.addEventListener('change', function () {
                              var files = this.files;
                              for(var i=0; i<files.length; i++){
                                  resizeAndUpload(this.files[i]);
                              }
                          }, false);
                        </script>
        						  <div class="errorTxt6 center-align" style="font-size:10px; color:red;">
                      </div>
      							
      							<div class="black-text center-align" style="max-width:600px;border-radius:10px; font-weight:600;padding: 0 10% 2% 5%;">
                  				NOTE:  Here's an example showing a village requesting a development project.  Your picture(s) must contain GPS coordinates.  Smartphones usually take pictures with GPS coordinates.
                  				<p/>If possible, please include a banner photo that's at least 1280px wide.
              			</div>
    					  </div>				
	          		
	          		<div class="row" style="padding:2% 0% 0% 0%;margin:0;max-width:600px">
	          		   <div class="black-text left-align" style="font-size:large; padding:0 0 0% 3%"><b>BIGGEST DEVELOPMENT PROBLEM</b>
                   </div>
                            
                      <div class="input-field col s12" style="padding:0% 13% 0% 3%;">
                      <i class="material-icons prefix">favorite</i>
                        <textarea id="village_problem" name="village_problem" required class="materialize-textarea donor-text" style="font-size:20px;" data-length="300" placeholder="e.g., lack of clean water" data-error=".errorTxt7"></textarea>
  						<div class="errorTxt7 center-align" style="font-size:10px; color:red;"></div>
                      </div>
                 
                      
              </div>
					
                      
	          		
                           <div class="center-align valign-wrapper" style="width:100%; padding:0% 9% 1% 3%;max-width:600px">
                    		   <div class="input-field center-align" style="width:100%;">
                    		   		
                    				<button disabled="true" id="addVillageButton" class="btn-large donor-background center-align submit" type="submit" style="width:100%;height:70px;font-size:25px;" > 
                    					Submit 
                    				</button>
                    			</div>
                    			</div>
                    			
            				   <div class="black-text center-align" style="max-width:600px;border-radius:10px; font-weight:600;padding: 0 10% 20px 5%;">
                This button will change color when you've added a picture with GPS coordinates.
            </div>
            				   
            				  
        </form>
			</div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('textarea#village_prob').characterCounter();
  });

  $().ready(function() {
    $("#add_village_form").validate({
      rules: {
    	  village_advocate: "required",
    	  advocate_phone: "required",
    	  village_name: "required",
    	  village_pop: "required",
    	  village_pics: "required",
        village_prob: "required"
      },
    messages: {
    	village_advocate: "this field is required",
    	advocate_phone: "this field is required",
    	village_name: "this field is required",
    		village_pop: "this field is required",
    		village_pics: "this field is required",
    		village_prob: "this field is required"
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
