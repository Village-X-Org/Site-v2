<?php
require_once("utilities.php");

if (isset($_POST['upload_file'])) {
	$img = $_POST['upload_file'];
	$filename = uniqid() . '.jpg';

	$ifp = fopen('uploads/'.$filename, 'wb');
    $data = explode(',', $img);
	fwrite($ifp, base64_decode($data[1]));
	fclose( $ifp ); 
	chmod('uploads/'.$filename, 0777);

	$orientation = $_POST['orientation'];
	if ($orientation == 3 || $orientation == 6 || $orientation == 8) {
    	$image = imagecreatefromjpeg('uploads/'.$filename);
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
	print $link->insert_id;
	$stmt->close();

	return;
} elseif (isset($_POST['projectId'])) {
	$projectId = $_POST['projectId'];
	$lat = $_POST['lat'];
	$lng = $_POST['lng'];
	$pictureIds = $_POST['pictureIds'];
	$notes = $_POST['notes'];
	$updateDate = strtotime($_POST['updateDate']);
	$stmt = prepare("INSERT INTO raw_updates (ru_project_id, ru_description, ru_date, ru_picture_ids, ru_lat, ru_lng) 
		VALUES (?, ?, FROM_UNIXTIME(?), ?, ?, ?)");
	$stmt->bind_param('isisdd', $projectId, $notes, $updateDate, $pictureIds, $lat, $lng);

	execute($stmt);
	print "<p>Update saved successfully!</p>";
	$stmt->close();
}
?>
<HTML>
	<HEAD>
		<script src="js/exif.js"></script>
		<script>
		var uploading = 0;
		function uploadFile(file, lat, lng, orientation, dateTime, image){
		    var xhr = new XMLHttpRequest();
		    var fd = new FormData();
		    xhr.open("POST", 'update.php', true);
		    xhr.onreadystatechange = function() {
		        if (xhr.readyState == 4 && xhr.status == 200) {
		        	document.getElementById('pictureIds').value += xhr.responseText + ',';
		        	image.style.opacity = 1;
		        	uploading--;
		        	if (uploading == 0) {
		        		document.getElementById('postUpdateButton').disabled = false;
		        	}
		        }
		    };
		    fd.append("upload_file", file);
		    if (lat) {
		    	document.getElementById('lat').value = lat;
		    	document.getElementById('lng').value = lng;
			}
		    fd.append("orientation", orientation);
		    if (dateTime) {
		    	document.getElementById('updateDate').value = dateTime;
		    }
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
   						dateTime = EXIF.getTag(this, "DateTimeOriginal");
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
					uploadFile(canvas.toDataURL('image/jpeg'), latDec, lngDec, orientation, dateTime, image);
					image.style.width='300px';
					image.style.opacity=.5;
					uploading++;
		        	document.getElementById('postUpdateButton').disabled = true;
        			document.getElementById('imageContainer').appendChild(image);
				};
        		image.src = e.target.result;
			}
			reader.readAsDataURL(file);
		}
		</script>
	</HEAD>
	<BODY>
		<?php if ($session_donor_id) { ?>
		<h4>Post a project update</h4>
		<form enctype="multipart/form-data" method="post" id='updateForm'>
			<p><SELECT id='projectId' name='projectId'><option>Select a Project</option>
				<?php
					$result = doUnprotectedQuery("SELECT project_id, project_name, village_name, MAX(pe_date) AS maxDate, MAX(pe_type) AS maxType 
						FROM projects JOIN villages ON project_village_id=village_id 
						JOIN project_events ON pe_project_id=project_id GROUP BY project_id HAVING maxType=3 ORDER BY maxDate ASC");

					while ($row = $result->fetch_assoc()) {
						$date = strtotime($row['maxDate']);
						$diff = round((time() - $date) / (24 * 60 * 60));
						print "<option value='{$row['project_id']}'>{$row['project_name']} in {$row['village_name']}</option>";
					}
				?>
			</SELECT></p>
		
			<input type="file" id="fileinput" multiple="multiple" />
			<div id='imageContainer'>
			</div>
			<input type='hidden' id='updateDate' name='updateDate' value='' />
			<input type='hidden' id='pictureIds' name='pictureIds' value=',' />
			<input type='hidden' id='lat' name='lat' value='' />
			<input type='hidden' id='lng' name='lng' value='' />
			<script>
				var uploadfiles = document.getElementById('fileinput');
				uploadfiles.addEventListener('change', function () {
				    var files = this.files;
				    for(var i=0; i<files.length; i++){
				        resizeAndUpload(this.files[i]);
				    }
				}, false);
			</script>

			<p><TEXTAREA style='width:300px;height:100px;' placeholder="Notes on uploaded pictures or general updates on project." 
				id='notes' name='notes'></TEXTAREA></p>
			<p><input type='submit' value='Post Update' id='postUpdateButton' /></p>
		</form>
		<?php } else { ?>
			<script>document.location='user_login.php';</script>
		<?php } ?>
	</BODY>
</HTML>