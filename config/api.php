<?php
header('Access-Control-Allow-Origin: *');
//getAllOrders();
include_once "config.php";

function getconnected() {
    $CON = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD)
        or die("<strong>ERROR CODE : </strong> COM - 66");

    mysqli_select_db($CON, DB_NAME)
        or die("<strong>ERROR CODE : </strong> NEW_COM - 67");

    return $CON;
}

function fireQuery($query) {
    $CON = getconnected();
    return mysqli_query($CON, $query);
}

//Orders

function placeOrder(
    $user,
    $name,
    $addr,
    $city,
    $state,
    $countryID,
    $pincode,
    $phone,
    $email,
    $subtotal,
    $discount,
    $shipping,
    $total,
    $payType,
    $paymentstatus,
    $status,
    $discountId,
    $couponDiscount,
    $giftCharges,
    $wrapMessage,
    $giftCardId
) {

    $user = $user ?? 0;

    $query = <<<ORDER_QUERY
        INSERT INTO orders (
            iMemberID, 
            vRecpName, vRecpAddress, vRecpCity, vRecpState, iRecpCountyID, vRecpPincode, vRecpPhone, vRecpEmail, 
            vBillName, vBillAddress, vBillCity, vBillState, iBillCountyID, vBillPincode, vBillPhone, vBillEmail, 
            fTotalRate, fTotalDiscount, fCouponDisc, fShipping, fGiftWrapCharges, fTotal, 
            cPaymentType, cPaymentStatus, cStatus, 
            iDiscCoupID, iGWCardID, 
            vGiftWrapMessage) 
        VALUES (
            ?,
            ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?,
            ?, ?, ?,
            ?, ?, 
            ?)
        ORDER_QUERY;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $lastInsertID = 0;
    try {
        $dbHandle = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die("<strong>ERROR CODE : </strong> COM - 66");
        mysqli_select_db($dbHandle, DB_NAME) or die("<strong>ERROR CODE : </strong> NEW_COM - 67");

        $stmnt = mysqli_prepare($dbHandle, $query);
        $bind_types = str_repeat("i", 1) .                                 // UserID
            str_repeat("s", 4) . str_repeat("i", 1) . str_repeat("s", 3) . // Recp Address
            str_repeat("s", 4) . str_repeat("i", 1) . str_repeat("s", 3) . // Billing Address
            str_repeat("d", 6) .                                           // Amounts
            str_repeat("s", 3) .                                           // Status fields
            str_repeat("i", 2) .                                           // Coupon and Gift IDs
            str_repeat("s", 1);                                            // Giftwrap Message

        mysqli_stmt_bind_param(
            $stmnt,
            $bind_types,
            $user,
            $name,
            $addr,
            $city,
            $state,
            $countryID,
            $pincode,
            $phone,
            $email,
            $name,
            $addr,
            $city,
            $state,
            $countryID,
            $pincode,
            $phone,
            $email,
            $subtotal,
            $discount,
            $couponDiscount,
            $shipping,
            $giftCharges,
            $total,
            $payType,
            $paymentstatus,
            $status,
            $discountId,
            $giftCardId,
            $wrapMessage
        );

        mysqli_stmt_execute($stmnt);
        $lastInsertID = mysqli_insert_id($dbHandle);
    } catch (mysqli_sql_exception $e) {

        $errMessage = sprintf("Error: %s\nStack Trace: %s\n", $e->getMessage(), $e->getTraceAsString());
        error_log($errMessage);

        return 0;
    }

    return $lastInsertID;
}

function updateOrderPaymentStatusByOrderId($orderId, $orderStatus, $paymentMode) {

    $query = <<<ORDERSTATUS_QUERY
        UPDATE orders 
        SET cPaymentStatus = ?, cPaymentType = ?
        WHERE iOrdID = ?
    ORDERSTATUS_QUERY;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_ALL);
    try {
        $dbHandle = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die("<strong>ERROR CODE : </strong> COM - 66");
        mysqli_select_db($dbHandle, DB_NAME) or die("<strong>ERROR CODE : </strong> NEW_COM - 67");

        $stmnt = mysqli_prepare($dbHandle, $query);
        mysqli_stmt_bind_param($stmnt, 'ssi', $orderStatus, $paymentMode, $orderId);
        mysqli_stmt_execute($stmnt);
    } catch (mysqli_sql_exception $e) {
        $err = $e->getMessage();
        $trace = $e->getTraceAsString();
        $logMessage = sprintf("Error updating payment status: %s\n%s", $err, $trace);
        error_log($logMessage);
    }

    $rows = mysqli_stmt_affected_rows($stmnt);
    error_log("\nCustom payment status rows affected: " . $rows);
}


