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
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add rooms on room management to display room options on dropdown.">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                                    </svg>
                                </a>
                                <select id="room_select_schedule" name="room_select_schedule" class="form-select form-ele">
                                    <?php
                                    $room_select_schedule = new display();
                                    $room_select_schedule->displayOption("room", "room_id", "room_name");
                                    ?>
                                    <option value="">All rooms</option>
                                </select>
                            </div>

                            <!-- SECTION SELECT  -->
                            <div class="col-xxl">
                                <label for="sec_select_schedule">Section</label>
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add sections on section management to display section options on dropdown.">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                                    </svg>
                                </a>
                                <select id="sec_select_schedule" name="sec_select_schedule" class="form-select form-ele">
                                    <option value="">All sections</option>
                                    <?php
                                    $room_select_schedule = new display();
                                    $room_select_schedule->displayOption("section", "section_id", "section_name");
                                    ?>
                                </select>
                            </div>

                            <!-- PROF SELECT  -->
                            <div class="col-xxl-3">
                                <label for="prof_select_schedule">Professor</label>
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add professors on professor management to display professor options on dropdown.">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                                    </svg>
                                </a>
                                <select id="prof_select_schedule" name="prof_select_schedule" class="form-select form-ele">
                                    <option value="">All professors</option>
                                    <?php
                                    $room_select_schedule = new display();
                                    $room_select_schedule->displayOption("professor", "professor_id", "professor_name");
                                    ?>
                                </select>
                            </div>
                            <div class="col-xxl">
                                <label for="sem_select_schedule">Semester</label>
                                <select id="sem_select_schedule" name="sem_select_schedule" class="form-select form-ele">
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
                                        const professor_id = document.querySelector('#prof_select_schedule').value;
                                        const section_id = document.querySelector('#sec_select_schedule').value;
                                        const semester_id = document.querySelector('#sem_select_schedule').value;
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
                                        if (room_id || professor_id || section_id || semester_id) {
                                            xhr.send(`room_schedule=1&room_id=${room_id}&professor_id=${professor_id}&section_id=${section_id}&semester_id=${semester_id}`);
                                        }
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
                    <div class="row">
                        <div class="d-grid">
                            <div class="col-xxl-3">
                                <label for="delete_schedule_semester">Delete Schedule For:</label>
                                <select id="delete_schedule_semester" name="delete_schedule_semester" class="form-select form-ele">
                                    <?php
                                    $sem_select = new display();
                                    $sem_select->displayOption("semester", "semester_id", "semester");
                                    ?>
                                </select>
                                <div class="d-grid col-xxl d-xxl-flex align-items-end">
                                    <button type="button" class="btn btn-dark fButton form-ele w-100" onclick="DeleteSchedule()" name="delete_schedule">Delete Schedule</button>
                                </div>
                                <script>
                                    function DeleteSchedule() {
                                        if (confirm("Are you sure you want to delete this schedule for the entire semester?")) {
                                            const semester_id = document.querySelector('#delete_schedule_semester').value;
                                            console.log(semester_id);
                                            const xhr = new XMLHttpRequest();
                                            xhr.open('POST', './php/delete-data.php', true);
                                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;charset=UTF-8');
                                            xhr.onreadystatechange = function() {
                                                if (xhr.readyState === 4) {
                                                    if (xhr.status === 200) {
                                                        // Request was successful, handle the response
                                                        var response = xhr.responseText;
                                                        if (response === "success") {
                                                            // Deletion was successful
                                                            alert("Failed");
                                                            // Perform any other actions you want
                                                        } else {
                                                            // Deletion failed or there was an error
                                                            alert("Successfully deleted schedule");
                                                            // Perform any other error handling or actions you want
                                                        }
                                                    } else {
                                                        // Request failed or there was an error
                                                        alert("Failed to make the request");
                                                        // Perform any error handling or actions you want
                                                    }
                                                }
                                            };

                                            // Prepare the POST data
                                            const postData = "delete_schedule=1&semester_id=" + encodeURIComponent(semester_id);

                                            // Send the request with the POST data
                                            xhr.send(postData);
                                        }
                                    }
                                </script>
                            </div>

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

                            <!-- SECTION AND SEM INPUT -->
                            <div class="row">
                                <div class="col">
                                    <label for="sec_select">Section</label>
                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add sections on section management to display section options on dropdown.">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                                        </svg>
                                    </a>
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

                            <!-- List Of Courses -->
                            <div class="container row form-ele sublist">
                                <div class="d-flex p-2">
                                    <p class="pe-2">List of Courses</p>
                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Select section and semester to display available list of courses.">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                                        </svg>
                                    </a>
                                </div>
                                <div id="listSubject">
                                </div>
                            </div>

                            <!-- SCHEDULE INPUT -->
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
                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add rooms on room management to display room options on dropdown.">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                                        </svg>
                                    </a>
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
                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add professors on professor management to display professor options on dropdown.">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                                        </svg>
                                    </a>
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
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>

</html>