<?php

if (!session_id()) {
        session_start();
}

include "include/db.php";

if (isset($_POST['username'])) {

        $username = $_POST['username'];
	$password = $_POST['password'];

        $qry_body = "
       `username`       = '".$username."',
       `password`	=  '".$password."'";


	$select_qry = "select * from `userdb` where `username`= '".$username."' AND password ='".$password."'";

        $res = $conn->query($select_qry);
              if($res->num_rows > 0) {
                        //Update user details if it is already exists in the table
		        $sql = "select * from `sipaccount` where `account`='".$username."'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    // output data of each row
				while($row = $result->fetch_assoc()) {
//					echo "Account name: " . $row["account"]. " - SIP username: " . $row["username"]. " " . $row["password"]. "<br>";
					$url = "wp_serveraddress=".$row["serveraddress"]."&wp_username=".$row["username"]."&wp_password=".$row["password"]."&wp_transport=".$row["transport"];
//					$url = '/webphone/softphone.html';
//		                        header('location:'.$url);
				}
			?>
			<!DOCTYPE html>
			<html>
			<head>
			<title>Siper</title>
			<meta charset="utf-8">
			</head>
			<body>
			<script type="text/javascript">
				window.open("/webphone/softphone.html?<?=$url;?>","_blank", "width=400, height=500");
				window.close();
			</script>
			</body>
			</html>

			<?php
			}			

              } else {
                        $url = 'failed.php';
                        header('location:'.$url);
                }
}
else{
       header("HTTP/1.1 200 OK");
}


?>
