<?php

if (!session_id()) {
    session_start();
}

include "include/db.php";

if (isset($_POST['username'])) {

        $username = $_POST['username'];
	$password = $_POST['password'];
	$company  = $_POST['company'];
	$provider = "Web";
	$email    = $_POST['email'];
	$phone	  = $_POST['phone'];

        $qry_body = "
       `id`             = '".rand(5,65535)."',
       `username`       = '".$username."',
       `password`	= '".$password."',
       `company`	= '".$company."',
       `provider`	=  '".$provider."',
       `email`		= '".$email."',
       `phone`		=  '".$phone."'";


	$select_qry = "select * from `userdb` where `username`= '".$username."'";

        $res = $conn->query($select_qry);
              if($res->num_rows > 0) {
                        //Update user details if it is already exists in the table
                        $sql = "update "."`radcheck`"." set `value` = ".$pass." WHERE `username` = '".$username."'";
                        if ($conn->query($sql) === TRUE) {
                                $url = 'https://cportal.al-enterprise.com/login?user='.$user.'&password='.$password;
                                header('location:'.$url);
                        }

              } else {
                //Insert into table if user not exists in the table
		      $sql = "insert into "."userdb"." set ".$qry_body.";";
		      echo $sql;
                        if ($conn->query($sql) === TRUE) {
                        $url = 'success.php';
                        header('location:'.$url);

                        }
                }
}
else{
       header("HTTP/1.1 200 OK");
}


?>