function getAllOrders() {
    $query = "SELECT * FROM orders ORDER BY iOrdID DESC";
    return fireQuery($query);
}

function getAllOrdersByUser($user) {
    $query = "SELECT iOrdID,dtDt,cStatus FROM orders WHERE iMemberID = $user ORDER BY dtDt DESC";
    return fireQuery($query);
}

function getOrderTotalById($orderId) {
    $query = "SELECT fTotal AS TOTAL FROM orders WHERE iOrdID = $orderId";
    fireQuery($query);
}

function getOrderDataById($order_id) {
    $query = "SELECT iOrdDatID,iProdID,fRate,iQty FROM `orders_dat` WHERE iOrdID = $order_id";
    return fireQuery($query);
}

function getOrderColorDataByOrderDataId($order_data_id) {
    $query = "SELECT vName FROM color WHERE iColorID IN (SELECT iColorID FROM product_color_assoc AS proc INNER JOIN orders_dat_color_assoc AS ordc ON proc.iPCID = ordc.iPCID  WHERE ordc.iOrdDatID = $order_data_id);";
    return fireQuery($query);
}

function getOrderAttrDataByOrderDataId($order_data_id) {
    $query = "SELECT proa.* FROM product_attrib proa INNER JOIN orders_dat_attrib_assoc orda ON orda.iProdAttribID = proa.iProdAttribID WHERE orda.iOrdDatID = $order_data_id";
    return fireQuery($query);
}

function getAttributeNameByAttributeId($attr_id) {
    $query = "SELECT vName FROM attribute WHERE iAttribID = $attr_id AND cStatus = 'A'";
    return fireQuery($query);
}

function getCountriesList() {
    $query = "SELECT iPostID, vCountryName from postage order by vCountryName";
    return fireQuery($query);
}

function getCountryNameById($countryId) {
    $query = "SELECT vCountryName FROM postage WHERE iPostID = $countryId";
    $result = mysqli_fetch_object(fireQuery($query));
    return $result->vCountryName;
}

function getOrderStatus($status) {
    switch ($status) {
        case "P":
            return "Pending";
            break;
        case "L":
            return "Pickup List Generated";
            break;
        case "W":
            return "Waiting Shipment";
            break;
        case "S":
            return "Shipped";
            break;
        case "X":
            return "Cancelled";
            break;
        case "R":
            return "Refunded";
            break;
        case "A":
            return "Completed";
            break;
        default:
            return "";
    }
}

function updateOrderDat(
    $ordId,
    $prodId,
    $prodRate,
    $prodQty,
    $prodTotal,
    $giftWrap
) {

    $query = <<<ORDERDAT_QUERY
        INSERT INTO orders_dat (
            iOrdID, 
            iProdID, fRate, iQty, fPayable,
            cGiftWrap)
        VALUES (
            ?,
            ?, ?, ?, ?,
            ?)
    ORDERDAT_QUERY;

    $dbHandle = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die("<strong>ERROR CODE : </strong> COM - 66");
    mysqli_select_db($dbHandle, DB_NAME) or die("<strong>ERROR CODE : </strong> NEW_COM - 67");

    $stmnt = mysqli_prepare($dbHandle, $query);
    mysqli_stmt_bind_param(
        $stmnt,
        'iidids',
        $ordId,
        $prodId,
        $prodRate,
        $prodQty,
        $prodTotal,
        $giftWrap
    );

    mysqli_stmt_execute($stmnt);
    $orderDatID = mysqli_insert_id($dbHandle);

    return $orderDatID;
}

