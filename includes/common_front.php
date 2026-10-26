<?php
require_once("config.inc.php");
require_once("define.inc.php");
require_once("generic.inc.php");
require_once("common.inc.php");
require_once("sql.inc.php");
require_once('userdat.inc.php');
require_once('dynamic_front.inc.php');

require_once("Mobile_Detect.php");
$detect = new Mobile_Detect();
if($detect->isMobile())
	define('IS_MOBILE','Y');
else
	define('IS_MOBILE','N');

$CON = getconnected();
?>