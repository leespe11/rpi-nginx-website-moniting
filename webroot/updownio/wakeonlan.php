<?php

session_start();
include("lib/auth.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$output = shell_exec('wakeonlan -i ' . $_POST["ip"] . ' -p 9 '. $_POST["mac"]);
	
	## The bellow line is UNSAFE, 
	## Only use in the case when you need to access a different subnet
	## PREFERED public key authentication (Requires id-rsa.pub to be added within PHP docker container)
	#$output = shell_exec('ssh username@192.168.2.100 \'wakeonlan ' . $_POST["mac"] . '\' 2>&1');
	
	## UNSAFE passing .pub file through ssh 
	#$output = shell_exec('ssh -i /var/www/.ssh/id_rsa username@192.168.2.100 \'echo 1 \' 2>&1');
	echo $output;
}else{
	echo "fail";
}
?>