function updateOrderDatAttrAssc($ordDatId, $attribId) {

    $query = <<<ORDERDATATTRIB_QUERY
        INSERT INTO orders_dat_attrib_assoc VALUES (?, ?)
    ORDERDATATTRIB_QUERY;

    $dbHandle = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die("<strong>ERROR CODE : </strong> COM - 66");
    mysqli_select_db($dbHandle, DB_NAME) or die("<strong>ERROR CODE : </strong> NEW_COM - 67");

    $stmnt = mysqli_prepare($dbHandle, $query);
    mysqli_stmt_bind_param($stmnt, 'dd', $ordDatId, $attribId);

    mysqli_stmt_execute($stmnt);
}

function getProductColorAsscId($prodId, $colorId, $prodAttrId) {
    $query = "SELECT iPCID AS ID FROM `product_color_assoc` WHERE iProdID = $prodId AND iColorID = $colorId AND iProdAttribID = $prodAttrId";
    return fireQuery($query);
}

function updateOrderDatColorAssc($ordDatId, $colorId) {

    $query = <<<ORDERDATCOLOR_QUERY
        INSERT INTO orders_dat_color_assoc VALUES (?, ?)
    ORDERDATCOLOR_QUERY;

    $dbHandle = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die("<strong>ERROR CODE : </strong> COM - 66");
    mysqli_select_db($dbHandle, DB_NAME) or die("<strong>ERROR CODE : </strong> NEW_COM - 67");

    $stmnt = mysqli_prepare($dbHandle, $query);
    mysqli_stmt_bind_param($stmnt, 'dd', $ordDatId, $colorId);

    mysqli_stmt_execute($stmnt);
}

//Products

function getAllProducts() {
    $query = "SELECT * FROM product ORDER BY iProdID";
    return fireQuery($query);
}

function getProductById($product_id) {
    $query = "SELECT * FROM product WHERE iProdID = $product_id and cStatus = 'A'";
    return fireQuery($query);
}

function getProductsByCategory($category) {
    $query = "SELECT * FROM product
                      WHERE iPCatID = $category AND
                            cStatus = 'A'
                      ORDER BY iPCatID ASC
                      LIMIT 0, 10";
    return fireQuery($query);
}

function getProductByUrlName($urlname) {
    $query = "SELECT * FROM product WHERE vUrlName = '$urlname' and cStatus = 'A'";
    return fireQuery($query);
}

function getProductImagesById($id) {
    $query = "SELECT * FROM `product_images` WHERE iProdID = $id and cStatus = 'A' order by iRank LIMIT 0,4";
    return fireQuery($query);
}

function getProductColorsById($id) {
    $query = "SELECT * from color WHERE iColorID IN (SELECT DISTINCT iColorID FROM product_color_assoc WHERE iProdID = $id) and cStatus = 'A'";
    return fireQuery($query);
}

function getProductAttrbsById($id) {
    $query = "SELECT * FROM product_attrib WHERE iProdID=$id and fPrice!=0 order by iProdAttribID ASC";
    return fireQuery($query);
}


function getRelatedProductsByCategory($category, $product_id) {
    $query = "SELECT * FROM product WHERE iPCatID = $category and iProdID != $product_id LIMIT 10";
    return fireQuery($query);
}

function searchProduct($query) {
    $query = "SELECT * FROM product WHERE vName like '%$query%' LIMIT 10";
    return fireQuery($query);
}

function getProductColorById($id) {
    $query = "SELECT * from color WHERE iColorID = $id";
    fireQuery($query);
}

function getAllProductAttributeNames() {
    $query = "SELECT iAttribID, vName FROM attribute WHERE cStatus = 'A'";
    $result = fireQuery($query);
    $data = array();
    for ($i = 0; $o = mysqli_fetch_object($result); $i++)
        $data[$o->iAttribID] = $o->vName;
    return $data;
}

