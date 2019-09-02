<?php

require_once __DIR__ . '/vendor/autoload.php'; // change path as needed

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


$fb = new Facebook\Facebook([
  	'app_id' 		=> '2407538752793450', // Replace {app-id} with your app id
  	'app_secret' 		=> '3cb091d3fd4db7ef0c57235f02c31a7a',
  	'default_graph_version' => 'v4.0',
]);

$helper = $fb->getRedirectLoginHelper();

try {
	$accessToken 		= $helper->getAccessToken();
	$response 		= $fb->get('/me?fields=email,name', $accessToken);

} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  	echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
}


if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}


// Logged in

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();
// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('2407538752793450'); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
    exit;
  }

}

$_SESSION['fb_access_token'] = (string) $accessToken;

$user = $response->getGraphUser();
$email=$user['email'];

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
	    <script src="/guest/assets/scripts/jquery-3.3.1.min.js"></script>
	    <script type="text/javascript">
	    	$(document).ready(function(){
		$("#frm1").submit();
		});
	    </script>
	</head>
	<body>
	<form method="POST" action="https://cportal.al-enterprise.com/login" id="frm1" style="display:none;">
	<input type="hidden" id="email" name="user" value="<?=$email; ?>" required>
	    <input type="hidden" name="password" value="<?=$password; ?>" required >
	    <input type="hidden" name="url" value="https://www.al-enterprise.com/" >
	    <input type="submit" class="btn"  value="Login">
	</form>
	<?php
	}

?>
