<?php
session_start();
include('config/api.php');

const INDIA = 214;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {

    $keys = array_keys($_POST);
    $required_keys = array(
        'name',
        'email',
        'contact',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'currency',
        'user',
        'cartdata'
    );

    $missing_keys = array();
    foreach ($required_keys as $key) {
        if (array_key_exists($key, $_POST) && $_POST[$key] != '')
            continue;
        else
            $missing_keys[] = $key;
    }

    if (sizeof($missing_keys) > 0) {
        header('Location: checkout');
        exit();
    }
} else {
    header('Location: checkout');
    exit();
}

$cartTotalAmount = 0;

if (
    isset($_SESSION['cart']) &&
    $_SESSION['cart'] != ''
) {

    $user = $_POST['user'] ?? 0;
    $cart = $_SESSION['cart'];

    $giftWrapMessage = $_SESSION['greeting-message'] ?? '';
    $giftWrapCard    = $_SESSION['greeting-id'] ?? 0;
    $giftWrap        = 'N';

    $cartTotal       = getCartTotal($cart);
    $giftWrapCharges = $_SESSION['GIFT_WRAP_CHARGES'];

    $discount = $discountId = 0;
    if (isset($_SESSION['coupon']) && $_SESSION['coupon'] != '') {

        $discount   = mysqli_fetch_object(findCouponByCode($_SESSION['coupon']))->fValue;
        $discountId = mysqli_fetch_object(findCouponIdByCouponCode($_SESSION['coupon']))->ID;
    }

    $discount  += calculateOfferDiscount($cart);

    $shipping   = calculateShippingCharge($_POST['country'], $cart);
    $orderTotal = $cartTotal - $discount + $shipping;
    $countryName = getCountryNameById($_POST['country']);

    $newOrderId = placeOrder(
        $user,
        $_POST['name'],
        $_POST['address'],
        $_POST['city'],
        $_POST['state'],
        $_POST['country'],
        $_POST['pincode'],
        $_POST['contact'],
        $_POST['email'],
        $cartTotal,
        $discount,
        $shipping,
        $orderTotal,
        'I',
        'N',
        'P',
        $discountId,
        $discount,
        $giftWrapCharges,
        $giftWrapMessage,
        $giftWrapCard
    );

    if (!isset($newOrderId) || $newOrderId == 0) {
        error_log("Invalid new orderID");
        header('Location: /cart');
        exit();
    }

    updateOrderMetaData($cart, $newOrderId, $giftWrap);
    redirectToPaymentsPage(
        $newOrderId,
        $orderTotal,
        $_POST['name'],
        $_POST['address'],
        $_POST['city'],
        $_POST['state'],
        $_POST['pincode'],
        $countryName,
        $_POST['contact'],
        $_POST['email']
    );
} else {
    header('Location: ' . SITE_ADDRESS);
    exit();
}

function updateOrderMetaData($cart, $newOrderId, $giftWrap) {

    foreach ($cart as $key => $value) {

        $freeQuantity = ($value['offer'] != '') ? $value['offer'] : 0;
        $newOrderDatId = updateOrderDat(
            $newOrderId,
            $value['productId'] + 0,
            $value['price'] + 0,
            ($value['quantity'] + $freeQuantity),
            ($value['price'] * $value['quantity']),
            $value['giftwrap']
        );
        if (!isset($newOrderDatId) || $newOrderDatId == 0) {
            header('Location: /cart');
            die();
        }

        if ($value['size'] != 'undefined')
            updateOrderDatAttrAssc($newOrderDatId, $value['sizeId']);

        if ($value['color'] != 'undefined') {
            $colorIpid = mysqli_fetch_object(getProductColorAsscId($value['productId'], $value['colorId'], $value['sizeId']))->ID;
            updateOrderDatColorAssc($newOrderDatId, $colorIpid);
        }
    }
}

function getCartTotal($cart) {

    $cartTotal = $giftWrapTotal = 0;

    foreach ($cart as $key => $value) {

        $cartTotal += ($value['price'] * $value['quantity']);
        if ($value['giftwrap'] == 'Y')
            $giftWrapTotal += 50;
    }

    $_SESSION['GIFT_WRAP_CHARGES'] = $giftWrapTotal;

    return $cartTotal + $giftWrapTotal;
}

