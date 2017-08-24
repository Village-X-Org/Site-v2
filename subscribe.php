<?php
require_once("utilities.php");
require_once('lib/stripe/init.php');

// Be sure to replace this with your actual test API key
// (switch to the live key later)
\Stripe\Stripe::setApiKey("sk_test_DGoi26vx76FlFn7sen3IDSC8");

$plan = \Stripe\Plan::create(array(
    "name" => "Basic Plan",
    "id" => "basic-monthly",
    "interval" => "month",
    "currency" => "usd",
    "amount" => paramInt('stripeAmount'),
));

try {
    $customer = \Stripe\Customer::create(array(
        'email' => param('stripeEmail'),
        'source'  => param('stripeToken'),
        'plan' => 'basic-monthly'
    ));
    // doQuery("INSERT INTO subscriptions (subscription_id, subscription_email, subscription_amount, subscription_start_dat) VALUES ()")
    print "You successfully registered for monthly payments.  Thank you!";
    exit;
} catch(Exception $e) {
    print "Registration failed.  Please contact us and let us know this happened.";
}