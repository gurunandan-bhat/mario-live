<?php
$_prev_page = (isset($_SESSION['temp_url']))?$_SESSION['temp_url']: false;
if(!empty($TAG_ME)) // only tag-worthy pages are tracked.. :)
	$_SESSION['temp_url'] = $_SERVER["REQUEST_URI"];
	
##	USER ACCESS      ###################################################################################
$logged = 0;
$sess_user_id='';
if(isset($_SESSION[USER_SESSION_ID]->log_stat)) // if the session variable has been set...
{	
	if($_SESSION[USER_SESSION_ID]->log_stat == "A")
	{
		$logged = 1;
		$sess_user_id = $_SESSION[USER_SESSION_ID]->user_id;
		$sess_user_name = $_SESSION[USER_SESSION_ID]->user_name;
		$sess_user_type = $_SESSION[USER_SESSION_ID]->user_type;
		$login_time = FormatDate($_SESSION[USER_SESSION_ID]->log_time, "B", 1);    
	}
	else
		ForceOut();
}
?>