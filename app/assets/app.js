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
    let students_table = document.getElementById('students-table');

    $.ajax({
        method: "GET",
        url: "/api/project/" + project_id + "/students",
        dataType: 'json',

        success: function (response) {
            students_table.children[1].innerHTML = "";

            for (let i = 0; i < response.data.length; i++ ) {

                let table_row = document.createElement("tr");
                students_table.children[1].appendChild(table_row);

                let fullName = document.createElement("td");
                fullName.innerHTML = response.data[i].fullName;
                table_row.appendChild(fullName);

                let group_title = document.createElement("td");
                group_title.innerHTML = response.data[i].group_title;
                table_row.appendChild(group_title);

                let delete_button = document.createElement("td");
                let delete_path = document.createElement("a");
                delete_path.innerHTML = 'Delete';
                delete_path.classList.add('delete_button');
                delete_path.href = response.data[i].url;
                delete_button.appendChild(delete_path);
                table_row.appendChild(delete_button);

                let group = document.getElementById('group' + response.data[i].group_id);
                group.children.innerHTML = "";
            }


            // let data = response.data;
            //
            // for(item of data) {
            //     boards.push(item);
            // }

            // console.log(response.data)
        },
        error: function (response) {
            console.log(response);
        }
    });
}