<?php
// $var_id = $_REQUEST['parameter'].":".$_REQUEST['valore'];
// echo $var_id;
$output = exec('/usr/bin/python3 /var/www/localhost/html/cgi-bin/issue_command.py '.$_REQUEST['parameter']." ".$_REQUEST['valore']);
echo $output;
?>
