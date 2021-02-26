/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

const $ = require('jquery');
require('bootstrap');
import './js/app.js';

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
});



let intervalId = window.setInterval(function(){
    getStudentsFromDatabase();
}, 10000);

function getStudentsFromDatabase() {
    let project_id = document.getElementById('project_id').innerHTML;

    $.ajax({
        method: "GET",
        url: "/api/project/" + project_id + "/students",
        dataType: 'json',

        success: function (response) {
            // let data = response.data;
            //
            // for(item of data) {
            //     boards.push(item);
            // }

            console.log(response.data)
        },
        error: function (response) {
            console.log(response);
        }
    });
}