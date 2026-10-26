<?php
include ('env.php');

switch (APP_ENV) {
    case 'DEV':
	include_once ('env_dev.php');
	break;
    case 'PROD':
	include_once ('env_prod.php');
	break;
    default:
	die ('No configuration found');
	break;
}
