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
	class Medicine
	{
		const DB_URL = "http://4me302-16.site88.net/getData.php?";

		const TBL_MEDICINE = "table=Medicine";

		const MEDICINE_ID = "&id=";

		private $XML;

		public function __construct()
		{

		}

		public function getMedicineNameWithID($medicineID)
		{
			$url = self::DB_URL . self::TBL_MEDICINE . self::MEDICINE_ID . $medicineID;
            //error_log(json_encode($url));
			$this->XML = file_get_contents($url);
			return $this->convertXMLDataToArray();
		}


		private function convertXMLDataToArray()
		{
			//$users_array = array();
			$obj = new SimpleXMLElement($this->XML);
			//((error_log(json_encode($obj->medicineID->name));

			return (string) $obj->medicineID->name;
		}

	}
?>
