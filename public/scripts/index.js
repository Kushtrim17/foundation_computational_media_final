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

}

//on button click
function loginWithTwitter() {
    var response = Twitter.sayHello('Kushtrim', function(response) {
        console.log('this is the response');
        console.log(response);
        console.log('this is the end of the response');
        if (response.status == 'success') {
            //we have to redirect so that we can grant access to our twitter app
            window.location.replace(response.url);
        }
        console.log(response);
    });
}

//on button click
function loginWithFacebook() {
    var response = FB.login(function(response) {

        if (response.status == 'success') {
            //we have to redirect so that we can grant access to our twitter app
            window.location.replace(response.url);
        }
        console.log(response);

    });
}

//on button click
function loginWithGoogle() {
    var response = Google.login(function(response) {
        if (response.status == 'success') {
            //we have to redirect so that we can grant access to our twitter app
            window.location.replace(response.url);
        }
        console.log(response);
    });
}
