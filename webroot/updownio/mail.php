<?php
use PHPMailer\PHPMailer\PHPMailer;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["token"] == "d2CMKTRQ3RMWED6DDAJ2SzU5TrTGEGG2UuWMsqQjQXRZRNfd7r6w67PX85tFvcc4"){
	$server_name = $_POST["server_name"];
	$ip_address = $_POST["ip_address"];
	$OS = $_POST["OS"];
	$status = $_POST["status"];
	$body = '
	<html>
	<head>
		<style>
			td{
				border-bottom: 1px dotted black;
				padding:10px 0;
			}
		</style>
	</head>
	<body>
		<h2>' .$server_name . ' is ' . $status . '</h2>
	<table>
		<tr><td style="width: 120px;font-weight:700;">Server </td><td>' . $server_name . '</td></tr>
		<tr><td style="font-weight:700;">IP </td><td>' . $ip_address . '</td></tr>
		<tr><td style="font-weight:700;">OS </td><td>' . $OS . '</td></tr>
		<tr><td style="font-weight:700;">Status </td><td>' . $status . '</td></tr>
	</table>
	</body>
	</html>';

	require '/var/www/vendor/autoload.php';
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 2;
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->SMTPAuth = true;
	$mail->Username = 'example@gmail.com';
	$mail->Password = '123456';
	$mail->setFrom('example@gmail.com', 'updown.io');
	$mail->addReplyTo('noreply', 'updown.io');
	$mail->addAddress('bobsmith@gmail.com', 'Bob Smith');
	$mail->Subject = '[updown]['.$status.'] ' . $server_name;
	$mail->msgHTML($body);
	/*$mail->Body = 'Server: ' . $server_name . PHP_EOL .
						'IP Address:' . $ip_address . PHP_EOL .
						'Operating System: ' . $OS;*/
	if (!$mail->send()) {
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		echo 'The email message was sent.';
	}
}else{
	Header ("Location: /");	
}
?>