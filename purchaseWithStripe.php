<?php
require_once("utilities.php");
require_once('lib/stripe/init.php');

$test = (isset($_SESSION['test']) && $_SESSION['test'] ? 1 : 0);
\Stripe\Stripe::setApiKey($test ? STRIPE_TEST_SECRET_KEY : STRIPE_SECRET_KEY);

$purchaseAmount = param('stripeAmount');
$stripeToken = param('stripeToken');
$donorEmail = $buyerEmail = param('stripeEmail');
$shippingName = param('shippingName');
$shippingStreet = param('shippingStreet');
$shippingApt = param('shippingApt');
$shippingCity = param('shippingCity');
$shippingState = param('shippingState');
$shippingZip = param('shippingZip');
$projectId = param('projectId');
$order = param('order');

$donorName = explode(' ', $shippingName);
$donorFirstName = $donorLastName = '';
if (count($donorName) > 0) { 
    $donorFirstName = $donorName[0];
    if (count($donorName) > 1) {
        $donorLastName = $donorName[1];
    }
}
$donationCount = $isSubscription = $fundraiserId = 0;

$stmt = prepare("SELECT donor_id FROM donors WHERE donor_email=?");
$stmt->bind_param('s', $buyerEmail);
$result = execute($stmt);
if ($row = $result->fetch_assoc()) {
    $donorId = $row['donor_id'];
    $stmt->close();
} else {
    $stmt = prepare("INSERT INTO donors (donor_email, donor_first_name, donor_last_name) VALUES (?, ?, ?)");

    $stmt->bind_param('sss', $donorEmail, $donorFirstName, $donorLastName);
    execute($stmt);
    $stmt->close();
    $donorId = $link->insert_id;
}

if (!$projectId) {
    $result = doUnprotectedQuery("SELECT project_id FROM projects JOIN villages ON project_village_id=village_id
        ORDER BY project_budget - project_funded ASC LIMIT 1");
    if ($row = $result->fetch_assoc()) {
        $projectId = $row['project_id'];
    }
}

if ($stripeToken !== 'offline' && $stripeToken !== 'gcOnly') {
    /*$charge = \Stripe\Charge::create(array(
        "amount" => $purchaseAmount,
        "currency" => "usd",
        "description" => "Project Donation",
        "source" => $stripeToken,
    ));*/
} 

$gcId = 0;
if (isset($_SESSION['gc'])) {
    $gcId = $_SESSION['gc'];
    doUnprotectedQuery("UPDATE gift_certificates SET gc_quantity = gc_quantity - 1 WHERE gc_id=$gcId");
    unset($_SESSION['gc']);
}

$purchaseAmountDollars = $purchaseAmount / 100;

$code = null;
if (isset($_SESSION['code'])) {
    $code = $_SESSION['code'];
}

$address = "$shippingName\n$shippingStreet $shippingApt\n$shippingCity, $shippingState $shippingZip";

$stmt = prepare("INSERT INTO purchases (purchase_donor_id, purchase_order, purchase_total, purchase_address) VALUES (?, ?, ?, ?)");
$stmt->bind_param('isds', $donorId, $order, $purchaseAmount, $address);
execute($stmt);
$purchaseId = $link->insert_id;
$stmt->close();

$donationAmount = 0;
$products = array();
foreach (explode(',', $order) as $item) {
    $parts = explode(':', $item);
    if (count($parts) < 2) {
        continue;
    }
    $itemId = $parts[0];
    $itemQuantity = $parts[1];

    $stmt = prepare("SELECT product_id, product_name, product_price, picture_filename, product_donation FROM products JOIN pictures ON product_picture=picture_id WHERE product_id=?");
    $stmt->bind_param("i", $itemId);
    $result = execute($stmt);
    if ($row = $result->fetch_assoc()) {
        $donation = $row['product_donation'];
        $donationAmount += $donation * $itemQuantity;
        $products[] = array($row['product_id'], $row['product_name'], $row['product_price'], $row['picture_filename'], $itemQuantity);
    }
    $stmt->close();

    $stmt = prepare("UPDATE products SET product_stock=product_stock-? WHERE product_id=?");
    $stmt->bind_param("di", $itemQuantity, $itemId);
    execute($stmt);
    $stmt->close();
}

$donationAmountDollars = $donationAmount / 100;

$stmt = prepare("INSERT INTO donations (donation_donor_id, donation_amount, donation_project_id, donation_remote_id, donation_code, donation_is_test, donation_gc_id, donation_purchase_id) VALUES (?, ?, ?, ?, ?, $test, $gcId, ?)");
$stmt->bind_param("idissi", $donorId, $donationAmountDollars, $projectId, $stripeToken, $code, $purchaseId);
execute($stmt);
$stmt->close();
$donationId = $link->insert_id;

if ($projectId && !$test) {
    recordDonation($projectId, $purchaseAmountDollars, $donationId);
}

include("thanks_for_purchase.php");

$type = EMAIL_TYPE_THANKS_FOR_PURCHASE;
ob_start();
include("email_content.php");
$output = ob_get_clean();
sendMail($buyerEmail, "Purchase from Village X", 
    $output, getCustomerServiceEmail());
sendMail(getCustomerServiceEmail(), "Purchase from Village X ($buyerEmail)",
    $output, getCustomerServiceEmail());
sendMail(getAdminEmail(), "Purchase from Village X ($buyerEmail)",
    $output, getCustomerServiceEmail());

?>
