<?php
$output = exec("/var/www/localhost/html/cgi-bin/store_wifi_parameters.sh");
// echo $output
header("refresh:10; url=index.html");
exit;
?>
