<?php
if (!session_id()) {
    session_start();
}

require_once __DIR__ . '/google/settings.php';

// Facebook SDK
require_once __DIR__ . '/vendor/autoload.php'; // change path as needed
$fb = new \Facebook\Facebook([
  'app_id' => '1386805538117846',
  'app_secret' => '98f5de3fa244f172a832691764f87e16',
  'default_graph_version' => 'v2.10',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$FBloginUrl = $helper->getLoginUrl('https://extcp.al-enterprise.sg/guest/fb-callback.php', $permissions);


	// What is the request state?
        //$isLoginRequest = isset($_REQUEST['loginurl']);
        $isLoginRequest = isset($_GET['switchip']);
        $isLoginError = isset($_GET['error_message']);
        $isLoggedIn = isset($_COOKIE['LogoutURL']);

        // Lets get the values from the query parameters
        $data = array();

        // Location of the splash
        $data['rootUrl'] = "https://" . $_SERVER['SERVER_NAME'];

        if ($isLoginRequest) {
                // URLs
                $data['loginUrl'] = "https://cportal.al-enterprise.com/login";
                $data['nextUrl'] = urldecode($_GET['url']);

                // Access Point Info
                $data['ap']['mac'] = $_GET['switchmac'];
                $data['ap']['ip'] = $_GET['switchip'];
                $data['ap']['ssid'] =  $_GET['ssid'];

                // Client Info
                $data['client']['mac'] = $_GET['clientmac'];
                $data['client']['ip'] = $_GET['clientip'];
	}

	if ($isLoginError) {
                // Error Message
                $data['errorMessage'] = $_REQUEST['error_message'];
        }

        if ($isLoggedIn) {
                // Get the logout URL from the cookie
                $data['logoutUrl'] = urldecode($_COOKIE['LogoutURL']);
        }
?>


<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name"apple-mobile-web-app=capable" content="no" />

        <title>Free WiFI Hotspot</title>

        <script type="text/javascript" src="assets/jquery-2.1.0.min.js"></script>
        <link rel="stylesheet" href="assets/bootstrap.min.css">
        <link rel="stylesheet" href="assets/style2.css">
</head>
<body>
<div class="container">
<div class="container">
<form method="POST" action="<?= $data['loginUrl']; ?>/">
    <div class="row">
      <h2 style="text-align:center">Free WiFi Hotspot</h2>
      <div class="vl">
        <span class="vl-innertext">or</span>
      </div>

      <div class="col">
<!--      <a href="<?//=$FBloginUrl; ?>" class="fb btn"> -->
	<a href="/cp/fb/fb-callback.php" class="fb btn">
          <i class="fa fa-facebook fa-fw"></i> Login with Facebook
        </a>
        <a href="/guest/azure/ms-login.php" class="twitter btn">
          <i class="fa fa-twitter fa-fw"></i> Login with Office365
        </a>
        <a href="<?= 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online' ?>" class="google btn">
          <i class="fa fa-google fa-fw"></i> Login with Google+
	</a>
        <a href="/guest/wechat/wechat.html" class="btn btn-success">
          <i class="fa fa-twitter fa-fw"></i> Login with WeChat
	</a>

      </div>

      <div class="col">
        <div class="hide-md-lg"> 
          <p>Or sign in manually:</p>
         </div> 

        <input type="text" name="user" placeholder="Username" required>
	<input type="password" name="password" placeholder="Password" required>
	<input type="hidden" name=url value="<?=$data['nextUrl'] ?>">
        <input type="hidden" name=onerror value="http://www.al-enterprise.com/">
        <input type="submit" value="Login">
      </div>

    </div>
  </form>
</div>

<div class="bottom-container">
  <div class="row">
    <div class="col">
      <a href="signup.php" style="color:white" class="btn">Sign up</a>
    </div>
    <div class="col">
      <a href="#" style="color:white" class="btn">Forgot password?</a>
    </div>
  </div>
</div>
</div>
</body>
</html>
