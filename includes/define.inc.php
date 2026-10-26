<?php
##	NICIATION VARIABLES DEFINES	################################################################################### 
define('MAX_IMG_UPLOAD_SIZE',50000000);    // 50000000 bytes
define('MAX_FILE_UPLOAD_SIZE',30000000);  //  30000000 bytes
//define('MAGIC_QUOTES',get_magic_quotes_gpc());
define('THUMBNAIL_ALLOWED', 1);	// 1 - Yes, 0 - No.

$IMG_TYPE = array('gif','png','pjpeg','jpeg','jpg','JPG','mp4');
//$IMG_TYPE = array('.gif','.png','.pjpeg','.jpeg','.jpg','.JPG');
$DOC_TYPE = array('.txt','.doc','.docx','.pdf','.xls','.xlsx');
$CSV_TYPE = array('.csv','.xls');
$IMG_FILE_TYPE = array('image/gif','image/png','image/pjpeg','image/jpeg','image/jpg','video/mp4');
$DOC_FILE_TYPE = array('text/plain','application/msword','application/pdf','application/vnd.ms-excel');
$CSV_FILE_TYPE = array('text/comma-separated-values','application/vnd.ms-excel');
$LOGIN_ERR = array('Password is empty !','Incorrect Password !!!','No such user !!!!','User Blocked for 30 Mins !','Invalid Parameters','Suspicious Activities','Please Login','Username is empty !');

$PROD_CAT_ARR = array("1"=>"Shoes","2"=>"Sandales");
$GENDER_ARR = array("M"=>"Men","W"=>"Women");

define('URL_REWRITTING','OFF');

$PAY_STAT_ARR = array("N"=>"Awaiting Payment","I"=>"Awaiting Fulfillment","A"=>"Payment Complete");
$ACTION_STAT_ARR = array("PIN"=>"Print Invoice","PKS"=>"Payment slip","PUL"=>"Pickup List");
$STATUS_STAT_ARR = array("P"=>"Pending","L"=>"Pickup List Generated","W"=>"Waiting Shipment","S"=>"Shipped","X"=>"Cancelled","R"=>"Refunded","A"=>"Completed");
$SUBSCRIBERTYPE_ARR = array("C"=>"I am a collector","A"=>"I am an Artist","AS"=>"I am an Art Seller","AC"=>"I am an Art Critic");
$QTY_ARR = array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10");

/// Sohel
$STATUS_ARR = array('A'=>'Active', 'I'=>'Inactive');
$DEFAULT_ARR = array('Y'=>'Yes', 'N'=>'No');
$ORD_STATUS_ARR_EN = array("P"=>"<span class='text-warning'>Pending</span>","L"=>"Pickup List Generated","W"=>"<span class='text-purple'>Waiting Shipment</span>","S"=>"<span class='text-info'>Shipped</span>","X"=>"Cancelled","R"=>"Refunded","A"=>"<span class='text-success'>Completed</span>");
$PAY_STATUS_ARR_EN = array("N"=>"Awaiting Payment","I"=>"Awaiting Fulfillment","A"=>"Payment Complete", "PR"=>"Payment Received");

$PAYMENT_TYPE_ARR = array('C'=>'Cheque/DD/NEFT','I'=>'Credit Card');
$PAYMENT_SHORTTYPE_ARR = array('C'=>'Cheque/DD/NEFT','I'=>'Credit Card');

$PAY_STAT_ARR = array("N"=>"Awaiting Payment","I"=>"Awaiting Fulfillment","A"=>"Payment Complete");
$ACTION_STAT_ARR = array("PIN"=>"Print Invoice","PKS"=>"Payment slip","PUL"=>"Pickup List");
$STATUS_STAT_ARR = array("P"=>"Pending","L"=>"Pickup List Generated","W"=>"Waiting Shipment","S"=>"Shipped","X"=>"Cancelled","R"=>"Refunded","A"=>"Completed");

