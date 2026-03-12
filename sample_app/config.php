<?php

use PDO\Mysql;

$host = 'localhost';
$dbname = 'myapp_db';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

// if ($conn) {
//     echo 'Database Connected Successfully';
// } else {
//     echo 'Database Connection Failed';
// }