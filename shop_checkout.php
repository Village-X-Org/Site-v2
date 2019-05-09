<?php
require_once("utilities.php");

$items = param('items');

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header.inc'); ?>
<div class='container'>
	<H5>Your Shopping Cart</H5>
<?php
$items = explode(',', $items);
$cart = array();
$inString = '';
$count = 0;
foreach ($items as $item) {
	$parts = explode(':', $item);
	$cart[$parts[0]] = $parts[1];

	if ($count > 0) {
		$inString .= ',';
	}
	$inString .= $parts[0];
	$count++;
}

$result = doUnprotectedQuery("SELECT product_id, product_name, product_description, product_price, product_picture, product_donation, picture_filename FROM products JOIN pictures ON product_picture=picture_id WHERE product_id IN ($inString)");
while ($row = $result->fetch_assoc()) {
	$productId = $row['product_id'];
	$quantity = $cart[$productId];
	$productName = $row['product_name'];
	$productDescription = $row['product_description'];
	$productPrice = $row['product_price'];
	$productPicture = ABS_PICTURES_DIR.$row['picture_filename'];
	$productDonation = $row['product_donation'];
	?>
	<div class='card' style='padding:10px;'>
		<div class="row">
			<div class="col s8">
				<span style='font-weight:bold;font-size:18px;'><?php print $productName; ?></span>
				<br/><?php print $productDescription; ?>
				<br/>Quantity: <input class='center' type='text' value='<?php print $quantity; ?>' style='height:20px;width:20px;' onkeydown='updateTotals(this);' /> x $<?php print $productPrice/100; ?> = $<?php print ($quantity * $productPrice / 100); ?>
				<br/>$<?php print ($quantity*$productDonation/100); ?> of this purchase will be donated to the project of your choice!
			</div>
			<div class="col s4 right" style="margin-top:10px;height:200px;width:200px;background-position:center;background-repeat:no-repeat;background-size:auto 200px;background-image:url('<?php print $productPicture; ?>');box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);">
			</div>
		</div>
	</div>
<?php } ?>
<script>
	function updateTotals() {
		
	}
</script>
</div>
<?php 
include('footer.inc'); 
?>