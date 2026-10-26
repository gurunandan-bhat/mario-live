<?php

// jCart v1.3
// http://conceptlogic.com/jcart/

// This file demonstrates a basic checkout page

// If your page calls session_start() be sure to include jcart.php first
include_once('jcart/jcart.php');

session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />

		<title>Mario de Miranda shopping cart</title>
		<link rel="stylesheet" href="css/blueprint/screen.css" type="text/css" media="screen, projection" />  
		<link rel="stylesheet" href="css/blueprint/print.css" type="text/css" media="print" />  
		<!--[if lt IE 8]><link rel="stylesheet" href="css/blueprint/ie.css" type="text/css" media="screen, projection" /><![endif]-->  
		<link rel="stylesheet" href="css/mario.css" type="text/css" media="screen" charset="utf-8" />
	</head>
	<body>
		<div class="container">
			<div class="span-24 last banner">
				<div class="span-3">
					<img src="images/self_portrait.jpg" width="110" height="175" alt="MariodeMiranda" />
				</div>
				<div class="span-21 last">
					<img src="images/banner.jpg" width="830" height="87" alt="MariodeMiranda" />
					<div class="span-3">
						<h3>Home</h3>
						<p>Nulla eget turpis ut nulla elementum tincidunt class aptent</p>
					</div>
					<div class="span-3">
						<h3>Books</h3>
						<p>Fusce turpis ligula, feugiat in ultricies vel, imperdiet id diam?</p>
					</div>
					<div class="span-3" id="current">
						<h3>Prints</h3>
						<p>Curabitur hendrerit rutrum laoreet? Nunc fringilla elementum</p>
					</div>
					<div class="span-3">
						<h3>Gallery</h3>
						<p>Curabitur pulvinar massa non risus placerat vestibulum.</p>
					</div>
					<div class="span-3">
						<h3>About Mario</h3>
						<p>Vestibulum ante ipsum primis in faucibus orci luctus</p>
					</div>
					<div class="span-3">
						<h3>Subscribe</h3>
						<p>Praesent vel nisl vel nisl molestie fringilla. Praesent sit amet.</p>
					</div>
					<div class="span-3 last">
						<h3>Contact</h3>
						<p>Nulla eget turpis ut nulla elementum tincidunt. Class aptent.</p>
					</div>
				</div>
			</div>
			
				
			
				<h2>Shopping Cart Checkout</h2>
				<hr />
				
				<div class="span-10 last"><?php $jcart->display_cart();?> 
				
				<p><a href="index.php">&larr; Continue shopping</a></p>

				<?php
					//echo '<pre>';
					//var_dump($_SESSION['jcart']);
					//echo '</pre>';
				?>
				
				</div>
				
				
   
			</div>
			<hr />
			<div class="prepend-9 span-8 append-8">
				<p>Legal | Copyright &copy; Architecture Autonomous 2011 | Contact Us</p>
			</div>
		</div>
		<script type="text/javascript" src="jcart/js/jquery-1.4.4.min.js"></script>
		<script type="text/javascript" src="jcart/js/jcart.min.js"></script>
	</body>
</html>