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

$totalPrice = 0;
$totalDonation = 0;
$result = doUnprotectedQuery("SELECT product_id, product_name, product_description, product_price, product_picture, product_donation, picture_filename FROM products JOIN pictures ON product_picture=picture_id WHERE product_id IN ($inString)");
while ($row = $result->fetch_assoc()) {
	$productId = $row['product_id'];
	$quantity = $cart[$productId];
	$productName = $row['product_name'];
	$productDescription = $row['product_description'];
	$productPrice = $row['product_price'];
	$productPicture = ABS_PICTURES_DIR.$row['picture_filename'];
	$productDonation = $row['product_donation'] / 100;
	$productTotal = ($quantity * $productPrice / 100);
	$totalPrice += $productTotal;
	$totalDonation += $productDonation * $quantity
	?>
	<div class='card' style='padding:10px;'>
		<div class="row">
			<div class="col s8">
				<span style='font-weight:bold;font-size:18px;'><?php print $productName; ?></span>
				<br/><?php print $productDescription; ?>
				<input type='hidden' id='donationAmountFor<?php print $productId; ?>' value='<?php print $productDonation; ?>' />
				<input type='hidden' id='totalDonationFor<?php print $productId; ?>' class='totalProductDonation' value='<?php print ($productDonation * $quantity); ?>' />
				<br/>Quantity: <input id='quantityFor<?php print $productId; ?>' class='center' type='text' value='<?php print $quantity; ?>' style='height:20px;width:20px;' onkeyup="updateTotals('<?php print $productId; ?>');" /> x $<span id='priceFor<?php print $productId; ?>'><?php print $productPrice/100; ?></span> = $<span class='totalPrice' id='totalFor<?php print $productId; ?>'><?php print $productTotal; ?></span>
				<br/>$<span id='donationFor<?php print $productId; ?>'><?php print ($productDonation); ?></span> of each item will be donated to the project of your choice!
			</div>
			<div class="col s4 right" style="margin-top:10px;height:200px;width:200px;background-position:center;background-repeat:no-repeat;background-size:auto 200px;background-image:url('<?php print $productPicture; ?>');box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);">
			</div>
		</div>
	</div>
<?php } ?>

	<div class="row">
    	<div class="input-field col s12 donor-text" style="font-size:18px;vertical-align:middle;">
			<select name="shop_project_id">
            	<option>Select Project to Fund with Your Purchase</option>
            	  <?php $result = doUnprotectedQuery("SELECT project_id, picture_filename, project_name, project_budget, project_funded, village_name 
                FROM projects JOIN pictures ON picture_id=project_profile_image_id JOIN villages ON village_id=project_village_id 
                WHERE project_funded < project_budget ORDER BY (project_funded / project_budget) ASC");
              while ($row = $result->fetch_assoc()) {
                $projectId = $row['project_id'];
                $pictureFilename = $row['picture_filename'];
                $projectName = $row['project_name'];
                $projectBudget = $row['project_budget'];
                $projectFunded = $row['project_funded'];
                $villageName = $row['village_name'];
                $percent = round(100 * $projectFunded / $projectBudget);
                $remaining = $projectBudget - $projectFunded;

                print "<option data-icon='".PICTURES_DIR."$pictureFilename' class='left circle' value='$projectId'>$projectName in $villageName ($percent% funded, $$remaining to go)</option>";
              }
              ?>
          	</select>      
		</div>				
	</div>
     						
	<script>
     $(document).ready(function() {
		     $('#shop_project_id').formSelect();
			  });
    </script>


<div style='text-align:right;font-size:18px;'>Price of Product(s): $<span id='totalPrice'><?php print $totalPrice; ?></span></div>
<div style='text-align:right;font-size:18px;'>Shipping: $<span id='shipping'><?php print getShippingCost(); ?></span></div>
<div style='text-align:right;font-size:18px;'>Total Purchase Price: $<span id='totalWithShipping'><?php print $totalPrice + getShippingCost(); ?></span></div>
<div style='text-align:right;font-size:18px;'>-------------------------</span></div>
<div style='text-align:right;font-size:18px;'>Amount for Projects: $<span id='totalDonation'><?php print $totalDonation; ?></span></div>
<div style='text-align:right;margin-top:10px;margin-bottom:40px;'><button class='btn' id="checkoutButton">Checkout with Stripe</button></div>


<script>
	function updateTotals(id) {
		quantity = document.getElementById('quantityFor' + id).value;
		price = document.getElementById('priceFor' + id).innerText;
		totalCell = document.getElementById('totalFor' + id);
		donationAmountFor = document.getElementById('donationAmountFor' + id).value;
		totalDonationForCell = document.getElementById('totalDonationFor' + id);

		if (!quantity) {
			quantity = 0;
		}
		totalCell.innerText = quantity * price;

		overallTotalCell = document.getElementById('totalPrice');
		overallDonationCell = document.getElementById('totalDonation');
		totalDonationForCell.value = quantity * donationAmountFor;

		overallTotal = 0;
		totals = document.getElementsByClassName('totalPrice');
		for (i = 0; i < totals.length; i++) {
			overallTotal += parseInt(totals[i].innerText);
		}
		overallTotalCell.innerText = overallTotal;

		overallDonation = 0;
		donations = document.getElementsByClassName('totalProductDonation');
		for (i = 0; i < donations.length; i++) {
			overallDonation += parseInt(donations[i].value);
		}
		overallDonationCell.innerText = overallDonation;

		totalWithShippingCell = document.getElementById('totalWithShipping');
		totalWithShippingCell.innerText = overallTotal + <?php print getShippingCost(); ?>;
	}

	  document.getElementById('checkoutButton').addEventListener('click', function(e) {
	  handler.open({
	    name: 'Village X Org',
	    description: 'Shop Checkout',
	    amount: $('#totalWithShipping').val() * 100,
        shippingAddress: true,
        billingAddress: true
	  });
	  e.preventDefault();
	});
</script>
</div>
<?php 
include('footer.inc'); 
?>