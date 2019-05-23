<?php
require_once("utilities.php");

if (hasParam('upload_file')) {
	$img = param('upload_file');
	$smallFile = param("upload_file_small");
	$filename = uniqid() . '.jpg';
	$smallFilename = uniqId() . '.jpg';

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
} elseif (isset($_POST['projectId'])) {
	$postTitle = $_POST['postTitle'];
	$projectId = $_POST['projectId'];
	$lat = $_POST['lat'];
	$lng = $_POST['lng'];
	$pictureIds = $_POST['pictureIds'];
	$notes = $_POST['notes'];
	$updateDate = strtotime($_POST['updateDate']);
	$stmt = prepare("INSERT INTO raw_updates (ru_project_id, ru_title, ru_description, ru_date, ru_picture_ids, ru_lat, ru_lng) 
		VALUES (?, ?, ?, FROM_UNIXTIME(?), ?, ?, ?)");
	$stmt->bind_param('issisdd', $projectId, $postTitle, $notes, $updateDate, $pictureIds, $lat, $lng);

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
		function uploadFile(file, smallFile, lat, lng, orientation, dateTime, image){
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
		    fd.append("upload_file_small", smallFile);
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

					uploadFile(dataUrlLarge, dataUrlSmall, latDec, lngDec, orientation, dateTime, image);

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
		<?php if ($session_donor_id || (hasParam('user') && hasParam('pass'))) { 
				if (!$session_donor_id) {
					$username = param('user');
					$password = md5(param('pass'));
					$stmt = prepare("SELECT donor_id, donor_first_name, donor_last_name, donor_email, donor_is_admin FROM donors WHERE donor_email=? AND donor_password=?");
					$stmt->bind_param('ss', $username, $password);
					$result = execute($stmt);
					if ($row = $result->fetch_assoc()) {
						$session_donor_id = $_SESSION['donor_id'] = $row['donor_id'];
						$session_first_name = $_SESSION['first_name'] = $row['donor_first_name'];
						$session_last_name = $_SESSION['last_name'] = $row['donor_last_name'];
						$session_email = $_SESSION['email'] = $row['donor_email'];
						$session_is_admin = $_SESSION['is_admin'] = $row['donor_is_admin'];
					} else {
						print "<script>document.location='user_login.php';</script></BODY></HTML>";
						die();
					}
					$stmt->close();
				}
			?>
		<h4>Post a project update</h4>
		<form enctype="multipart/form-data" method="post" id='updateForm'>
			<p><SELECT id='projectId' name='projectId' onchange="document.getElementById('postTitle').style.display = (this.value == -1 ? 'block' : 'none');"><option>Select a Project</option>
				<option value='-1'>No Project</option>
				<?php
					$result = doUnprotectedQuery("SELECT project_id, project_name, village_name, MAX(pe_date) AS maxDate, MAX(pe_type) AS maxType 
						FROM projects JOIN villages ON project_village_id=village_id 
						JOIN project_events ON pe_project_id=project_id GROUP BY project_id ORDER BY maxDate ASC");

					while ($row = $result->fetch_assoc()) {
						$date = strtotime($row['maxDate']);
						$diff = round((time() - $date) / (24 * 60 * 60));
						print "<option value='{$row['project_id']}'>{$row['project_name']} in {$row['village_name']}</option>";
					}
				?>
			</SELECT></p>

			<div style='display:none;margin-bottom:10px;' id='postTitle'>Post Title: <input type='text' name='postTitle' style='width:300px;' /></div>
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