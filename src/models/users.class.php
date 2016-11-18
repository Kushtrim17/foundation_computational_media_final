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

	require_once("organization.class.php");
	require_once("role.class.php");

	class User
	{
		const DB_URL = "http://4me302-16.site88.net/getData.php?";

		const TBL_USER = "table=User";

		const USER_PATIENT = "&id=3";

		const USER_PHYSICAN = "&id=1";

		const USER_ALL = "";

        const USER_WITH_ID = "&id=";

		private $requestUrl;

		private $XML;

		public function __construct()
		{

		}

		public function getUsers($userType = self::USER_ALL)
		{
			//echo debug_backtrace()[1]['function'];
			$this->requestUrl = self::DB_URL . self::TBL_USER . $userType;
			$this->getDbData();
			return $this->convertXMLDataToArray();
		}


		private function getDbData()
		{
			$this->XML = file_get_contents($this->requestUrl);
		}

		private function convertXMLDataToArray()
		{
			$users_array = array();
			$obj = new SimpleXMLElement($this->XML);
			foreach ($obj->userID as $user) {
				//we add only the users
				if ((string)$user['id'] == '3' || (string)$user['id'] == '4') {
					$user_array['id'] = (string)$user['id'];
					$user_array['username'] = (string)$user->username;
					$user_array['email'] = (string)$user->email;
					$user_array['lat'] = (string)$user->Lat;
					$user_array['long'] = (string)$user->Long;

					$user_array['Role_IDrole'] = 'patient';
					$user_array['Organization'] = 'organization';

					array_push($users_array, $user_array);
				}
			}

			return $users_array;
		}

	}
?>
