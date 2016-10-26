/**
*   This file is part of Final Assignment.

    Final Assignment. is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Final Assignment is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Final Assignment..  If not, see <http://www.gnu.org/licenses/>.
*/
var FB = {};

FB.reqType = "fb";

/*
* login
* the configurations can be found under public/scripts/configs.js
*/
FB.login = function(cb) {
    //we have to contact the server
    $.ajax({ type: "POST", url: config.fbServerURL, data: { type: FB.reqType}})
  	 .done(function(response) {
        cb($.parseJSON(response));
	 });
}
