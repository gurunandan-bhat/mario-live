<?php 

// data that needs to be rememberered...
class userdat
{
	var $log_time;		// time of login
	var $log_stat;		// log status - is the user logged in or not
	var $sess_id;		// session id
///////////////////////////////////////////////

	var $user_id;		// de user's id		
	var $user_name;		// de user's name	
	var $user_level;	//
	var $user_locid;	//	
///////////////////////////////////////////////

	var $srch_ctrl_arr = array();
	
	var $info;			// error msg
}

$sess_id = session_id();

if(empty($sess_id))
{
	session_start();
}
?>