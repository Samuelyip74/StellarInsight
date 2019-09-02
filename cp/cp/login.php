<?php
if (!session_id()) {
    session_start();
}
require_once __DIR__ . '/google/settings.php';
require_once __DIR__ . '/vendor/autoload.php'; // change path as needed

session_start();
$fb = new Facebook\Facebook([
  'app_id' => '2407538752793450', // Replace {app-id} with your app id
  'app_secret' => '3cb091d3fd4db7ef0c57235f02c31a7a',
  'default_graph_version' => 'v3.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://extcp.ale-enterprise.com/cp/fb/fb-callback.php', $permissions);

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
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport" content="target-densitydpi=device-dpi, width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no;" />
    <script src="js/angular-bootstrap/jquery.js"></script>
    <script src="js/angular-bootstrap/angular.min.js"></script>
    <script src="js/angular-bootstrap/angular-local-storage.js"></script>
    <script src="js/angular-bootstrap/angular-translate.min.js"></script>
    <script src="js/angular-bootstrap/angular-translate-loader-static-files.min.js"></script>
    <script src="js/angular-bootstrap/underscore.js"></script>
    <script src="js/angular-bootstrap/angular-animate.min.js"></script>
    <script src="js/angular-bootstrap/bootstrap.min.js"></script>
    <script src="js/angular-bootstrap/ui-bootstrap.min.js"></script>
    <script src="js/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>

    <script src="js/user-custom/main.js"></script>
    <script src="js/user-custom/action-service.js"></script>
    <script src="js/angular-bootstrap/angularjs-social-login.js"></script>
    <script src="js/user-custom/main-constant.js"></script>
    <script src="js/user-custom/service.js"></script>
    <script src="js/user-custom/login-controller.js"></script>
    <script src="js/user-custom/portal-param.js"></script>
    <script src="js/user-custom/style.js"></script>
    

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/portal-layout.css">
    <link rel="stylesheet" type="text/css" href="css/additional.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/declaration.css">
    <link rel="stylesheet" href="css/flag-icon.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">      
    <link rel="stylesheet" type="text/css" href="css/custom.css">    
</head>
<body>
<div class="portal_layout_container vertical-center" id="welcome_layout_id" ng-cloak>
    <div class="row col-md-12 no-padding-left-right">
        <div class="portal_layout_function">
            <div class="row no-padding-left-right">
                <div id="welcome_bg" class="welcome_portal_layout_function_bg" style="background:none;background-color:white;">
                        <div class="container no-padding-left-right logo">
                                <img id="welcome_logo" src="/cp/img/logo-default.jpg" width="100%" style="cursor: pointer">
                        </div> 
                <div class="container  welcome-container-body" style="border:none;box-shadow: 0px 2px 5px 0px rgba(173,155,173,1);
                    "
                                             id="chohei">                  
                         <div class="row">
							<form class="text-center" role="form" id="nobu" name="form" method="POST" action="<?= $data['loginUrl']; ?>/">
								<div class="login-title form-group">Login to your account</div>
								<div class="form-group" ng-if="vm.loginBy == 'account'">
											<span class="input-icon icon-right" ng-class="{'has-error':form.username.$error.invalid }">
																	<input type="text" class="form-control" name="user"  placeholder="Username / Email">
																	<i class="glyphicon glyphicon-user" style="color:#ccc"></i>
										   </span>
								<div class="form-group">
											<span class="input-icon icon-right" ng-class="{'has-error':form.password.$error.invalid }">
																	<input type="password" class="form-control" name="password" placeholder="Password" id="password">
																	<i class="glyphicon glyphicon-lock" style="color:#ccc"></i>
										   </span>

                                <div class="form-group">
                                    <label>
										<input id="declara" type="checkbox" ng-model="vm.acceptItem"> <span
											id="accept">I accept the</span>
										<a href="declaration.html" id="terms">Terms of Use</a>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Login">
                                </div>
                                <div>
								<div class="form-group" ng-class="{'col-lg-6 col-md-6 col-xs-12 col-sm-12':vm.selfRegistration}" ng-if="vm.loginBy == 'account'">
                                            <div class="form-check">
										<input type="checkbox" class="form-check-input">
                                                <label class="form-check-label" for="rememberCheck" id="rememberme">Remember Me</label>
                                            </div>
                                        </div>
								        <div class="form-group" ng-class="{'col-lg-6 col-md-6 col-xs-12 col-sm-12':vm.selfRegistration}" ng-if="vm.selfRegistration">
								        	<a id="createaccount" href="register.html"> Sign up to create an account</a>
										</div>
                                </div>
										<div class="clearfix"></div>

								<div class="loginbox-or form-group">
											<div class="or-line"></div>
											<div class="or" id="splitline">or</div>
										</div>

                <div class="form-group">
									<a class="btn btn-block btn-social twitter" href="/cp/azure/ms-login.php"> <span class="fa fa-twitter fa-fw"></span>
										<span>Sign in with Office 365</span></a>

										</div>                    
								<div class="form-group">
									<a class="btn btn-danger btn-block btn-social btn-google" href="<?= 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online' ?>"> <span class="fa fa-google"></span>
										<span>Sign in with Google</span></a>

										</div>
								<div class="form-group">
									<a class="btn btn-primary btn-block btn-social btn-facebook" href="<?= htmlspecialchars($loginUrl); ?>><span class="fa fa-facebook"></span>
										<span>Sign in with Facebook</span></a>
										</div>
							</form>
						</div>
                    </div>
					      <!-- <div class="clearfix"></div> -->
                </div>
            </div>
		
        </div>
    </div>
    
</div>
</body>
</html>
