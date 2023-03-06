<?php
include("templates/page_header.php");
include("lib/auth.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$stmt = update_server($dbconn, $_POST["name"], $_POST["ipaddress"], $_POST["dhcp"], $_POST["type"], $_POST["OS"], $_POST["vmip"], $_POST["wakeonlan"], $_POST["description"], $_POST["comment"], $_POST["ID"]);	
	try {
		if ($stmt->affected_rows == 1  or error(4) == 1) {
			echo "success";
		}
	}catch(Exception $e) { 
		//Throws error 'Update was unsuccessful'
		echo $e->getMessage();
	} 
	
}
	
?>