<?php

define('DB_HOST',     'localhost');
define('DB_USERNAME', 'mario');
define('DB_PASSWORD', 'goaf1984!');
define('DB_NAME',     'mario');

try {

    $conn_string = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
    $dbh = new PDO($conn_string, DB_USERNAME, DB_PASSWORD);

    $rows = $dbh->query('SELECT * FROM orders ORDER BY iOrdID DESC LIMIT 10');
    foreach ($rows as $row) {
        print_r($row);
    }

    $dbh = null;

} catch (PDOException $e) {

    print "<pre>{$conn_string}<br/>Error!: {$e->getMessage()}</pre>";
    die();
}
