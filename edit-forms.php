<?php
$title = "Edit";
$css_link = "";
$auth = true;
$filter = false;
require_once('./php/require/header.php');
?>

<body>
  <?php
  include './php/require/navbar.php';
  if (!isset($_GET['edit'])) {
    header("Location:" . $_SERVER['HTTP_REFERER']);
  }
  ?>
  <div class="container vh-100">
    <div class="row vh-100 justify-content-center pt-5">
      <div class="form-group">
        <h2 class="text-center">Edit <?php echo $_GET['edit'] ?></h2>
        <form id="login" method="POST" class="col-12" action="<?php echo htmlentities('./php/update-data.php'); ?>">
          <?php
          if (empty($_GET['edit'])) {
            //header to last location 
            header("Location: " . $_SERVER['HTTP_REFERER']);
          }
          if (isset($_GET['edit'])) {
            if ($_GET['edit'] == 'program') {
              $result = DB::query("SELECT * FROM program WHERE program_id = %s", $_GET['program_id']);
              if ($result) {

                echo "<input type='hidden' name='edit' value='program'>";
                echo "<label for='program_id' class='form-label'>Program ID</label>";
                echo "<input type='text' class='form-control' id='program_id' name='program_id' value='" . $result[0]['program_id'] . "' readonly>";
                echo "<label for='program_name' class='form-label'>Program Name</label>";
                echo "<input type='text' class='form-control' id='program_name' name='program_name' value='" . $result[0]['program_name'] . "'>";
                echo "<label for='program_department' class='form-label'>Program Department</label>";
                echo "<select class='form-select form-ele' name='program_department' id='program_department'>";
                echo "<option value='DCS'". ($result[0]['program_department'] == 'DCS' ? ' selected' : '') .">DCS</option>";
                echo "<option value='DOA'". ($result[0]['program_department'] == 'DOA' ? ' selected' : '') .">DOA</option>";
                echo "<option value='DOE'". ($result[0]['program_department'] == 'DOE' ? ' selected' : '') .">DOE</option>";
                echo "</select>";
                echo "<label for='program_abbreviation' class='form-label'>Program Abbreviation</label>";
                echo "<input type='text' class='form-control' id='program_abbreviation' name='program_abbreviation' value='" . $result[0]['program_abbreviation'] . "'>";
              } else {
                header("Location: ./program-manage.php");
              }
            } else if ($_GET['edit'] == 'professor') {
              $result = DB::query("SELECT * FROM professor WHERE professor_id = %s", $_GET['professor_id']);
              if (($result)) {
                echo "<input type='hidden' name='edit' value='professor'>";
                echo "<label for='professor_id' class='form-label'>Professor ID</label>";
                echo "<input type='text' class='form-control' id='professor_id' name='professor_id' value='" . $result[0]['professor_id'] . "' readonly>";
                echo "<label for='professor_name' class='form-label'>Professor Name</label>";
                echo "<input type='text' class='form-control' id='professor_name' name='professor_name' value='" . $result[0]['professor_name'] . "'>";
                echo "<label for='professor_department' class='form-label'>Professor Department</label>";
                echo "<select class='form-select form-ele' id='professor_department' name='professor_department'>";
                echo "<option value='DCS'". ($result[0]['professor_department'] == 'DCS' ? ' selected' : '') .">DCS</option>";
                echo "<option value='DOA'". ($result[0]['professor_department'] == 'DOA' ? ' selected' : '') .">DOA</option>";
                echo "<option value='DOE'". ($result[0]['professor_department'] == 'DOE' ? ' selected' : '') .">DOE</option>";
                echo "</select>";
              }
            } else if ($_GET['edit'] == 'room') {
              $result = DB::query("SELECT * FROM room WHERE room_id = %s", $_GET['room_id']);
              if ($result) {
                echo "<input type='hidden' name='edit' value='room'>";
                echo "<label for='room_id' class='form-label'>Room ID</label>";
                echo "<input type='text' class='form-control' id='room_id' name='room_id' value='" . $result[0]['room_id'] . "' readonly>";
                echo "<label for='room_name' class='form-label'>Room Name</label>";
                echo "<input type='text' class='form-control' id='room_name' name='room_name' value='" . $result[0]['room_name'] . "'>";
                echo "<label for='room_category' class='form-label'>Room Category</label>";
                echo "<select class='form-select' id='room_category' name='room_category'>";
                echo "<option value='Lecture Room'" . ($result[0]['room_category'] == 'Lecture Room' ? ' selected' : '') . ">Lecture Room</option>";
                echo "<option value='Laboratory Room'" . ($result[0]['room_category'] == 'Laboratory Room' ? ' selected' : '') . ">Laboratory Room</option>";
                echo "</select>";
                echo "<label for='room_location' class='form-label'>Room Location</label>";
                echo "<select class='form-select' id='room_location' name='room_location'>";
                echo "<option value='Main'" . ($result[0]['room_location'] == 'Main' ? ' selected' : '') . ">Main</option>";
                echo "<option value='Annex'" . ($result[0]['room_location'] == 'Annex' ? ' selected' : '') . ">Annex</option>";
                echo "</select>";
              } else {
                header("Location: ./room-manage.php");
              }
            } else if ($_GET['edit'] == 'section') {
              $fields = array('section_id', 'section_name', 'section_year', 'course_id');
              $result = DB::query("SELECT * FROM section WHERE section_id = %s", $_GET['section_id']);
              if ($result) {
                echo "<input type='hidden' name='edit' value='section'>";
                echo "<label for='section_id' class='form-label'>Section ID</label>";
                echo "<input type='text' class='form-control' id='section_id' name='section_id' value='" . $result[0]['section_id'] . "' readonly>";
                echo "<label for='section_name' class='form-label'>Section Name</label>";
                echo "<input type='text' class='form-control' id='section_name' name='section_name' value='" . $result[0]['section_name'] . "'>";
                echo "<label for='section_year' class='form-label'>Section Year</label>";
                echo "<select class='form-select' id='section_year' name='section_year'>";
                echo "<option value='1st'" . ($result[0]['section_year'] == '1st' ? ' selected' : '') . ">1st</option>";
                echo "<option value='2nd'" . ($result[0]['section_year'] == '2nd' ? ' selected' : '') . ">2nd</option>";
                echo "<option value='3rd'" . ($result[0]['section_year'] == '3rd' ? ' selected' : '') . ">3rd</option>";
                echo "<option value='4th'" . ($result[0]['section_year'] == '4th' ? ' selected' : '') . ">4th</option>";
                echo "</select>";
                echo "<label for='program_id' class='form-label'>Program</label>";
                echo "<select class='form-select' id='program_id' name='program_id'>";
                $program = DB::query("SELECT * FROM program");
                foreach ($program as $row) {
                  echo "<option value='" . $row['program_id'] . "'" . ($result[0]['program_id'] == $row['program_id'] ? ' selected' : '') . ">" . $row['program_name'] . "</option>";
                }
                echo "</select>";
              } else {
                header("Location: ./section-manage.php");
              }
            } else if ($_GET['edit'] == 'schedule') {
              $result = DB::query("select * from `scheduling table` where `schedule_id` = %s", $_GET['schedule_id']);
              if ($result) {
                echo "<input type='hidden' name='edit' value='schedule'>";
                echo "<label for='schedule_id' class='form-label'>Schedule ID</label>";
                echo "<input type='text' class='form-control' id='schedule_id' name='schedule_id' value='" . $result[0]['schedule_id'] . "' readonly>";
                echo "<label for='section_id' class='form-label'>Section</label>";
                echo "<select class='form-select' id='section_id' name='section_id'>";
                $section = DB::query("SELECT * FROM section");
                foreach ($section as $row) {
                  echo "<option value='" . $row['section_id'] . "'" . ($result[0]['section_id'] == $row['section_id'] ? ' selected' : '') . ">" . $row['section_name'] . "</option>";
                }
                echo "</select>";
                //semester_id
                echo "<label for='semester_id' class='form-label'>Semester</label>";
                echo "<select class='form-select' id='semester_id' name='semester_id'>";
                $semester = DB::query("SELECT * FROM semester");
                foreach ($semester as $row) {
                  echo "<option value='" . $row['semester_id'] . "'" . ($result[0]['semester_id'] == $row['semester_id'] ? ' selected' : '') . ">" . $row['semester'] . "</option>";
                }
                echo "</select>";
                //Course id
                echo "<label for='course_id' class='form-label'>Course</label>";
                echo "<select class='form-select' id='course_id' name='course_id'>";
                echo "</select>";
                echo "<label for='room_id' class='form-label'>Room</label>";
                echo "<select class='form-select' id='room_id' name='room_id'>";
                $room = DB::query("SELECT * FROM room");
                foreach ($room as $row) {
                  echo "<option value='" . $row['room_id'] . "'" . ($result[0]['room_id'] == $row['room_id'] ? ' selected' : '') . ">" . $row['room_name'] . "</option>";
                }
                echo "</select>";
                //day_id
                echo "<label for='day_id' class='form-label'>Day</label>";
                echo "<select class='form-select' id='day_id' name='day_id'>";
                $day = DB::query("SELECT * FROM day");
                foreach ($day as $row) {
                  echo "<option value='" . $row['day_id'] . "'" . ($result[0]['day_id'] == $row['day_id'] ? ' selected' : '') . ">" . $row['day'] . "</option>";
                }
                echo "</select>";
                //schedule_start-time
                echo "<label for='schedule_start_time' class='form-label'>Start Time</label>";
                $start_time = new Display();
                echo "<select class='form-select' id='schedule_start_time' name='schedule_start_time'>";
                $start_time->displayTimeSelected("07:00", "21:00", "+30 minutes", $result[0]['schedule_start_time']);
                echo "</select>";
                //schedule_end-time
                echo "<label for='schedule_end_time' class='form-label'>End Time</label>";
                $end_time = new Display();
                echo "<select class='form-select' id='schedule_end_time' name='schedule_end_time'>";
                $end_time->displayTimeSelected("07:00", "21:00", "+30 minutes", $result[0]['schedule_end_time']);
                echo "</select>";
                echo "<label for='schedule_type' class='form-label'>Schedule Type</label>";
                echo "<select class='form-select' id='schedule_type' name='schedule_type'>";
                echo "<option value='Lecture'" . ($result[0]['schedule_type'] == 'Lecture' ? ' selected' : '') . ">Lecture</option>";
                echo "<option value='Laboratory'" . ($result[0]['schedule_type'] == 'Laboratory' ? ' selected' : '') . ">Laboratory</option>";
                echo "</select>";
                echo "<label for='professor_id' class='form-label'>Professor</label>";
                echo "<select class='form-select' id='professor_id' name='professor_id'>";
                $professor = DB::query("SELECT * FROM professor");
                foreach ($professor as $row) {
                  echo "<option value='" . $row['professor_id'] . "'" . ($result[0]['professor_id'] == $row['professor_id'] ? ' selected' : '') . ">" . $row['professor_name'] . "</option>";
                }
                echo "</select>";
                echo "<script src='./javascript/scheduling.js?=v4'></script>";
              } else {
                header("Location: ./scheduling.php");
              }
            } else if ($_GET['edit'] == 'course') {
              $fields = array('course_id', 'course_id', 'semester_id', 'course_code', 'course_name', 'lecture_hr', 'laboratory_hr');
              $result = DB::query("SELECT * FROM course WHERE course_id = %s", $_GET['course_id']);
              if ($result) {
                echo "<input type='hidden' name='edit' value='course'>";
                echo "<label for='course_id' class='form-label'>Course ID</label>";
                echo "<input type='text' class='form-control' id='course_id' name='course_id' value='" . $result[0]['course_id'] . "' readonly>";
                echo "<label for='program_id' class='form-label'>Program</label>";
                echo "<select class='form-select' id='program_id' name='program_id'>";
                $program = DB::query("SELECT * FROM program");
                foreach ($program as $row) {
                  echo "<option value='" . $row['program_id'] . "'" . ($result[0]['program_id'] == $row['program_id'] ? ' selected' : '') . ">" . $row['program_name'] . "</option>";
                }
                echo "</select>";
                echo "<label for='course_id' class='form-label'>Course</label>";
                echo "<select class='form-select' id='course_id' name='course_id'>";
                $course = DB::query("SELECT * FROM course");
                foreach ($course as $row) {
                  echo "<option value='" . $row['course_id'] . "'" . ($result[0]['course_id'] == $row['course_id'] ? ' selected' : '') . ">" . $row['course_name'] . "</option>";
                }
                echo "</select>";
                echo "<label for='semester_id' class='form-label'>Semester</label>";
                echo "<select class='form-select' id='semester_id' name='semester_id'>";
                $semester = DB::query("SELECT * FROM semester");
                foreach ($semester as $row) {
                  echo "<option value='" . $row['semester_id'] . "'" . ($result[0]['semester_id'] == $row['semester_id'] ? ' selected' : '') . ">" . $row['semester'] . "</option>";
                }
                echo "</select>";
                echo "<label for='course_code' class='form-label'>Course Code</label>";
                echo "<input type='text' class='form-control' id='course_code' name='course_code' value='" . $result[0]['course_code'] . "'>";
                echo "<label for='course_name' class='form-label'>Course Name</label>";
                echo "<input type='text' class='form-control' id='course_name' name='course_name' value='" . $result[0]['course_name'] . "'>";
                // echo "<label for='lecture_units' class='form-label'>Lecture Units</label>";
                // echo "<input type='number' class='form-control' id='lecture_units' name='lecture_units' value='" . $result[0]['lecture_units'] . "' min=1 max=3>";
                // echo "<label for='laboratory_units' class='form-label'>Laboratory Units</label>";
                // echo "<input type='number' class='form-control' id='laboratory_units' name='laboratory_units' value='" . $result[0]['laboratory_units'] . "'min=1 max=2>";
                echo "<label for='lecture_units'>Lecture Units</label>";
                echo "<select class='form-select form-ele' id='lec_hrs' name='lecture_units'>";
                    echo "<option value='1' ".($result[0]['lecture_units'] == 1 ? 'selected': '').">1</option>";
                    echo "<option value='2' ".($result[0]['lecture_units'] == 2 ? 'selected': '').">2</option>";
                    echo "<option value='3' ".($result[0]['lecture_units'] == 3 ? 'selected': '').">3</option>";
                echo "</select>";
                echo "<label for='laboratory_units'>Laboratory Units</label>";
                echo "<select class='form-select form-ele' id='laboratory_units' name='laboratory_units'>";
                    echo "<option value='0' ".($result[0]['laboratory_units'] == 0 ? 'selected': '').">0</option>";
                    echo "<option value='1' ".($result[0]['laboratory_units'] == 1 ? 'selected': '').">1</option>";
                    echo "<option value='2' ".($result[0]['laboratory_units'] == 2 ? 'selected': '').">2</option>";
                echo "</select>";
              } else {
                header("Location:./course-manage.php");
              }
            }
          }
          ?>
          <div class="form-group text-center pt-3 mx-auto">
            <?php
            //save button
            echo "<button type='submit' class='btn btn-primary' name=\"" . "" . $_GET['edit'] . "\" href='./php/update-data.php' onclick='return confirm(\"Are you sure you want to save changes?\")'>Save</button>";

            echo "<button type= 'button' class='btn btn-danger' onclick='window.location.href = \"./" . $_GET['edit'] . "-manage.php\"'>Cancel</button>";
            ?>
          </div>

        </form>
      </div>
    </div>
  </div>

</body>

</html>