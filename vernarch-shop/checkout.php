<?php
include_once(__DIR__ . '/../config/config.php');
include(__DIR__ . '/../config/crypto.php');
include(__DIR__ . '/../config/MarioDB.php');

session_start();
$dbh = new MarioDB();

$indiaID = 214;
$order = array();
$sender = parse_url($_SERVER['HTTP_REFERER'])['host'];
if (($_SERVER['REQUEST_METHOD'] == 'POST') &&
    isset($_SERVER['HTTP_REFERER']) &&
    preg_match("/" . HOST_VERNARCH_SHOP . "$/", $sender)
) {

    $order = array(
        'vBillName'         => $_POST['fullName'],
        'vBillEmail'        => $_POST['email'],
        'vBillAddress'      => $_POST['address-1'] . '; ' . $_POST['address-2'],
        'vBillCity'         => $_POST['city'],
        'vBillState'        => $_POST['state'],
        'iBillCountyID'     => $indiaID,
        'vBillPincode'      => $_POST['zip'],
        'fTotal'            => $_POST['fTotalAmount'],
        'cPaymentType'      => 'I',
        'cPaymentStatus'    => 'N',
        'cStatus'           => 'P',
        'vSource'           => 'vernarch-shop'
    );

    $iOrdID = 0;
    try {
        $iOrdID = $dbh->createOrder($order);
    } catch (\Throwable $e) {
        die("error creating order: " . $e->getMessage());
    }

    $itemCount      = $_POST['iItemCount'];
    $total_charge = number_format($order['fTotal'], 2, '.', '');
    $cart = [];
    $products = [];
    for ($i = 0; $i < $itemCount; $i++) {
        $cart[] = array(
            'iProdID' => $_POST['iProdID'][$i],
            'vCategoryName' => $_POST['vCategoryName'][$i],
            'vProductName' => $_POST['vProductName'][$i],
            'iCartQuantity' => $_POST['iCartQuantity'][$i],
            'fPrice' => $_POST['fPrice'][$i],
            'fAmount' => $_POST['fAmount'][$i],
        );

        $products[] = array(
            'iOrdID' => $iOrdID,
            'iProdID' => $_POST['iProdID'][$i],
            'iQty' => $_POST['iCartQuantity'][$i],
            'fRate' => $_POST['fPrice'][$i],
            'fPayable' => $_POST['fAmount'][$i]
        );
    }

    try {
        $dbh->createOrderProducts($products);
    } catch (\Throwable $e) {
        die("error creating order products: " . $e->getMessage());
    }

    $site = "https://mariodemiranda.com";
    $CCAV_REQUEST = array(
        'merchant_id'       => '15070',
        'order_id'          => $iOrdID,
        'currency'          => 'INR',
        'amount'            => $order['fTotal'],
        'redirect_url'      => $site . '/vernarch-shop/response_handler.php',
        'cancel_url'        => $site . '/vernarch-shop/response_handler.php',
        'language'          => 'en',
        'billing_name'      => $order['vBillName'],
        'billing_address'   => $order['vBillAddress'],
        'billing_city'      => $order['vBillCity'],
        'billing_state'     => $order['vBillState'],
        'billing_zip'       => $order['vBillPincode'],
        'billing_country'   => $_POST['country'],
        'billing_email'     => $order['vBillEmail'],
        'delivery_name'     => $order['vBillName'],
        'delivery_address'  => $order['vBillAddress'],
        'delivery_city'     => $order['vBillCity'],
        'delivery_state'    => $order['vBillState'],
        'delivery_zip'      => $order['vBillPincode'],
        'delivery_country'  => $_POST['country'],
    );

    $params         = '';
    $working_key    = 'FA758434843586A264BE2F6E9F643383'; //Shared by CCAVENUES
    $access_code    = 'QUK4LJVWZHIELYFM'; //Shared by CCAVENUES

    foreach ($CCAV_REQUEST as $key => $value) {
        $params .= $key . '=' . $value . '&';
    }

    $encrypted_data  = encrypt($params, $working_key);
    $transact_url    = "https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction";
} else {
    print "Access Error: Disallowed";
    exit();
}
?>
<!doctype html>
`<html lang="en">

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
                    <h1>Thank you for the order!</h1>
                    <h2>Order Details</h2>
                    <p>
                        Thank you for placing an order for
                        at INR <?php echo $total_charge; ?>.
                        We are certain that you will enjoy the items related to traditional Indian Architecture in the book.
                    </p>
                    <hr />
                    <p>
                        Your Order Details are:
                    </p>
                    <table class="table table-sm table-borderless mb-5">
                        <tbody>
                            <tr>
                                <th scope="row">Deliver To:</th>
                                <td><?php echo $order['vBillName']; ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><?php echo $order['vBillAddress']; ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><?php echo $order['vBillCity'] . ', ' . $order['vBillState'] . ' ' . $order['vBillPincode']; ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><?php echo $_POST['country']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Email For shipping updates:</th>
                                <td><?php echo $order['vBillEmail']; ?></td>
                            </tr>
                    </table>
                    <h2>Your Cart</h2>
                    <table class="table table-sm">
                        <thead>
                            <th>Category</th>
                            <th>Item</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Amt (in INR)</th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($cart as $item) {
                            ?>
                                <tr>
                                    <td><?php echo $item['vCategoryName'] ?></td>
                                    <td><?php echo $item['vProductName'] ?></td>
                                    <td class="text-end"><?php echo $item['fPrice'] ?></td>
                                    <td class="text-end"><?php echo $item['iCartQuantity'] ?></td>
                                    <td class="text-end"><?php echo $item['fAmount'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <td colspan="4">Total</td>
                            <td class="text-end"><?php echo $_POST['fTotalAmount'] ?></td>
                        </tfoot>
                    </table>
                    <form method="post" action="<?php echo $transact_url ?>" novalidate>
                        <?php
                        $input_list = '';
                        foreach ($CCAV_REQUEST as $key => $value) {
                            $input_list .= '<input type="hidden" name="' . $key . '" value="' . $value . '">' . "\n";
                        }
                        echo $input_list;
                        ?>
                        <input type="hidden" name="encRequest" value="<?php echo $encrypted_data; ?>">
                        <input type="hidden" name="access_code" value="<?php echo $access_code; ?>">
                        <button class="btn btn-danger btn-md mt-3" type="submit">Continue and Pay</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>