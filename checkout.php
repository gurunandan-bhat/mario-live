<?php
include "header.php";
const INDIA = '214';

if(!isset($_SESSION['cart'])) { ?>
    <script type="text/javascript">window.location.href="index";</script>
<?php }

$destCountries   = getCountriesList();

$cartsubtotal    = 0;
$cartdiscount    = 0;
$offerdiscount   = 0;
$cartTotal       = 0;
$shippingcharges = 0;
$giftwrap        = 0;
$cartdata        = '';

$FREE_QTY        = array();
$GIFT_WRAP_INR   = 50;

if (isset($_SESSION['cart'])) {

    $cart = $_SESSION['cart'];

    foreach ($cart as $key => $value) {
        $cartdata = $cartdata . $value['productId'] . '-' . $value['quantity'] . '|';
        $cartsubtotal += $value['price'] * $value['quantity'];

        if ( $value['giftwrap'] == 'Y')
            $giftwrap += $GIFT_WRAP_INR;

        $price    = $value['price'];
        $offer = checkOfferByCategoryAndQuantity ($value['category'], $value['quantity']);

        if( !empty($offer) ) {

            $offerMul = floor ($value['quantity']/($offer->minQuantity));

            switch($offer->offerType)   {

                case "FREEQTY":
                    $offerdiscount      = $offerdiscount + ($offerMul * $price);
                    $FREE_QTY[$value['productId']] = ($offerMul * $offer->freeQuantity);
                    break;
                case "AMTDISC":
                    $offerdiscount      = $offerdiscount + ($offerMul * (($offer->minQuantity * $price) - $offer->discountedAmt));
                    break;
                case "PERDISC":
                    $offerdiscount      = $offerdiscount + ($offerMul * (($offer->minQuantity * $price * $offer->discountedPer)/100));
                    break;
            }
        }
    }
    //$offerdiscount = 0; //disabled due to deviation in requirement
}

if( isset ($_SESSION['coupon']) && $_SESSION['coupon'] != '')    {
    $coupondata   = mysqli_fetch_object(findCouponByCode($_SESSION['coupon']));
    $cartdiscount = $coupondata['fValue'];
}



// Just get the first row.
$userData  = $_SESSION['user'] ?? 0;
$useraddrlist = mysqli_fetch_object (getAllAddressByUserId ($userData));

$name       = $useraddrlist -> vName          ?? '';
$address    = $useraddrlist -> vAddress       ?? '';
$city       = $useraddrlist -> vCity          ?? '';
$state      = $useraddrlist -> vState         ?? '';
$country    = $useraddrlist -> iPostCountryID ?? '';
$pincode    = $useraddrlist -> vPincode       ?? '';
$phone      = $useraddrlist -> vPhone         ?? '';
$email      = $useraddrlist -> vEmail         ?? '';

//Courier Charges
if( isset($country) &&
    $country != '' &&
    isset($cartdata) &&
    $cartdata != '') {

    $cart = substr ($cartdata, 0, -1);
    $ctry = $country;

    if($ctry == INDIA) {
        $shippingcharges =  0.0;
    }
    else {
	$query = <<<INTERNATIONAL
	SELECT
	    fInternationalShippingCharge
	FROM
	seo_settings
	INTERNATIONAL;

        $charge = mysqli_fetch_object(fireQuery($query));

        $shippingcharges = $charge->fInternationalShippingCharge;
    }
}

$cartTotal = $cartsubtotal
                 + $shippingcharges
                 + $giftwrap
	         - $offerdiscount
	         - $cartdiscount;

function calculateShippingCharges($cart) {

	 return 0;

    $cartitems  = explode('|',$cart);
    $prodWeight= 0;

    foreach ($cartitems as $product) {

        $prodMeta   = explode('-',$product);
        $prodid     = $prodMeta[0];
        $quantity   = $prodMeta[1];

	$prodQuery  =<<<WEIGHT
	SELECT
	    fActualWeight,
	    fVolumetricWeight
	FROM
	    product
	WHERE
	    iProdID = {$prodid}
	WEIGHT;

        $prodresult = mysqli_fetch_object(fireQuery($prodQuery));

        $prodWeight += $quantity *
	    max ($prodresult->fActualWeight, $prodresult->fVolumetricWeight);
    }

    $blueDQuery =<<<SHIPPING
    SELECT
        fMinWeight,
        fPricePerWeight,
        fAdditionalWeight,
        fAdditionalPrice,
        fFuelSurchargePercentage,
        fCAFPercentage,
        fAWBAmount,
        fInsuracePercentage,
        fSTPercentage
    FROM
        bluedart_settings
    SHIPPING;

    $blueresult = mysqli_fetch_object(fireQuery($blueDQuery));
    $unitCalculation  = ceil($prodWeight/$blueresult->fMinWeight);

    if ($unitCalculation == 1)
        $chargeBeforeTax  = $blueresult->fPricePerWeight;
    else
        $chargeBeforeTax  = $blueresult->fPricePerWeight + ($unitCalculation - 1) * $blueresult->fAdditionalPrice;

    $chargeWFuelSurch = $chargeBeforeTax * (1 + ($blueresult->fFuelSurchargePercentage/100));
    $chargeWCAFPercen = $chargeWFuelSurch * (1 + ($blueresult->fCAFPercentage/100));
    $chargeWAWBAmount = $chargeWCAFPercen + $blueresult->fAWBAmount;
    $chargeWInsurance = $chargeWAWBAmount * (1 + ($blueresult->fInsuracePercentage/100));

    $shippingCharge   = ceil ($chargeWInsurance * (1 + ($blueresult->fSTPercentage/100)));

    return $shippingCharge;
}

