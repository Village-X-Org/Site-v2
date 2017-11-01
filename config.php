<?php
//session_save_path("/Users/jeff.depree/nonworkspace/tmp");
date_default_timezone_set("America/New_York");
//require_once "Mail.php";
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'mulanje');
define('DB_DATABASE', 'villagex');
define('PICTURES_DIR', 'https://villagex.org/uploads/');
define('BASE_URL', 'http://localhost/Site-v2/');
define('STRIPE_API_KEY', "pk_test_AXxdOsB0Xz9tOVdCVq8jpkAQ");
define('STRIPE_API_SECRET', "sk_test_DGoi26vx76FlFn7sen3IDSC8");

// The following are probably optional
define('GOOGLE_API_KEY', 'AIzaSyBI0lHSGrRmWKb7OoK-sD_x36i1XH9i1Bc');
define('MAPBOX_API_KEY', 'pk.eyJ1IjoiamRlcHJlZSIsImEiOiJNWVlaSFBBIn0.IxSUmobvVT64zDgEY9GllQ');
define("FACEBOOK_APP_ID", "107425412747634");
define("FACEBOOK_SECRET", "baf7876396ab74cab819d30bd806f0c0");
define("CACHING_ENABLED", 0);

function sendMailSend($to, $subject, $body, $fromName, $replyEmail) {
	$host = "ssl://secure53.webhostinghub.com";
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
