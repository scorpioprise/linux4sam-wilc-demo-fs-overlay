<?php
$var_id = $_REQUEST['id'];
$output = exec('/usr/bin/python3 /var/www/localhost/html/cgi-bin/issue_command.py 9002 ' . $var_id);
// echo $var_id;
echo $output
?>
