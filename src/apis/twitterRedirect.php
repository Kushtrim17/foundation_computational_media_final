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
     * NOTE : THIS CODE IS TAKEN FROM THE TWITTER API EXAMPLES
     */
	session_start();
	require_once("../external_apis/twitter/autoload.php");
    use Abraham\TwitterOAuth\TwitterOAuth;

    define('CONSUMER_KEY',  'yq8lHiWghyhudGP2S1iWx1Pmr');
    define('CONSUMER_SECRET', 'XToqprOcfH4SllNS4UXWwIweSdyvB5xbaVf2lZrwBekMmtWYJr');

	if (isset($_REQUEST['oauth_verifier']) && isset($_REQUEST['oauth_verifier']) && $_REQUEST['oauth_token'] == $_SESSION['oauth_token']) {
		$request_token['oauth_token'] = $_SESSION['oauth_token'];
		$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
		$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST["oauth_verifier"]));

		if (isset($access_token) && isset($access_token['oauth_token'])) {
			$_SESSION['twitter'] = array();
			$_SESSION['twitter']['access_token'] = $access_token;
			header('Location: http://146.185.134.19/final/public/user/physician.html');
			exit;
		}
		else {
			//something was wrong the authorization failed
			header('Location: http://146.185.134.19/final/public/');
		}
	}
	else {
		//something was wrong the authorization failed
		header('Location: http://146.185.134.19/final/public/');
	}

 ?>
