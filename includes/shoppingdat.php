<?php 
// data that needs to be rememberered...
class shoppingdat
{
// GENERAL CART VARIABLES
	var $order_id;	//ORDER id

	var $ord_id = array();	// ORDER_DAT ID
	var $ord_qty = array();
	var $ord_type = array();
	var $ord_stat = array(); // available 'A' or out-of-stock 'R'
	var $ord_price = array();
	var $cart_data = array();
	var $giftwrap_data = array();
	var $giftwrap_card_data = array();
	var $address_data = array();
	var $disc_data = array();
	var $attrib_data = array();
	var $color_data = array();
	var $ord_dcircle;
	var $ord_total;
	var $currency;
	var $memTYPE;
		
	var $logtime;	// time of login
	var $sess;		// dunno yet - me thinks it stores the name of the session
					///////////////////////////////////////////////
	var $ANCHOR; 	// a variable  to store if a location has to be remembered 
	var $info;		// error msg

}
?>