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
var Physician = {};

Physician.reqType = "physician";

Physician.patients = [];

Physician.therapies = [];

Physician.tests = [];

Physician.isLoggedIn = function(callback) {
	//we have to contact the server
    $.ajax({ type: "POST", url: config.userURL, data: { type: Physician.reqType, command : "session"}})
  	 .done(function(response) {
        callback($.parseJSON(response));
	});
}

Physician.getPhysicianData  = function(callback) {
	$.ajax({ type: "POST", url: config.userURL, data: { type: Physician.reqType, command: "getData"}})
  	 .done(function(response) {
        callback($.parseJSON(response));
	});
}

Physician.getVisualisationData = function(data, callback) {
    $.ajax({ type: "POST", url: config.userURL, data: { type: Physician.reqType, command: "getVisualisationData", data:data}})
     .done(function(response) {
        callback($.parseJSON(response));
    });
}

Physician.storeAnnotation = function(id, data, callback) {
    $.ajax({ type: "POST", url: config.userURL, data: { type: Physician.reqType, command: "storeAnotation", annotation:data, test_id:id}})
     .done(function(response) {
        callback($.parseJSON(response));
    });
}

Physician.logOut = function(callback) {
    $.ajax({ type: "POST", url: config.userURL, data: {command: "logout"}})
    .done(function(response) {
        callback($.parseJSON(response));
    });
}

Physician.setPatients = function(patients) {
	Physician.patients = patients;
	console.log(Physician.patients);
}

Physician.getPatients = function() {
	return Physician.patients;
}

Physician.setTherapies = function(therapies) {
    Physician.therapies = therapies;
}

Physician.getTherapies = function() {
    return Physician.therapies;
}

Physician.setTests = function(tests)
{
    Physician.tests = tests;
}

Physician.getTests = function()
{
    return Physician.tests;
}
