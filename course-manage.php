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
                <!--Course Program Filter field-->
                <div class="col-md">
                    <select class="form-select input-filter" id="CourseInput">
                        <option value="">All Course</option>
                        <?php
                        $course = new Display();
                        $course->displayOption("program", "program_name", "program_name");
                        ?>
                    </select>
                </div>

                <div class="col-md">
                    <input type="text" name="CourseCodeInput" placeholder="Course Code" class="form-control input-filter" id="CourseCodeInput">
                </div>

                <div class="col-md">
                    <input type="text" name="CourseNameInput" placeholder="Course Name" class="form-control input-filter" id="CourseNameInput">
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
                    <button type="submit" class="btn btn-dark input-filter fButton" data-bs-toggle="modal" data-bs-target="#modal">Add Course</button>
                </div>

            </div>
            <?php
            $course = new Display();
            $course->displayStatus();
            ?>
            <!--Course Management Table-->
            <div class="table-wrap">
                <table class="table table-hover" id="course-table">
                    <thead class="thead">
                        <tr>
                            <td>Program</td>
                            <td>Course Code</td>
                            <td>Course Name</td>
                            <td>Semester</td>
                            <td>Lecture Units</td>
                            <td>Laboratory Units</td>
                            <td>Units</td>
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
                            echo "<td>" . $row['lecture_units'] . "</td>";
                            echo "<td>" . $row['laboratory_units'] . "</td>";
                            echo "<td>" . ($row['lecture_units'] + $row['laboratory_units']) . "</td>";
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
    </div>
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border border-dark rounded-5 overflow-hidden">
                <div class="modal-header popup-header">
                    <h1 class="modal-title fs-2" id="exampleModalLabel">Add Course</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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

                        <label for="lecture_units">Lecture Units</label>
                        <input type="number" name="lecture_units" id="lec_hrs" step=0.5 class="form-control form-ele" placeholder="1">

                        <label for="laboratory_units">Laboratory Units</label>
                        <input type="number" name="laboratory_units" id="laboratory_units" step=0.5 class="form-control form-ele" placeholder="1">


                        <div class="btn-con">
                            <button type="submit" class="btn btn-dark fButton" name="add-course">Add Course</button>
                            <button type="button" class="btn btn-dark fButton" data-bs-dismiss="modal">Back</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--POPUP JAVASCRIPT-->
    <script>
        filterTable(["#CourseInput", "#CourseCodeInput", "#CourseNameInput", "#SemesterInput"], "#course-table");
    </script>

</body>

</html>