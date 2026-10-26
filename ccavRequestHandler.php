<?php
session_start();
include('config/api.php');
include('config/crypto.php');
error_reporting(0);
if(isset($_SESSION['requestData']) && $_SESSION['requestData'] != '' ) {
	$requestData = $_SESSION['requestData'];
}
else
{
    $requestData = $_SESSION['requestData'];
}
//$OrdID = (isset($_POST['order_id']) && is_numeric($_POST['order_id']))?$_POST['order_id']:'';
$OrdID = (isset($requestData['order_id']) && is_numeric($requestData['order_id']))?$requestData['order_id']:'';
if( empty($OrdID) )	{
//	header('location:'.SITE_ADDRESS);
//	exit;
}
$finalAMOUNT = $requestData['amount'];
//$finalAMOUNT = mysqli_fetch_object(getOrderTotalById($OrdID))->TOTAL;
if(empty($finalAMOUNT))	{
//	header('location:'.SITE_ADDRESS);
//	exit;
}
$_POST['amount'] = $finalAMOUNT;
$merchant_data   = '';
$working_key     = 'FA758434843586A264BE2F6E9F643383'; //Shared by CCAVENUES
$access_code     = 'QUK4LJVWZHIELYFM'; //Shared by CCAVENUES
foreach ($requestData as $key => $value)	{
	$merchant_data.=$key.'='.$value.'&';
}
$encrypted_data  = encrypt($merchant_data,$working_key); // Method for encrypting the data.
?>
<html>
<body onLoad = "document.redirect.submit();">
<center>
<h3>Please wait, redirecting to process payment..</h3>
  <form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
    <?php
		echo "<input type=hidden name=encRequest value=$encrypted_data>";
		echo "<input type=hidden name=access_code value=$access_code>";
	?>
  </form>
</center>
</body>
</html>