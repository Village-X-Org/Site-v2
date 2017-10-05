<?php

require_once("utilities.php");
require_once('lib/stripe/init.php');

$donationAmount = param('amount');
$token = param('token');

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
$charge = \Stripe\Charge::create(array(
    "amount" => $donationAmount,
    "currency" => "usd",
    "description" => "Project Donation",
    "source" => $token,
));