function getProductSubSets($prodId) {
    $query = "SELECT cCatlogueNum,iPCatID FROM `product` WHERE iProdID = $prodId AND cStatus = 'A'"; //  AND cType = 'S'";
    $catalogId  = mysqli_fetch_object(fireQuery($query))->cCatlogueNum;
    $categoryId = mysqli_fetch_object(fireQuery($query))->iPCatID;
    $query = "SELECT * FROM `product` WHERE cCatlogueNum LIKE '%$catalogId%' AND iProdID != $prodId AND cStatus = 'A' AND iPCatID = $categoryId ORDER BY iRank ASC";
    return fireQuery($query);
}

//Product Categories

function getAllCategories() {
    $query = "SELECT * FROM prodcat ORDER BY iPCatID ASC";
    return fireQuery($query);
}

function getHomePageCategoryMenu() {
    $query = "SELECT * FROM `prodcat` WHERE iParentID = 0 and cStatus = 'A' and iTopRank IS NOT NULL ORDER BY iTopRank ASC";
    return fireQuery($query);
}

function getCategoryById($id) {
    $query = "SELECT * FROM prodcat WHERE iPCatID = $id";
    return fireQuery($query);
}

function searchCategory($query) {
    $query = "SELECT * FROM prodcat WHERE vName like '%$query%' LIMIT 10";
    return fireQuery($query);
}

function getSubCategoriesByCategory($categoryUrl) {
    $query = "SELECT * FROM `prodcat` WHERE iParentID IN (SELECT iPCatID FROM prodcat WHERE vUrlName = '$categoryUrl' and cStatus = 'A')";
    return fireQuery($query);
}

//Product Reviews

function getAllReviews() {
    $query  = "SELECT * FROM reviews ORDER BY review_id DESC";
    return fireQuery($query);
}

function getLimitedReviewsByProductId($id) {
    $query = "SELECT * FROM reviews WHERE product_id = $id and cStatus = 'A' order by datetime DESC LIMIT 0,2";
    return fireQuery($query);
}

function getAllReviewsByProductId($id) {
    $query = "SELECT * FROM reviews WHERE product_id = $id and cStatus = 'A' order by datetime DESC";
    return fireQuery($query);
}

function getReviewById($id) {
    $query = "SELECT * FROM reviews WHERE review_id = $id";
    return fireQuery($query);
}

function addNewReview($prodid, $prodName, $prodCatId, $user, $userName, $review) {
    $query = "INSERT INTO reviews(product_id,product_name,product_catID,member_id,reviewer_name,review) VALUES ($prodid,'$prodName',$prodCatId,$user,'$userName','$review')";
    fireQuery($query);
}

function findCouponByCode($couponcode) {
    $query = "SELECT * FROM disc_coupon WHERE vCode = '$couponcode' and cStatus = 'A'";
    return fireQuery($query);
}

function findCouponIdByCouponCode($couponcode) {
    $query = "SELECT iDiscCoupID AS ID FROM disc_coupon WHERE vCode = '$couponcode' and cStatus = 'A'";
    return fireQuery($query);
}

//Testimonials
function getAllTestimonials() {
    $query = "SELECT * FROM testimonials";
    return fireQuery($query);
}

//Gift Cards
function getAllGreetingCards() {
    $query = "SELECT * FROM giftwrap_cards WHERE cStatus = 'A' ORDER BY iRank";
    return fireQuery($query);
}

//User Management
function authorizeUser($email, $password) {
    $query = "SELECT iMemberID, vName FROM member WHERE cStatus='A' and vEmail='$email' and vPassword='$password'";
    return fireQuery($query);
}

function getLastestUserId() {
    $query  = "SELECT max(iMemberID) as MUID FROM member";
    return fireQuery($query);
}

function insertNewUser($id, $name, $email, $password, $mobile, $address, $city, $state, $country, $pincode) {
    $query = "INSERT INTO member(iMemberID,vName,vEmail,vPassword,vContact,vLandLine,vAddress,vCity,vState,iPostCountryID,vZipcode,cStatus) VALUES ($id,'$name','$email','$password','$mobile','$mobile','$address','$city','$state',$country,'$pincode','A')";
    fireQuery($query);
}

