<?php
$title = "Section Management";
$css_link = "./styles/section-manage.css?=" . date("y-m-d");
$jquery = true;
$auth = true;
$filter = true;
require_once('./php/require/header.php');
?>

<body>

    <?php
    include './php/require/navbar.php';
    ?>

    <div id="overlay"><!--overlay for blur of background when modal is open-->
        <div class="container-fluid sec-con">
            <h1>Section Management</h1>
            <p>Filter by:</p>
            <!--Filter Fields-->
            <div class="row">
                <!--Name field-->
                <div class="col-md">
                    <input type="text" name="secName" placeholder="Section Name" class="form-control input-filter" id="SectionInput">
                </div>
                <!--Course field-->
                <div class="col-md">
                    <input type="text" name="course" placeholder="Course Name" class="form-control input-filter" id="CourseInput">
                </div>
                <!--Year field-->
                <div class="col-md">
                    <select class="form-select input-filter" id="YearInput">
                        <option value="">All Location</option>
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                        <option value="3rd">3rd</option>
                        <option value="4th">4th</option>
                    </select>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-dark input-filter fButton" onclick="toggle()">Add Section</button>
                </div>
            </div>
            <?php

            $subject = new Display();
            $subject->displayStatus();
            ?>
            <!--Section Management Table-->
            <table class="table table-hover" id="sec-table">
                <thead class="thead">
                    <tr>
                        <td>Section Name</td>
                        <td>Course</td>
                        <td>Year</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody class="tbody">
                    <?php
                    $stmt = $pdo->prepare("SELECT section.section_id, section.section_name, section.section_year, course.course_name FROM section INNER JOIN course ON section.course_id = course.course_id");
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<td>" . $row['section_name'] . "</td>";
                        echo "<td>" . $row['course_name'] . "</td>";
                        echo "<td>" . $row['section_year'] . "</td>";
                        echo "<td>";
                        echo '<div class="dropdown">';
                        echo '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton-' . $row['section_id'] . '" data-bs-toggle="dropdown" aria-expanded="false">';
                        echo 'Actions';
                        echo '</button>';
                        echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row['section_id'] . '">';
                        echo '<li><a class="dropdown-item" href="edit-forms.php?edit=section&section_id=' . $row['section_id'] . '">Edit</a></li>';
                        echo '<li><a class="dropdown-item" href="#" onclick="deleteConfirmation(\'section\',\'' . $row['section_id'] . '\')">Delete</a></li>';
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
            <h1>Add Section</h1>
        </div>
        <form id="section-add-form" method="POST" action="./php/add-data.php">
            <label for="secName">Section Name</label>
            <input type="text" name="secName" id="secName" class="form-control form-ele" placeholder="CS301">
            <label for="secYear">Year</label>
            <select class="form-select form-ele" name="secYear" id="secYear">
                <option value="1st">1st</option>
                <option value="2nd">2nd</option>
                <option value="3rd">3rd</option>
                <option value="4th">4th</option>
            </select>
            <label for="secCourse">Course</label>
            <select class="form-select form-ele" id="secCourse" name="secCourse">
                <?php
                $result = DB::query("SELECT * FROM course");
                foreach ($result as $row) {
                    echo "<option value='" . $row['course_id'] . "'>" . $row['course_name'] . "</option>";
                }
                ?>
            </select>
            <div class="btn-con">
                <button type="submit" class="btn btn-dark fButton" name="add-section">Add Section</button>
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
        filterTable(["#SectionInput", "#CourseInput", "#YearInput"], "#sec-table");
    </script>
</body>

</html>