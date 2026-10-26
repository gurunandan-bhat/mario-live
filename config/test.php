<?php

include "MarioDB.php";

$marioDB = new MarioDB;
$sections = $marioDB -> categoryProducts ('crockery');

/* foreach ($categories as $row) {
 *     print_r ($row);
 * } */

print_r ($sections);
