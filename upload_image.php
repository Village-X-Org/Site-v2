<?php
	require_once("utilities.php");
  $img = param('upload_file');
  $smallFile = param("upload_file_small");
  $filename = uniqid() . '.jpg';
  $smallFilename = uniqId() . '.jpg';

  if ($session_is_admin) {
  } elseif (hasParam('g-recaptcha-response')) {
    $captcha = param('g-recaptcha-response');
  } else {
    die(1);
  }

  if (!$session_is_admin && !verifyRecaptcha3($captcha, 'upload_image')) {
    print "Google has decided you are a robot.  If you think this is an error, please tell the site administrator, or maybe just try again.";
      emailAdmin("Robot detected in add village", "Someone tried to upload an image.");
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
              $newSmallImage = imagerotate($smallImage, 180, 0);
              break;
      case 6: // 90 rotate right
              $newImage = imagerotate($image, -90, 0);
              $newSmallImage = imagerotate($smallImage, -90, 0);
              break;
      case 8:    // 90 rotate left
              $newImage = imagerotate($image, 90, 0);
              $newSmallImage = imagerotate($smallImage, 90, 0);
              break;
      }
      imagejpeg($newImage, 'uploads/'.$filename, 100);
      imagejpeg($newSmallImage, 'uploads/'.$smallFilename, 100);
      imagedestroy($image);
      imagedestroy($smallImage);
      imagedestroy($newImage);
      imagedestroy($newSmallImage);
  }

  $stmt = prepare("INSERT INTO pictures (picture_filename) VALUES (?)");
  $stmt->bind_param('s', $filename);
  execute($stmt);
  $picId = $link->insert_id;
  $stmt->close();

  $stmt = prepare("INSERT INTO pictures (picture_filename) VALUES (?)");
  $stmt->bind_param('s', $smallFilename);
  execute($stmt);
  $smallPicId = $link->insert_id;
  $stmt->close();

  rename("uploads/$filename", "uploads/$picId.jpg");
  rename("uploads/$smallFilename", "uploads/$smallPicId.jpg");
  doUnprotectedQuery("UPDATE pictures SET picture_filename='$picId.jpg' WHERE picture_id=$picId");
  doUnprotectedQuery("UPDATE pictures SET picture_filename='$smallPicId.jpg' WHERE picture_id=$smallPicId");

  print "{\"large\":\"$picId\",\"small\":\"$smallPicId\"}";

?>