<?php
include('config/api.php');
include('config/crypto.php');
error_reporting(0);
$workingKey    = 'FA758434843586A264BE2F6E9F643383';		//Working Key should be provided here.

$encResponse   = $_POST["encResp"];			//This is the response sent by the CCAvenue Server
$rcvdString    = decrypt($encResponse, $workingKey);		//Crypto Decryption used as per the specified working key.

$params		    = array();
parse_str($rcvdString, $params);

$validResponse = isset($params['order_id']) &&
	$params['order_id'] != '' &&
	isset($params['order_status']) &&
	$params['order_status'] != '';

if (!$validResponse) {
	$loc_str = 'message/4';
	header('location:' . SITE_ADDRESS . $loc_str);
	exit;
}


$order_id  = (int)$params['order_id'];
$order_status = $params['order_status'];
$payment_mode = $params['payment_mode'] ?? 'Unknown';


if ($order_status === "Success") {
	$loc_str = 'message/1';
	error_log("\nCustom Error before updating Payment Status with OrderID " . $order_id);
} else if ($order_status === "Aborted")
	$loc_str = 'message/2';
else if ($order_status === "Failure")
	$loc_str = 'message/3';
else
	$loc_str = 'message/4';

	updateOrderPaymentStatusByOrderId($order_id, $order_status, $payment_mode);
	header('location:' . SITE_ADDRESS . $loc_str);
exit;
?>
<div align="center"> <img src="<?php echo SITE_ADDRESS; ?>images/loading_dark.gif"></div>
<h3>Please wait, redirecting to process payment..</h3>