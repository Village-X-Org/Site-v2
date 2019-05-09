<?php
require_once("utilities.php");
$cartContents = isset($_SESSION['session_user_cart']) ? $_SESSION['session_user_cart'] : '';
$cartCount = $cartContents === '' ? 0 : count(explode(',', $cartContents));

$productCat = 0;
if (hasParam('cat')) {
	$productCat = param('cat');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header.inc'); ?>

<div class="container">

	<div class="row" style="padding:3% 1% 1% 1%;">

		<div class="col s12 m6 l4 valign-wrapper" style="vertical-align: middle; height:50px; padding:1% 1% 1% 1%;">		
    		    <!-- Dropdown Trigger -->
      		<a class="dropdown-trigger btn donor-background" style="display: block; margin: 0 auto;" href='#' data-target='dropdown1' id='catFilter'>Filter by Category</a>

            <!-- Dropdown Structure -->
          	<ul id="dropdown1" class="dropdown-content" style="margin-left:25px;margin-top:50px;">
          		<li><a href="#!" onclick="catFilter=0; $('.shopCell').show(); $('#catFilter').html('Filter by Category'); return false;">All</a></li>
          		<?php 
          			$categories = array();
          			$result = doUnprotectedQuery("SELECT pc_id, pc_label FROM product_categories");
          			while ($row = $result->fetch_assoc()) {
          				$categoryLabel = $row['pc_label'];
          				$stripped = strtolower(preg_replace("/(?)[\p{P} ]/u", "", $categoryLabel));
          				print "<li><a id='option$stripped' href='' onclick=\"$('.shopCell').hide();partnerFilter='$stripped';className = '.$stripped';$(className).show(); $('#catFilter').html('".str_replace("'", "\\'", $categoryLabel)." &nbsp;&nbsp;&#10004;'); return false;\">$categoryLabel</a></li>";
          			}
          		?>
          	</ul>
          </div>
          <div class="col s12 m6 l8 center" style="padding-top:15px;font-weight:500;">
          	100% of proceeds go directly to our projects!
          </div>
      </div>
	<div class="section"><div class='row'>		
		<script>
			var productMapping = new Array();
		</script>
			<?php 
	if (!CACHING_ENABLED || !file_exists(CACHED_SHOP_FILENAME.$donorId)) {
		ob_start();
		$query = "SELECT product_id, product_name, product_description, product_price, picture_filename, product_category, pc_label, product_stock FROM products JOIN pictures ON picture_id=product_picture JOIN product_categories ON pc_id=product_category";
        $result = doUnprotectedQuery($query);

		$count = 0;
		while ($row = $result->fetch_assoc()) {
			$productId = $row['product_id'];
			$productName = $row['product_name'];
			$productDescription = $row['product_description'];
			$productPrice = $row['product_price'] / 100;
			$productStock = $row['product_stock'];
			$productPicture = $row['picture_filename'];
			$productCategory = $row['product_category'];
			$categoryLabel = $row['pc_label'];
          	$stripped = strtolower(preg_replace("/(?)[\p{P} ]/u", "", $categoryLabel));
          	?>
          	<script>
          		productMapping[<?php print $productId; ?>] = '<?php print $productPicture; ?>';
          	</script>
		      	<div class='col s12 m6 l4 shopCell <?php print $stripped; ?>' style='min-width:225px;cursor:pointer;'>
					<div class='card sticky-action hoverable'>
						<div class='card-image'>
							<div class='activator' style="height:325px;background:url('<?php print PICTURES_DIR.$productPicture; ?>');background-size:cover;background-position:center;"></div>
						</div>
						<div class='card-content' style='padding-top:0;margin-top:0;'>
							<h2 class='card-title activator gray-text text-darken-4' style='padding-top:0;margin-top:0;'>
								<TABLE><TR>
									<TD><?php print $productName; ?></TD>
									<TD style='text-align:right;'><b>$<?php print $productPrice; ?></b></TD>
								</TR></TABLE>
							</h2>
							<span><?php print $productDescription; ?></span>
						</div>
           	 	     	<div class='row center'>
							<div class='col s12' style='margin-bottom:15px;'>
								<?php if ($productStock > 0) { ?>
		      					<a href=''id='purchase_button' class='btn waves-effect waves-light donor-background lighten-1' 
		      					onclick="this.innerText='Added &nbsp;&nbsp;&#10004';addToCart(<?php print $productId; ?>); return false;">Add to Cart</a>
		      				<?php } else { ?>
								<a href=''id='purchase_button' class='btn waves-effect waves-light donor-background lighten-1 disabled'>Out of Stock</a>
		      				<?php } ?>
							</div>
                        </div>
					</div>
				</div>
			<?php 
		    $count++;
		}

    	$contents = ob_get_contents();
    	ob_end_clean();
		if (CACHING_ENABLED) {
		  $handle = fopen(CACHED_SHOP_FILENAME.$donorId, 'w');
		  fwrite($handle, $contents);
		  fclose($handle);
		} else {
		    print $contents;
		}
	}
	if (CACHING_ENABLED) {
	   include(CACHED_SHOP_FILENAME.$donorId);
	}
?>			</div><!-- row end -->
		</div> <!-- section end -->
		
		<br><br>

</div>
<div class="fixed-action-btn" id='cartButton' style='<?php print ($cartCount > 0 ? '' : 'display:none'); ?>'>
  <a class="btn-floating btn-large" onclick="goToCheckout();">
    <i class="large material-icons">shopping_cart</i>
  </a>
  <ul id='productList'>
  </ul>
  <span style='width:10px;position:absolute;bottom:10px;right:10px;z-index:1;font-weight:bold;font-size:11px;color:white;' id='cartCount'>
  		<?php print $cartCount; ?></span>
</div>
<script>
	var cartContents = '<?php print $cartContents; ?>';
	var instance = 0;
	function addToCart(productId) {
		$.post('shop_addToCart.php', {productId: productId, cartContents: cartContents}, function(response) {
			$('#cartButton').show();
			cartContents = response;
			$('#cartCount').html(cartContents.split(',').length);
			
			populateProductList();

			var cartButton = document.getElementById('cartButton');
			var instance = M.FloatingActionButton.init(cartButton, {});
			instance.open();
			setTimeout(function() { instance.close(); }, 1000);
		});
	}

	function populateProductList() {
		productList = document.getElementById('productList');
		while (productList.firstChild) {
    		productList.removeChild(productList.firstChild);
		}

		items = cartContents.split(',');
		items.forEach(function(item) {
			parts = item.split(':');

			li = document.createElement('li');
			img = document.createElement('img');
			img.classList = 'btn-floating white';
			img.src = '<?php print PICTURES_DIR; ?>' + productMapping[parts[0]];
			img.style = 'width:64px;height:64px;vertical-align:middle;';
			li.appendChild(img);
			productList.appendChild(li);
		});
	}
	populateProductList();

	function goToCheckout() {
		document.location = 'shop_checkout.php?items=' + cartContents;
	}

	<?php
	if ($productCat !== 0) {
        print "\$( document ).ready(function() { \$('#option$productCat').trigger('click'); });";
    }
    ?>
</script>

<?php 
include('footer.inc'); 
?>