<!-- Start Header Area -->
<?php include "header.php" ;
    if(!isset($_SESSION['cart']))
        echo "<script type=\"text/javascript\">
                window.location.href = \"index\";
            </script>";
    if(isset($_SESSION['cart']))
        $cart = $_SESSION['cart'];
    $itemCounter  = 0;
    $cartsubtotal = 0;
    $cartdiscount = 0;
    $carttotal    = 0;
    $giftwrap     = 0;
    $offerdiscount= 0;
    $userdata     = (isset($_SESSION['user']))?	$_SESSION['user']:"GUEST";
?>
<!-- Start Header Area -->

    <!-- Start Checkout -->
    <section class="shop checkout section">
        <div class="container">
            <div class="row"> 
				<div class="col-lg-8 col-12">
					<!-- Shopping Summery -->
					<table class="table shopping-summery">
						<thead>
                        <?php if(!empty($cart)) { ?>
							<tr class="main-hading">
								<th>PRODUCT</th>
								<th>NAME</th>
								<th class="text-center">UNIT PRICE</th>
								<th class="text-center">QUANTITY</th>
								<th class="text-center">TOTAL</th> 
							</tr>
                        </thead>
                        
						<tbody>
                            <?php 
                                foreach($cart as $key=>$value) {
                                    $itemCounter++;
                                    $product = mysqli_fetch_object(getProductById($value['productId']));
                                    $cartsubtotal += ($value['price']*$value['quantity']);
                            ?>
							<tr class="cart-item-<?php echo $value['productId']?>">
                                <td class="image" data-title="No"><a href="product/<?php echo $product->vUrlName; ?>"><img src="uploads/products/sml_<?php echo $product-> vSmallImage;?>" alt="<?php echo $product->vSmallImage_AltTag; ?>"></a></td>
								<td class="product-des" data-title="Description">
									<p class="product-name"><a href="product/<?php echo $product->vUrlName; ?>"><?php echo ucwords($product->vName); ?></a></p>
								<?php if($value['size'] != 'undefined')  { ?><span><b>Size  : </b><?=$value['size']; ?></span><br><?php } ?>
								<?php if($value['color'] != 'undefined') { ?><span><b>Color : </b><?=$value['color']; ?></span><?php } ?>
								</td>
								<td class="price item-price-<?php echo $value['productId']?>" name="<?php echo $value['productId'].'|'. $key ?>" data-title="Price"><span><b>&#8377; <?php echo $value['price']; ?></b></span></td>
								<td class="qty" data-title="Qty"><center><?php echo $value['quantity']; ?></center></td>
								<td class="total-amount-<?php echo $value['productId']?>" data-title="Total"><span><b>&#8377; <?php echo $value['price'] * $value['quantity']; ?></b></span></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <?php } else {
                            echo '<tbody><tr><td colspan="6"><center><h3>Oops!! Cart is Empty</h3></center></td></tr></tbody>';
                        } ?>
					</table>
					<!--/ End Shopping Summery -->
				</div>
			
                <div class="col-lg-4 col-12">
                    <div class="order-details">
                        <!-- Order Widget -->
                        <div class="single-widget">
                            <h2>CART  TOTAL</h2>
                            <div class="content">
                                <ul>
                                    <li>Sub Total<span class="cart-subtotal">&#8377; <?php echo $cartsubtotal; ?></span></li>
                                    <li>(+) Shipping<span><span class="cart-shipping">~ TBC</li>
									<?php if($cartdiscount  > 0) { ?><li>(-) Coupon Discount<span class="cart-discount">&#8377; <?php echo $cartdiscount; ?></span></li><?php } ?>
                                    <?php if($offerdiscount > 0) { ?><li>(-) Offer Discount<span class="cart-offer-discount">&#8377; <?php echo $offerdiscount; ?></span></li><?php } ?>
                                    <li class="last"><b>Total<span class=" cart-total">&#8377; <?php echo $carttotal; ?></span></b></li>
                                </ul>
                            </div>
                        </div>
                        <!--/ End Order Widget -->
                        <!-- Payment Method Widget -->
                        <div class="single-widget payement">
                            <div class="content">
                                <img src="images/payments.png" alt="payments"/>
                            </div>
                        </div>
                        <!--/ End Payment Method Widget -->
                        <!-- Button Widget -->
                        <div class="single-widget get-button">
                            <div class="content">
                                <div class="button">
                                    <a class="final-checkout-btn btn">proceed to pay</a>
                                </div>
                            </div>
                        </div>
                        <!--/ End Button Widget -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Checkout -->

	<!-- Start Footer Area -->
	<?php include "footer.php" ?>
	<!-- /End Footer Area -->
</body>
</html>