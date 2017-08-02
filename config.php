<?php
date_default_timezone_set("America/New_York");
//require_once "Mail.php";
define('DB_HOST', 'localhost');
define('DB_USER', '');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'villagex');
define('PICTURES_DIR', 'uploads/');

// The following are probably optional
define('GOOGLE_API_KEY', '');
define('MAPBOX_API_KEY', '');
define("FACEBOOK_APP_ID", "");
define("FACEBOOK_SECRET", "");

function sendMailSend($to, $subject, $body, $fromName, $replyEmail) {
	$host = "";
	$port = "465";
	$username = "";
	$password = "";
	
	if ($fromName === $username) {
		$fromName = "Village X";
	}
	
	if ($replyEmail === $username) {
		$headers = array ('From' => "$fromName <$username>",
				'To' => $to,
				'Subject' => $subject);
	} else {
		$headers = array ('From' => "$fromName <$username>",
				'To' => $to,
				'Reply-To' => $replyEmail,
				'Subject' => $subject);
	}
	
	print $body;
}
?>
