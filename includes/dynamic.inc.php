<?php
##	GETCONNECTED	###################################################################################
$CON = getconnected();

##	USER ACCESS		###################################################################################
$logged = 0;
$is_super_admin = $is_admin = $is_manager = $is_executive = $is_tellecaller = $is_production = $is_acc = false;


if(isset($_SESSION[PROJ_SESSION_ID]->log_stat)) // if the session variable has been set...
{	
	if($_SESSION[PROJ_SESSION_ID]->log_stat == "A")
	{
		$logged = 1;
		$sess_user_id = $_SESSION[PROJ_SESSION_ID]->user_id;
		$sess_user_name = $_SESSION[PROJ_SESSION_ID]->user_name;
		$sess_user_level = $_SESSION[PROJ_SESSION_ID]->user_level;
		$sess_login_time = FormatDate($_SESSION[PROJ_SESSION_ID]->log_time, "B", 1);

		$is_super_admin = (!$sess_user_id && $sess_user_level==1)? true: false;
		$is_admin = ($sess_user_level==0)? true: false;
		$is_manager = ($sess_user_level==1)? true: false;
		// $is_executive = ($sess_user_level==2)? true: false;
		$is_tellecaller = ($sess_user_level==3)? true: false;
	}

	$sess_user_access = GetUserPermissionArr($sess_user_id, $sess_user_level);
}

if(!$logged && empty($NO_REDIRECT))
	ForceOut(6);

##	DEFINED MENU ARRAYs	###################################################################################
//$disp = (isset($_SESSION[PROJ_SESSION_ID]->user_id))?$_SESSION[PROJ_SESSION_ID]->user_id:'';

$BREADCRUMB_ARR = array();

//$CONFIG_MENU_ARR['Showcase'] = array('slideshow_disp.php');
$CONFIG_MENU_ARR['Tags'] = array('tags_disp.php');
$CONFIG_MENU_ARR['Static Pages'] = array('static_disp.php');
$CONFIG_MENU_ARR['Coupons'] = array('coupon_disp.php');
$CONFIG_MENU_ARR['Testimonials'] = array('testimonial.php');
$CONFIG_MENU_ARR['Bluedart Settings'] = array('bluedart_settings.php');
$CONFIG_MENU_ARR['GiftWrap Settings'] = array('giftwrap_settings.php');
$CONFIG_MENU_ARR['GiftWrap Cards'] = array('giftwrap_cards_disp.php');
$CONFIG_MENU_ARR['Intl Shipping'] = array('international_settings.php');
$CONFIG_MENU_ARR['SEO Settings'] = array('seo_settings.php');
$CONFIG_MENU_ARR['About Us'] = array('about_us.php');
$CONFIG_MENU_ARR['Contact Us Left'] = array('contact_us_left.php');
$CONFIG_MENU_ARR['Contact Us Right'] = array('contact_us_right.php');
$CONFIG_MENU_ARR['Change Password'] = array('change_password.php');
$CONFIG_URLS = GetAllUrls($CONFIG_MENU_ARR, 'Configuration');

$SHIPPING_MENU_ARR['Country'] = array('country_disp.php');
$SHIPPING_MENU_ARR['State'] = array('state_disp.php');
$SHIPPING_MENU_ARR['Courier'] = array('courier_disp.php');
$SHIPPING_URLS = GetAllUrls($SHIPPING_MENU_ARR, 'Shipping');

$ATTRIBUTE_MENU_ARR['Attribute'] = array('attrib_disp.php');
$ATTRIBUTE_MENU_ARR['Color'] = array('color_disp.php');
$ATTRIBUTE_URLS = GetAllUrls($ATTRIBUTE_MENU_ARR, 'Attribute');

$COMPETITION_MENU_ARR['Category'] = array('competition_cat_disp.php');
$COMPETITION_MENU_ARR['Entries'] = array('competition_disp.php');
$COMPETITION_URLS = GetAllUrls($COMPETITION_MENU_ARR, 'Attribute');

$PRODUCT_MENU_ARR['Category'] = array('prod_cat_disp.php');
$PRODUCT_MENU_ARR['List'] = array('product_disp.php');
$PRODUCT_MENU_ARR['Reviews'] = array('product_reviews.php');
$PRODUCT_MENU_ARR['Product Offers'] = array('product_offers.php');
$PRODUCT_URLS = GetAllUrls($PRODUCT_MENU_ARR, 'Product');

$HM_MENU_ARR['Offers Section'] = array('section_disp.php');
$HM_MENU_ARR['Showcase'] = array('slideshow_disp.php');
$HM_MENU_ARR['Page Sections'] = array('page_disp.php');
$HM_URLS = GetAllUrls($HM_MENU_ARR, 'Home Manager');

