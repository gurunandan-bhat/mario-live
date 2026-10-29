<?php
include __DIR__ . '/../config/crypto.php';

//error_reporting(0);

$post		    = $_POST['encResp'];

$workingKey	    = 'FA758434843586A264BE2F6E9F643383';
$paramString	= decrypt($post, $workingKey);
$params		    = array();

parse_str($paramString, $params);

$order_id	    = $params['order_id'] ?? uniqid('FONS');

$order_status	    = $params['order_status'];
$email		        = $params['billing_email'];
$failure_message    = $params['failure_message'];
$payment_mode	    = $params['payment_mode'];
$card_name	        = $params['card_name'];
$status_code	    = $params['status_code'];
$status_message	    = $params['status_message'];
$response_code      = $params['response_code'];
$currency           = $params['currency'];
$amount             = $params['amount'];

$debug_info = "Original: "           .
	print_r($post, true)  .
	"\nParams: "           .
	print_r($params, true) .
	"\nEND";

$fname = "/home/gbhat/afons_transactions/{$order_id}";
$w = file_put_contents($fname, $debug_info);
?>
<!doctype html>
<html lang="en">

<head>
	<title>Angelo da Fonseca</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
	<link href="css/form-validation.css" rel="stylesheet">
	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			user-select: none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}
	</style>
</head>

<body>
	<nav class="navbar navbar-expand-md navbar-light bg-light">
		<div class="container-fluid">
			<a class="navbar-brand" href="index.html">Angelo da Fonseca</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarMenu">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item mx-1">
						<a class="nav-link" aria-current="page" href="index.html">Home</a>
					</li>
					<li class="nav-item mx-1">
						<a class="nav-link" href="foreword.html">Foreword</a>
					</li>
					<li class="nav-item mx-1">
						<a class="nav-link" href="intro.html">Read</a>
					</li>
					<li class="nav-item mx-1">
						<a class="nav-link" href="about.html">About Us</a>
					</li>
					<li class="nav-item mx-1">
						<a class="nav-link active" href="preorder.html">Pre-order Now</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
		<main>
			<div class="row g-5">
				<div class="col-md-7 col-lg-8">
					<?php
					if ($order_status == "Success") {
					?>

						<h1>Thank you for the purchase!</h1>
						<p>
							Your transaction for the purchase of "Fonseca"
							has been successful. We will start preparing the
							shipment on August 3, 2022 and inform you at <?php echo $email; ?>
						</p>
					<?php
					} else {
					?>
						<h1>Sorry! Your transaction could not be completed</h1>
						<p>
							Our apologies! Your transaction for the purchase of
							"Fonseca" was marked as <?php echo $order_status ?>.
						</p>
						<p>
							This could be due to several reasons
							including network and connectivity
							issues. If you prefer to take this up with
							ypur Bank or Credit Card Company, the
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
									<td><?php echo $order_status; ?></td>
								</tr>
								<tr>
									<th scope="row">Payment Mode and Type</th>
									<td><?php echo "$payment_mode $card_name"; ?></td>
								</tr>
								<tr>
									<th scope="row">Amount</th>
									<td colspan="2"><?php echo "$currency $amount"; ?></td>
								</tr>
								<tr>
									<th scope="row">Reason for Failure</th>
									<td><?php echo $failure_message; ?></td>
								</tr>
								<tr>
									<th scope="row">Authorization Code from Bank</th>
									<td colspan="2"><?php echo $status_code; ?></td>
								</tr>
								<tr>
									<th scope="row">Authorization Message from Bank</th>
									<td colspan="2"><?php echo "$status_message (Code: $response_code)"; ?></td>
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