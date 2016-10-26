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

    class ResearchRSS
    {
        const RSS_URL = "http://www.news-medical.net/tag/feed/Parkinsons-Disease.aspx";

        private $XML;

        public function __construct()
        {

        }

        public function getResearchFeed()
		{
			$url = self::RSS_URL;
            //error_log(json_encode($url));
			$this->XML = file_get_contents($url);
			return $this->convertXMLDataToArray();
		}

        private function convertXMLDataToArray()
        {
            $research_array = array();
            $research_array['items'] = array();
			$obj = new SimpleXMLElement($this->XML);
            $research_array['title'] = (string)$obj->channel->title;

            foreach ($obj->channel->item as $item) {
                $item_array['title'] = (string)$item->title;
                $item_array['description'] = (string)$item->description;
                $item_array['pubDate'] = (string)$item->pubDate;
                array_push($research_array['items'], $item_array);
            }

            return $research_array;
        }
    }
?>