$MENU_ARR = array();
$MENU_ARR[0] = array('TEXT'=>'Dashboard', 'FILE'=>'home.php', 'IMG'=>'<img src="../assets/images/header/icon_dashboard.png" />');
$MENU_ARR['ATTRIB'] = array('TEXT'=>'Attributes', 'FILE'=>'#', 'SUB_MENU'=>$ATTRIBUTE_MENU_ARR, 'URLS'=>$ATTRIBUTE_URLS);
//$MENU_ARR['PROD_CAT'] = array('TEXT'=>'Product Category', 'FILE'=>'prod_cat_disp.php');
//$MENU_ARR['PRODUCT'] = array('TEXT'=>'Product', 'FILE'=>'product_disp.php');
$MENU_ARR['PRODUCT'] = array('TEXT'=>'Products', 'FILE'=>'#', 'SUB_MENU'=>$PRODUCT_MENU_ARR, 'URLS'=>$PRODUCT_URLS);
//$MENU_ARR['SLIDES'] = array('TEXT'=>'Showcase', 'FILE'=>'slideshow_disp.php');
$MENU_ARR['NEWS'] = array('TEXT'=>'News & Events', 'FILE'=>'news_disp.php');
$MENU_ARR['ORDER'] = array('TEXT'=>'Order', 'FILE'=>'order_disp.php');
//$MENU_ARR['STATIC'] = array('TEXT'=>'Static Pages', 'FILE'=>'static_disp.php');
$MENU_ARR['COMPETITION'] = array('TEXT'=>'Competition', 'FILE'=>'#', 'SUB_MENU'=>$COMPETITION_MENU_ARR, 'URLS'=>$COMPETITION_URLS);
$MENU_ARR['FLASH'] = array('TEXT'=>'Flash Sale', 'FILE'=>'flashsale_disp.php');
$MENU_ARR['DC'] = array('TEXT'=>'Daily Cartoon', 'FILE'=>'cartoon_disp.php');
$MENU_ARR['HM'] = array('TEXT'=>'Home Manager', 'FILE'=>'#', 'SUB_MENU'=>$HM_MENU_ARR, 'URLS'=>$HM_URLS);
$MENU_ARR['SHIP'] = array('TEXT'=>'Shipping', 'FILE'=>'#', 'SUB_MENU'=>$SHIPPING_MENU_ARR, 'URLS'=>$SHIPPING_URLS);
$MENU_ARR['CFG'] = array('TEXT'=>'Configuration', 'FILE'=>'#', 'SUB_MENU'=>$CONFIG_MENU_ARR, 'URLS'=>$CONFIG_URLS);	// */
$MENU_ARR[1] = array('TEXT'=>'Logout', 'FILE'=>'logout.php', 'IMG'=>'<img src="../assets/images/header/topnav/logouticon.png" />');

	
##	SESSION->INFO	###################################################################################
$_file_name = basename($_SERVER["SCRIPT_NAME"]);
$_file_module = GetFileModule($_file_name);

$lbl_display = 'none'; // used for LBL_ERR
$sess_info = (isset($_SESSION[PROJ_SESSION_ID]->info))? trim($_SESSION[PROJ_SESSION_ID]->info): '';
$sess_success_info = (isset($_SESSION[PROJ_SESSION_ID]->success_info))? trim($_SESSION[PROJ_SESSION_ID]->success_info): '';
$sess_error_info = (isset($_SESSION[PROJ_SESSION_ID]->error_info))? trim($_SESSION[PROJ_SESSION_ID]->error_info): '';

$sess_info .= $sess_success_info . $sess_error_info;
$lbl_display = ($sess_info!="")? '': 'none';
if(isset($_SESSION[PROJ_SESSION_ID]))
{
	$_SESSION[PROJ_SESSION_ID]->info="";
	$_SESSION[PROJ_SESSION_ID]->success_info="";
	$_SESSION[PROJ_SESSION_ID]->error_info="";
}

#######################################################################################################
function GetAllUrls($menu_arr, $module)
{
	$arr = array();
	global $BREADCRUMB_ARR;
	$i=0;
	
	foreach($menu_arr as $a_key=>$a)
	{
		if($a[0]!='#')
			$BREADCRUMB_ARR[$a[0]] = array($module, '<a href="'.$a[0].'">'.$a_key.'</a>');

		foreach($a as $b_key=>$b)
		{
			if(!is_array($b))
			{
				$arr[$i++] = $b;
				continue;
			}

			foreach($b as $c_key=>$c)
			{					
				$arr[$i++] = $c;

				if(is_numeric($c_key))
					$BREADCRUMB_ARR[$c] = array($module, '<a href="'.$a[0].'">'.$a_key.'</a>');
				else
					$BREADCRUMB_ARR[$c] = array($module, '<a href="'.$a[0].'">'.$a_key.'</a>', '<a href="'.$b[0].'">'.$b_key.'</a>');
			}
		}		
	}
	
	$arr = array_unique($arr);
	return $arr;
}

function GetFileModule($_file_name)
{
	global $MENU_ARR;
	$str = 'XYZ';
	$is_this_url = false;
	
	if(isset($MENU_ARR))
	{
		foreach($MENU_ARR as $M_CODE=>$M)
		{
			if($_file_name == $M['FILE'] || (isset($M['URLS']) && is_array($M['URLS']) && in_array($_file_name, $M['URLS'])))
			{
				$str = $M_CODE;
				break;
			}
		}
	}

	return $str;
}
?>
