<?php
	
	$host="localhost";
	$user="root";
	$pass="";
	$db="user_registration";


	
	$conn = mysqli_connect($host, $user, $pass, $db);

	if (!$conn) {
	    echo "Error: Unable to connect to MySQL." . PHP_EOL;
	    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
	    exit;
	}
?>