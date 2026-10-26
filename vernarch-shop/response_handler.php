<?php
include_once(__DIR__ . '/../config/config.php');
include(__DIR__ . '/../config/crypto.php');
include(__DIR__ . '/../config/MarioDB.php');

//error_reporting(0);

$encResp		    = $_POST['encResp'];

$workingKey	    = 'FA758434843586A264BE2F6E9F643383';
$paramString	= decrypt($encResp, $workingKey);
$params		    = array();

parse_str($paramString, $params);

$response = array(
	'iOrdID' 			=> $params['order_id'],
	'vSource' 			=> 'vernarch-shop',
	'vOrderStatus'	    => $params['order_status'],
	'iTrackingID' 		=> $params['tracking_id'],
	'fAmount' 			=> $params['amount'],
	'vCurrency'			=> $params['currency'],
	'vBankRefNo' 		=> $params['bank_ref_no'],
	'vFailureMessage'	=> $params['failure_message'],
	'vPaymentMode'	    => $params['payment_mode'],
	'vCardName'	        => $params['card_name'],
	'iStatusCode'	    => $params['status_code'] || 0,
	'vStatusMessage' 	=> $params['status_message'],
);

$debug_info = "Original: "           .
	print_r($encResp, true)  .
	"\nParams: "           .
	print_r($params, true) .
	"\nEND";

$fname = "/home/gbhat/vernarch_transactions/{$params['order_id']}";
$w = file_put_contents($fname, $debug_info);

$dbh = new MarioDB();

try {
	$dbh->updateOrderResponse($response);
} catch (Throwable $e) {
	die("error updating response: " . $e->getMessage());
}

// $url = "https://mariodemiranda.com/vshop";
// $data = ["encResp" => $encResp];

// $options = array(
// 	'http' => array(
// 		'header' => "Content-type: application/x-www-form-urlencoded\r\n",
// 		'method' => "POST",
// 		'content' => http_build_query($data),
// 	)
// );

// $context = stream_context_create($options);
// $result = file_get_contents($url, false, $context);
?>

<!doctype html>
<html lang="en">

<head>
	<title>Vernacular Architecture of India</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;500;700&family=Lora:ital,wght@0,400;1,600&display=swap"
		rel="stylesheet" />
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/theme.css" rel="stylesheet">
</head>

<body>
	<nav class="navbar navbar-expand-md my-5">
		<div class="container">
			<a class="navbar-brand" href="https://vernacular-architecture.in">
				<h2 class="lead">vernacular-architecture.in</h2>
			</a>
		</div>
	</nav>
	<div class="container">
		<main>
			<div class="row g-5">
				<div class="offset-md-2 col-md-8">
					<?php
					print_r($result);

					if ($response['vOrderStatus'] == "Success") {
					?>

						<h1>Thank you for the purchase!</h1>
						<p>
							Your transaction for the purchase of "Vernacular Architecture of India" items has been successful. We will start preparing the
							shipment and inform you at <?php echo $params['billing_email']; ?>
						</p>
					<?php
					} else {
					?>
						<h1>Sorry! Your transaction could not be completed</h1>
						<p>
							Our apologies! Your transaction for the purchase of
							"Vernacular Architecture of India" items was marked as <?php echo $response['vOrderStatus'] ?>.
						</p>
						<p>
							This could be due to several reasons
							including network and connectivity
							issues. If you prefer to take this up with
							your Bank or Credit Card Company, the
							following information might be useful. A
							copy of this information is also available
							with us and we will try to make sure that
							you can return and complete your purchase.
						</p>
						<table class="table">
							<thead>
								<tr>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row">Payment Status</th>
									<td><?php echo $response['vOrderStatus']; ?></td>
								</tr>
								<tr>
									<th scope="row">Payment Mode and Type</th>
									<td><?php echo $response['vPaymentMode'] . " " . $response['vCardName']; ?></td>
								</tr>
								<tr>
									<th scope="row">Amount</th>
									<td colspan="2"><?php echo $response['vCurrency'] . " " . $response['fAmount']; ?></td>
								</tr>
								<tr>
									<th scope="row">Reason for Failure</th>
									<td><?php echo $response['vFailureMessage']; ?></td>
								</tr>
								<tr>
									<th scope="row">Authorization Message from Bank</th>
									<td colspan="2"><?php echo $response['vStatusMessage']; ?></td>
								</tr>
							</tbody>
						</table>
					<?php
					}
					?>
				</div>
			</div>
		</main>
	</div>
</body>

</html>