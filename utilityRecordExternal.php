<?php
require("utilities.php");

$projectId = $argv[1];
$donationAmount = $argv[2];
$donationId = $argv[3];

recordDonation($projectId, $donationAmount, $donationId);
?>