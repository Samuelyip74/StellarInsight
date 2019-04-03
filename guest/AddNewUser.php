<?php
class AddNewUser {
	private $host		= "localhost";
	private $username 	= "radius";
	private $password	= "p@ssw0rd";
	private $database_name	= "radius";
	private $table		= 'radcheck';
	private $db;


	function __construct (){
		$this->db = new mysqli($this->host,$this->username, $this->password, $this->database_name);
		if($this->db->connect_error){
			die("Failed to connect");
		}
	}

	function verifyUser ($userInfo){


		$qry_body = "
			    `id`     		= '".$userInfo['id']."',
			    `username`          = '".$userInfo['email']."',
			    `attribute`		= 'Cleartext-Password',
			    `op`		= ':=',
		            `value`       	= '".$userInfo['id']."' ";


		$select_qry = "select * from 'radcheck' where `id`= '".$userInfo['id']."'";
		$res = $this->db->query($select_qry);
		if($res->num_rows > 0) {
		//Update user details if it is already exists in the table
			$qry = "update ".$this->table." set ".$qry_body." WHERE `id` = '".$userInfo['id']."'";
		} else {
		//Insert into table if user not exists in the table
			$qry = "insert into ".$this->table." set ".$qry_body.";";
//			echo $qry;
		}

		$this->db->query($qry);
		if($this->db->affected_rows == 1) {
			$_SESSION['user_is_login']     = true;
			$_SESSION['user_id']      = $userInfo['id'];
			$_SESSION['user_email']   = $userInfo['email'];
			//header('location:welcome.php');
//			exit();
		}
  	}// end of function
}// end of class
?>

