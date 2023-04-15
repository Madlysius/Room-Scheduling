<?php
require_once('require/DBConfig.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['room_schedule'])) {
    $room_id = $_POST['room_id'];
    $stmt = $pdo->prepare("
            SELECT st.schedule_id, st.schedule_start_time, st.schedule_end_time,
                   su.subject_name, su.subject_code, d.day
            FROM `scheduling table` AS st
            JOIN `subject` AS su ON st.subject_id = su.subject_id
            JOIN `day` AS d ON st.day_id = d.day_id
            WHERE st.room_id = :room_id
            ORDER BY st.schedule_start_time
        ");
    $stmt->execute([':room_id' => $room_id]);
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
                        echo '<div class="tb-content">' . $row->subject_name . ' <br> ' . $row->subject_code . ' <br>' . $row->schedule_start_time . '  -  ' . $row->schedule_end_time;
                        //add a button to delete the schedule
                        echo '<div class="dropdown ">
                            <button class="btn btn-secondary dropdown-toggle" style="background-color:#FFFFFFF" type="button" id="dropdownMenuButton-'  . $row->schedule_id . '" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row->schedule_id  . '">
                                <li><a class="dropdown-item" href="edit-forms.php?edit=schedule&schedule_id=' . $row->schedule_id  . '">Edit</a></li>
                                <li><a class="dropdown-item" href="./php/delete-data.php?delete=schedule&schedule_id=' . $row->schedule_id  . '">Delete</a></li>
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
        // prepare the SQL statement to get the course_id for the section
        $sql = "SELECT course_id FROM `section` WHERE section_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$section_id]);
        $row = $stmt->fetch();
        $course_id = $row['course_id'];

        // prepare the SQL statement to retrieve the subjects
        $sql = "SELECT subject_id, subject_name FROM `subject` WHERE course_id = ? AND semester_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$course_id, $semester_id]);

        // display the results in two columns
        $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $half_count = ceil(count($subjects) / 2);

        echo '<div class="row">';
        echo '<div class="col text-center">';
        foreach (array_slice($subjects, 0, $half_count) as $subject) {
            echo '<div class="sub-container pt-1">';
            echo '<input class="form-check-input" type="radio" name="subject" id="subject' . $subject['subject_id'] . '" value="' . $subject['subject_id'] . '">';
            echo '<label class="form-check-label mx-auto" for="subject' . $subject['subject_id'] . '">' . $subject['subject_name'] . '</label>';
            echo '</div>';
        }
        echo '</div>';
        echo '<div class="col text-center">';
        foreach (array_slice($subjects, $half_count) as $subject) {
            echo '<div class="sub-container">';
            echo '<input class="form-check-input" type="radio" name="subject" id="subject' . $subject['subject_id'] . '" value="' . $subject['subject_id'] . '">';
            echo '<label class="form-check-label mx-auto" for="subject' . $subject['subject_id'] . '">' . $subject['subject_name'] . '</label>';
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

    $sql = "SELECT course_id FROM `section` WHERE section_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$section_id]);
    $row = $stmt->fetch();
    $course_id = $row['course_id'];
    // prepare the SQL statement to retrieve the subjects
    $sql = "SELECT subject_id, subject_name FROM `subject` WHERE course_id = ? AND semester_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$course_id, $semester_id]);

    //print the result in option value = $subjects
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($subjects as $subject) {
        echo '<option value="' . $subject['subject_id'] . '">' . $subject['subject_name'] . '</option>';
    }
}
