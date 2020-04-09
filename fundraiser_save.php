<?php
require_once("utilities.php");

$title = param('fundraiser_title');
$donorId = $session_donor_id;
$projectId = paramInt('fundraiser_project_id');
$deadline = strtotime(param('fundraiser_deadline')) + (24 * 3600);
$amount = paramInt('fundraiser_amount');
$description = param('fundraiser_description');
if (hasParam('g-recaptcha-response')) {
	$captcha = param('g-recaptcha-response');
} else {
	die(1);
}

if (!verifyRecaptcha($captcha) || $amount == 0) {
	print "Google has decided you are a robot.  If you think this is an error, please tell the site administrator, or maybe just try again.";
    //emailAdmin("Robot detected in fundraiser_create", "Someone tried to create a fundraiser with donor id: $donorId, Title: $title, Description: $description, Amount: $amount, and email: ".(hasParam('fundraiser_email') ? param('fundraiser_email') : ""));
    die(1);
}

if (hasParam('fundraiser_email')) {
	$email = param('fundraiser_email');
	$stmt = prepare("SELECT donor_id FROM donors WHERE donor_email=?");
	$stmt->bind_param('s', $email);
	$result = execute($stmt);
	if ($row = $result->fetch_assoc()) {
		$donorId = $row['donor_id'];
	} else {
		$stmt = prepare("INSERT INTO donors (donor_email, donor_first_name, donor_last_name) VALUES (?, 'Fundraiser', 'Organizer')");
		$stmt->bind_param('s', $email);
		execute($stmt);
		$donorId = $link->insert_id;
	}
	$stmt->close();
}

if ($donorId) {
	$stmt = prepare("INSERT INTO fundraisers (fundraiser_title, fundraiser_donor_id, fundraiser_project_id, fundraiser_deadline, fundraiser_amount, fundraiser_description) 
		VALUES (?, ?, ?, FROM_UNIXTIME(?), ?, ?)");
	$stmt->bind_param('siiiis', $title, $donorId, $projectId, $deadline, $amount, $description);
	execute($stmt);
	$stmt->close();

	$id = $link->insert_id;

	$type = EMAIL_TYPE_FUNDRAISER;
	ob_start();
	include("email_content.php");
	$output = ob_get_clean();
	sendMail($donorEmail, "Your fundraiser has been created!", 
	    $output, getCustomerServiceEmail());
	sendMail(getCustomerServiceEmail(), "Your fundraiser has been created! ($donorId)",
	    $output, getCustomerServiceEmail());
	sendMail(getAdminEmail(), "Your fundraiser has been created! ($donorId)",
	    $output, getCustomerServiceEmail());

	header("Location: fundraiser_view.php?id=$id");
} else {
	print "You must be logged in to create a fundraiser.";
}
?>