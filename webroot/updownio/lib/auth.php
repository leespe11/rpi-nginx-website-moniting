<?php
// redirect the user to login.php if they arent authenticated via username/password
if (!isset($_SESSION['authenticated'])) {
	Header ("Location: /updownio/login.php");
}
?>
