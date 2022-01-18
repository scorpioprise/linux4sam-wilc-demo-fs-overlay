<?php
$var_id = $_REQUEST['id'];
$output = exec('issue_command 9002 ' . $var_id);
// echo $var_id;
echo $output
?>
