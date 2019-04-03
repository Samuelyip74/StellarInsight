<?php

// Facebook SDK
require_once __DIR__ . '/vendor/autoload.php'; // change path as needed
$fb = new \Facebook\Facebook([
  'app_id' => '{app-id}',
  'app_secret' => '{app-secret}',
  'default_graph_version' => 'v2.10',
  //'default_access_token' => '{access-token}', // optional
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://example.com/fb-callback.php', $permissions);


// What is the request state?
	//$isLoginRequest = isset($_REQUEST['loginurl']);
	$isLoginRequest = isset($_REQUEST['switchip']);
	$isLoginError = isset($_REQUEST['error_message']);
	$isLoggedIn = isset($_COOKIE['LogoutURL']);

	// Lets get the values from the query parameters
	$data = array();

	// Location of the splash
	$data['rootUrl'] = "http://" . $_SERVER['SERVER_NAME'];

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Splash Page Test</title>

	<script type="text/javascript" src="assets/jquery-2.1.0.min.js"></script>
	<link rel="stylesheet" href="assets/bootstrap.min.css">
	<link rel="stylesheet" href="assets/style.css">
</head>
<body>
   <div class="container">
	<div class="wrapper">
		<div class="container">
		<form class="form-signin" role="form" method="POST" action="<?= $data['loginUrl']; ?>/">
			<?php if ($isLoginRequest) { ?>
				<h2 class="form-signin-heading">Please Login </h2>
				<h4><?= $data['ap']['name']; ?></h4>

				<?php if ($isLoginError) { ?>
					<div class="alert alert-danger"><?= $data['errorMessage'] ?></div>
				<?php } ?>

				<input type="text" name="user" class="form-control" placeholder="Username" required autofocus value="<?= $_REQUEST['username'] ?>">
				<input type="password" name="password" class="form-control" placeholder="Password" required>
				<input type="hidden" name=url value="<?=$data['nextUrl'] ?>">
				<input type="hidden" name=onerror value="http://www.al-enterprise.com/">
				<label class="checkbox">
				        <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Remember me
			        </label>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

				<br/>

			<?php } else  if ($isLoggedIn) { ?>
				<div class="alert alert-info">Already logged in? <a href="/logout.php">Logout</a></div>
			<?php } else { ?>
				<div class="alert alert-danger">Hmmm... not sure what you're doing here...</div>
			<?php } ?>
		</form>
		<form action="<?=$loginUrl; ?>">
                        <input class="btn btn-lg btn-primary btn-block" type="submit" value="Login with Facebook" />
		</form>
		</div>


		<script>
			function setUser(username, password) {
				$('input[name=user]').val(username);
				$('input[name=password]').val(password);
			}
		</script>
		<pre id='debug' style="display: none"><?php var_dump($data); ?></pre>
	</div>
 </div>
</body>
</html>
