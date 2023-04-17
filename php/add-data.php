<?php
require_once('./require/DBConfig.php');
require_once('./function/database_function.php');
if (($_SERVER['REQUEST_METHOD'] == 'POST') &&  (isset($_POST['add-section']))) {
    form_validation(array('secName', 'secYear', 'secCourse'), '../section-manage.php');

    $secName = htmlspecialchars($_POST['secName']);
    $secYear = htmlspecialchars($_POST['secYear']);
    $secCourse = htmlspecialchars($_POST['secCourse']);

    $yearvalidate = array('1st', '2nd', '3rd', '4th');
    $stmt = $pdo->prepare("SELECT course_id FROM course");
    $stmt->execute();
    $courseArray = $stmt->fetchAll(PDO::FETCH_COLUMN);

    validateDropdownValues($secCourse, $courseArray, 'Invalid Input', '../section-manage.php');
    validateDropdownValues($secYear, $yearvalidate, 'Invalid Input', '../section-manage.php');
    if (empty($secName) || empty($secYear) || empty($secCourse)) {
        $status = "empty";
        header("Location: ../section-manage.php?status=$status&message=Please Fill Up All Fields");
        exit();
    }
    if (DB::insert('section', array(
        'section_name' => $secName,
        'section_year' => $secYear,
        'course_id' => $secCourse
    ))) {
        $status = "success";
        header("Location: ../section-manage.php?status=$status&message=Successfully Added");
    } else {
        $status = "error";
        header("Location: ../section-manage.php?status=$status&message=Failed to Add");
    }
}
if (($_SERVER['REQUEST_METHOD'] == 'POST') &&  (isset($_POST['add-subject']))) {
    // Check if form has already been submitted
    $form_fields = array('subject_code', 'subject_name', 'subject_course', 'subject_semester');
    form_validation($form_fields, '../subject-manage.php');
    $subject_code = htmlspecialchars($_POST['subject_code']);
    $subject_name = htmlspecialchars($_POST['subject_name']);
    $subject_course = htmlspecialchars($_POST['subject_course']);
    $subject_semester = htmlspecialchars($_POST['subject_semester']);
    $lec_hrs = htmlspecialchars($_POST['lec_hrs']);
    $lab_hrs = htmlspecialchars($_POST['lab_hrs']);
    if (empty($lec_hrs) || !is_numeric($lec_hrs) || $lec_hrs < 0 || !is_numeric($lab_hrs) || $lab_hrs < 0) {
        $status = "empty";
        header("Location: ../subject-manage.php?status=$status&message=Please Fill Up All Fields");
        exit();
    }
    if (DB::insert('subject', array(
        'course_id' => $subject_course,
        'semester_id' => $subject_semester,
        'subject_code' => $subject_code,
        'subject_name' => $subject_name,
        'lecture_hr' => $lec_hrs,
        'laboratory_hr' => $lab_hrs
    ))) {
        $status = "success";
        header("Location: ../subject-manage.php?status=$status&message=Successfully Added");
    } else {
        $status = "error";
        header("Location: ../subject-manage.php?status=$status&message=Failed to Add");
    }
}
if (($_SERVER['REQUEST_METHOD'] == 'POST') &&  (isset($_POST['add-course']))) {

    form_validation(
        array('course_name'),
        '../course-manage.php'
    );
    $course_name = htmlspecialchars($_POST['course_name']);
    if (empty($course_name)) {
        $status = "empty";
        header("Location: ../course-manage.php?status=$status");
        exit();
    }
    if (DB::insert('course', array(
        'course_name' => $course_name
    ))) {
        $status = "success";
        header("Location: ../course-manage.php?status=$status&message=Successfully Added");
    } else {
        $status = "error";
        header("Location: ../course-manage.php?status=$status&message=Failed to Add");
    }
}
if (($_SERVER['REQUEST_METHOD'] == 'POST') &&  (isset($_POST['add-room']))) {
    $valid_room_categories =  array('Lecture Room', 'Laboratory Room');
    $valid_room_addr = array('Main', 'Annex');
    form_validation(
        array('room_code', 'room_name', 'room_categ', 'room_addr'),
        '../room-manage.php'
    );
    $room_code = htmlspecialchars($_POST['room_code']);
    $room_name = htmlspecialchars($_POST['room_name']);
    $room_categ = htmlspecialchars($_POST['room_categ']);
    $room_addr = htmlspecialchars($_POST['room_addr']);

    validateDropdownValues($room_categ, $valid_room_categories, "Invalid category value", '../room-manage.php');
    validateDropdownValues($room_addr, $valid_room_addr, "Invalid Location value", '../room-manage.php');
    if (empty($room_code) || empty($room_name) || empty($room_categ) || empty($room_addr)) {
        $status = "empty";
        header("Location: ../room-manage.php?status=$status&message=Please Fill Up All Fields");
        exit();
    }
    if (DB::insert('room', array(
        'room_code' => $room_code,
        'room_name' => $room_name,
        'room_category' => $room_categ,
        'room_location' => $room_addr
    ))) {
        $status = "success";
        header("Location: ../room-manage.php?status=$status&message=Successfully Added");
    } else {
        $status = "error";
        header("Location: ../room-manage.php?status=$status&message=Failed to Add");
    }
}
// * For Scheduling Room Request
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['scheduing_submit']))) {

    $subject_id = htmlentities($_POST['subject']);
    $room_id = htmlentities($_POST['room_select']);
    $section_id = htmlentities($_POST['sec_select']);
    $day_id = htmlentities($_POST['day_select']);
    $semster_id = htmlentities($_POST['sem_select']);
    $schedule_start_time = htmlentities($_POST['sched_start']);
    $schedule_end_time = htmlentities($_POST['sched_end']);

    // Get the lecture hours of the selected subject
    $stmt = $pdo->prepare("SELECT lecture_hr FROM subject WHERE subject_id = :subject_id");
    $stmt->execute(array(':subject_id' => $subject_id));
    $subject = $stmt->fetch(PDO::FETCH_ASSOC);

    // Calculate the maximum schedule duration based on the lecture hours of the selected subject
    $max_duration = $subject['lecture_hr'] * 60 * 60; // Convert lecture hours to seconds

    // Calculate the actual duration of the schedule
    $duration = strtotime($schedule_end_time) - strtotime($schedule_start_time);

    // If the actual duration exceeds the maximum duration, cut it off
    if ($duration > $max_duration) {
        $schedule_end_time = date("H:i", strtotime($schedule_start_time) + $max_duration);
    }

    if (strtotime($schedule_start_time) >= strtotime($schedule_end_time)) {
        header("Location: ../scheduling.php?status=error&message=Start%20Time%20Must%20Be%20Less%20Than%20End%20Time");
        exit();
    }
    $stmt = $pdo->prepare("SELECT * FROM `scheduling table` WHERE room_id = :room_id AND day_id = :day_id AND ((`schedule_start_time` <= :schedule_start_time AND `schedule_end_time` > :schedule_start_time) OR (`schedule_start_time` >= :schedule_start_time AND `schedule_start_time` < :schedule_end_time))");
    $stmt->execute(array(':room_id' => $room_id, ':day_id' => $day_id, ':schedule_start_time' => $schedule_start_time, ':schedule_end_time' => $schedule_end_time));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($result)) {
        header("Location: ../scheduling.php?status=error&message=Room%20is%20already%20occupied%20during%20that%20time%20and%20day");
        exit();
    }
    $result = DB::insert('scheduling table', array(
        'subject_id' => $subject_id,
        'room_id' => $room_id,
        'section_id' => $section_id,
        'day_id' => $day_id,
        'semester_id' => $semster_id,
        'schedule_start_time' => $schedule_start_time,
        'schedule_end_time' => $schedule_end_time
    ));
    if ($result) {
        header("Location: ../scheduling.php?status=success&message=Schedule%20Added");
    } else {
        echo "Error";
    }
}
