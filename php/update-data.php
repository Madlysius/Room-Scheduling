<?php
require_once('./require/DBConfig.php');
require_once('./function/database_function.php');
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['edit']))) {
    if (isset($_POST['edit'])) {
        if ($_POST['edit'] == 'program') {
            $program_id = htmlentities($_POST['program_id']);
            $program_name = strtolower(htmlspecialchars($_POST['program_name']));
            $program_department = htmlentities($_POST['program_department']);
            $program_abbreviation = htmlentities($_POST['program_abbreviation']);

            $stmt = $pdo->prepare("SELECT LOWER(program_name) FROM program WHERE program_id!=" . $program_id);
            $stmt->execute();
            $progArray = $stmt->fetchAll(PDO::FETCH_COLUMN);
            duplicateCheck($program_name, $progArray, 'Program', '../program-manage.php');
            $program_name = ucwords($program_name);
            $result = DB::update('program', array(
                'program_name' => $program_name,
                'program_department' => $program_department,
                'program_abbreviation' => $program_abbreviation
            ), "program_id=%s", $_POST['program_id']);

            if ($result) {
                header("Location: ../program-manage.php?status=success&message=Program%20Updated");
            } else {
                echo "Error";
            }
        } else if ($_POST['edit'] == 'room') {
            $room_id = htmlentities($_POST['room_id']);

            $room_name = RemoveSpecialChar(strtoupper(htmlentities($_POST['room_name'])));
            $room_category = htmlentities($_POST['room_category']);
            $room_location = htmlentities($_POST['room_location']);

            $stmt = $pdo->prepare("SELECT LOWER(room_name) FROM room WHERE room_id!=" . $room_id);
            $stmt->execute();
            $roomArray = $stmt->fetchAll(PDO::FETCH_COLUMN);
            duplicateCheck($room_name, $roomArray, 'Room', '../room-manage.php');

            $result = DB::update('room', array(
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
            $section_name = RemoveSpecialChar(strtoupper(htmlentities($_POST['section_name'])));
            $section_year = htmlentities($_POST['section_year']);
            $program_id = htmlentities($_POST['program_id']);

            $stmt = $pdo->prepare("SELECT LOWER(section_name) FROM section WHERE section_id!=" . $section_id);
            $stmt->execute();
            $secArray = $stmt->fetchAll(PDO::FETCH_COLUMN);
            duplicateCheck($section_name, $secArray, 'Section', '../section-manage.php');

            $result = DB::update('section', array(
                'section_name' => $section_name,
                'program_id' => $program_id,
                'section_year' => $section_year
            ), "section_id=%s", $_POST['section_id']);
            if ($result) {
                header("Location: ../section-manage.php?status=success&message=Section%20Updated");
            } else {
                echo "Error";
            }
        } else if ($_POST['edit'] == 'schedule') {
            $schedule_id = htmlentities($_POST['schedule_id']);
            $course_id = htmlentities($_POST['course_id']);
            $room_id = htmlentities($_POST['room_id']);
            $section_id = htmlentities($_POST['section_id']);
            $day_id = htmlentities($_POST['day_id']);
            $semester_id = htmlentities($_POST['semester_id']);
            $professor_id = htmlentities($_POST['professor_id']);
            $schedule_type = htmlentities($_POST['schedule_type']);
            $schedule_start_time = htmlentities($_POST['schedule_start_time']);
            $schedule_end_time = htmlentities($_POST['schedule_end_time']);
            //check everything if empty
            if (empty($course_id) || empty($room_id) || empty($section_id) || empty($day_id) || empty($semester_id) || empty($schedule_start_time) || empty($schedule_end_time)) {
                header("Location: ../schedule-manage.php?status=empty&message=Empty");
                exit();
            }

            //getting previous schedule data of same course and schedule type
            $stmt = $pdo->prepare("SELECT schedule_id, schedule_start_time, schedule_end_time FROM `scheduling table` WHERE course_id = :course_id AND schedule_type = :schedule_type AND section_id = :section_id");
            $stmt->execute(array(':course_id' => $course_id, ':schedule_type' => $schedule_type, 'section_id' => $section_id));
            $prev = $stmt->fetchAll(PDO::FETCH_OBJ);
            foreach ($prev as $row) {
                $current_id = $row->schedule_id;
                if ($schedule_id != $current_id) {
                    $prev_start = strtotime($row->schedule_start_time);
                    $prev_end = strtotime($row->schedule_end_time);
                    $prev_duration += ($prev_end - $prev_start);
                }
            }

            if ($schedule_type == "Lecture") {
                // Get the lecture hours of the selected course
                $stmt = $pdo->prepare("SELECT lecture_units FROM course WHERE course_id = :course_id");
                $stmt->execute(array(':course_id' => $course_id));
                $course = $stmt->fetch(PDO::FETCH_ASSOC);

                // 1 lecture unit = 1 hour
                $time = $course['lecture_units'] * 1;
                // Calculate the maximum schedule duration based on the lecture hours of the selected course
                $max_duration = $time * 60 * 60; // Convert lecture hours to seconds
            } else if ($schedule_type == "Laboratory") {
                // Get the laboratory hours of the selected course
                $stmt = $pdo->prepare("SELECT laboratory_units FROM course WHERE course_id = :course_id");
                $stmt->execute(array(':course_id' => $course_id));
                $course = $stmt->fetch(PDO::FETCH_ASSOC);

                // 1 lab unit = 3 hours
                $time = $course['laboratory_units']  * 3;
                // Calculate the maximum schedule duration based on the laboratory hours of the selected course
                $max_duration = $time * 60 * 60; // Convert laboratory hours to seconds
            }

            //if max duration is already reached by previously added schedule, terminate code
            if ($prev_duration >= $max_duration) {
                header("Location: ../schedule-manage.php?status=error&message=Maximum%20$schedule_type%20weekly%20schedule%20duration%20for%20this%20course%20is%20already%20reached.");
                exit();
            } //else, subtract the previous schedule duration from current max duration
            else {
                $max_duration -= $prev_duration;
            }

            // Calculate the actual duration of the schedule
            $duration = strtotime($schedule_end_time) - strtotime($schedule_start_time);
            $cut = false;

            // If the actual duration exceeds the maximum duration, cut it off
            if ($duration > $max_duration) {
                $schedule_end_time = date("H:i", strtotime($schedule_start_time) + $max_duration);
                $cut = true;
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

            $result = DB::update('scheduling table', array(
                'course_id' => $course_id,
                'room_id' => $room_id,
                'section_id' => $section_id,
                'day_id' => $day_id,
                'semester_id' => $semester_id,
                'professor_id' => $professor_id,
                'schedule_type' => $schedule_type,
                'schedule_start_time' => $schedule_start_time,
                'schedule_end_time' => $schedule_end_time
            ), "schedule_id=%s", $_POST['schedule_id']);
            if ($result) {
                if ($cut == true) {
                    header("Location: ../schedule-manage.php?status=success&message=Set schedule exceeded maximum hours. Schedule added with automatically adjusted end time.");
                } else {
                    header("Location: ../schedule-manage.php?status=success&message=Schedule%20Updated");
                }
            } else {
                echo "Error";
            }
        } else if ($_POST['edit'] == 'course') {
            $course_id = htmlentities($_POST['course_id']);
            $program_id = htmlentities($_POST['program_id']);
            $course_code = strtolower(htmlspecialchars($_POST['course_code']));
            $course_name = strtolower(htmlspecialchars($_POST['course_name']));
            $course_id = htmlentities($_POST['course_id']);
            $semester_id = htmlentities($_POST['semester_id']);
            $lecture_units = htmlentities($_POST['lecture_units']);
            $laboratory_units = htmlentities($_POST['laboratory_units']);
            $total_units = $lecture_units + $laboratory_units;

            if ($total_units > 3) {
                $status = "error";
                header("Location: ../course-manage.php?status=$status&message=Total number of units exceeded 3.");
                exit();
            } elseif ($total_units < 3) {
                $status = "error";
                header("Location: ../course-manage.php?status=$status&message=Please set lecture and lab units properly to reach 3 units of the course.");
                exit();
            }

            $stmt = $pdo->prepare("SELECT LOWER(course_code) FROM course WHERE course_id != :course_id AND program_id = :program_id");
            $stmt->execute(array(":course_id" => $course_id, ":program_id" => $program_id));
            $codeArray = $stmt->fetchAll(PDO::FETCH_COLUMN);
            if (in_array($course_code, $codeArray)) {
                $count += 1;
                $status = "error";
                $error = "code";
            }
            $stmt = $pdo->prepare("SELECT LOWER(course_name) FROM course WHERE course_id != :course_id AND program_id = :program_id");
            $stmt->execute(array(":course_id" => $course_id, ":program_id" => $program_id));
            $nameArray = $stmt->fetchAll(PDO::FETCH_COLUMN);
            if (in_array($course_name, $nameArray)) {
                $count += 1;
                $error = "name";
                $status = "error";
            }
            if ($count > 0) {
                if ($count == 1 && $error == "code") {
                    header("Location: ../course-manage.php?status=$status&message=Course code already exists");
                    exit();
                } elseif ($count == 1 && $error == "name") {
                    header("Location: ../course-manage.php?status=$status&message=Course name already exists");
                    exit();
                } elseif ($count == 2) {
                    header("Location: ../course-manage.php?status=$status&message=Course code and name already exists");
                    exit();
                }
            }

            $course_code = strtoupper($course_code);
            $course_name = ucwords($course_name);
            $result = DB::update('course', array(
                'course_code' => $course_code,
                'course_name' => $course_name,
                'program_id' => $program_id,
                'course_id' => $course_id,
                'semester_id' => $semester_id,
                'lecture_units' => $lecture_units,
                'laboratory_units' => $laboratory_units
            ), "course_id=%s", $_POST['course_id']);
            if ($result) {
                header("Location: ../course-manage.php?status=success&message=Course%20Updated");
            } else {
                echo "Error";
            }
        } else if ($_POST['edit'] == 'professor') {
            $professor_name = strtolower(htmlspecialchars($_POST['professor_name']));
            $professor_id = htmlentities($_POST['professor_id']);
            $professor_department = htmlentities($_POST['professor_department']);

            $stmt = $pdo->prepare("SELECT LOWER(professor_name) FROM professor WHERE professor_id!=" . $professor_id);
            $stmt->execute();
            $profArray = $stmt->fetchAll(PDO::FETCH_COLUMN);
            duplicateCheck($professor_name, $profArray, 'Professor', '../professor-manage.php');
            $professor_name = ucwords($professor_name);
            $result = DB::update('professor', array(
                'professor_name' => $professor_name,
                'professor_department' => $professor_department
            ), "professor_id=%s", $_POST['professor_id']);
            if ($result) {
                header("Location: ../professor-manage.php?status=success&message=Professor%20Updated");
            } else {
                echo "Error";
            }
        }
    }
}
