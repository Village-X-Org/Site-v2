<?php
require_once("utilities.php");

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_DGoi26vx76FlFn7sen3IDSC8");

// Retrieve the request's body and parse it as JSON
$input = @file_get_contents("php://input");
$event_json = json_decode($input);

// Do something with $event_json

doQuery("INSERT INTO stripe_donations (stripe_token, stripe_is_subscription, stripe_amount) VALUES (.., .., ..)");

http_response_code(200); // PHP 5.4 or greater


