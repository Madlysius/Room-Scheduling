<?php
$title = "Subject Management";
$css_link = "./styles/subject-manage.css?=" . date("ymd");
$jquery = true;
$auth = true;
$filter = true;
require_once('./php/require/header.php');
?>

<body>

    <?php
    include './php/require/navbar.php';
    ?>

    <div id="overlay">
        <div class="container-fluid subject-con">
            <h1>Subject Management</h1>
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
                <div class="col">
                    <select class="form-select input-filter" id="CourseInput">
                        <option value="">All Course</option>
                        <?php
                        $course = new Display();
                        $course->displayOption("course", "course_name", "course_name");
                        ?>
                    </select>
                </div>

                <!--Semester Filter field-->
                <div class="col">
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
                    <button type="submit" class="btn btn-dark input-filter fButton" onclick="toggle()">Add Subject</button>
                </div>

            </div>
            <?php
            $subject = new Display();
            $subject->displayStatus();
            ?>
            <!--Subject Management Table-->
            <table class="table table-hover" id="subject-table">
                <thead class="thead">
                    <tr>
                        <td>Course Program</td>
                        <td>Subject Code</td>
                        <td>Subject Name</td>
                        <td>Semester</td>
                        <td>Lecture Hours</td>
                        <td>Laboratory Hours</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody class="tbody">
                    <?php
                    $result = DB::query('SELECT * FROM subject');
                    foreach ($result as $row) {
                        $subjects[] = $row;
                        echo "<tr>";
                        $course = $mysqli->query("SELECT course_name FROM course WHERE course_id = " . $row['course_id']);
                        echo "<td>" . $course->fetch_assoc()['course_name'] . "</td>";
                        echo "<td>" . $row['subject_code'] . "</td>";
                        echo "<td>" . $row['subject_name'] . "</td>";
                        $semester = $mysqli->query("SELECT semester FROM semester WHERE semester_id = " . $row['semester_id']);
                        echo "<td>" . $semester->fetch_assoc()['semester'] . "</td>";
                        echo "<td>" . $row['lecture_hr'] . "</td>";
                        echo "<td>" . $row['laboratory_hr'] . "</td>";
                        echo '<td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton-' . $row['subject_id'] . '" data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row['subject_id'] . '">
                                            <li><a class="dropdown-item" href="edit-forms.php?edit=subject&subject_id=' . $row['subject_id'] . '">Edit</a></li>
                                            <li><a class="dropdown-item" href="./php/delete-data.php?delete=subject&subject_id=' . $row['subject_id'] . '">Delete</a></li>
                                        </ul>
                                    </div>
                                </td>';
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!--POPUP-->
    <div class="popup" id="popup">
        <div class="popup-header">
            <h1>Add Subject</h1>
        </div>

        <!-- ADD SUBJECT FORM -->
        <form id="subject-add-form" action="./php/add-data.php" method="POST">
            <label for="subject_code">Subject Code</label>
            <input type="text" name="subject_code" id="subject_code" class="form-control form-ele" placeholder="ITEN04C">

            <label for="subject_name">Subject Name</label>
            <input type="text" name="subject_name" id="subject_name" class="form-control form-ele" placeholder="Quantitative Methods">

            <label for="subject_course">Course Program</label>
            <select class="form-select form-ele" id="subject_course" name="subject_course">
                <?php
                $CourseProgram = new display();
                $CourseProgram->displayOption('course', 'course_id', 'course_name');
                ?>
            </select>

            <label for="subject_semester">Semester</label>
            <select class="form-select form-ele" id="subject_semsester" name="subject_semester">
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
                <button type="submit" class="btn btn-dark fButton" name="add-subject">Add Subject</button>
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
        filterTable(["#CourseInput", "#empty1", "#empty2", "#SemesterInput"], "#subject-table");
    </script>

</body>

</html>