<?php
require_once('require/DBConfig.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['room_schedule'])) {
    $room_id = $_POST['room_id'];
    $section_id = $_POST['section_id'];
    $semester_id = $_POST['semester_id'];
    $professor_id = $_POST['professor_id'];

    // initialize arrays for the query conditions and parameters
    $conditions = array();
    $parameters = array();

    // add condition and parameter for room_id, if it's not empty
    if (!empty($room_id)) {
        $conditions[] = "st.room_id = :room_id";
        $parameters[':room_id'] = $room_id;
    }

    // add condition and parameter for section_id, if it's not empty
    if (!empty($section_id)) {
        $conditions[] = "st.section_id = :section_id";
        $parameters[':section_id'] = $section_id;
    }

    // add condition and parameter for semester_id, if it's not empty
    if (!empty($semester_id)) {
        $conditions[] = "st.semester_id = :semester_id";
        $parameters[':semester_id'] = $semester_id;
    }

    // add condition and parameter for professor_id, if it's not empty
    if (!empty($professor_id)) {
        $conditions[] = "st.professor_id = :professor_id";
        $parameters[':professor_id'] = $professor_id;
    }

    // build the SQL query
    $sql = "SELECT st.schedule_id, st.schedule_start_time, st.schedule_end_time,
                   su.course_name, su.course_code, d.day, st.schedule_type, p.professor_name, r.room_name, se.section_name
            FROM `scheduling table` AS st
            JOIN `course` AS su ON st.course_id = su.course_id
            JOIN `day` AS d ON st.day_id = d.day_id
            JOIN `professor` AS p ON st.professor_id = p.professor_id
            JOIN `room` AS r ON st.room_id = r.room_id
            JOIN `section` AS se ON st.section_id = se.section_id";
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    $sql .= " ORDER BY st.schedule_start_time";

    // execute the query
    $stmt = $pdo->prepare($sql);
    $stmt->execute($parameters);
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);

    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    $start_time = "07:00:00";
    $end_time = "21:00:00";

    $schedule_map = [];
    foreach ($result as $row) {
        if (!isset($schedule_map[$row->day])) {
            $schedule_map[$row->day] = [];
        }
        $schedule_map[$row->day][] = $row;
    }
    while (strtotime($start_time) <= strtotime($end_time)) {
        echo '<tr>';
        echo '<td>' . date("g:i a", strtotime($start_time)) . '-' . date("g:i a", strtotime("+30 minutes", strtotime($start_time))) . '</td>';
        foreach ($days as $day) {
            echo '<td>';
            $class_scheduled = false;
            if (isset($schedule_map[$day])) {
                foreach ($schedule_map[$day] as $row) {
                    $schedule_start_time = strtotime($row->schedule_start_time);
                    $schedule_end_time = strtotime($row->schedule_end_time);
                    $current_time = strtotime($start_time);
                    if ($current_time >= $schedule_start_time && $current_time < $schedule_end_time) {
                        echo '<div class="tb-content">' . $row->course_name . ' - ' . $row->course_code . ' <br>' . $row->schedule_start_time . '  -  ' . $row->schedule_end_time . '<br>' . $row->schedule_type . '<br>' . $row->professor_name . '<br>' . $row->room_name . '<br> ' . $row->section_name . '<br>';
                        //add a button to delete the schedule
                        echo '<div class="dropdown ">
                        <button class="btn btn-secondary dropdown-toggle" style="background-color:#FFFFFFF" type="button" id="dropdownMenuButton-'  . $row->schedule_id . '" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row->schedule_id  . '">
                            <li><a class="dropdown-item" href="edit-forms.php?edit=schedule&schedule_id=' . $row->schedule_id  . '">Edit</a></li>
                            <li><a class="dropdown-item" href="#" onclick="deleteConfirmation(\'schedule\',\'' . $row->schedule_id . '\')">Delete</a></li>
                        </ul>
                    </div>';
                        echo '</div>';

                        $class_scheduled = true;
                    }
                }
            }
            if (!$class_scheduled) {
                echo '&nbsp;';
            }
            echo '</td>';
        }
        echo '</tr>';
        $start_time = date("H:i:s", strtotime("+30 minutes", strtotime($start_time)));
    }
}

if (isset($_POST['sec_select'], $_POST['sem_select'])) {
    $section_id = $_POST["sec_select"];
    $semester_id = $_POST["sem_select"];
    try {
        // prepare the SQL statement to get the program_id for the section
        $sql = "SELECT program_id FROM `section` WHERE section_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$section_id]);
        $row = $stmt->fetch();
        $program_id = $row['program_id'];

        // prepare the SQL statement to retrieve the courses
        $sql = "SELECT course_id, course_name FROM `course` WHERE program_id = ? AND semester_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$program_id, $semester_id]);

        // display the results in two columns
        $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $half_count = ceil(count($subjects) / 2);

        echo '<div class="row">';
        echo '<div class="col text-center">';
        foreach (array_slice($subjects, 0, $half_count) as $subject) {
            echo '<div class="sub-container pt-1">';
            echo '<input class="form-check-input" type="radio" name="course" id="course' . $subject['course_id'] . '" value="' . $subject['course_id'] . '">';
            echo '<label class="form-check-label mx-auto" for="course' . $subject['course_id'] . '">' . $subject['course_name'] . '</label>';
            echo '</div>';
        }
        echo '</div>';
        echo '<div class="col text-center">';
        foreach (array_slice($subjects, $half_count) as $subject) {
            echo '<div class="sub-container">';
            echo '<input class="form-check-input" type="radio" name="course" id="course' . $subject['course_id'] . '" value="' . $subject['course_id'] . '">';
            echo '<label class="form-check-label mx-auto" for="course' . $subject['course_id'] . '">' . $subject['course_name'] . '</label>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST['edit_subject_schedule'])) {
    $section_id = $_POST["section_id"];
    $semester_id = $_POST["semester_id"];

    $sql = "SELECT program_id FROM `section` WHERE section_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$section_id]);
    $row = $stmt->fetch();
    $program_id = $row['program_id'];
    // prepare the SQL statement to retrieve the subjects
    $sql = "SELECT course_id, course_name FROM `course` WHERE course_id = ? AND semester_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$program_id, $semester_id]);

    //print the result in option value = $subjects
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($subjects as $subject) {
        echo '<option value="' . $subject['course_id'] . '">' . $subject['course_name'] . '</option>';
    }
}
