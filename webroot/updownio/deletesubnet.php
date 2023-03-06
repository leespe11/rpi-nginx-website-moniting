<?php
include("templates/page_header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$stmt = delete_subnet($dbconn, $_POST["value"]);	
	try {
		if ($stmt->affected_rows == 1  or error(5) == 1) {
			echo "success";
		}
	}catch(Exception $e) { 
		//Throws error 'Deletion was unsuccessful'
		echo $e->getMessage();
	} 
	
}
	
?>