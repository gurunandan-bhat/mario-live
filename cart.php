<!-- Start Header Area -->
<?php include "header.php" ;
if(isset($_SESSION['cart']))
    $cart = $_SESSION['cart'];
$greeting = $greeting_msg = '';
if(isset($_SESSION['greeting-id']) && $_SESSION['greeting-id'] != '')
    $greeting = $_SESSION['greeting-id'];
if(isset($_SESSION['greeting-message']) && $_SESSION['greeting-message'] != '')
    $greeting_msg = $_SESSION['greeting-message'];
$itemCounter  = 0;
$cartsubtotal = 0;
$cartdiscount = 0;
$carttotal    = 0;
$giftwrap     = 0;
$userdata     = (isset($_SESSION['user']))?     $_SESSION['user']:"GUEST";
$greetings    = getAllGreetingCards();
?>
<!-- End Header Area -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="index">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="cart">Cart</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shopping Cart -->
<div class="shopping-cart section">
    <input class="page-name" type="hidden" value="cart"/>
    <div class="container-fluid">
        <div class="cart-terms">
            <span>
		<b style="color:red;">
		    <center>
             <h7>
		    All orders within india will be processed in minimum 7 working days.<br />
		<b style="color:red;">
		    International orders take around 45 to 70 working days to deliver.<br />
            </span>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Shopping Summery -->
                <table class="table shopping-summery">
                    <thead>
                        <?php if (! empty ($cart)) { ?>
                            <tr class="main-hading">
                                <th>PRODUCT</th>
                                <th>NAME</th>
                                <th class="text-center">UNIT PRICE</th>
                                <th class="text-center">QUANTITY</th>
                                <th class="text-center">TOTAL</th>
                                <th class="text-center"><i class="ti-trash remove-icon"></i></th>
                                <th class="text-center">GIFT WRAP</th>
                            </tr>
                    </thead>

                    <tbody class="item-list">
                        <?php
                        foreach ($cart as $key => $value) {
                            $itemCounter++;
                            $status = '';

                            $product = mysqli_fetch_object (getProductById ($value['productId']));
                            $cartsubtotal += $value['price'] * $value['quantity'];

                            if( $value['giftwrap'] == 'Y' ) {
                                $giftwrap += 50;
                                $status = 'checked';
                            }
                        ?>
                        <tr class="cart-item-<?= $value['productId']; ?>">
                            <td class="image" data-title="No">
                                <a href="product/<?= $product->vUrlName; ?>">
                                    <center>
                                        <img src="uploads/products/sml_<?= $product->vSmallImage; ?>" alt="<?= $product->vSmallImage_AltTag; ?>">
                                    </center>
                                </a>
                            </td>
                            <td class="product-des" data-title="Description">
                                <p class="product-name">
                                    <a href="product/<?= $product->vUrlName; ?>">
                                        <?= ucwords($product->vName); ?>
                                    </a>
                                </p>
                                <?php if($value['size'] != 'undefined')  { ?><span><b>Size  : </b><?= $value['size']; ?></span><br><?php } ?>
                                <?php if($value['color'] != 'undefined') { ?><span><b>Color : </b><?= $value['color']; ?></span><?php } ?>
                            </td>
                            <td class="price item-price-<?= $value['productId']; ?>"
				name="<?= $value['productId'] . '|' . $key ?>"
				data-title="Price">
                                <center>
                                    <span><b>&#8377; <?php echo $value['price']; ?></b></span>
                                </center>
                            </td>
                            <td class="qty" data-title="Qty"><center>
                                <!-- Input Order -->
                                <div class="input-group">
                                    <div class="button minus">
                                        <button type="button"
                                                name="<?= $value['productId'] . '|' . $key ?>"
                                                class="btn btn-primary btn-number cart-item-minus"
                                                <?= ($value['quantity'] == 1) ? 'disabled="disabled"' : ''; ?>
                                                data-type="minus"
                                                data-field="quant[<?= $itemCounter; ?>]">
                                            <i class="ti-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text"
                                           name="quant[<?= $itemCounter ?>]"
                                           class="input-number item-qty-<?= $value['productId']?>"
                                           data-min="1" data-max="100"
                                           value="<?= $value['quantity']; ?>"
                                           readonly>
                                    <div class="button plus">
                                        <button type="button"
                                                name="<?= $value['productId'].'|'. $key ?>"
                                                class="btn btn-primary btn-number cart-item-add"
                                                data-type="plus"
                                                data-field="quant[<?= $itemCounter ?>]">
                                            <i class="ti-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <!--/ End Input Order -->
                            </center></td>
                            <td class="total-amount-<?= $value['productId']?>" data-title="Total">
                                <center>
                                    <span><b>&#8377; <?= $value['price'] * $value['quantity']; ?></b></span>
                                </center>
                            </td>
                            <td class="action delete-btn" data-title="Remove">
                                <center>
                                    <a class="cart-item-delete" name="<?= $value['productId'].'|'. $key ?>">
                                        <i class="ti-trash remove-icon"></i>
                                    </a>
                                </center>
                            </td>
                            <td name="<?= $value['productId']; ?>">
                                <center>
                                    <input class="gift-wrap cart-item-gift-wrap-<?= $value['productId']; ?>"
                                           type="checkbox"
                                           id="<?= $value['productId'];?>"
                                           name="giftwrap"
                                           <?= $status; ?>>
                                </center>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                        <?php }
                        else { ?>
                            <tbody class="empty-cart">
                                <tr>
                                    <td colspan="6">
                                        <center>
                                            <h3>
                                                Oops!! Cart is Empty
                                            </h3>
                                        </center>
                                    </td>
                                </tr>
                            </tbody>
                            <?php } ?>
                </table>
                <!--/ End Shopping Summery -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form method="post" action="#" onsubmit="validateCart(this)">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <?php if (!empty($cart)) { ?>
                                <div class="col-lg-8 col-md-5 col-12">
                                    <div class="greeting-section">
                                        <input type="hidden" class="selected-greeting" value="<?= $greeting; ?>"/>
                                        <div>
                                            <span>Choose your greeting card</span><br>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="owl-carousel popular-slider">
                                                        <?php for ($i=0; $o = mysqli_fetch_object($greetings); $i++) { ?>
                                                            <div class="single-product">
                                                                <center>
                                                                    <div class="product-img">
                                                                        <a class="greeting-select" id="greeting-select-<?= $o->iGWCardID; ?>" name="<?= $o->iGWCardID; ?>">
                                                                            <img  class="default-img" src="uploads/giftwrap_cards/<?= $o-> vPic; ?>" alt="<?= $o-> vName; ?>">
                                                                        </a>
                                                                    </div>
                                                                </center>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <span>Gift wrap at an extra charge of ₹50.00</span><br>
                                            <input class="greeting-message" type="text" placeholder="Enter your message" value="<?= $greeting_msg; ?>"><br>
                                            <button class="greeting-btn">
                                                <?= ($greeting_msg == '') ? 'Add Message' : 'Edit Message'; ?>
                                            </button>
                                            <br>
                                            <span>
                                                We will wrap your gift
                                                with one of our fun
                                                Mario gift papers and
                                                add a personalised
                                                card of your choice
                                                along with it!
                                            </span>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="left">
                                        <div class="coupon">
                                            <input class="coupon-code" name="Coupon" placeholder="Enter Your Coupon">
                                            <input class="coupon-mini" value='' type="hidden"/>
                                            <button class="btn coupon-btn" onclick="event.preventDefault()">Apply</button>
                                        </div>
                                        <span class="coupon-error"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-7 col-12">
                                    <div class="right cart-summary">
                                        <ul>
                                            <li>Cart Subtotal
                                                <span class="cart-subtotal">
                                                    <b>&#8377; <?= $cartsubtotal ?></b>
                                                </span>
                                            </li>
                                            <li class="gift-wrap-line">
                                                Gift Wrap
                                                <span class="gift-wrap-total">
                                                    <b>&#8377; <?= $giftwrap ?></b>
                                                </span>
                                            </li>
                                            <li>
                                                Discount
                                                <span class="cart-discount">
                                                    <b>- &#8377; <?= $cartdiscount ?></b>
                                                </span>
                                            </li>
                                            <li class="last">
                                                Total
                                                <span class="cart-total">
                                                    <b>&#8377; <?= $cartsubtotal + $giftwrap - $cartdiscount ?></b>
                                                </span>
                                            </li>
                                        </ul>
                                        <div class="button5">
                                            <a href="checkout" class="btn order-checkout-btn">Checkout</a>
                                            <a href="index" class="btn continue-shop-btn">Continue shopping</a>
                                            <input type="hidden" class="user-data" value="<?= $userdata ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="col-lg-8 col-md-5 col-12"></div>
                                <div class="col-lg-4 col-md-7 col-12">
                                    <div class="right">
                                        <div class="button5">
                                            <a href="index" class="btn">Continue shopping</a>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </form>
            </div>
        </div>
    </div>
    <br><br>
</div>
<!--/ End Shopping Cart -->
<!-- Start Footer Area -->
<?php include "footer.php" ?>
<!-- /End Footer Area -->
</body>
</html>