?>
<style>
    label.error {
	color: red !important;
	padding-left: 10px;
    }
</style>
<!-- Start Header Area -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="index">Home<i class="ti-arrow-right"></i></a></li>
                        <li><a href="cart">Cart<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="checkout">Checkout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Start Checkout -->
<section class="shop checkout section">
    <div class="container">
        <div class="row">
            <h2><?= $userData == 'GUEST' ? 'Add' : 'Edit and confirm'; ?> your Shipping Address</h2>
        </div>
        <form class="form" action="place-order" method="post" id="toOrder">
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-form">
                        <div class="row">
                            <input type="hidden" name="user" value="<?= $userData; ?>">
			    <input type="hidden" name="cartdata" class="cart-data" value="<?= $cartdata; ?>">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Name<span>*</span></label>
                                    <input type="text" name="name" id="name" placeholder="" value="<?= $name; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Email Address<span>*</span></label>
                                    <input type="email" name="email" id="email" placeholder="" value="<?= $email; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Phone Number<span>*</span></label>
                                    <input type="text" name="contact" id="contact" placeholder="" value="<?= $phone; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Address Line<span>*</span></label>
                                    <input type="text" name="address" id="address" placeholder="" value="<?= $address; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>City<span>*</span></label>
                                    <input type="text" name="city" id="city" placeholder="" value="<?= $city; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>State<span>*</span></label>
                                    <input type="text" name="state" id="state" placeholder="" value="<?= $state; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Country<span>*</span></label>
                                    <select name="country" class="form-select customer-address-city" id="country" selected="<?= $country; ?>" required>
                                        <option value="">Select Your Country</option>
                                        <?php for ($i=0; $o = mysqli_fetch_object ($destCountries); $i++) { ?>
                                            <option value="<?= $o -> iPostID; ?>"
                                                    <?= $o -> iPostID == $country ? 'selected' : ''; ?>>
                                                <?= $o -> vCountryName; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label>Postal Code<span>*</span></label>
                                    <input type="text" name="pincode" id="pincode" placeholder="" value="<?= $pincode; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="order-details">
                        <!-- Order Widget -->
                        <div class="single-widget">
                            <h2>CART  TOTAL</h2>
                            <div class="content">
                                <ul>
                                    <li>Sub Total<span class="cart-subtotal">&#8377; <?= $cartsubtotal; ?></span></li>
                                    <?php if ($giftwrap  > 0) { ?>
                                        <li>(+) Gift Wrap <span class="cart-gift-wrap">&#8377; <?= $giftwrap; ?></span></li>
                                    <?php } ?>
                                    <li>(+) Shipping<span class="cart-shipping"><?= $shippingcharges; ?></span></li>
                                        <?php if($cartdiscount  > 0) { ?>
                                            <li>(-) Coupon Discount<span class="cart-discount">&#8377; <?= $cartdiscount; ?></span></li>
                                        <?php }
                                        if($offerdiscount > 0) { ?>
                                            <li>(-) Offer Discount<span class="cart-offer-discount"> &#8377; <?= $offerdiscount; ?></span></li>
                                        <?php } ?>
                                        <li class="last"><b>Total<span class=" cart-total">&#8377; <?= $cartTotal; ?></span></b></li>
                                </ul>
                                <!--/ End Order Widget -->
                                <!-- Currency Selector and Converter -->
                                <h2>Choose your currency</h2>
                                <p>
                                    Each currency option shows the current
                                    value of your order in that currency
                                    in our opinion. <b>The actual value you will be
                                    charged depends on your Bank or
                                    Credit/Debit Card Company and may
                                    differ slightly from the value shown
                                    here.</b>
                                </p>
                                <div class="container" id="currencySelector">
                                    <?php
                                    $currencyValue = $marioDB -> currencyCalculator ($cartTotal);
                                    ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="currency" id="currencyINR" value="INR" checked>
                                        <label class="form-check-label" for="currencyINR">INR (Value is &#8377 <?= $cartTotal; ?>)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="currency" id="currencyUSD" value="USD">
                                        <label class="form-check-label" for="currencyUSD">USD (Value is &dollar; <?= $currencyValue ['USD']; ?>)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="currency" id="currencyGBP" value="GBP">
                                        <label class="form-check-label" for="currencyGBP">GBP (Value is &pound; <?= $currencyValue ['GBP']; ?>)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="currency" id="currencyEUR" value="EUR">
                                        <label class="form-check-label" for="curencyEUR">EUR (Value is &euro; <?= $currencyValue ['EUR']; ?>)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="currency" id="currencyCAD" value="CAD">
                                        <label class="form-check-label" for="curencyEUR">CAD (Value is CAD &dollar; <?= $currencyValue ['CAD']; ?>)</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Payment Method Widget -->
                            <div class="single-widget payement">
                                <div class="content">
                                    <img src="images/payments.png" alt="payments"/>
                                </div>
                            </div>
                            <!--/ End Payment Method Widget -->
                            <!-- Button Widget -->
                            <div class="single-widget get-button">
                                <input type="submit" class="btn btn-primary btn-success" id="to_pay" value="Proceed to Pay" />
                            </div>
                            <!--/ End Button Widget -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!--/ End Checkout -->

<!-- Start Footer Area -->
<?php include "footer.php" ?>
<!-- /End Footer Area -->
<script src="js/jquery.validate.min.js"></script>
<script>
 $(document).ready(function () {

     $('#toOrder').validate({
	 ignore: [],
	 errorPlacement: function(error, element) {
             error.insertBefore(element);
         },
	 submitHandler: function (form) {
	     form.submit();
	 }
     });
 });
 </script>
</body>
</html>