function updateUser($id, $name, $email, $mobile, $address, $city, $state, $country, $pincode) {
    $query = "UPDATE member SET vName='$name', vContact='$mobile', vAddress='$address', vCity='$city', vState='$state', iPostCountryID='$country', vZipcode='$pincode', cStatus='A', vEmail='$email' WHERE iMemberID=$id";
    fireQuery($query);
    echo "Details have been successfully updated";
}

function updateUserPassword($id, $oldpassword, $newpassword) {
    $query = "SELECT * FROM member WHERE iMemberID = $id AND vPassword='$oldpassword'";
    $userFound = fireQuery($query);
    if ($userFound->num_rows > 0) {
        $query = "UPDATE member SET vPassword='$newpassword' WHERE iMemberID = $id";
        fireQuery($query);
        echo "Details have been successfully updated";
    } else {
        echo "Invalid password, Please retry";
    }
}

function getUserById($userid) {
    $query = "SELECT * FROM member WHERE iMemberID = $userid";
    return fireQuery($query);
}

function getAllAddressByUserId($userid) {
    $query = "SELECT iMAddrID, vNickName, vName, vAddress, vCity, vState, iPostCountryID, vPincode, vPhone, vLandline, vEmail, cDefault FROM member_address WHERE cStatus='A' and iMemberID = '$userid' order by cDefault";
    return fireQuery($query);
}

function getUserAddressById($addressId, $userid) {
    $query = "SELECT * FROM member_address WHERE cStatus='A' and iMemberID = $userid and iMAddrID = $addressId";
    return fireQuery($query);
}

function updateProfileAddress($id, $name, $email, $phone, $address, $city, $state, $country, $pincode) {
    $query = "UPDATE member_address SET vName='$name', vPhone='$phone', vAddress='$address', vCity='$city', vState='$state', iPostCountryID='$country', vPincode='$pincode', vEmail='$email' WHERE iMAddrID=$id";
    fireQuery($query);
}

function addNewUserAddress($userid, $name, $email, $phone, $address, $city, $state, $country, $pincode) {
    $result = mysqli_fetch_object(fireQuery("select max(iMAddrID) as ID from member_address"));
    $id = ($result->ID) + 1;
    $query = "INSERT INTO member_address(iMAddrID,iMemberID,vName,vPhone,vAddress,vCity,vState,iPostCountryID,vPincode,vEmail,dtDt,cStatus) VALUES ($id,$userid,'$name','$phone','$address','$city','$state','$country','$pincode','$email',CURRENT_TIMESTAMP,'A')";
    fireQuery($query);
}

function deleteUserAddressById($addressId, $userid) {
    $query = "DELETE FROM member_address WHERE iMemberID = $userid and iMAddrID = $addressId";
    fireQuery($query);
}

//Profile Management
function getUserWishlist($userid) {
    $query = "SELECT * FROM `product` where iProdID IN (select DISTINCT(iProdID) from `member_bookmark` WHERE iMemberID = $userid) and cStatus = 'A'";
    return fireQuery($query);
}

//Cart Management
function addItemToCart() {
}

function removeItemFromCart() {
}

//Search Bar
function searchProductList($searchquery, $offset, $pagelimit, $order) {
    //$query = "SELECT * FROM product WHERE vName like '%$query%' AND cStatus = 'A' order by iProdID LIMIT $offset,$pagelimit";
    $searchquery = htmlspecialchars(htmlspecialchars($searchquery, ENT_QUOTES), ENT_QUOTES);
    $query = "SELECT p.* FROM product p JOIN prodcat c ON p.iPCatID = c.iPCatID WHERE p.vName like '%$searchquery%' AND p.cStatus = 'A' and c.cStatus = 'A' order by iProdID";
    return fireQuery($query);
}

function countSearchProductList($query) {
    $query = "SELECT count(*) as `total` FROM product p JOIN prodcat c ON p.iPCatID = c.iPCatID  WHERE p.vName like '%$query%' AND p.cStatus = 'A' AND c.cStatus = 'A' order by iProdID";
    $result = fireQuery($query);
    return mysqli_fetch_assoc($result)['total'];
}

