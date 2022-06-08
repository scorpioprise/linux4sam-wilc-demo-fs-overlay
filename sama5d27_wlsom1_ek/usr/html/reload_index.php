<?php
foreach ( $_SERVER as $k=>$v ) putenv("$k=$v");
// header('Content-type: text/plain');
$output = exec('issue_command 9008 ssid=$SSID passphrase=$PASS dhcp=$DHCP ipaddress=$IPADDRESS netmask=$NETMASK gateway=$GATEWAY dns=$DNS');
echo $output;
// header("refresh:10; url=index.html");
// exit;
?>
