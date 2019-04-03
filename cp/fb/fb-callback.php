<?php
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


require_once __DIR__ . '/vendor/autoload.php'; // change path as needed
// Note: the GenericProvider requires the `urlAuthorize` option, even though
// it's not used in the OAuth 2.0 client credentials grant type.

$provider = new \League\OAuth2\Client\Provider\GenericProvider([
    'clientId'                => '1386805538117846',    // The client ID assigned to you by the provider
    'clientSecret'            => '98f5de3fa244f172a832691764f87e16',    // The client password assigned to you by the provider
    'redirectUri'             => 'https://extcp.al-enterprise.sg/cp/fb/fb-callback.php',
    'urlAuthorize'            => 'https://www.facebook.com/v3.2/dialog/oauth',
    'urlAccessToken'          => 'https://graph.facebook.com/v3.2/oauth/access_token',
    'urlResourceOwnerDetails' => 'https://graph.facebook.com/me?fields=name,first_name,last_name,email'
]);

// If we don't have an authorization code then get one
if (!isset($_GET['code'])) {

    // Fetch the authorization URL from the provider; this returns the
    // urlAuthorize option and generates and applies any necessary parameters
    // (e.g. state).
    $authorizationUrl = $provider->getAuthorizationUrl();

    // Get the state generated for you and store it to the session.
    $_SESSION['oauth2state'] = $provider->getState();

    // Redirect the user to the authorization URL.
    header('Location: ' . $authorizationUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {

    if (isset($_SESSION['oauth2state'])) {
        unset($_SESSION['oauth2state']);
    }
    
    exit('Invalid state');

} else {

    try {

        // Try to get an access token using the authorization code grant.
        $accessToken = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        // Using the access token, we may look up details about the
        // resource owner.
        $resourceOwner = $provider->getResourceOwner($accessToken);
	$fbuser = $resourceOwner->toArray();

	$email =  $fbuser['email'];
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
	<form method="POST" action="https://cportal.al-enterprise.com/login/" id="frm1">
	<input type="hidden" id="email" name="user" value="<?=$email; ?>" required>
	    <input type="hidden" name="password" value="<?=$password; ?>" required >
	    <input type="hidden" name="url" value="https://www.al-enterprise.com/" >
	    <input type="hidden" class="btn"  value="Login">
	</form>
	<?php
	}

    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

        // Failed to get the access token or user details.
        exit($e->getMessage());

    }

}

?>
