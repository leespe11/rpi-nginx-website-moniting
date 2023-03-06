<?php
$dbconn = mysqli_connect("mysql_net", "root", "1234", "updownio");
if (!$dbconn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

function run_query($dbconn, $query) {
	return mysqli_query($dbconn, $query);
}

// function for prepared statments 
function run_query_prepared($stmt) {
	$stmt->execute();
	return $stmt;
}


//database functions
function get_servers_list($dbconn){
	// Dont need prepared statment for this function 
	$query = "SELECT 
		ID,
	    ipaddress, 
		name, 
		type, 
		OS,
		DHCP, 
		description,
		vmip, 
		wakeonlan,
		comment,
		status
		FROM servers
		ORDER BY
		name ASC";
	return run_query($dbconn, $query);
}

function get_subnet_list($dbconn){
	$query = "SELECT value FROM subnets";
	return run_query($dbconn, $query);
}

function delete_server($dbconn, $ID) {
	$stmt = $dbconn->prepare("DELETE FROM servers WHERE ID= ? ");
	$stmt->bind_param("i", $ID);
	return run_query_prepared($stmt);
}

function delete_subnet($dbconn, $value) {
	$stmt = $dbconn->prepare("DELETE FROM subnets WHERE value= ? ");
	$stmt->bind_param("i", $value);
	return run_query_prepared($stmt);
}

function add_subnet($dbconn, $value) {
	$stmt = $dbconn->prepare("
		INSERT INTO
		subnets VALUES ( ? )");
	$stmt->bind_param("i", $value);
	return run_query_prepared($stmt);
}

function add_server($dbconn, $name, $ipaddress, $DHCP, $type, $OS, $vmip, $wakeonlan, $description, $comment, $status) {
	$stmt = $dbconn->prepare("
		INSERT INTO
		servers
		(name, ipaddress, dhcp, type, OS, vmip, wakeonlan, description, comment, status) 
		VALUES
		( ? , ? , ? , ? , ? , ? , ? , ? , ?, ? )");
	$stmt->bind_param("ssissssssi", $name, $ipaddress, $DHCP, $type, $OS, $vmip, $wakeonlan, $description, $comment, $status);
	return run_query_prepared($stmt);
}

function update_server($dbconn, $name, $ipaddress, $DHCP, $type, $OS, $vmip, $wakeonlan, $description, $comment, $ID) {
	$stmt = $dbconn->prepare("UPDATE servers SET name= ? , ipaddress = ? , DHCP = ? , type = ? , OS = ? , vmip = ? , wakeonlan = ? , description = ?, comment = ? where ID = ? ");
	$stmt->bind_param("ssissssssi", $name, $ipaddress, $DHCP, $type, $OS, $vmip, $wakeonlan, $description, $comment, $ID);
	return run_query_prepared($stmt);
}

function authenticate_user($dbconn, $username, $password) {
	// Also used prepated statment to mitigate sql injections
	if(filter($username) && filter($password)){
		$stmt = $dbconn->prepare("SELECT `userid`, `role` FROM `users` WHERE `username` = ? AND `password` = ? ");
		$stmt->bind_param("ss", $username, $password);
		return run_query_prepared($stmt);
	}
    return "null";
}	

function filter($input){
	// Created an 'if' statment using htmlspecialchars() and regex match to catch any special charcters not caught by htmlspecialchars()
	if(!preg_match('/^(["\'\;#]).*\1$/m', $input) && htmlspecialchars($input, ENT_QUOTES) == $input){
		return true;	
	}else{
		return false;
	}
}
?>
