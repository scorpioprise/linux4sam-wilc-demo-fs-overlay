<?php
$output = exec('/usr/bin/python3 /var/www/localhost/html/cgi-bin/issue_command.py 9000');
echo $output;
?>
