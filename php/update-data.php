<?php
require_once('./require/DBConfig.php');
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['edit']))) {
    if (isset($_POST['edit'])) {
        if ($_POST['edit'] == 'progam') {
            $result = DB::update(
                'program',
                array(
                    'program_id' => htmlentities($_POST['program_id']),
                    'program_name' => htmlentities($_POST['program_name'])
                ),
                "program_id=%s",
                htmlentities($_POST['program_id'])
            );
            if ($result) {
                header("Location: ../program-manage.php?status=success&message=Program%20Updated");
            } else {
                echo "Error";
            }
        } else if ($_POST['edit'] == 'room') {
            $room_code = htmlentities($_POST['room_code']);
            $room_name = htmlentities($_POST['room_name']);
            $room_category = htmlentities($_POST['room_category']);
            $room_location = htmlentities($_POST['room_location']);
            $result = DB::update('room', array(
                'room_code' => $room_code,
                'room_name' => $room_name,
                'room_category' => $room_category,
                'room_location' => $room_location
            ), "room_id=%s", $_POST['room_id']);
            if ($result) {
                header("Location: ../room-manage.php?status=success&message=Room%20Updated");
            } else {
                echo "Error";
            }
        } else if ($_POST['edit'] == 'section') {
            $section_id = htmlentities($_POST['section_id']);
            $section_name = htmlentities($_POST['section_name']);
            $section_year = htmlentities($_POST['section_year']);
            $course_id = htmlentities($_POST['course_id']);
            $result = DB::update('section', array(
                'section_name' => $section_name,
                'course_id' => $course_id,
                'section_year' => $section_year
            ), "section_id=%s", $_POST['section_id']);
            if ($result) {
                header("Location: ../section-manage.php?status=success&message=Section%20Updated");
            } else {
                echo "Error";
            }
        } else if ($_POST['edit'] == 'schedule') {
            $schedule_id = htmlentities($_POST['schedule_id']);
            $subject_id = htmlentities($_POST['subject_id']);
            $room_id = htmlentities($_POST['room_id']);
            $section_id = htmlentities($_POST['section_id']);
            $day_id = htmlentities($_POST['day_id']);
            $semester_id = htmlentities($_POST['semester_id']);
            $schedule_start_time = htmlentities($_POST['schedule_start_time']);
            $schedule_end_time = htmlentities($_POST['schedule_end_time']);
            //check everything if empty
            if (empty($subject_id) || empty($room_id) || empty($section_id) || empty($day_id) || empty($semester_id) || empty($schedule_start_time) || empty($schedule_end_time)) {
                header("Location: ../scheduling.php?status=empty&message=Empty");
                exit();
            }
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
            $result = DB::update('scheduling table', array(
                'subject_id' => $subject_id,
                'room_id' => $room_id,
                'section_id' => $section_id,
                'day_id' => $day_id,
                'semester_id' => $semester_id,
                'schedule_start_time' => $schedule_start_time,
                'schedule_end_time' => $schedule_end_time
            ), "schedule_id=%s", $_POST['schedule_id']);
            if ($result) {
                header("Location: ../scheduling.php?status=success&message=Schedule%20Updated");
            } else {
                echo "Error";
            }
        } else if ($_POST['edit'] == 'subject') {
            $subject_id = htmlentities($_POST['subject_id']);
            $subject_code = htmlentities($_POST['subject_code']);
            $subject_name = htmlentities($_POST['subject_name']);
            $course_id = htmlentities($_POST['course_id']);
            $semester_id = htmlentities($_POST['semester_id']);
            $lec_hrs = htmlentities($_POST['lecture_hr']);
            $lab_hrs = htmlentities($_POST['laboratory_hr']);
            $result = DB::update('subject', array(
                'subject_code' => $subject_code,
                'subject_name' => $subject_name,
                'course_id' => $course_id,
                'semester_id' => $semester_id,
                'lecture_hr' => $lec_hrs,
                'laboratory_hr' => $lab_hrs
            ), "subject_id=%s", $_POST['subject_id']);
            if ($result) {
                header("Location: ../subject-manage.php?status=success&message=Subject%20Updated");
            } else {
                echo "Error";
            }
        }
    }
}
