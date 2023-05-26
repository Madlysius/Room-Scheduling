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
                    <input type="text" name="CourseInput" placeholder="Program" class="form-control input-filter" id="CourseInput">
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
                            echo "<td>" . ($row['laboratory_units']) . "</td>";
                            echo "<td>" . ($row['lecture_units'] + ($row['laboratory_units'])) . "</td>";
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
                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add programs on program management to display program options on dropdown.">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z" />
                            </svg>
                        </a>
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
                        <select class="form-select form-ele" id="lec_hrs" name="lecture_units">
                            <option value="1">1</option>
                            <option value="2" selected>2</option>
                            <option value="3">3</option>
                        </select>


                        <label for="laboratory_units">Laboratory Units</label>
                        <select class="form-select form-ele" id="laboratory_units" name="laboratory_units">
                            <option value="0">0</option>
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                        </select>


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

        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

</body>

</html>