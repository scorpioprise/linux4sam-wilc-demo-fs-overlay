<?php
$args='';
foreach ( $_REQUEST as $k=>$v ) $args=$args." $k='$v'";
$output = exec("issue_command 9008 $args");
echo "output is ".$output;
?>
