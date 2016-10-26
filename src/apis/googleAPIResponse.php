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
     * NOTE : THIS CODE IS TAKEN FROM THE GOOGLE API EXAMPLES
     */
    session_start();
	require_once("../external_apis/google-api-php-client-2.0.3/vendor/autoload.php");

    $client = new Google_Client();
	$client->setAuthConfig('../external_apis/google-api-php-client-2.0.3/client_secret.json');
	$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
	$client->setRedirectUri('http://146.185.134.19.chickenkiller.com/final/src/apis/googleAPIResponse.php');

	$client->authenticate($_GET['code']);

	$access_token = $client->getAccessToken();
    $_SESSION['researcher'] = 1;
	if (isset($access_token) && count($access_token) > 0) {
		$_SESSION['google'] = array();
		$_SESSION['google']['access_token'] = $access_token;
		//error_log(json_encode($_SESSION));
		header('Location: http://146.185.134.19/final/public/user/researcher.html');
        exit();
	}
	else {
		header('Location: http://146.185.134.19/final/public/');
		exit();
	}

?>
