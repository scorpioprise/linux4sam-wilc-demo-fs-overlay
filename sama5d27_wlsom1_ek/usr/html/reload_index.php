<?php
foreach ( $_SERVER as $k=>$v ) putenv("$k=$v");
header('Content-type: text/plain');
$output = shell_exec('sudo --preserve-env /usr/share/nginx/html/cgi-bin/store_wifi_parameters.sh 2>&1');
echo $output;
// header("refresh:10; url=index.html");
// exit;
?>
