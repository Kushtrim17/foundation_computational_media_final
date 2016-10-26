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

	class Therapy
	{
		const DB_URL = "http://4me302-16.site88.net/getData.php?";

		const TBL_THERAPY = "table=Therapy";

        const TBL_THERAPY_LIST = "table=Therapy_List";

        const TBL_MEDICINE = "table=Medicine";

		const ID = "&id=";

		private $XML;

		public function __construct()
		{

		}

        public function getTherapies()
        {
            $url = self::DB_URL . self::TBL_THERAPY;
            $this->XML = file_get_contents($url);
			return $this->convertTherapyXMLDataToArray();
        }

        public function getTherapyWithID($therapyID)
        {
            $therapies = $this->getTherapies();
            foreach ($therapies as $therapy) {
                if ($therapy['id'] == $therapyID) {
                    return $therapy;
                }
            }

            return array();
        }

		private function convertTherapyXMLDataToArray()
		{
			$therapies_array = array();
			$obj = new SimpleXMLElement($this->XML);
            foreach ($obj->therapyID as $therapy) {
                $therapy_array['id'] = (string)$therapy['id'];
                $user_id = (string)$therapy->User_IDpatient;
                $user = new User();
                $therapy_array['user_id'] = $user_id;
                $therapy_array['user'] = $user->getUsers(user::USER_WITH_ID.$user_id)[0]['username'];
                $therapy_id = (string)$therapy->TherapyList_IDtherapylist;
                $therapyDetails = $this->getTherapyLists($therapy_id);
                $therapy_array['therapy_name'] = $therapyDetails['name'];
                $therapy_array['therapy_dosage'] = $therapyDetails['dosage'];
                $therapy_array['therapy_medicine'] = $therapyDetails['medicine'];
                //error_log(json_encode($therapy_array));
                array_push($therapies_array, $therapy_array);
            }

            return $therapies_array;
		}

        public function getTherapyLists($therapyListID = "")
        {
            $url = self::DB_URL . self::TBL_THERAPY_LIST;
            if (strlen($therapyListID) > 0) {
                //we have an id specified so we must append it to the URL
                $id_string = self::ID . $therapyListID;
                $url .= $id_string;
            }

            $therapyListXML = file_get_contents($url);
            $therapyListsArray = $this->convertTherapyListsXMLDataToArray($therapyListXML);

            //if it is specified a therapy ID we only have to return that therapy list as object which is always at index 0 since its one element
            //else we should return an array with all the therapy lists
            return (strlen($therapyListID) > 0) ? $therapyListsArray[0] : $therapyListsArray;
        }

        private function convertTherapyListsXMLDataToArray($xml)
        {
            $therapy_lists = array();
            $obj = new SimpleXMLElement($xml);

            foreach ($obj->therapy_listID as $therapyList) {
                $therapy_list['name'] = (string)$therapyList->name;
                $therapy_list['dosage'] = (string)$therapyList->Dosage;
                //we have to get the medicine name since we have the id
                $medicine_id = (string)$therapyList->Medicine_IDmedicine;
                $medicine = new Medicine();
                $therapy_list['medicine'] = $medicine->getMedicineNameWithID($medicine_id);

                array_push($therapy_lists, $therapy_list);
            }

            return $therapy_lists;
        }

	}
?>
