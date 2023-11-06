<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'www-data');
define('DB_PASSWORD', '');
define('DB_NAME', 'storage');
define('DB_PORT', '3306');
define('DB_SOCKET', '/var/lib/mysql/mysql.sock');
//define('DB_SOCKET', '');
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT, DB_SOCKET);
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
function trovaLingua()
{
    $link2   = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT, DB_SOCKET);
    $sql = "SELECT `value` FROM configuration WHERE `name` = 'language'";
    if ($stmt = mysqli_prepare($link2, $sql)) {
        if (mysqli_stmt_execute($stmt)) {
            $result = $stmt->get_result();
            $nrows = 0;
            while ($row = $result->fetch_assoc()) {
                $nrows++;
                //lingua inserite in produzione
                if ($row['value'] == 'it_IT') {
                    $lingua = "it";
                } else if ($row['value'] == 'en_EN') {
                    $lingua = "en";
                } else if ($row['value'] == 'ru_RU') {
                    $lingua = "ru";
                    //lingua modificata dall'utente
                } else if ($row['value'] == 'user_IT-EN') {
                    $lingua = "useriten";
                } else if ($row['value'] == 'user_EN-IT') {
                    $lingua = "userenit";
                } else if ($row['value'] == 'user_EN-RU') {
                    $lingua = "userenru";
                } else if ($row['value'] == 'user_RU-EN') {
                    $lingua = "userruen";
                } else
                    $lingua = "en";
            }
            if ($nrows == 0) {
                echo "Missing parameter";
            }
        } else {
            echo "Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link2);
    return $lingua;
}