$NOVELTY_ARR = array('1'=>'fPrice<500','2'=>'fPrice>=500 and fPrice<1000','3'=>'fPrice>=1000 and fPrice<2000','4'=>'fPrice>=2000 and fPrice<3000','5'=>'fPrice>=3000');
$MERCHANDISE_ARR = array('1'=>'fPrice<500','2'=>'fPrice>=500');
$PRINTS_ARR = array('1'=>'fPrice<500','2'=>'fPrice>=500 and fPrice<1000','3'=>'fPrice>=1000');
$LIMITED_ARR = array('1'=>'fPrice<2000','2'=>'fPrice>=2000 and fPrice<3000','3'=>'3000 and fPrice<4000','4'=>'fPrice>=4000');
$BOOK_ARR = array('1'=>'fPrice<500','2'=>'fPrice>=500 and fPrice<1000','3'=>'fPrice>=1000 and fPrice<2000','4'=>'fPrice>=2000');
$ORIGINAL_ARR = array('1'=>'fPrice>=20000 and fPrice<50000','2'=>'fPrice>=50000 and fPrice<100000','3'=>'fPrice>=100000 and fPrice<150000','4'=>'fPrice>=150000 and fPrice<200000','5'=>'fPrice>=200000');
## SITE	VARIABLES DEFINES	################################################################################### 
define('PROJ_DELIMITER', '[MM_BREAK]');
define('PROJ_SESSION_ID', 'udat_MMIRANDA');
define('NEWLINE', "\r\n");

define('TODAY', date("Y-m-d"));
define('TODAY2', date("d-m-Y"));
define('NOW', date("Y-m-d H:i:s"));
define('NOW2', date("d-m-Y H:i:s"));
define('YEAR_UBOUND', date('Y', strtotime('+2 years')));
define('LAST_MONTH', date("Y-m-d", strtotime("-1 month")));

define('NOW3', date("Ymd.Hi"));

define('YEAR_LBOUND', '2011');
define('PAGE_LIMIT', 15);
define('SQL_ERROR', 1);

//define('CATEGORY', 1);
define('STYLE', 1);
define('ORIENTATION', 2);
define('SIZE', 3);
define('MATERIAL', 4);

define('ALL', 'A');
define('ORIGINAL', 2);
define('TYPEPRINT', 3);

## FOLDER PATH DEFINES	################################################################################### 
define('AJAX_INC_URL','../includes/ajax.inc.php');

define('TEMPLATE_PATH',SITE_ADDRESS.'uploads/content/');
define('TEMPLATE_UPLOAD',DOCROOT.'uploads/content/');

define('CONTENT_PATH',SITE_ADDRESS.'uploads/content/');
define('CONTENT_UPLOAD',DOCROOT.'uploads/content/');

define('ADMIN_IMAGE_PATH',SITE_ADDRESS.'images/icons/');
define('IMAGE_PATH',SITE_ADDRESS.'images/');

define('PROD_CAT_UPLOAD',DOCROOT.'uploads/prodcat/');
define('PROD_CAT_PATH',SITE_ADDRESS.'uploads/prodcat/');

define('PRODUCT_UPLOAD',DOCROOT.'uploads/products/');
define('PRODUCT_PATH',SITE_ADDRESS.'uploads/products/');

define('SHOWCASE_UPLOAD',DOCROOT.'uploads/showcase/');
define('SHOWCASE_PATH',SITE_ADDRESS.'uploads/showcase/');

define('PRODUCT_IMAGE_PATH',SITE_ADDRESS.'uploads/product_images/');
define('PRODUCT_IMAGE_UPLOAD',DOCROOT.'uploads/product_images/');

define('PRODUCT_COLOR_IMAGE_PATH',SITE_ADDRESS.'uploads/product_color_images/');
define('PRODUCT_COLOR_IMAGE_UPLOAD',DOCROOT.'uploads/product_color_images/');

define('NEWS_PATH',SITE_ADDRESS.'uploads/news/');
define('NEWS_UPLOAD',DOCROOT.'uploads/news/');

define('INVOICE_UPLOAD',DOCROOT.'uploads/invoice/');
define('INVOICE_PATH',SITE_ADDRESS.'uploads/invoice/');

define('BOXES_UPLOAD',DOCROOT.'uploads/boxes/');
define('BOXES_PATH',SITE_ADDRESS.'uploads/boxes/');

define('ARTIST_UPLOAD',DOCROOT.'uploads/artist/');
define('ARTIST_PATH',SITE_ADDRESS.'uploads/artist/');

define('STATIC_UPLOAD',DOCROOT.'uploads/static/');
define('STATIC_PATH',SITE_ADDRESS.'uploads/static/');

define('CARTOON_UPLOAD',DOCROOT.'uploads/cartoon/');
define('CARTOON_PATH',SITE_ADDRESS.'uploads/cartoon/');

