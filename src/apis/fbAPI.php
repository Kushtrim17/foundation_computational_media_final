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
    define('OAUTH_CALLBACK', 'http://146.185.134.19/final/src/apis/fbAPIResponse.php');

    $fb = new Facebook\Facebook(array(
      'app_id' => APP_ID,
      'app_secret' => APP_SECRET,
      'default_graph_version' => DEFAULT_GRAPH_VERSION,
    ));

    $helper = $fb->getRedirectLoginHelper();
    $permissions = array('email');
    $loginUrl = $helper->getLoginUrl(OAUTH_CALLBACK, $permissions);

    $response = array("status" => "success", "url" => $loginUrl);
    $json_response = json_encode($response);

    print_r($json_response);
?>
