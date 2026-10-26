<!-- Start Header Area -->
<?php include "header.php";

$messagePunch = $message = '';
$status = $_GET['key'] ?? 0;

if ($status == 1) {
    $messagePunch = "Order Placed Successfully";
    $message      = "Your Payment was successful. Thanks for shopping with us, Hope to see you soon here!";
} else if ($status == 2) {
    $messagePunch = "Oops! There seems to be a Problem.";
    $message      = "The transaction was Aborted. Your Payment Information 
    was not sent succesfully to us. We would appreciate if you 
    try again in a couple of minutes.";
} else if ($status == 3) {
    $messagePunch = "Oops! There seems to be a Problem.";
    $message      = "The transaction failed. Your Payment Information 
    was not sent succesfully to us. We would appreciate if you 
    try again in a couple of minutes.";
} else if ($status == 4) {
    $messagePunch = "Oops! There seems to be a Problem.";
    $message      = "Security Error. Illegal access detected.";
} else {
    $messagePunch = "Oops! There seems to be a Problem.";
    $message      = "Your Payment Information 
    was not sent succesfully to us. We would appreciate if you 
    try again in a couple of minutes.";
}

unset($_SESSION["cart"]);
unset($_SESSION['coupon']);
unset($_SESSION["message"]);
unset($_SESSION['PREV']);
unset($_SESSION['GIFT_WRAP_CHARGES']);
unset($_SESSION['greeting-message']);
unset($_SESSION['greeting-id']);
?>
<!-- Mail Success-->
<section class="mail-success section page">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-12">
                <div class="mail-inner">
                    <h2><?php echo $messagePunch; ?></h2><br>
                    <p><?php echo $message; ?></p>
                    <div class="button">
                        <a class="btn primary" href="index">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ End Mail Success -->
<!-- Start Footer Area -->
<?php include "footer.php" ?>
<!-- /End Footer Area -->
</body>

</html>