##	IMAGE DEFINES	################################################################################### 
define("ADD_RECORD_IMG" , "<i class='fas fa-plus-circle' alt='Add Record'></i> Add New");
//define("ADD_RECORD_IMG" , "<img src='" . ADMIN_IMAGE_PATH . "add-icon.gif' alt='Add Record' border='0'>");
define("FEATURED_IMG"   , "<i class='fas fa-star text-warning' alt='Add Record'></i> ON");
//define("FEATURED_IMG"   , "<img src='" . ADMIN_IMAGE_PATH . "featured.gif' alt='Edit Record' border='0'>");
define("UNFEATURED_IMG"   , "<i class='fas fa-star text-secondary' alt='Add Record'></i> OFF");
//define("UNFEATURED_IMG"   , "<img src='" . ADMIN_IMAGE_PATH . "unfeatured.gif' alt='Edit Record' border='0'>");
define("EDIT_IMG"       , "<i class='fas fa-pen' alt='Edit Record'></i>");
//define("EDIT_IMG"       , "<img src='" . ADMIN_IMAGE_PATH . "edit.gif' alt='Edit Record' border='0'>");
define("DELETE_IMG"     , "<img src='" . ADMIN_IMAGE_PATH . "delete.gif' alt='Delete Record' border='0'>");
define("ACTIVE_IMG"     , "<i class='fas fa-check-circle fa-2x'></i>");
//define("ACTIVE_IMG"     , "<img src='" . ADMIN_IMAGE_PATH . "active.gif'  alt='Active' border='0'>");
define("INACTIVE_IMG"   , "<i class='far fa-stop-circle fa-2x'></i>");
//define("INACTIVE_IMG"   , "<img src='" . ADMIN_IMAGE_PATH . "inactive.gif' alt='Inactive' border='0'>");
define("IMG_YES"        , "<img src='" . ADMIN_IMAGE_PATH . "image_y.jpg' alt='Edit Record' border='0'>");
define("IMG_NO"         , "<img src='" . ADMIN_IMAGE_PATH . "image_n.jpg' alt='Edit Record' border='0'>");
//define("PENDING_IMG"   	, "<img src='" . ADMIN_IMAGE_PATH . "pending.gif' alt='Pending' border='0'>");
//define("PENDING_IMG"   	, "<i class='far fa-pause-circle fa-2x'></i>");

define("DEFAULT_YES","<i class='fas fa-check-square text-sucess' alt='Edit Record'></i>");
//define("DEFAULT_YES","<img src='" . IMAGE_PATH . "yes-ico.gif' alt='Edit Record' border='0'>");<i class="fal fa-do-not-enter"></i>
define("DEFAULT_NO","<i class='fas fas fa-times-circle' alt='Edit Record'></i>");
//define("DEFAULT_NO","<img src='" . IMAGE_PATH . "no-ico.gif' alt='Edit Record' border='0'>");

define("STOCK_YES","<img src='" . IMAGE_PATH . "yes-ico.gif' alt='Edit Record' border='0'>");
define("STOCK_NO","<img src='" . IMAGE_PATH . "no-ico.gif' alt='Edit Record' border='0'>");

##	DEFINED ARRAYs	###################################################################################

$USER_LEVEL_ARR = array('1'=>' Admin', '2'=>'Operators');

define('COMPETITION_UPLOAD',DOCROOT.'uploads/competition/');
define('COMPETITION_PATH',SITE_ADDRESS.'uploads/competition/');

$COMPETITON_AGE_GROUP = array('1'=>'Upto 10 years', '2'=>'11 to 17 years', '3'=>'18 to 70 years', '4'=>'Above 70 years');
$WINNER_STATUS_ARR = array('0'=>'NA', '1'=>'1st Prize', '2'=>'2nd Prize', '3'=>'Consolation Prize');
$WINNER_IMAGE_ARR = array('1'=>'images/1st.png','2'=>'images/2nd.png','3'=>'images/cons.png');

define('USER_SESSION_ID', 'udat_FMM');
define('SHOP_SESSION_ID', 'shop_MM');

$OFFERS_SECTION_TYPE = array('N'=>'Text', 'F'=>'Flash Sale', 'C'=>'Coupon Code');

define('PAGE_SECTION_UPLOAD',DOCROOT.'uploads/pagesection/');
define('PAGE_SECTION_PATH',SITE_ADDRESS.'uploads/pagesection/');

define('TAGS_UPLOAD',DOCROOT.'uploads/tags/');
define('TAGS_PATH',SITE_ADDRESS.'uploads/tags/');

define('GIFTWRAP_CARDS_UPLOAD',DOCROOT.'uploads/giftwrap_cards/');
define('GIFTWRAP_CARDS_PATH',SITE_ADDRESS.'uploads/giftwrap_cards/');

$SORTBY_ARR = array('1'=>'Price Low to High', '2'=>'Price High to Low', '3'=>'A-Z');
?>