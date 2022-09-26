<?php
// $var_id = $_REQUEST['oldname']." --- ".$_REQUEST['newname'];
// echo $var_id;
$output = exec('issue_command 3015 '.$_REQUEST['cardnumber']." ".$_REQUEST['newname']);
echo $output;
?>
