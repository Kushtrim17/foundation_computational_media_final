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
var Researcher = {};

Researcher.reqType = "researcher";

Researcher.patients = [];

Researcher.therapies = [];

Researcher.tests = [];

Researcher.research = [];

Researcher.isLoggedIn = function(callback) {
	//we have to contact the server
    $.ajax({ type: "POST", url: config.userURL, data: { type: Researcher.reqType, command : "session"}})
  	 .done(function(response) {
        callback($.parseJSON(response));
	});
}

Researcher.getPhysicianData = function(callback) {
	$.ajax({ type: "POST", url: config.userURL, data: { type: Researcher.reqType, command: "getData"}})
  	 .done(function(response) {
        callback($.parseJSON(response));
	});
}

Researcher.getVisualisationData = function(data, callback) {
    $.ajax({ type: "POST", url: config.userURL, data: { type: Researcher.reqType, command: "getVisualisationData", data:data}})
     .done(function(response) {
        callback($.parseJSON(response));
    });
}

Researcher.storeAnnotation = function(id, data, callback) {
    $.ajax({ type: "POST", url: config.userURL, data: { type: Researcher.reqType, command: "storeAnotation", annotation:data, test_id:id}})
     .done(function(response) {
        callback($.parseJSON(response));
    });
}

Researcher.logOut = function(callback) {
    $.ajax({ type: "POST", url: config.userURL, data: {command: "logout"}})
    .done(function(response) {
        callback($.parseJSON(response));
    });
}

Researcher.setPatients = function(patients) {
	Researcher.patients = patients;
	console.log(Researcher.patients);
}

Researcher.getPatients = function() {
	return Researcher.patients;
}

Researcher.setTherapies = function(therapies) {
    Researcher.therapies = therapies;
}

Researcher.getTherapies = function() {
    return Researcher.therapies;
}

Researcher.setTests = function(tests)
{
    Researcher.tests = tests;
}

Researcher.getTests = function()
{
    return Researcher.tests;
}

Researcher.setResearch = function(research)
{
    Researcher.research = research;
}

Researcher.getResearch = function()
{
    return Researcher.research;
}
