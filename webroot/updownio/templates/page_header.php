<?php
	session_start();
	include("lib/db.php");

#Custom error messages determined by $x value
function error($x){
	if ($x == 1){
		throw new Exception("Invalid Syntax used");
	}else if ($x == 2){
		throw new Exception("Wrong username/password");
	}else if ($x == 3){
		throw new Exception("Invalid Permissions");
	}else if ($x == 4){
		throw new Exception("Update Failed");
	}else if ($x == 4){
		throw new Exception("Delete Failed");
	}
}
?>
