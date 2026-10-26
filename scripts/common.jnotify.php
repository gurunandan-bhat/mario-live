<?php
if(empty($_GET['flag']))
	header("content-type: application/x-javascript");

require_once("../includes/common.php");
// require_once("../includes/userdat.inc.php");
$jnotify_str = '';
/*
echo '/*'."/n";
// echo 'alert("'.$var.'");'."\n";
 print_r($_SESSION);
// $_SESSION[PROJ_SESSION_ID]->success_info = 'success!!';
// $_SESSION[PROJ_SESSION_ID]->error_info = ':(';
echo "/n".'*///'."/n";	// */


if(isset($_SESSION[PROJ_SESSION_ID]->success_info) && $_SESSION[PROJ_SESSION_ID]->success_info!='')
{
	$success_str = trim($_SESSION[PROJ_SESSION_ID]->success_info);	
	$jnotify_str .= '$.jnotify("'.$success_str.'");'."\n";
	$_SESSION[PROJ_SESSION_ID]->success_info = '';
}

if(isset($_SESSION[PROJ_SESSION_ID]->error_info) && $_SESSION[PROJ_SESSION_ID]->error_info!='')
{
	$error_str = trim($_SESSION[PROJ_SESSION_ID]->error_info);
	$jnotify_str .= '$.jnotify("'.$error_str.'", "error");'."\n";
	$_SESSION[PROJ_SESSION_ID]->error_info = '';
}

if(isset($_SESSION[PROJ_SESSION_ID]->warning_info) && $_SESSION[PROJ_SESSION_ID]->warning_info!='')
{
	$error_str = trim($_SESSION[PROJ_SESSION_ID]->warning_info);
	$jnotify_str .= '$.jnotify("'.$error_str.'", "error", true);'."\n";
	$_SESSION[PROJ_SESSION_ID]->warning_info = '';
}
/*
if(!empty($_SESSION['err_code'])) //  && !empty($LOGIN_ERR[$_SESSION['err_code']])
{
	// $is_sticky_info = (!empty($_SESSION['jnotify_sticky']))? 'true': 'false';
	$is_sticky_info = 'true';
	$error_str = trim($_SESSION['err_code']);
	$jnotify_str .= '$.jnotify("'.$error_str.'", "error", '.$is_sticky_info.');'."\n";
	$_SESSION['err_code'] = '';
}	// */

$_SESSION['jnotify_sticky'] = '';

if($jnotify_str!='')
{
?>
$(document).ready(function (){
	<?php echo $jnotify_str; ?>
});
<?php
}
?>