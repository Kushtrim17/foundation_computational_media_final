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
 	if (!isset($_SESSION)) {
         session_start();
     }

     require_once("../models/users.class.php");
     require_once("../models/therapy.class.php");
     require_once("../models/test.class.php");
     require_once("../models/researchRSS.php");

     //session_unset();
     error_reporting(E_ALL);

     if (isset($_REQUEST['type'])) {
         if ($_REQUEST['type'] == 'patient') {
         	//PATIENT REQUESTS
         	if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'session') {
         		if (isset($_SESSION['fb']) && isset($_SESSION['fb']['accessToken'])) {
     	    		//we have patient authenticated through facebook
     	    		$response_array = array("status"=>"success");
     	    	}
     	    	else {
     	    		$response_array = array("status"=>"fail");
     	    	}

     	    	$json_encode = json_encode($response_array);
     			print_r($json_encode);
         	}
         	else if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'getData') {
         		//we have a command TO GET THE DATA i.e. the exercise videos .. we send the links so that the client can display them
                  $array_of_youtube_videos = array("https://www.youtube.com/embed/7CFLm1SL5EU",
                     "https://www.youtube.com/embed/B1TIdGG4mE0",
                     "https://www.youtube.com/embed/YEiupqJDugA");

                  //get tests
                 $tests = new Test();
                 $response_array['statistics'] = json_encode($tests->getTests());
                 $response_array['links'] = $array_of_youtube_videos;
         		//header('X-Frame-Options: GOFORIT');
                 $json_encode = json_encode($response_array);
     			print_r($json_encode);
         	}
         }
         else if ($_REQUEST['type'] == 'physician') {
         	//PHYSICAN REQUESTS
             $response_array = array();

         	if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'session') {
         		if (isset($_SESSION['twitter']) && isset($_SESSION['twitter']['access_token'])) {
     			//we have patient authenticated through twitter
     	    		$response_array["status"] = "success";
     	    	}
     	    	else {
     	    		$response_array = array("status"=>"fail");
     	    	}

     	    	$json_encode = json_encode($response_array);
     			print_r($json_encode);
         	}
         	else if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'getData') {
         		//we have a command
                 try {
                     //get all patients
                     $user = new User();
                     $all_patients_array = $user->getUsers($user::USER_PATIENT);
                     $response_array["patients"] = $all_patients_array;

                     //get therapies
                     $therapy = new Therapy();
                     $response_array["therapies"] = $therapy->getTherapies();

                     //get tests
                     $tests = new Test();
                     $response_array['tests'] = $tests->getTests();

                     $json = (array)json_decode(file_get_contents("annotation.json"), 1);
                     foreach($response_array['tests'] as $key=>$test) {
                         if (isset($json[$test['id']])) {
                             $response_array['tests'][$key]['data'] = $json[$test['id']]["annotation"];
                         }
                     }

                 } catch (Exception $e) {
                     error_log($e);
                 }

         		$json_encode = json_encode($response_array);
     			print_r($json_encode);
         	}
             else if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'getVisualisationData') {

                 $csvData = file_get_contents('http://4me302-16.site88.net/'.$_REQUEST['data'].'.csv');
                 $csvData = str_replace("\r\n", "\n", $csvData);
                 $csvData = str_replace("\r", "\n", $csvData);
                 $csvData = preg_replace("/\n{2,}/", "\n", $csvData);

                 $tmpArray = explode(PHP_EOL, $csvData);

                 $cvsArray = array();

                 foreach ($tmpArray as $value) {
                     $tmp_array = explode(',', $value);
                     //we only need the X and the Y coordinates
                     $new_array = array($tmp_array[0],$tmp_array[1]);
                     array_push($cvsArray, $new_array);
                 }

                 $json_visualisation_data = json_encode($cvsArray);
                 print_r($json_visualisation_data);

             }
         }
         else if ($_REQUEST['type'] == 'researcher') {
         	//RESEARCHER REQUESTS
         	if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'session') {
         		//if (isset($_SESSION['google']) && isset($_SESSION['google']['access_token'])) {
                 if (isset($_SESSION['researcher'])) {
     			//we have patient authenticated through facebook
     	    		$response_array = array("status"=>"success");
     	    	}
     	    	else {
     	    		$response_array = array("status"=>"fail", "session" => $_SESSION);
     	    	}

     	    	$json_encode = json_encode($response_array);
     			print_r($json_encode);
         	}
         	else if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'getData') {
                 $response_array = array();
                 try {
                     //get research feed
                     $research = new ResearchRSS();
                     $response_array['researchRSS'] = $research->getResearchFeed();
                     //get all patients
                     $user = new User();
                     $all_patients_array= $user->getUsers($user::USER_ALL);
                     $response_array["patients"] = $all_patients_array;

                     //get therapies
                     $therapy = new Therapy();
                     $response_array["therapies"] = $therapy->getTherapies();

                     //get tests
                     $tests = new Test();
                     $response_array['tests'] = $tests->getTests();
                     //we add our annotations here
                     $json = (array)json_decode(file_get_contents("annotation.json"), 1);
                     foreach($response_array['tests'] as $key=>$test) {
                         if (isset($json[$test['id']])) {
                             $response_array['tests'][$key]['data'] = $json[$test['id']]["annotation"];
                         }
                     }
                 } catch (Exception $e) {
                     error_log($e);
                 }
         		//we have a command
         		$json_encode = json_encode($response_array);
     			print_r($json_encode);
         	}
             else if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'getVisualisationData') {

                 $csvData = file_get_contents('http://4me302-16.site88.net/'.$_REQUEST['data'].'.csv');
                 $csvData = str_replace("\r\n", "\n", $csvData);
                 $csvData = str_replace("\r", "\n", $csvData);
                 $csvData = preg_replace("/\n{2,}/", "\n", $csvData);

                 $tmpArray = explode(PHP_EOL, $csvData);

                 $cvsArray = array();

                 foreach ($tmpArray as $value) {
                     $tmp_array = explode(',', $value);
                     //we only need the X and the Y coordinates
                     $new_array = array($tmp_array[0],$tmp_array[1]);
                     array_push($cvsArray, $new_array);
                 }

                 $json_visualisation_data = json_encode($cvsArray);
                 print_r($json_visualisation_data);

             }
             else if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'storeAnotation') {
                 //$old = json_decode(file_get_contents('annotation.json'));
                 $file = "annotation.json";
                 $json = (array)json_decode(file_get_contents($file));
                 $json[$_REQUEST['test_id']] = array("annotation" => $_REQUEST['annotation']);
                 file_put_contents($file, json_encode($json));

                 //print_r(file_get_contents($file));
                 //get therapies
                 $therapy = new Therapy();
                 $response_array["therapies"] = $therapy->getTherapies();

                 //get tests
                 $tests = new Test();
                 $response_array['tests'] = $tests->getTests();
                 //we add our annotations here
                 $json = (array)json_decode(file_get_contents("annotation.json"), 1);
                 foreach($response_array['tests'] as $key=>$test) {
                     if (isset($json[$test['id']])) {
                         $response_array['tests'][$key]['data'] = $json[$test['id']]["annotation"];
                     }
                 }

                 print_r(json_encode($response_array));
             }
         }
     }
     else {
         if ($_REQUEST['command'] == 'logout') {
             ///we clear the session i.e. logout and then we redirect to our starting page
             session_unset();
             $response_array = array("statuss" => "success"); //logged out successfully
             $json_array = json_encode($response_array);
             print_r($json_array);
         }
         else {
             $response_array = array("statuss" => "fail");
             $json_encode = json_encode($_GET);

             print_r($json_encode);
         }
     }
 ?>
