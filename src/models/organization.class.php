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

	class Organization
	{
		const DB_URL = "http://4me302-16.site88.net/getData.php?";

		const TBL_ORGANIZATION = "table=Organization";

		const ORG_ID = "&id=";

		private $XML;

		public function __construct()
		{

		}

		public function getOraganizationNameWithId($orgID)
		{
			$url = self::DB_URL . self::TBL_ORGANIZATION . self::ORG_ID . $orgID;
			$this->XML = file_get_contents($url);
			return $this->convertXMLDataToArray();
		}


		private function convertXMLDataToArray()
		{
			$obj = new SimpleXMLElement($this->XML);

			return (string) $obj->OrganizationID->name;
		}

	}
?>
