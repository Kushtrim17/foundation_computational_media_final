<?php
    /***
     *   This file is part of Final Assignment.
     *    Final Assignment. is free software: you can redistribute it and/or modify
     *    it under the terms of the GNU General Public License as published by
     *    the Free Software Foundation, either version 3 of the License, or
     *    (at your option) any later version.
     *
     *    Final Assignment is distributed in the hope that it will be useful,
     *    but WITHOUT ANY WARRANTY; without even the implied warranty of
     *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *    GNU General Public License for more details.
     *
     *    You should have received a copy of the GNU General Public License
     *    along with Final Assignment..  If not, see <http://www.gnu.org/licenses/>.
     **/
    /**
    * NOTE : THIS CODE IS TAKEN FROM THE FACEBOOK API EXAMPLES in developers.facebook.com
    */
    if (!isset($_SESSION)) {
        session_start();
    }
    error_reporting(E_ALL);
    require_once("../external_apis/fb/src/Facebook/autoload.php");

    define('APP_ID', 	'1067664810020973');
    define('APP_SECRET', '28913dc1cab682bd62dbce3f474ab828');
    define('DEFAULT_GRAPH_VERSION', 'v2.8');
    define('OAUTH_CALLBACK', 'http://146.185.134.19/src/apis/fbAPIResponse.php');

    $fb = new Facebook\Facebook(array(
      'app_id' => APP_ID,
      'app_secret' => APP_SECRET,
      'default_graph_version' => DEFAULT_GRAPH_VERSION,
    ));

    $_SESSION['fb'] = array();
    //we already have a session
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

    $_SESSION['fb']['accessToken'] = $accessToken->getValue();

    // The OAuth 2.0 client handler helps us manage access tokens
    $oAuth2Client = $fb->getOAuth2Client();

    // Get the access token metadata from /debug_token
    $tokenMetadata = $oAuth2Client->debugToken($accessToken);
    $_SESSION['fb']['tokenMetadata'] = $tokenMetadata;


    $tokenMetadata->validateAppId(APP_ID);
    // If you know the user ID this access token belongs to, you can validate it here
    $tokenMetadata->validateExpiration();

    if (! $accessToken->isLongLived()) {
      // Exchanges a short-lived access token for a long-lived one
      try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
      } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
        exit;
      }
    }

    if (isset($accessToken)) {
      $_SESSION['fb']['accessToken'] = (string) $accessToken;
      header('Location: http://146.185.134.19/final/public/user/patient.html');
    }
    else {
      header('Location: http://146.185.134.19/final/public/');
    }
    
?>