function checkOfferByCategoryAndQuantity($category, $quantity) {
    $query    = 'SELECT po.*,pc.iPCatID FROM `product_offers` po INNER JOIN `prodcat` pc ON po.offerId = pc.iOfferId1 OR po.offerId = pc.iOfferId2 OR po.offerId = pc.iOfferId3 OR po.offerId = pc.iOfferId4 OR po.offerId = pc.iOfferId5 WHERE po.cStatus = "A" AND pc.iPCatID = ' . $category . ' AND ' . $quantity . ' >= po.minQuantity ORDER BY po.minQuantity DESC,pc.iPCatID';
    $offers   = fireQuery($query);
    $maxCount = 0;
    $selOffer = 0;
    for ($i = 0; $offer = mysqli_fetch_object($offers); $i++) {
        $count = floor($quantity / ($offer->minQuantity));
        if ($count >= $maxCount) {
            $maxCount = $count;
            $selOffer = $offer;
        }
        if ($quantity == ($offer->minQuantity)) {
            $maxCount = $count;
            $selOffer = $offer;
            break;
        }
    }
    return $selOffer;
}

function offerMultiplierCheck($offer, $quantity) {
    echo ($quantity / $offer->minQuantity);
}

//Homepage
function getHomepageSections() {
    $query = "SELECT * FROM homepage_section WHERE cStatus = 'A' ORDER BY iRank";
    return fireQuery($query);
}

function getHomepageSectionsById($id) {
    $query = "SELECT * FROM product INNER JOIN homepage_section_dat ON product.iProdID = homepage_section_dat.iProdID WHERE homepage_section_dat.iHPSecID = $id AND product.cStatus = 'A'";
    return fireQuery($query);
}

function getWeeklyCartoons() {
    $query = "SELECT vTitle, vPic, vPic_AltTag FROM daily_cartoon WHERE cStatus='A' ORDER BY dDisplay DESC";
    return fireQuery($query);
}

function    getShowcaseData() {
    $query = 'SELECT iPicID, vPicTitle, vPic, vLink, vPic_AltTag FROM showcase WHERE cStatus="A" ORDER BY iRank';
    return fireQuery($query);
}

if (isset($_POST['query'])) {
    $query    = $_POST['query'];
    $response = "";
    $header   = '<ul class="typeahead dropdown-menu" role="listbox" style="left: 0px; display: block;">';
    $footer   = '</ul>';
    $products = searchProduct($query);
    $category = searchCategory($query);
    if ($query != '') {
        //Searching for Products
        foreach ($products as $prod) :
            $response = $response . '<li class="active" style="min-width: 350px;"><a class="dropdown-item" href="profile.php?id=' . $prod['iProdID'] . '" role="option">' . $prod['vName'] . '<p style="float:right;border-radius: 11px;background-color: #f0f0f1;padding: 2px 6px;">&nbsp;Product&nbsp;</p></a></li>';
        endforeach;
        //Searching for Category
        foreach ($category as $cat) :
            $response = $response . '<li class="active" style="min-width: 350px;"><a class="dropdown-item" href="church.php?id=' . $cat['iPCatID'] . '" role="option">' . $cat['vName'] . '<p style="float:right;border-radius: 11px;background-color: #f0f0f1;padding: 2px 6px;">&nbsp;Category&nbsp;</p></a></li>';
        endforeach;
    }
    if ($response == '')
        $response = '<li class="active" style="min-width: 350px;"><a class="dropdown-item">No Results Found</a></li>';
    echo $header . $response . $footer;
}

//Discounts & Coupons
if (isset($_GET['coupon']) && $_GET['coupon'] != '') {
    $result = findCouponByCode($_GET['coupon']);
    if ($result->num_rows > 0) {
        $coupon = mysqli_fetch_object($result);
        echo $coupon->fValue . '|' . $coupon->fMinPurchase;
    } else
        echo 'NF';
}

