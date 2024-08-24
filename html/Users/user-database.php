<?php
	$hostName = "localhost:3307";
	$dbuser = "root";
	$dbpassword = "";
	$dbname = "registerdb";

	$conn = mysqli_connect($hostName, $dbuser, $dbpassword, $dbname);

	if (!$conn) {
		die("Something went wrong");
	}
?>