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
	class Note
	{
        const DB_URL = "http://4me302-16.site88.net/getData.php?";

		const TBL_TEST = "table=Note";

        const ID = "&id=";

        private $requestUrl;

        public function __construct()
        {

        }

        public function getNoteForTestSession($sessionID)
        {
            $this->requestUrl = self::DB_URL . self::TBL_TEST;
			$this->getDbData();
			return $this->convertXMLDataToArray($sessionID);
        }

        private function getDbData()
		{
			$this->XML = file_get_contents($this->requestUrl);
		}

        private function convertXMLDataToArray($sessionID)
        {
			$obj = new SimpleXMLElement($this->XML);
			foreach ($obj->noteID as $note) {
                $test_session_id = intval((string)$note->Test_Session_IDtest_session);
                if ($test_session_id == intval($sessionID)) {
                    return (string)$note->note;
                }
            }
        }
    }

?>