//Courier Charges
if (
    isset($_POST['shippingcountry']) && $_POST['shippingcountry'] != '' &&
    isset($_POST['cartdump']) && $_POST['cartdump'] != ''
) {
    $cart = substr($_POST['cartdump'], 0, -1);
    $ctry = $_POST['shippingcountry'];
    if ($ctry == '234') {
        echo calculateShippingCharges($cart);
    } else {
        $charge = mysqli_fetch_object(fireQuery('select fInternationalShippingCharge from seo_settings'));
        if (empty($defaultShippingCharge) || $defaultShippingCharge == '-1')
            $defaultShippingCharge = '0';
        echo $charge->fInternationalShippingCharge;
    }
}

//get attribute price
if (isset($_POST['attr_id'])) {
    $get = mysqli_fetch_object(fireQuery("SELECT * FROM product_attrib WHERE iProdAttribID=" . $_POST['attr_id']));

    echo $get->fPrice;
}

if (
    isset($_GET['surfer']) &&
    $_GET['surfer'] != '' &&
    isset($_GET['order']) &&
    $_GET['order'] != ''
) {
    $userid = $_GET['surfer'];
    $order  = $_GET['order'];

    if ($order == 'hl')
        $query = "SELECT * FROM `product` where iProdID IN (select DISTINCT(iProdID) from `member_bookmark` WHERE iMemberID = $userid) and cStatus = 'A' order by fPrice DESC";
    else if ($order == 'lh')
        $query = "SELECT * FROM `product` where iProdID IN (select DISTINCT(iProdID) from `member_bookmark` WHERE iMemberID = $userid) and cStatus = 'A' order by fPrice ASC";
    else if ($order == 'az')
        $query = "SELECT * FROM `product` where iProdID IN (select DISTINCT(iProdID) from `member_bookmark` WHERE iMemberID = $userid) and cStatus = 'A' order by vName ASC";
    $result = fireQuery($query);
    $response = '';
    if ($result->num_rows > 0) {
        for ($i = 0; $o = mysqli_fetch_object($result); $i++) {
            $response = $response . '<div class="col-lg-3 col-md-6 col-12">';
            $response = $response . '<div class="single-product">';
            $response = $response . '<div class="product-img">';
            $response = $response . '<a href="product/' . $o->vUrlName . '?>">';
            $response = $response . '<img class="default-img" src="uploads/products/sml_' . $o->vSmallImage . '" alt="' . $o->vSmallImage_AltTag . '">';
            $response = $response . '</a>';
            $response = $response . '</div>';
            $response = $response . '<div class="product-content">';
            $response = $response . '<h3><a href="product/' . $o->vUrlName . '">' . $o->vName . '</a></h3>';
            $response = $response . '<div class="product-price">';
            $response = $response . '<span><b>&#8377; ' . $o->fPrice . '</b></span>';
            $response = $response . '</div>';
            $response = $response . '</div>';
            $response = $response . '</div>';
            $response = $response . '</div>';
        }
    } else {
        $response = $response . '<div class="col-lg-12 col-md-8 col-12">';
        $response = $response . '<h3><br><center><span>No Results Found</span></center></h3>';
        $response = $response . '</div>';
    }
    echo $response;
}

if (
    isset($_POST['prod']) &&
    $_POST['prod'] != '' &&
    isset($_POST['user']) &&
    $_POST['user'] != ''
) {
    $userid = $_POST['user'];
    $prodid = $_POST['prod'];
    $query  = "SELECT iMemberID,iProdID from member_bookmark where iMemberID = $userid and iProdID = $prodid";
    $check  = fireQuery($query);
    if (!($check->num_rows > 0)) {
        $result = mysqli_fetch_object(fireQuery("select max(iMBID) as ID from member_bookmark"));
        $id = ($result->ID) + 1;
        $insertquery = "INSERT INTO member_bookmark(iMBID,dtAdded,iMemberID,iProdID) VALUES($id,now(),$userid,$prodid)";
        fireQuery($insertquery);
    }
    echo $insertquery;
}


