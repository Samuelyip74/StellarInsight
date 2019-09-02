<?php
require_once '/var/www/html/cp/include/global.php';

//require_once '../include/dbconnect.php';

if (!session_id()) {
    session_start();
}


$servername = "localhost";
$username = "radius";
$password = "p@ssw0rd";
$dbname = "radius";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['openId'])) {
	
	$user = $_GET['openId'];
	$pass = rand(5, 65535);

        $qry_body = "
       `id`                = '".rand(5,65535)."',
       `username`          = '".$user."',
        `attribute`         = 'Cleartext-Password',
        `op`                = ':=',
        `value`             = '".$pass."'";


        $select_qry = "select * from `radcheck` where `username`= '".$user."'";
	$res = $conn->query($select_qry);
              if($res->num_rows > 0) {
                        //Update user details if it is already exists in the table
		      	$sql = "update "."`radcheck`"." set `value` = ".$pass." WHERE `username` = '".$user."'";
 			if ($conn->query($sql) === TRUE) {
				$url = 'https://cportal.al-enterprise.com/login?user='.$user.'&password='.$pass;
				header('location:'.$url);
			}
	      
	      } else {
                //Insert into table if user not exists in the table
			$sql = "insert into "."radcheck"." set ".$qry_body.";";
			if ($conn->query($sql) === TRUE) {
			$url = 'https://cportal.al-enterprise.com/login?user='.$user.'&password='.$pass;
                        header('location:'.$url);
	
		        }
                }
}
else{
       header("HTTP/1.1 200 OK");
}

?>
