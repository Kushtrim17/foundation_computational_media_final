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

    require_once("medicine.class.php");
    require_once("note.class.php");

	class Test
	{
		const DB_URL = "http://4me302-16.site88.net/getData.php?";

		const TBL_TEST = "table=Test";

        const TBL_TEST_SESSION = "table=Test_Session";

        const ID = "&id=";

        private $requestUrl;

		private $XML;

		public function __construct()
		{

		}

        public function getTests()
        {
            $this->requestUrl = self::DB_URL . self::TBL_TEST_SESSION;
			$this->getDbData();
			return $this->convertXMLDataToArray();
        }

        private function getDbData()
		{
			$this->XML = file_get_contents($this->requestUrl);
		}

        private function convertXMLDataToArray()
		{
			$tests_array = array();
			$obj = new SimpleXMLElement($this->XML);
			//error_log(json_encode($obj));
			foreach ($obj->test_SessionID as $testSession) {
                $test_session['id'] = (string)$testSession['id'];
                $test_id = (string)$testSession->Test_IDtest;
                $test_data = $this->getTest($test_id);
                //get the note for this test and user id
                $note = new Note();
                $test_session['note'] = $note->getNoteForTestSession($test_session['id']);
                $test_session['user'] = $test_data['user'];
                $test_session['date'] = $test_data['date'];
                $test_session['therapy_name'] = $test_data['therapy_name'];
                $test_session['therapy_dosage'] = $test_data['therapy_dosage'];
                $test_session['therapy_medicine'] = $test_data['therapy_medicine'];
                $test_session['data'] = (string)$testSession->DataURL;

                array_push($tests_array, $test_session);
            }

            return $tests_array;
        }

        public function getTest($testID = "")
        {
            $url = self::DB_URL . self::TBL_TEST;

            if (strlen($testID) > 0) {
                //we have an id specified
                $id_string = self::ID . $testID;
                $url .= $id_string;
            }

            $testXML = file_get_contents($url);
            $testArray = $this->convertTherapyListsXMLDataToArray($testXML);

            return $testArray;
        }

        private function convertTherapyListsXMLDataToArray($testXML)
        {
            $test_array = array();
            $obj = new SimpleXMLElement($testXML);

            foreach ($obj->testID as $test) {
                $test_array['date'] = (string)$test->dateTime;
                //we have to get the therapy details
                $therapyID = $test->Therapy_IDtherapy;
                $therapy = new Therapy();
                $therapy_data = $therapy->getTherapyWithID($therapyID);
                $test_array['user_id'] = $therapy_data['user_id'];
                $test_array['user'] = $therapy_data['user'];
                $test_array['therapy_name'] = $therapy_data['therapy_name'];
                $test_array['therapy_dosage'] = $therapy_data['therapy_dosage'];
                $test_array['therapy_medicine'] = $therapy_data['therapy_medicine'];
            }

            return $test_array;
        }
    }


?>
