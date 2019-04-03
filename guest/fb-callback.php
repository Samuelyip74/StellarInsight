<?php
if (!session_id()) {
    session_start();
}

require_once __DIR__ . '/vendor/autoload.php'; // change path as needed
include 'OauthUser.php';

$fb = new \Facebook\Facebook([
  'app_id' => '1386805538117846',
  'app_secret' => '98f5de3fa244f172a832691764f87e16',
  'default_graph_version' => 'v2.10',
//  'default_access_token' => '{access_token}'
]);

// Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
//   $helper = $fb->getRedirectLoginHelper();
//   $helper = $fb->getJavaScriptHelper();
//   $helper = $fb->getCanvasHelper();
//   $helper = $fb->getPageTabHelper();

//$accessToken = isset($_REQUEST['code']);

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
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


// The OA:uth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

//echo '<h3>User Data</h3>';
$profileRequest = $fb->get('/me?fields=name,first_name,last_name,email', $accessToken);
$fbUserData = $profileRequest->getGraphNode()->asArray();
//var_dump($fbUserData);

// Create an instance of OauthUser class;
$oauth_user_obj = new OauthUser();
$userData = $oauth_user_obj->verifyUser($fbUserData);
// Logged in
//
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
<input type="hidden" id="email" name="user" value="<?=$fbUserData['email']; ?>" required>
    <input type="hidden" name="password" value="<?=$fbUserData['id']; ?>" required >
    <input type="hidden" name="url" value="https://www.al-enterprise.com/" >
    <input type="hidden" class="btn"  value="Login"> 
</form>
<?php

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('{app-id}'); // Replace {app-id} with your app id
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

  echo '<h3>Long-lived</h3>';
//  var_dump($accessToken->getValue());
}

$_SESSION['fb_access_token'] = (string) $accessToken;

// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
//header('Location: https://example.com/members.php');
//
//
?>
</body>
</html>
