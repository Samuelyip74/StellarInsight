<?php
if (!session_id()) {
    session_start();
}

	// What is the request state?
        //$isLoginRequest = isset($_REQUEST['loginurl']);
        $isLoginRequest = isset($_REQUEST['switchip']);
        $isLoginError = isset($_REQUEST['error_message']);
        $isLoggedIn = isset($_COOKIE['LogoutURL']);

        // Lets get the values from the query parameters
        $data = array();

        // Location of the splash
        $data['rootUrl'] = "https://" . $_SERVER['SERVER_NAME'];

        if ($isLoginRequest) {
                // URLs
                $data['loginUrl'] = "https://cportal.al-enterprise.com/login";
                $data['nextUrl'] = urldecode($_REQUEST['url']);

                // Access Point Info
                $data['ap']['mac'] = $_REQUEST['switchmac'];
                $data['ap']['ip'] = $_REQUEST['switchip'];
                $data['ap']['ssid'] =  $_REQUEST['ssid'];

                // Client Info
                $data['client']['mac'] = $_REQUEST['clientmac'];
                $data['client']['ip'] = $_REQUEST['clientip'];
	}

	if ($isLoginError) {
                // Error Message
                $data['errorMessage'] = $_REQUEST['error_message'];
        }

        if ($isLoggedIn) {
                // Get the logout URL from the cookie
                $data['logoutUrl'] = urldecode($_COOKIE['LogoutURL']);
	}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 16; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Free WiFI Hotspot</title>

        <script type="text/javascript" src="assets/jquery-2.1.0.min.js"></script>
        <link rel="stylesheet" href="assets/bootstrap.min.css">
        <link rel="stylesheet" href="assets/style2.css">
</head>
<body>
<div class="container">
	<div class="container">
		<form method="POST" action="CreateUser.php">
		    <div class="row">
		      <h2 style="text-align:center">Sign up for Wireless Access</h2>
		      <div class="col" style="float:none !important" >
                        <input type="text" name="name" placeholder="Name" required>
                        <input type="text" name="user" placeholder="Email" required>
			<input type="text" name="mobile" placeholder="Handphone" required>
			<input type="hidden" name="password" value="<?=rand(5,65535); ?>" required>
		        <input type="hidden" name=url value="<?=$data['nextUrl'] ?>">
		        <input type="hidden" name=onerror value="http://www.al-enterprise.com/">
		        <input type="submit" value="Login">
	               </div>
       		   </div>
		</form>
	</div>
</div>
</body>
</html>
