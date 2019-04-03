<?php
$servername = "localhost";
$username = "dbuser";
$password = "p@ssw0rd";
$dbname = "siper";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

