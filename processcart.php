<?php 
    session_start();
    
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['price']) &&
        isset($_POST['color']) && isset($_POST['size']) &&
        isset($_POST['quant']) && isset($_POST['productid']) &&
        isset($_POST['productcatid']))  {
            $productId    = $_POST['productid'];
            $productCatId = $_POST['productcatid'];
            if( $_POST['color'] != 'undefined' ) {
                $prodColorMeta = explode("|",$_POST['color']);
            } else {
                $prodColorMeta = explode("|","undefined|undefined");
            }
            if( $_POST['size'] != 'undefined' ) {
                $prodSizeMeta  = explode("|",$_POST['size']);
            } else {
                $prodSizeMeta  = explode("|","undefined|undefined");
            }
            $prodQuantity = $_POST['quant'];
            $prodPrice    = $_POST['price'];
        $currentItem = array(
            $productId => array(
            'productId'=>$productId,
            'category'=>$productCatId,
            'price'=>$prodPrice,
            'quantity'=>$prodQuantity,
            'color'=>$prodColorMeta[0],
            'colorId'=>$prodColorMeta[1],
            'size'=>$prodSizeMeta[0],
            'sizeId'=>$prodSizeMeta[1],
            'offer'=>'',
            'giftwrap'=>'N'
            )
        );
        $new_item = true;
		if(empty($_SESSION["cart"])) {
            $_SESSION['cart'] = $currentItem;
        } else {
            foreach($_SESSION["cart"] as $key => $value){
                if($productId == $value['productId']) {
                    unset($_SESSION['cart'][$key]);
                    $new_item = false;
                    $_SESSION["cart"] = array_merge( $_SESSION["cart"] , $currentItem );
                    break;
                }
            }
            if($new_item)
                $_SESSION["cart"] = array_merge( $_SESSION["cart"] , $currentItem );
        }
        echo sizeof($_SESSION["cart"]);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quantity']) && 
        isset($_POST['cartkey']) && isset($_POST['productid']) && isset($_POST['operation'])) {
            if($_POST['operation'] == "UPD" && $_POST['operation'] == "UPD")
                foreach($_SESSION["cart"] as $key => $value) {
                    if($key == $_POST['cartkey'] && $value['productId'] == $_POST['productid']){
                        $value['quantity'] = $_POST['quantity'];
                        $_SESSION["cart"][$key] = $value;
                        break;
                    }
                }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cartkey']) && 
        isset($_POST['operation']) && $_POST['operation'] == "DEL" && isset($_POST['productid'])) {
            if($_POST['operation'] == "DEL")
                    foreach($_SESSION["cart"] as $key => $value) {
                        if($key == $_POST['cartkey'] && $value['productId'] == $_POST['productid']){
                            unset($_SESSION['cart'][$key]);
                            break;
                        }
                    }
        echo sizeof($_SESSION["cart"]);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['greetingid']) && $_POST['greetingid'] != '' 
       && isset($_POST['greetingmessage'])  && $_POST['greetingmessage'] != '')  {
            $_SESSION['greeting-id']      = $_POST['greetingid'];
            $_SESSION['greeting-message'] = $_POST['greetingmessage'];
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productid']) && $_POST['productid'] != '' 
       && isset($_POST['greetingstatus'])  && $_POST['greetingstatus'] != '')  {
            foreach($_SESSION["cart"] as $key => $value) {
                if( $value['productId'] == $_POST['productid'] ) {
                    $value['giftwrap'] = $_POST['greetingstatus'];
                    $_SESSION["cart"][$key] = $value;
                    break;
                }
            }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['coupon']) && $_POST['coupon'] == '') {
            $_SESSION['coupon'] = $_POST['coupon'];
    }
?> 