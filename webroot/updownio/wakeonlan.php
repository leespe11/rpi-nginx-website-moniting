<?php

session_start();
include("lib/auth.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$output = shell_exec('ssh spacecar@192.168.86.199 \'wakeonlan ' . $_POST["mac"] . '\' 2>&1');
	#$output = shell_exec('ssh -i /var/www/.ssh/id_rsa spacecar@192.168.86.199 \'echo 1 \' 2>&1');
	echo $output;
}else{
	echo "fail";
}

#shell_exec('ssh spacecar@192.168.86.200 \'wakeonlan ' . $_POST["mac"] . ' -i ' . $_POST["ip"] . '\'');
/*
$output = shell_exec('ssh spacecar@192.168.86.200 \'wakeonlan 44:87:FC:66:C4:41\' 2>&1');
echo "<pre>$output</pre>";
*/
?>