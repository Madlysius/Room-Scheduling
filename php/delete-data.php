<?php
require_once('./require/DBConfig.php');
if (isset($_GET['delete']) && ($_SERVER['REQUEST_METHOD'] == 'GET')) {
    if ($_GET['delete'] == 'course') {
        $course_id = filter_input(INPUT_GET, 'course_id', FILTER_SANITIZE_NUMBER_INT);
        if (empty($course_id)) {
            $status = "empty";
            header("Location: ../course-manage.php?status=$status&message=Please Fill Up All Fields");
            exit();
        }
        try {
            DB::delete('course', "course_id=%s", $course_id);
            $status = "success";

            header("Location: ../course-manage.php?status=$status&message=Successfully Deleted");
        } catch (Exception $e) {
            $status = "failed";
            header("Location: ../course-manage.php?status=$status&message=Failed to Delete");
        }
    }
    //Delete Section
    if ($_GET['delete'] == 'section') {
        $section_id = filter_input(INPUT_GET, 'section_id', FILTER_SANITIZE_NUMBER_INT);
        if (empty($section_id)) {
            $status = "empty";
            header("Location: ../section-manage.php?status=$status&message=Empty");
            exit();
        }
        try {
            DB::delete('section', "section_id=%s", $section_id);
            $status = "success";
            header("Location: ../section-manage.php?status=$status&message=Successfully Deleted");
        } catch (Exception $e) {
            $status = "error";
            header("Location: ../section-manage.php?status=$status&message=Failed to Delete Section");
        }
    }
    //Delete Subject
    if ($_GET['delete'] == 'subject') {
        $subject_id = filter_input(INPUT_GET, 'subject_id', FILTER_SANITIZE_NUMBER_INT);
        if (empty($subject_id)) {
            $status = "empty";
            header("Location: ../subject-manage.php?status=$status&message=Empty");
            exit();
        }
        try {
            DB::delete('subject', "subject_id=%s", $subject_id);
            $status = "success";
            header("Location: ../subject-manage.php?status=$status&message=Successfully Deleted");
        } catch (Exception $e) {
            $status = "failed";
            header("Location: ../subject-manage.php?status=$status&message=Failed to Delete Subject");
        }
    }
    //Delete Room
    if ($_GET['delete'] == 'room') {
        $room_id = filter_input(INPUT_GET, 'room_id', FILTER_SANITIZE_NUMBER_INT);
        if (empty($room_id)) {
            $status = "empty";
            header("Location: ../room-manage.php?status=$status&message=Empty");
            exit();
        }
        try {
            // Check if room has associated records in other tables
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM `scheduling table` WHERE room_id = :room_id');
            $stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            if ($count > 0) {
                $status = "error";
                $message = "Cannot delete room with associated reservations";
            } else {
                // Delete the room
                $stmt = $pdo->prepare('DELETE FROM room WHERE room_id = :room_id');
                $stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
                $stmt->execute();
                $status = "success";
                $message = "Successfully deleted room";
            }
            header("Location: ../room-manage.php?status=$status&message=$message");
        } catch (PDOException $e) {
            $status = "error";
            $error = $e->getMessage();
            echo $error;
            header("Location: ../room-manage.php?status=$status&message=Failed to Delete Room");
        }
    }
    //delete schedule
    if ($_GET['delete'] == 'schedule') {
        $schedule = filter_input(INPUT_GET, 'schedule_id', FILTER_SANITIZE_NUMBER_INT);
        if (empty($schedule)) {
            $status = "empty";
            header("Location: ../schedule-manage.php?status=$status&message=Empty");
            exit();
        }
        try {
            DB::delete('scheduling table', "schedule_id=%s", $schedule);
            $status = "success";
            header("Location: ../scheduling.php?status=$status&message=Successfully Deleted");
        } catch (Exception $e) {
            $status = "error";
            header("Location: ../scheduling.php?status=$status&message=Failed to Delete Schedule");
        }
    }
}
