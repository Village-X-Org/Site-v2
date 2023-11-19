<?php
require_once("utilities.php");

if (!hasParam('items')) {
	return;
}
$itemStr = param('items');

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header.inc'); ?>
<div class='container'>
	<H5>Your Shopping Cart</H5>
<?php
$items = explode(',', $itemStr);
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
$stmt = prepare("SELECT product_id, product_name, product_description, product_price, product_picture, product_donation, picture_filename FROM products JOIN pictures ON product_picture=picture_id WHERE product_id IN (?)");
$stmt->bind_param("s", $inString);
$result = execute($stmt);
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
			<select name="shop_project_id" onchange="$('#projectId').val(this.value);">
            	<option>Select Project to Fund with Your Purchase</option>
            	  <?php $result = doUnprotectedQuery("SELECT project_id, picture_filename, project_name, project_budget, project_funded, village_name 
                FROM projects JOIN pictures ON picture_id=project_profile_image_id JOIN villages ON village_id=project_village_id 
                WHERE project_funded < project_budget ORDER BY (project_funded / project_budget) DESC");
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
<div style='text-align:right;font-size:18px;'>--------------------------------------------</span></div>
<div style='text-align:right;font-size:18px;'>Amount reserved for Projects: $<span id='totalDonation'><?php print $totalDonation; ?></span></div>
<form action="purchaseWithStripe.php" id="purchaseForm" method='post' action="purchaseWithStripe.php">
	<input type='hidden' id='order' name='order' value='<?php print $itemStr; ?>' />
 	<input type='hidden' name='stripeToken' value='' />
 	<input type='hidden' name='stripeEmail' value='' />
 	<input type='hidden' id='stripeAmount' name='stripeAmount' value='<?php print (($totalPrice + getShippingCost()) * 100); ?>' />
	<input type='hidden' id='projectId' name='projectId' value='' />
	<input type='hidden' id='shippingName' name='shippingName' value='' />
	<input type='hidden' id='shippingStreet' name='shippingStreet' value='' />
	<input type='hidden' id='shippingApt' name='shippingApt' value='' />
	<input type='hidden' id='shippingCity' name='shippingCity' value='' />
	<input type='hidden' id='shippingState' name='shippingState' value='' />
	<input type='hidden' id='shippingZip' name='shippingZip' value='' />
	<div style='text-align:right;margin-top:30px;margin-bottom:40px;'><input type='submit' class='btn' id="checkoutButton" value='Checkout with Stripe' onclick="purchaseWithStripe();return false;" /></div>
</form>

<script src="https://checkout.stripe.com/checkout.js" ></script>
<script>
	function getItemString() {
		return ''<?php foreach ($items as $item) {
			$parts = explode(':', $item);
			$id = $parts[0];
			print " + '$id:' + $('#quantityFor' + $id).val() + ','";
		} ?>;
	}

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

		document.getElementById('stripeAmount').value = (overallTotal + <?php print getShippingCost(); ?>) * 100;
		document.getElementById('order').value = getItemString();

	}

	var handler = StripeCheckout.configure({
	  key: '<?php print (isset($_SESSION['test']) && $_SESSION['test'] ? STRIPE_TEST_API_KEY : STRIPE_API_KEY); ?>',
	  image: 'https://villagex.org/images/logox.jpg',
	  locale: 'auto',
	  token: function(token, args) {
		  form = document.getElementById('purchaseForm');
		  form.stripeToken.value = token.id;
		  form.stripeEmail.value = token.email;
  		  form.shippingName.value = args.shipping_name;
  		  form.shippingStreet.value = args.shipping_address_line1;
  		  if (args.shipping_address_line2) {
		  	form.shippingApt.value = args.shipping_address_line2;
		  } else {
		  	form.shippingApt.value = '';
		  }
  		  form.shippingCity.value = args.shipping_address_city;
		  form.shippingState.value = args.shipping_address_state;
  		  form.shippingZip.value = args.shipping_address_zip;
		  form.submit();
	  }
	});

	function purchaseWithStripe() {
	  handler.open({
	    name: 'Complete Your Purchase',
	    amount: parseInt($('#stripeAmount').val()),
        shippingAddress: true,
        billingAddress: true
	  });
	}

</script>
</div>
<?php 
include('footer.inc'); 
?>