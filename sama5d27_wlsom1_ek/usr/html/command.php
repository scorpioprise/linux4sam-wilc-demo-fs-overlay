<?php
// $var_id = $_REQUEST['parameter'].":".$_REQUEST['valore'];
// echo $var_id;
$output = exec('issue_command '.$_REQUEST['parameter']." ".$_REQUEST['valore']);
echo $output;
?>
