<?php
include('config/api.php');

header('Access-Control-Allow-Origin: *');

const INDIA = '214';

//Courier Charges
if( isset($_POST['shippingCountry']) &&
    $_POST['shippingCountry'] != '' &&
    isset($_POST['cartDump']) &&
    $_POST['cartDump'] != '') {

    $cart = substr($_POST['cartDump'],0,-1);
    $ctry = $_POST['shippingCountry'];

    if($ctry == INDIA) {
        echo 0;
    }
    else {
	$query = <<<INTERNATIONAL
	SELECT
	    fInternationalShippingCharge
	FROM
	seo_settings
	INTERNATIONAL;

        $charge = mysqli_fetch_object(fireQuery($query));

        echo $charge->fInternationalShippingCharge;
    }
}

function calculateShippingCharges($cart) {

    $cartdata  = explode('|',$cart);
    $prodWeight= 0;

    foreach ($cartdata as $product) {

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
