<?php

require_once ($_SERVER["DOCUMENT_ROOT"] . '/cp/include/global.php');

$servername = SERVERNAME;
$username = USERNAME;
$password = PASSWORD;
$dbname = DBNAME;

// Create connection
$conn = new mysqli(SERVERNAME,USERNAME,PASSWORD,DBNAME);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
	exit();
}




?>
