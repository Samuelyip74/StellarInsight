<?php 
require_once 'vendor/autoload.php';
// Start user session reqd for storing state

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

// Your App Configs
$provider = new TheNetworg\OAuth2\Client\Provider\Azure([
    'clientId'          => 'fbd1ec1e-47a1-4b64-9d02-8e5fc0fb3a8c',
    'clientSecret'      => 'dqiwONM13_jcbRUOW964^]$',
    'redirectUri'       => 'https://extcp.ale-enterprise.com/cp/azure/ms-login.php'
]);
// Just do basic read of /me endpoint 
$provider->scope = ['offline_access User.Read'];
$provider->urlAPI = "https://graph.microsoft.com/v1.0/";
// This tells the library not to pass resource reqd for v2.0
$provider->authWithResource = false;
// Obtain the auth code
if (!isset($_GET['code'])) {
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;
// State validation 
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit("State mismatch, ending auth");
} else {
    // Exchange auth code for tokens
    // Token will be in '$token->getToken();'
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code'],
        'resource' => 'https://graph.microsoft.com',
    ]);
    
    // Now we can call /me endpoint of MS Graph 
    try {
        $me = $provider->get("me", $token);
        // To get individual claims, you can do '$me['givenName']'
	$values = '<pre>' . print_r($me, true) . '</pre>';
	$password = rand(5,65535);

	$qry_body = "
		`id`                = '".rand(5,65535)."',
                `username`          = '".$me['mail']."',
                `attribute`         = 'Cleartext-Password',
                `op`                = ':=',
                `value`             = '".$password."' ";


                $select_qry = "select * from `radcheck` where `username`= '".$me['mail']."'";
		$res = $conn->query($select_qry);

                if($res->num_rows > 0) {
			//Update user details if it is already exists in the table
                        $sql = "update "."`radcheck`"." set `value` = ".$password." WHERE `username` = '".$me[mail]."'";
                } else {
                //Insert into table if user not exists in the table
		        $sql = "insert into "."radcheck"." set ".$qry_body.";";
			//                      echo $qry;
                }

//	echo $qry_body;
	//$sql = "insert into "."radcheck"." set ".$qry_body.";";
//	echo $sql;
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
<input type="hidden" id="email" name="user" value="<?=$me['mail']; ?>" required>
    <input type="hidden" name="password" value="<?=$password; ?>" required >
    <input type="hidden" name="url" value="https://www.al-enterprise.com/" >
    <input type="hidden" class="btn"  value="Login">
</form>
<?php

	}

        //exit($values);
    } catch (Exception $e) {
        exit('Failed to call the me endpoint of MS Graph.');
    }
}
