<?php

    error_reporting(E_ALL);
    require_once("apis/twitterAPI.php");
    require_once("external_apis/twitter/autoload.php");
    require_once("external_apis/fb/src/Facebook/autoload.php");

    use Abraham\TwitterOAuth\TwitterOAuth;

    define('CONSUMER_KEY', 	'OF2oH4lGOtL9HHgUWDImo8FBS');
    define('CONSUMER_SECRET', '	tSLzCbKQMRPbQkR83hsBrEq3ujboc4qHtkOhpUPsaDEh7zX2XJ');
    define('OAUTH_CALLBACK', 'http://kushtrim.comyr.com/src/controller.php?type=twitter&callback=1');


    if ($_REQUEST['type'] == 'twitter') {
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
        $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));

        $json_response = json_encode($requeset_token);
        print_r($json_response);
    }
    else {
        echo 'wrong request';
    }

 ?>