if (
    isset($_GET['query']) &&
    $_GET['query'] != '' &&
    isset($_GET['offset']) &&
    $_GET['offset'] != '' &&
    isset($_GET['pageLimit']) &&
    $_GET['pageLimit'] != '' &&
    isset($_GET['order']) &&
    $_GET['order'] != ''
) {
    $query = $_GET['query'];
    $order = $_GET['order'];

    if ($order == 'hl')
        $query = "SELECT * FROM product WHERE vName like '%$query%' AND cStatus = 'A' order by fPrice DESC";
    else if ($order == 'lh')
        $query = "SELECT * FROM product WHERE vName like '%$query%' AND cStatus = 'A' order by fPrice ASC";
    else if ($order == 'az')
        $query = "SELECT * FROM product WHERE vName like '%$query%' AND cStatus = 'A' order by vName ASC";
    $result = fireQuery($query);
    $response = '';
    if ($result->num_rows > 0) {
        for ($i = 0; $o = mysqli_fetch_object($result); $i++) {
            $response = $response . '<div class="col-lg-3 col-md-6 col-12">';
            $response = $response . '<div class="single-product">';
            $response = $response . '<div class="product-img">';
            $response = $response . '<a href="product/' . $o->vUrlName . '?>">';
            $response = $response . '<img class="default-img" src="uploads/products/sml_' . $o->vSmallImage . '" alt="' . $o->vSmallImage_AltTag . '">';
            $response = $response . '</a>';
            $response = $response . '</div>';
            $response = $response . '<div class="product-content">';
            $response = $response . '<h3><a href="product/' . $o->vUrlName . '">' . $o->vName . '</a></h3>';
            $response = $response . '<div class="product-price">';
            $response = $response . '<span><b>&#8377; ' . $o->fPrice . '</b></span>';
            $response = $response . '</div>';
            $response = $response . '</div>';
            $response = $response . '</div>';
            $response = $response . '</div>';
        }
    } else {
        $response = $response . '<div class="col-lg-12 col-md-8 col-12">';
        $response = $response . '<h3><br><center><span>No Results Found</span></center></h3>';
        $response = $response . '</div>';
    }
    echo $response;
}

if (
    isset($_GET['category']) &&
    $_GET['category'] != '' &&
    isset($_GET['offset']) &&
    $_GET['offset'] != '' &&
    isset($_GET['pageLimit']) &&
    $_GET['pageLimit'] != '' &&
    isset($_GET['order']) &&
    $_GET['order'] != ''
) {
    $category = $_GET['category'];
    $order = $_GET['order'];
    $basequery = "SELECT * 
                    FROM product 
                    WHERE iPCatID IN (
                        SELECT iPCatID FROM `prodcat` WHERE (
                            SELECT iPCatID FROM `prodcat` WHERE vUrlName = '$category')
                        IN (iPCatID,iParentID)
                        AND cStatus = 'A'
                    ) AND cStatus = 'A'";
    if ($order == 'hl')
        $query = $basequery . ' order by fPrice DESC';
    else if ($order == 'lh')
        $query = $basequery . ' order by fPrice ASC';
    else if ($order == 'az')
        $query = $basequery . ' order by vName ASC';
    $result = fireQuery($query);
    $response = '';
    if ($result->num_rows > 0) {
        for ($i = 0; $o = mysqli_fetch_object($result); $i++) {
            $response = $response . '<div class="col-lg-3 col-md-6 col-12">';
            $response = $response . '<div class="single-product">';
            $response = $response . '<div class="product-img">';
            $response = $response . '<a href="product/' . $o->vUrlName . '?>">';
            $response = $response . '<img class="default-img" src="uploads/products/sml_' . $o->vSmallImage . '" alt="' . $o->vSmallImage_AltTag . '">';
            $response = $response . '</a>';
            $response = $response . '</div>';
            $response = $response . '<div class="product-content">';
            $response = $response . '<h3><a href="product/' . $o->vUrlName . '">' . $o->vName . '</a></h3>';
            $response = $response . '<div class="product-price">';
            $response = $response . '<span><b>&#8377; ' . $o->fPrice . '</b></span>';
            $response = $response . '</div>';
            $response = $response . '</div>';
            $response = $response . '</div>';
            $response = $response . '</div>';
        }
    } else {
        $response = $response . '<div class="col-lg-12 col-md-8 col-12">';
        $response = $response . '<h3><br><center><span>No Results Found</span></center></h3>';
        $response = $response . '</div>';
    }
    echo $response;
}
