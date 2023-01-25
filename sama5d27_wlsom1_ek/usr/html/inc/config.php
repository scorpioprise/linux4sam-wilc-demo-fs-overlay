<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'www-data');
define('DB_PASSWORD', '');
define('DB_NAME', 'wallbox');
define('DB_PORT', '3306');
define('DB_SOCKET', '/var/lib/mysql/mysql.sock');
#define('DB_SOCKET', '');
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT, DB_SOCKET);
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
function trovaLingua() {
    $link   = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT, DB_SOCKET);
    $sql = "SELECT `value` FROM configuration WHERE `name` = 'language'";
    if ($stmt = mysqli_prepare($link, $sql)) {
        if (mysqli_stmt_execute($stmt)) {
            $result = $stmt->get_result();
            $nrows = 0;
            while ($row = $result->fetch_assoc()) {
                $nrows++;
                if ($row['value'] == 'it-IT') {
                    $lingua = "it";
                } else if ($row['value'] == 'en-EN') {
                    $lingua = "en";
                } else if ($row['value'] == 'ru-RU') {
                    $lingua = "ru";
                } else
                    $lingua = "en";
            }
            if ($nrows == 0) {
                echo "Missing parameter.";
            }
        } else {
            echo "Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
    return $lingua;
}
