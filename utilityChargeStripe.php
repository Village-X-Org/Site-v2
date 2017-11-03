<?php

require_once("utilities.php");
require_once('lib/stripe/init.php');

$donationAmount = param('amount');
$token = param('token');

\Stripe\Stripe::setApiKey(isset($_SESSION['test']) && $_SESSION['test'] ? STRIPE_TEST_SECRET_KEY : STRIPE_SECRET_KEY);
$charge = \Stripe\Charge::create(array(
    "amount" => $donationAmount,
    "currency" => "usd",
    "description" => "Project Donation",
    "source" => $token,
));