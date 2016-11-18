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
$().ready( function(){
    //runs on page load
    init();
});

var selectedTab = "";

function init() {
	Physician.isLoggedIn(function(response) {
		if (response.status == 'success') {
			//the patient is correctly authenticated using facebook
			Physician.getPhysicianData(function(data) {
                //console.log(data);
				Physician.setPatients(data.patients);
                Physician.setTherapies(data.therapies);
                Physician.setTests(data.tests);
				getData('patients');
			});
		}
		else {
			//we have to redirect
			window.location.replace("http://146.185.134.19/public/");
		}

	});
}

//called upon initiation and when a tab is clicked
function getData(type) {
	//reset the data div to empty
	$('#data_div').html("");
	//check what type of data we want to show
	switch(type) {
	    case 'sessions':
            $('#patients').removeClass('active');
	    	$('#therapies').removeClass('active');
	    	$("#sessions").addClass('active');
	    	displayAllSessions();
	        break;
	    case 'therapies':
	        $('#sessions').removeClass('active');
	    	$('#patients').removeClass('active');
	    	$("#therapies").addClass('active');
	    	displayAllTherapies();
	        break;
	    default:
	    	$('#sessions').removeClass('active');
	    	$('#therapies').removeClass('active');
	    	$("#patients").addClass('active');
	    	//get patient data
	        displayAllPatients();
	}
}

function displayAllPatients() {

	var patients = Physician.getPatients();

	//create the HTML string
	var html =
	"<table class='table table-striped'>" +
        "<thead>" +
          "<tr>" +
            "<th>ID</th>" +
            "<th>Organization</th>" +
            "<th>Username</th>" +
            "<th>Role</th>" +
            "<th>Email</th>" +
          "</tr>" +
        "</thead>" +
        "<tbody>";

    $.each(patients, function(key, patient) {
		html +=
			"<tr>" +
				"<td>" + patient.id + "</td>" +
				"<td>" + patient.Organization + "</td>" +
				"<td>" + patient.username + "</td>" +
				"<td>" + patient.Role_IDrole + "</td>" +
				"<td>" + patient.email + "</td>";
	});
	//append the remaining part of the table
    html += "</tbody></table>";
    //append the table to the page
	$('#data_div').html(html);
}

function displayAllTherapies() {

    var therapies = Physician.getTherapies();
    var html =
        "<table class='table table-striped'>" +
        "<thead>" +
          "<tr>" +
            "<th>ID</th>" +
            "<th>Therapy Name</th>" +
            "<th>Therapy Medicine</th>" +
            "<th>Medicine Dosage</th>" +
            "<th>User</th>" +
          "</tr>" +
        "</thead>" +
        "<tbody>";

     $.each(therapies, function(key, therapy) {
		html +=
			"<tr>" +
				"<td>" + therapy.id + "</td>" +
				"<td>" + therapy.therapy_name + "</td>" +
				"<td>" + therapy.therapy_medicine + "</td>" +
				"<td>" + therapy.therapy_dosage + "</td>" +
				"<td>" + therapy.user + "</td>";
	});
	//append the remaining part of the table
    html += "</tbody></table>";

    $('#data_div').html(html);
}

function displayAllSessions() {
    var tests = Physician.getTests();
    var html =
        "<table class='table table-striped'>" +
        "<thead>" +
          "<tr>" +
            "<th>Test ID</th>" +
            "<th>Test Note</th>" +
            "<th>User</th>" +
            "<th>Therapy Name</th>" +
            "<th>Therapy Medicine</th>" +
            "<th>Medicine Dosage</th>" +
            "<th>Note</th>" +
            "<th>Add Note</th>" +
          "</tr>" +
        "</thead>" +
        "<tbody>";

     $.each(tests, function(key, test) {
     	var onclick = 'visualizeTest("'+test.data+'")';
     	var annotation = 'setClickedTest("' +test.id+'")';
		html +=
			"<tr>" +
				'<td><button onClick='+onclick+'>' + test.id + '</button></td>' +
                "<td>" + test.note + "</td>" +
                "<td>" + test.user + "</td>" +
				"<td>" + test.therapy_name + "</td>" +
				"<td>" + test.therapy_medicine + "</td>" +
				"<td>" + test.therapy_dosage + "</td>" +
				"<td>" + test.data + "</td>" +
				'<td><button type="button" class="btn btn-info" onClick='+annotation+'>Add Annotation</button></td>';
	});
	//append the remaining part of the table
    html += "</tr></tbody></table>";

    $('#data_div').html(html);;
}

function visualizeTest(dataToVisualize) {
	//empty out the html then make the api call to get the data
	//then use the google api to present the data
	Physician.getVisualisationData(dataToVisualize, function(data) {
		//the data has the int values in string so we convert them in int
		for (var i = 0; i < data.length; i ++) {
			for (var j = 0; j < data[i].length; j++) {
				if ($.isNumeric(data[i][j])) {
					data[i][j] = parseFloat(data[i][j]);
				}
			}
		}
		googleVisualisation(data);
	});
}

function googleVisualisation(myData) {
	// Load the Visualization API and the corechart package.
	google.charts.load('current', {'packages':['corechart']});
     google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(myData);

        var options = {
          title: 'Data visualiztion',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.ScatterChart(document.getElementById('data_div'));

        chart.draw(data, options);
      }
}

function setClickedTest(test_id) {
	$('#myModal').modal('toggle');
	//we need to know which test was selected that we want to set annotations
	SELECTED_TEST = test_id;
}

function storeAnotation()
{
	var text = $('#annotation_text').val();
	Physician.storeAnnotation(SELECTED_TEST, text, function(response) {
		Physician.setTests(response.tests);
		displayAllSessions();
	});
}
