<?php
//Sets https only cookies
session_set_cookie_params(3600, '/', 'localhost', isset($_SERVER["HTTPS"]), true);
session_name("PHPSESSID");
ini_set('session.cookie_httponly', '1');
include("templates/page_header.php");?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//Authentication query
	$stmt = authenticate_user($dbconn, $_POST["username"], $_POST["password"]);
	try {
		$result = $stmt->get_result();
		// The @ supresses any php errors, the error() function is still fired although 
		// The error() function prints custom error messages defined in 'page_header.php'
		if (@mysqli_num_rows($result) or error(2) == 1) {
			$row = mysqli_fetch_array($result);
			//Set sessions, "seccess" message will redirect the user via javascript
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['role'] = $row['role'];
			$_SESSION['id'] = $row['userid'];
			$_SESSION['authenticated'] = True;
			echo "success";
		}
	}catch(Exception $e) { 
		//Throws error 'Wrong username/password'
		echo $e->getMessage();
	} 
}

?>