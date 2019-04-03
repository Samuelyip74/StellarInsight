<?php
session_start();

require_once('settings.php');
require_once('google-login-api.php');

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

// Google passes a parameter 'code' in the Redirect Url
if(isset($_GET['code'])) {
	try {
		$gapi = new GoogleLoginApi();
		
		// Get the access token 
		$data = $gapi->GetAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);
		
		// Get user information
		$user_info = $gapi->GetUserProfileInfo($data['access_token']);
		$email =  $user_info['emails'][0]['value'];
		//echo '<pre>';print_r($user_info); echo '</pre>';

		// Now that the user is logged in you may want to start some session variables
		$_SESSION['logged_in'] = 1;

		// You may now want to redirect the user to the home page of your website
		// header('Location: home.php');

		$password = rand(5,65535);

	        $qry_body = "
                `id`                = '".rand(5,65535)."',
                `username`          = '".$email."',
                `attribute`         = 'Cleartext-Password',
                `op`                = ':=',
                `value`             = '".$password."' ";


                $select_qry = "select * from `radcheck` where `username`= '".$email."'";
                $res = $conn->query($select_qry);

                if($res->num_rows > 0) {
                        //Update user details if it is already exists in the table
                        $sql = "update "."`radcheck`"." set `value` = ".$password." WHERE `username` = '".$email."'";
                } else {
                //Insert into table if user not exists in the table
                        $sql = "insert into "."radcheck"." set ".$qry_body.";";
                        //                      echo $qry;
                }

		//      echo $qry_body;
//	        $sql = "insert into "."radcheck"." set ".$qry_body.";";
	//      echo $sql;
        	if ($conn->query($sql) === TRUE) {
		?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Begin: Meta Data -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <title>Free WIFI HotSpot</title>
    <meta name="description" content=""/>
    <meta http-equiv="content-language" content="en">
    <meta name="viewport" content="width=device-width" />
    <!-- END: Meta Data -->
    <!-- Begin: Coveo CSS (Template ID=Search Page) -->
    <!-- END: Coveo CSS -->
    <!-- Begin: Global CSS -->

    <!-- Begin: Global JavaScript Top -->
<script src="/guest/assets/scripts/jquery-3.3.1.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
   $("#frm1").submit();
});

</script>



    <!-- End: Global JavaScript Top -->


</head>
<body>
<form method="POST" action="https://cportal.al-enterprise.com/login/" id="frm1">
<input type="hidden" id="email" name="user" value="<?=$email; ?>" required>
    <input type="hidden" name="password" value="<?=$password; ?>" required >
    <input type="hidden" name="url" value="https://www.al-enterprise.com/" >
    <input type="hidden" class="btn"  value="Login">
</form>
<?php
	}


	}
	catch(Exception $e) {
		echo $e->getMessage();
		exit();
	}
}

?>
