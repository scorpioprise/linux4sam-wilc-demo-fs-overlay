<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'www-data');
define('DB_PASSWORD', '');
define('DB_NAME', 'wallbox');
define('DB_PORT', '3306');
define('DB_SOCKET', '/var/lib/mysql/mysql.sock');
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT, DB_SOCKET);
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
