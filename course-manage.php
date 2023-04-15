<?php
$title = "Course Management";
$css_link = "./styles/course-manage.css?=" . date("YMD");
$filter = true;
$jquery = true;
$auth = true;
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
                <!--ID field-->
                <div class="col">
                    <input type="text" name="id" placeholder="ID" class="form-control input-filter" id="IdInput">
                </div>

                <!--Name field-->
                <div class="col">
                    <input type="text" name="name" placeholder="Name" class="form-control input-filter" id="NameInput">
                </div>

                <!--Add Course Button-->
                <div class="col">
                    <button type="submit" class="btn btn-dark input-filter fButton" onclick="toggle()">Add Course</button>
                </div>
            </div>
            <?php
            $subject = new Display();
            $subject->displayStatus();
            ?>
            <!--Course Management Table-->
            <table class="table table-hover" id="course-table">
                <thead class="thead">
                    <tr>
                        <td>Course ID</td>
                        <td>Courses Registered in COECSA</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody class="tbody">
                    <?php
                    $result = DB::query('SELECT * FROM course');
                    foreach ($result as $row) {
                        echo "<td>" . $row['course_id'] . "</td>";
                        echo "<td>" . $row['course_name'] . "</td>";
                        echo '<td>
                           <div class="dropdown">
                               <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton-' . $row['course_id'] . '" data-bs-toggle="dropdown" aria-expanded="false">
                                   Actions
                               </button>
                               <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row['course_id'] . '">
                                   <li><a class="dropdown-item" href="edit-forms.php?edit=course&course_id=' . $row['course_id'] . '">Edit</a></li>
                                   <li><a class="dropdown-item" href="./php/delete-data.php?delete=course&course_id=' . $row['course_id'] . '">Delete</a></li>
                               </ul>
                           </div>
                       </td>';
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
        <form id="course-add-form" method="POST" action="./php/add-data.php">

            <label for="course_name">Course Name</label>
            <input type="text" name="course_name" id="course_name" class="form-control form-ele" placeholder="Computer Science">

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

        filterTable(["#IdInput", "#NameInput"], "#course-table");
    </script>

</body>

</html>