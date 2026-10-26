<?php
require('php-captcha.inc.php');
$aFonts = array('../fonts/Tran551m.ttf');
$oVisualCaptcha = new PhpCaptcha($aFonts, 100, 25);
$oVisualCaptcha->Create();
?>