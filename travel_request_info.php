<?php
require_once("utilities.php");

$firstName = param('travelFirstName');
$lastName = param('travelLastName');
$email = param('travelEmail');
$departureDate = param('travelDepartureDate');
$returnDate = param('travelReturnDate');
$message = param('travelMessage');
$groupType = param('travelGroupType');
$groupSize = param('travelGroupSize');

if (!$departureDate) {
	$departureDate = "January 1, 2018";
	$returnDate = "January 1, 2018";
}

$departureDate = date('Y-m-d', strtotime($departureDate));
$returnDate = date('Y-m-d', strtotime($returnDate));

$stmt = prepare("INSERT INTO travel_requests (tr_first_name, tr_last_name, tr_email, tr_departure_date, tr_return_date, tr_additional_info, tr_group_type, tr_group_size) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $firstName, $lastName, $email, $departureDate, $returnDate, $message, $groupType, $groupSize);
$result = execute($stmt);

sendMail(getCustomerServiceEmail(), "Travel Info Request",
    "First Name: $firstName\nLast Name: $lastName\nEmail: $email\nDeparture Date: $departureDate\nReturn Date: $returnDate\nAdditional Info: $message", getAdminEmail());
sendMail(getAdminEmail(), "Travel Info Request",
    "First Name: $firstName\nLast Name: $lastName\nEmail: $email\nDeparture Date: $departureDate\nReturn Date: $returnDate\nAdditional Info: $message", getAdminEmail());

?>

<div id='responseText' class='flow-text' style='padding:5% 5% 5% 5%'>We have received your request and will be in touch shortly.  Thank you for your interest!</div>