function calculateOfferDiscount($cart) {

    $offerdiscount = 0;

    foreach ($cart as $key => $value) {

        $price    = $value['price'];
        $offer = checkOfferByCategoryAndQuantity($value['category'], $value['quantity']);
        if (!empty($offer)) {

            $offerMul = floor($value['quantity'] / ($offer->minQuantity));
            switch ($offer->offerType) {
                case "FREEQTY":
                    $offerdiscount = $offerdiscount + ($offerMul * $price);
                    $value['offer'] = $offerMul;
                    $_SESSION["cart"][$key] = $value;
                    break;
                case "AMTDISC":
                    $offerdiscount = $offerdiscount + ($offerMul * (($offer->minQuantity * $price) - $offer->discountedAmt));
                    break;
                case "PERDISC":
                    $offerdiscount = $offerdiscount + ($offerMul * (($offer->minQuantity * $price * $offer->discountedPer) / 100));
                    break;
            }
        }
    }
    return $offerdiscount;
}

function calculateShippingCharge($countryId, $cart) {

    $cartdata = '';
    $charge   = 0;

    foreach ($cart as $key => $value)
        $cartdata = $cartdata . $value['productId'] . '-' . $value['quantity'] . '|';

    $cart = substr($cartdata, 0, -1);
    if (($countryId + 0) == INDIA) {
        return 0;
        $cartdata  = explode('|', $cart);
        $prodWeight = 0;
        foreach ($cartdata as $product) {
            $prodMeta   = explode('-', $product);
            $prodid     = $prodMeta[0];
            $quantity   = $prodMeta[1];
            $prodQuery  = "SELECT fActualWeight,fVolumetricWeight FROM product where iProdID = $prodid";
            $prodresult = mysqli_fetch_object(fireQuery($prodQuery));
            $prodWeight += ($quantity * (($prodresult->fActualWeight >= $prodresult->fVolumetricWeight) ? $prodresult->fActualWeight : $prodresult->fVolumetricWeight));
        }
        $blueDQuery = "SELECT fMinWeight, fPricePerWeight, fAdditionalWeight, fAdditionalPrice, fFuelSurchargePercentage, fCAFPercentage, fAWBAmount, fInsuracePercentage, fSTPercentage FROM bluedart_settings";
        $blueresult = mysqli_fetch_object(fireQuery($blueDQuery));
        $unitCalculation  = ceil($prodWeight / $blueresult->fMinWeight);
        if ($unitCalculation == 1)
            $chargeBeforeTax  = $blueresult->fPricePerWeight;
        else
            $chargeBeforeTax  = $blueresult->fPricePerWeight + ($unitCalculation - 1) * $blueresult->fAdditionalPrice;
        $chargeWFuelSurch = $chargeBeforeTax * (1 + ($blueresult->fFuelSurchargePercentage / 100));
        $chargeWCAFPercen = $chargeWFuelSurch * (1 + ($blueresult->fCAFPercentage / 100));
        $chargeWAWBAmount = $chargeWCAFPercen + $blueresult->fAWBAmount;
        $chargeWInsurance = $chargeWAWBAmount * (1 + ($blueresult->fInsuracePercentage / 100));
        $shippingCharge   = ceil($chargeWInsurance * (1 + ($blueresult->fSTPercentage / 100)));
        return $shippingCharge;
    } else {
        $charge = mysqli_fetch_object(fireQuery('select fInternationalShippingCharge from seo_settings'));
        if (empty($defaultShippingCharge) || $defaultShippingCharge == '-1')
            $defaultShippingCharge = '0';
        $charge = $charge->fInternationalShippingCharge;
    }
    return $charge;
}

function redirectToPaymentsPage($newOrderId, $orderTotal, $name, $address, $city, $state, $pincode, $country, $phone, $email ) {
    $merchantId   = '15070';
    $currency     = 'INR';
    $redirect_url = SITE_ADDRESS . 'ccavResponseHandler.php';
    $cancel_url   = SITE_ADDRESS . 'ccavResponseHandler.php';
    $language     = 'EN';
    $requestData  = array(
        'merchant_id' => $merchantId,
        'order_id' => $newOrderId,
        'amount' => $orderTotal,
        'currency' => $currency,
        'redirect_url' => $redirect_url,
        'cancel_url' => $cancel_url,
        'language' => $language,
        'billing_name' => $name,
        'billing_address' => $address,
        'billing_city' => $city,
        'billing_state' => $state,
        'billing_zip' => $pincode,
        'billing_country' => $country,
        'billing_tel' => $phone,
        'billing_email' => $email,
        'delivery_name' => $name,
        'delivery_address' => $address,
        'delivery_city' => $city,
        'delivery_state' => $state,
        'delivery_zip' => $pincode,
        'delivery_country' => $country,
        'delivery_tel' => $phone
    );
    $_SESSION['requestData'] = $requestData;
    header("location:" . SITE_ADDRESS . 'ccavRequestHandler.php');
}
