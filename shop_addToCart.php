<?php
require_once("utilities.php");

$cartContents = param('cartContents');
$newItem = paramInt('productId');
$items = explode(',', $cartContents);
$cart = array();
foreach ($items as $item) {
	if (strlen($item) < 3) {
		continue;
	}
	$split = explode(':', $item);
	if (count($split) < 2) {
		return;
	}
	$cart[$split[0]] = $split[1];
}

if (isset($cart[$newItem])) {
	$cart[$newItem]++;
} else {
	$cart[$newItem] = 1;
}

$numPrinted = 0;
$cartStr = '';
foreach ($cart as $id => $count) {
	if ($numPrinted > 0) {
		$cartStr .= ",";
	}
	$cartStr .= "$id:$count";
	$numPrinted++;
}
$_SESSION['session_user_cart'] = $cartStr;
print $cartStr;

?>