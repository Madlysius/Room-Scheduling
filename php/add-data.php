<?php
require_once('./require/DBConfig.php');
require_once('./function/database_function.php');
if (($_SERVER['REQUEST_METHOD'] == 'POST') &&  (isset($_POST['add-section']))) {
    form_validation(array('secName', 'secYear', 'secProgram'), '../section-manage.php');

    $secName = htmlspecialchars($_POST['secName']);
    $secYear = htmlspecialchars($_POST['secYear']);
    $secProgram = htmlspecialchars($_POST['secProgram']);

    $yearvalidate = array('1st', '2nd', '3rd', '4th');
    $stmt = $pdo->prepare("SELECT program_id FROM program");
    $stmt->execute();
    $courseArray = $stmt->fetchAll(PDO::FETCH_COLUMN);

    validateDropdownValues($secProgram, $courseArray, 'Invalid Input', '../section-manage.php');
    validateDropdownValues($secYear, $yearvalidate, 'Invalid Input', '../section-manage.php');
    if (DB::insert('section', array(
        'section_name' => $secName,
        'section_year' => $secYear,
        'program_id' => $secProgram
    ))) {
        $status = "success";
        header("Location: ../section-manage.php?status=$status&message=Successfully Added");
    } else {
        $status = "error";
        header("Location: ../section-manage.php?status=$status&message=Failed to Add");
    }
}
if (($_SERVER['REQUEST_METHOD'] == 'POST') &&  (isset($_POST['add-course']))) {
    // Check if form has already been submitted
    $form_fields = array('course_code', 'course_name', 'program_id', 'course_semester');
    form_validation($form_fields, '../course-manage.php');
    $course_code = htmlspecialchars($_POST['course_code']);
    $course_name = htmlspecialchars($_POST['course_name']);
    $program_id = htmlspecialchars($_POST['program_id']);
    $course_semester = htmlspecialchars($_POST['course_semester']);
    $lecture_units = htmlspecialchars($_POST['lecture_units']);
    $laboratory_units = htmlspecialchars($_POST['laboratory_units']);
    $total_units = $lecture_units+$laboratory_units;

    if($total_units>3){
        $status="error";
        header("Location: ../course-manage.php?status=$status&message=Total number of units exceeded 3.");
        exit();
    }elseif($total_units<3){
        $status="error";
        header("Location: ../course-manage.php?status=$status&message=Please set lecture and lab units properly to reach 3 units of the course.");
        exit();
    }

    if (DB::insert('course', array(
        'program_id' => $program_id,
        'semester_id' => $course_semester,
        'course_code' => $course_code,
        'course_name' => $course_name,
        'lecture_units' => $lecture_units,
        'laboratory_units' => $laboratory_units
    ))) {
        $status = "success";
        header("Location: ../course-manage.php?status=$status&message=Successfully Added");
    } else {
        $status = "error";
        header("Location: ../course-manage.php?status=$status&message=Failed to Add");
    }
}
if (($_SERVER['REQUEST_METHOD'] == 'POST') &&  (isset($_POST['add-program']))) {

    form_validation(
        array('program_name', 'program_department', 'program_abbreviation'),
        '../program-manage.php'
    );
    $program_name = htmlspecialchars($_POST['program_name']);
    $program_department = htmlspecialchars($_POST['program_department']);
    $program_abbreviation = htmlspecialchars($_POST['program_abbreviation']);

    if (DB::insert('program', array(
        'program_name' => $program_name,
        'program_department' => $program_department,
        'program_abbreviation' => $program_abbreviation
    ))) {
        $status = "success";
        header("Location: ../program-manage.php?status=$status&message=Successfully Added");
    } else {
        $status = "error";
        header("Location: ../program-manage.php?status=$status&message=Failed to Add");
    }
}
if (($_SERVER['REQUEST_METHOD'] == 'POST') &&  (isset($_POST['add-room']))) {
    $valid_room_categories =  array('Lecture Room', 'Laboratory Room');
    $valid_room_addr = array('Main', 'Annex');
    form_validation(
        array('room_name', 'room_categ', 'room_addr'),
        '../room-manage.php'
    );

    $room_name = htmlspecialchars($_POST['room_name']);
    $room_categ = htmlspecialchars($_POST['room_categ']);
    $room_addr = htmlspecialchars($_POST['room_addr']);

    validateDropdownValues($room_categ, $valid_room_categories, "Invalid category value", '../room-manage.php');
    validateDropdownValues($room_addr, $valid_room_addr, "Invalid Location value", '../room-manage.php');
    if (empty($room_name) || empty($room_categ) || empty($room_addr)) {
        $status = "empty";
        header("Location: ../room-manage.php?status=$status&message=Please Fill Up All Fields");
        exit();
    }
    if (DB::insert('room', array(
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
if (($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['add-professor'])))) {
    form_validation(
        array('professor_name', 'professor_department'),
        '../professor-manage.php'
    );
    $professor_name = htmlspecialchars($_POST['professor_name']);
    $professor_department = htmlspecialchars($_POST['professor_department']);
    if ((DB::insert('professor', array(
        'professor_name' => $professor_name,
        'professor_department' => $professor_department
    )))) {
        $status = "success";
        header("Location: ../professor-manage.php?status=$status&message=Successfully Added");
    } else {
        $status = "error";
        header("Location: ../professor-manage.php?status=$status&message=Failed to Add");
    }
}
// * For Scheduling Room Request
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['scheduing_submit']))) {

    $course_id = htmlentities($_POST['course']);
    $room_id = htmlentities($_POST['room_select']);
    $section_id = htmlentities($_POST['sec_select']);
    $day_id = htmlentities($_POST['day_select']);
    $semester_id = htmlentities($_POST['sem_select']);
    $professor_id = htmlentities($_POST['professor_select']);
    $schedule_type = htmlentities($_POST['schedule_type']);
    $schedule_start_time = htmlentities($_POST['sched_start']);
    $schedule_end_time = htmlentities($_POST['sched_end']);

    //getting previous schedule data of same course and schedule type
    $stmt = $pdo->prepare("SELECT schedule_id, schedule_start_time, schedule_end_time FROM `scheduling table` WHERE course_id = :course_id AND schedule_type = :schedule_type AND section_id = :section_id");
    $stmt->execute(array(':course_id' => $course_id, ':schedule_type' => $schedule_type, 'section_id' => $section_id));
    $prev = $stmt->fetchAll(PDO::FETCH_OBJ);
    foreach($prev as $row){
        $prev_start = strtotime($row->schedule_start_time);
        $prev_end = strtotime($row->schedule_end_time);
        $prev_duration += ($prev_end - $prev_start);
    }
    // $prev_start = $prev_s['schedule_start_time'];

    // $stmt = $pdo->prepare("SELECT schedule_end_time FROM `scheduling table` WHERE course_id = :course_id AND schedule_type = :schedule_type");
    // $stmt->execute(array(':course_id' => $course_id, ':schedule_type' => $schedule_type));
    // $prev_e = $stmt->fetch(PDO::FETCH_ASSOC);
    // $prev_end = $prev_e['schedule_end_time'];
    // $prev_duration = strtotime($prev_end) - strtotime($prev_start);

    if ($schedule_type == "Lecture") {
        // Get the lecture hours of the selected course
        $stmt = $pdo->prepare("SELECT lecture_units FROM course WHERE course_id = :course_id");
        $stmt->execute(array(':course_id' => $course_id));
        $course = $stmt->fetch(PDO::FETCH_ASSOC);
        // 1 unit = 1.5 hour
        $time = $course['lecture_units'] * 1;
        // Calculate the maximum schedule duration based on the lecture hours of the selected course
        $max_duration = $time * 60 * 60; // Convert lecture hours to seconds

    } else if ($schedule_type == "Laboratory") {
        // Get the laboratory hours of the selected course
        $stmt = $pdo->prepare("SELECT laboratory_units FROM course WHERE course_id = :course_id");
        $stmt->execute(array(':course_id' => $course_id));
        $course = $stmt->fetch(PDO::FETCH_ASSOC);
        // 1 unit = 3 hours
        $time = $course['laboratory_units']  * 3;
        // Calculate the maximum schedule duration based on the laboratory hours of the selected course
        $max_duration = $time * 60 * 60; // Convert laboratory hours to seconds
    }

    //if max duration is already reached by previously added schedule, terminate code
    if($prev_duration >= $max_duration){
        header("Location: ../schedule-manage.php?status=error&message=Maximum%20$schedule_type%20weekly%20schedule%20duration%20for%20this%20course%20is%20already%20reached.");
        exit();
    }//else, subtract the previous schedule duration from current max duration
    else{
        $max_duration-=$prev_duration;
    }

    // Calculate the actual duration of the schedule
    $duration = strtotime($schedule_end_time) - strtotime($schedule_start_time);
    $cut=false;

    // If the actual duration exceeds the maximum duration, cut it off
    if ($duration > $max_duration) {
        $schedule_end_time = date("H:i", strtotime($schedule_start_time) + $max_duration);
        $cut=true;
    }

    if (strtotime($schedule_start_time) >= strtotime($schedule_end_time)) {
        header("Location: ../schedule-manage.php?status=error&message=Start%20Time%20Must%20Be%20Less%20Than%20End%20Time");
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM `scheduling table` WHERE room_id = :room_id AND day_id = :day_id AND section_id = :section_id AND semester_id = :semester_id AND ((`schedule_start_time` <= :schedule_start_time AND `schedule_end_time` > :schedule_start_time) OR (`schedule_start_time` >= :schedule_start_time AND `schedule_start_time` < :schedule_end_time))");
    $stmt->execute(array(':room_id' => $room_id, ':day_id' => $day_id, ':semester_id' => $semester_id, ':section_id' => $section_id, ':schedule_start_time' => $schedule_start_time, ':schedule_end_time' => $schedule_end_time));
    $count = $stmt->rowCount();

    if ($count > 0) {
        header("Location: ../schedule-manage.php?status=error&message=Room%20is%20already%20occupied%20during%20that%20time%20and%20day%20in%20this%20semester");
        exit();
    }


    $result = DB::insert('scheduling table', array(
        'course_id' => $course_id,
        'room_id' => $room_id,
        'section_id' => $section_id,
        'day_id' => $day_id,
        'semester_id' => $semester_id,
        'professor_id' => $professor_id,
        'schedule_type' => $schedule_type,
        'schedule_start_time' => $schedule_start_time,
        'schedule_end_time' => $schedule_end_time
    ));
    if ($result) {
        if($cut==true){
            header("Location: ../schedule-manage.php?status=success&message=Set schedule exceeded maximum hours. Schedule added with automatically adjusted end time.");
        } else {
            header("Location: ../schedule-manage.php?status=success&message=Schedule%20Added");
        }
    } else {
        echo "Error";
    }
}