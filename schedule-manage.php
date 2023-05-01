<?php
$title = "Schedule Management";
$css_link = "./styles/scheduling.css?=" . time();
$auth = true;
$filter = false;
require_once('./php/require/header.php');
?>
<style>
    *,
    :root {
        --bs-btn-bg: #4C0000 !important;
        --bs-btn-border-color: #FFFFFF !important;
        --bs-btn-hover-bg: #4C0000 !important;
    }
</style>

<body>

    <?php
    include './php/require/navbar.php';
    ?>
    <div id="overlay">
        <div class="container-fluid sched-con">
            <h1>Schedule Management</h1>
            <div class="row">
                <!--LEFT COLUMN-->

                <!--RIGHT COLUMN-->
                <div class="col-xl grid-con">
                    <?php

                    $subject = new Display();
                    $subject->displayStatus();
                    ?>
                    <!--ROOM FILTER-->
                    <form class="mb-3">
                        <div class="row">
                            <!-- ROOM SELECT  -->
                            <div class="col-xxl">
                                <label for="room_select_schedule">Room</label>
                                <select id="room_select_schedule" name="room_select_schedule" class="form-select form-ele">
                                    <option value="" disabled selected>All rooms</option>
                                    <?php
                                    $room_select_schedule = new display();
                                    $room_select_schedule->displayOption("room", "room_id", "room_name");
                                    ?>
                                </select>
                            </div>

                            <!-- SECTION SELECT  -->
                            <div class="col-xxl">
                                <label for="sec_select_schedule">Section</label>
                                <select id="sec_select_schedule" name="sec_select_schedule" class="form-select form-ele">
                                    <option value="" disabled selected>All sections</option>
                                    <?php
                                    $room_select_schedule = new display();
                                    $room_select_schedule->displayOption("section", "section_id", "section_name");
                                    ?>
                                </select>
                            </div>

                            <!-- PROF SELECT  -->
                            <div class="col-xxl-3">
                                <label for="prof_select_schedule">Professor</label>
                                <select id="prof_select_schedule" name="prof_select_schedule" class="form-select form-ele">
                                    <option value="" disabled selected>All professors</option>
                                    <?php
                                    $room_select_schedule = new display();
                                    $room_select_schedule->displayOption("professor", "prof_id", "prof_name");
                                    ?>
                                </select>
                            </div>
                            <div class="col-xxl">
                                <label for="sec_select_schedule">Semester</label>
                                <select id="sec_select_schedule" name="sec_select_schedule" class="form-select form-ele">
                                    <option value="" disabled selected>All semester</option>
                                    <?php
                                    $sem_select = new display();
                                    $sem_select->displayOption("semester", "semester_id", "semester");
                                    ?>
                                </select>
                            </div>

                            <!-- d-grid col-xxl d-xxl-block  -->
                            <div class="d-grid col-xxl d-xxl-flex align-items-end">
                                <button type="button" class="btn btn-dark fButton form-ele w-100" onclick="updateSchedule()" name="room_schedule">View Schedules</button>
                                <script>
                                    function updateSchedule() {
                                        const room_id = document.querySelector('#room_select_schedule').value;
                                        const xhr = new XMLHttpRequest();
                                        xhr.open('POST', './php/request.php', true);
                                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;charset=UTF-8');
                                        xhr.onload = function() {
                                            if (xhr.status === 200) {
                                                document.querySelector('#table-gen').innerHTML = xhr.responseText;
                                            } else {
                                                console.log('Error: ' + xhr.statusText);
                                            }
                                        };
                                        xhr.onerror = function() {
                                            console.log('Error: ' + xhr.statusText);
                                        };
                                        xhr.send(`room_schedule=1&room_id=${room_id}`);
                                    }
                                </script>
                            </div>

                            <div class="d-grid col-xxl d-xxl-flex align-items-end">
                                <button type="button" class="btn btn-dark fButton form-ele w-100" data-bs-toggle="modal" data-bs-target="#modal">Add Schedule</button>
                            </div>
                        </div>
                    </form>
                    <!--WEEK CALENDAR-->
                    <div class="row table-wrap">
                        <table id="sched-calendar" class="table table-bordered border border-dark table-hover">
                            <thead class="thead">
                                <tr>
                                    <td></td>
                                    <?php
                                    $day = new display();
                                    $day->displayDay();
                                    ?>
                                </tr>
                            </thead>
                            <tbody class="tbody" id="table-gen">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border border-dark rounded-5 overflow-hidden">
                <div class="modal-header popup-header">
                    <h1 class="modal-title fs-2" id="exampleModalLabel">Add Schedule</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="sched_form" method="POST" action="./php/add-data.php">

                        SECTION AND SEM INPUT
                        <div class="row">
                            <div class="col">
                                <label for="sec_select">Section</label>
                                <select id="sec_select" name="sec_select" class="form-select form-ele">
                                    <option selected></option>
                                    <?php
                                    $sec_select = new display();
                                    $sec_select->displayOption("section", "section_id", "section_name");
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="sem_select">Semester</label>
                                <select id="sem_select" name="sem_select" class="form-select form-ele">
                                    <option selected></option>
                                    <?php
                                    $sem_select = new display();
                                    $sem_select->displayOption("semester", "semester_id", "semester");
                                    ?>
                                </select>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const sec_select = document.querySelector('#sec_select');
                                    const sem_select = document.querySelector('#sem_select');

                                    function handleSelectChange() {
                                        const section = sec_select.value;
                                        const semester = sem_select.value;
                                        if (section === "" || semester === "") {
                                            return; // exit function without making AJAX call
                                        }
                                        const xhr = new XMLHttpRequest();
                                        xhr.open('POST', './php/request.php', true);
                                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;charset=UTF-8');
                                        xhr.onload = function() {
                                            if (xhr.status === 200) {
                                                document.querySelector('#listSubject').innerHTML = xhr.responseText;
                                            } else {
                                                console.log('Error: ' + xhr.statusText);
                                            }
                                        };
                                        xhr.onerror = function() {
                                            console.log('Error: ' + xhr.statusText);
                                        };
                                        xhr.send(`sec_select=${section}&sem_select=${semester}`);
                                    }
                                    sec_select.addEventListener('change', handleSelectChange);
                                    sem_select.addEventListener('change', handleSelectChange);
                                });
                            </script>

                        </div>

                        LIST OF SUBJECTS
                        <div class="container row form-ele sublist">
                            <p>List of Subjects</p>
                            <div id="listSubject">
                            </div>
                        </div>

                        SCHEDULE INPUT
                        <div class="row">
                            <div class="col">
                                <label for="sched_start">Start Time</label>
                                <select name="sched_start" id="sched_start" class="form-select  form-ele">
                                    <?php
                                    $start_time = new display();
                                    $start_time->displayTime("07:00", "21:00", "+30 minutes");
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="sched_end">End Time</label>
                                <select name="sched_end" id="sched_end" class="form-select  form-ele">
                                    <?php
                                    $end_time = new display();
                                    $end_time->displayTime("07:00", "21:00", "+30 minutes");
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="room_select">Room</label>
                                <select id="room_select" name="room_select" class="form-select form-ele">
                                    <?php
                                    $room_select = new display();
                                    $room_select->displayOption("room", "room_id", "room_name");
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="day_select">Day</label>
                                <select id="day_select" name="day_select" class="form-select form-ele">
                                    <?php
                                    $day_select = new display();
                                    $day_select->displayOption("day", "day_id", "day");
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="schedule_type">Type of Schedule</label>
                                <select id="schedule_type" name="schedule_type" class="form-select form-ele">
                                    <option value="Lecture">Lecture</option>
                                    <option value="Laboratory">Laboratory</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="professor_select">Professor</label>
                                <select id="professor_select" name="professor_select" class="form-select form-ele">
                                    <?php
                                    $professor = new display();
                                    $professor->displayOption("professor", "professor_id", "professor_name");
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="btn-con">
                            <button type="submit" class="btn btn-dark fButton" name="scheduing_submit">Save</button>
                            <button type="button" class="btn btn-dark fButton" data-bs-dismiss="modal">Back</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>
</body>

<script>
    //on load of the website
    window.onload = function() {
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    };
</script>

</html>