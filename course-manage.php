<?php
$title = "Course Management";
$css_link = "./styles/course-manage.css?=" . date("ymd");
$auth = true;
$filter = true;
require_once('./php/require/header.php');
?>

<body>

    <?php
    include './php/require/navbar.php';
    ?>

    <div id="overlay">
        <div class="container-fluid course-con">
            <h1>Course Management</h1>
            <p>Filter by:</p>
            <!--Filter Fields-->
            <div class="row">
                <!-- empty 1 -->
                <div class="col" style="display:none">
                    <select class="" id="empty1">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col" style="display:none">
                    <select class="" id="empty2">
                        <option value=""></option>
                    </select>
                </div>
                <!--Course Classification Filter field-->
                <div class="col-md">
                    <select class="form-select input-filter" id="CourseInput">
                        <option value="">All Course</option>
                        <?php
                        $course = new Display();
                        $course->displayOption("program", "program_name", "program_name");
                        ?>
                    </select>
                </div>

                <!--Semester Filter field-->
                <div class="col-md">
                    <select class="form-select input-filter" id="SemesterInput">
                        <option value="">All Semester</option>
                        <?php
                        $semester = new Display();
                        $semester->displayOption("semester", "semester_id", "semester");
                        ?>
                    </select>
                </div>

                <!--Add Room Button-->
                <div class="col">
                    <button type="submit" class="btn btn-dark input-filter fButton" onclick="toggle()">Add Course</button>
                </div>

            </div>
            <?php
            $course = new Display();
            $course->displayStatus();
            ?>
            <!--Course Management Table-->
            <table class="table table-hover" id="course-table">
                <thead class="thead">
                    <tr>
                        <td>Program</td>
                        <td>Course Code</td>
                        <td>Course Name</td>
                        <td>Semester</td>
                        <td>Lecture Hours</td>
                        <td>Laboratory Hours</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody class="tbody">
                    <?php
                    $result = DB::query('SELECT * FROM course');
                    foreach ($result as $row) {
                        $courses[] = $row;
                        echo "<tr>";
                        $course = $mysqli->query("SELECT program_name FROM program WHERE program_id = " . $row['program_id']);
                        echo "<td>" . $course->fetch_assoc()['program_name'] . "</td>";
                        echo "<td>" . $row['course_code'] . "</td>";
                        echo "<td>" . $row['course_name'] . "</td>";
                        $semester = $mysqli->query("SELECT semester FROM semester WHERE semester_id = " . $row['semester_id']);
                        echo "<td>" . $semester->fetch_assoc()['semester'] . "</td>";
                        echo "<td>" . $row['lecture_hr'] . "</td>";
                        echo "<td>" . $row['laboratory_hr'] . "</td>";
                        echo "<td>";
                        echo '<div class="dropdown">';
                        echo '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton-' . $row['course_id'] . '" data-bs-toggle="dropdown" aria-expanded="false">';
                        echo 'Actions';
                        echo '</button>';
                        echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row['course_id'] . '">';
                        echo '<li><a class="dropdown-item" href="edit-forms.php?edit=course&course_id=' . $row['course_id'] . '">Edit</a></li>';
                        echo '<li><a class="dropdown-item" href="#" onclick="deleteConfirmation(\'course\',\'' . $row['course_id'] . '\')">Delete</a></li>';
                        echo '</ul>';
                        echo '</div>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!--POPUP-->
    <div class="popup" id="popup">
        <div class="popup-header">
            <h1>Add Course</h1>
        </div>

        <!-- ADD COURSE FORM -->
        <form id="course-add-form" action="./php/add-data.php" method="POST">
            <label for="course_code">Course Code</label>
            <input type="text" name="course_code" id="course_code" class="form-control form-ele" placeholder="ITEN04C">

            <label for="course_name">Course Name</label>
            <input type="text" name="course_name" id="course_name" class="form-control form-ele" placeholder="Quantitative Methods">

            <label for="program_id">Program</label>
            <select class="form-select form-ele" id="program_id" name="program_id">
                <?php
                $CourseProgram = new display();
                $CourseProgram->displayOption('program', 'program_id', 'program_name');
                ?>
            </select>

            <label for="course_semester">Semester</label>
            <select class="form-select form-ele" id="course_semsester" name="course_semester">
                <?php
                $Semester = new display();
                $Semester->displayOption('semester', 'semester_id', 'semester');
                ?>
            </select>

            <label for="lec_hrs">Lecture Hours</label>
            <input type="number" name="lec_hrs" id="lec_hrs" step=0.5 class="form-control form-ele" placeholder="1">

            <label for="lab_hrs">Laboratory Hours</label>
            <input type="number" name="lab_hrs" id="lab_hrs" step=0.5 class="form-control form-ele" placeholder="1">

            <div class="btn-con">
                <button type="submit" class="btn btn-dark fButton" name="add-course">Add Course</button>
                <button type="button" class="btn btn-dark fButton" onclick="toggle()">Back</button>
            </div>
        </form>
    </div>

    <!--POPUP JAVASCRIPT-->
    <script>
        let popup = document.getElementById("popup");
        let overlay = document.getElementById("overlay");

        function toggle() {
            popup.classList.toggle("active");
            overlay.classList.toggle("active");
        }
        filterTable(["#CourseInput", "#empty1", "#empty2", "#SemesterInput"], "#course-table");
    </script>

</body>

</html>