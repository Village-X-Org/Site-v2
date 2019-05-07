<?php
require_once("utilities.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header.inc'); ?>

<div class="container">

	<div class="row" style="padding:3% 1% 1% 1%;">

		<div class="col s12 m4 l4 valign-wrapper" style="vertical-align: middle; height:50px; padding:1% 1% 1% 1%;">		
	
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
          				print "<li><a href='' onclick=\"$('.shopCell').hide();partnerFilter='$stripped';className = '.$stripped';$(className).show(); $('#catFilter').html('".str_replace("'", "\\'", $categoryLabel)." &nbsp;&nbsp;&#10004;'); return false;\">$categoryLabel</a></li>";
          			}
          		?>
          	</ul>
          </div>
      </div>
		
	<div class="section"><div class='row'>		
			<?php 
	if (!CACHING_ENABLED || !file_exists(CACHED_SHOP_FILENAME)) {
		$query = "SELECT product_id, product_name, product_description, product_price, picture_filename, product_category, pc_label, product_stock FROM products JOIN pictures ON picture_id=product_picture JOIN product_categories ON pc_id=product_category";
        $result = doUnprotectedQuery($query);

		$buffer = '';
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
		      					onclick="this.innerText='Added &nbsp;&nbsp;&#10004;addToCart(<?php print $productId; ?>);'; return false;">Add to Cart</a>
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
		if (CACHING_ENABLED) {
		  $handle = fopen(CACHED_SHOP_FILENAME.$donorId, 'w');
		  fwrite($handle, $buffer);
		  fclose($handle);
		} else {
		    print $buffer;
		}
	}
	if (CACHING_ENABLED) {
	   include(CACHED_SHOP_FILENAME.$donorId);
	}
?>			</div><!-- row end -->
		</div> <!-- section end -->
		
		<br><br>

</div>
<script>
	var cart = new Array();
	<?php
		if (isset($_SESSION['cart'])) {
			foreach ($_SESSION['cart'] as $item) {
				print "cart.push($item);";
			}
		}
	?>

	function addToCart(productId) {
		cart.push(productId);
	}
</script>

<?php 
include('footer.inc'); 
?>
