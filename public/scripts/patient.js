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

function init() {
	var response = Patient.isLoggedIn(function(response) {
		if (response.status == 'success') {
			//the patient is correctly authenticated using facebook
			console.log('successss');
			Patient.getPatientData(function(response) {
				alert('we got the response here ..');
				console.log(response);
                Patient.setVideoLinks(response.links);
                Patient.setStatistics(response.statistics);
                //displayPatientVideoExercises();
                getData('exercises');
			})

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
	    case 'exercises':
	    	$('#statistics').removeClass('active');
	    	$("#exercises").addClass('active');
	    	displayPatientVideoExercises();
	        break;
	    default:
	    	$('#exercises').removeClass('active');
	    	$("#statistics").addClass('active');
	    	//get patient data
	        displayStatistics();
	}
}


function displayPatientVideoExercises() {

	var videoLinks = Patient.getVideoLinks();
	var html = "";

    $.each(videoLinks, function(key, videoLink) {
           html += '<div class="col-md-12 col-sm-12"><iframe width="100%" height="500"' +
                        'src='+"'"+videoLink+"'"+'>'+
                    '</iframe></div>';
	});

    //append the table to the page
	$('#data_div').html(html);
}

function displayStatistics() {
	console.log(Patient.getStatistics());
}
