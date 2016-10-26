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
    //}

    error_reporting(E_ALL);
    require_once("../external_apis/twitter/autoload.php");
    use Abraham\TwitterOAuth\TwitterOAuth;

    define('CONSUMER_KEY',  'yq8lHiWghyhudGP2S1iWx1Pmr');
    define('CONSUMER_SECRET', 'XToqprOcfH4SllNS4UXWwIweSdyvB5xbaVf2lZrwBekMmtWYJr');
    define('OAUTH_CALLBACK', 'http://146.185.134.19/final/src/apis/twitterRedirect.php');

    if (!isset($_SESSION['access_token'])) {
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
        $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
        $_SESSION['oauth_token'] = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
        $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
        $response = array("status" => "success", "url" => $url);
        $json_response = json_encode($response);

        print_r($json_response);
    }
    else {

    }

 ?>
