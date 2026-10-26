<?php
error_reporting(0);
include "config.inc.php"; // db configurations
include "define.inc.php"; // # defines
include "generic.inc.php"; // # common functions
include "common.inc.php"; // # project specific functions
include "sql.inc.php"; // # sql functions
include "calendar.inc.php"; // # calender

if(!isset($NO_INCLUDE))
{
	include "userdat.php"; // # 
	include "permission.inc.php"; // 
}

include "dynamic.inc.php"; // */
?>