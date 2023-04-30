<?php
$title = "Program Management";
$css_link = "./styles/program-manage.css?=" . date("YMD");
$filter = true;
$auth = true;
require_once('./php/require/header.php');
?>

<body>

    <?php
    include './php/require/navbar.php';
    ?>

    <div id="overlay">
        <div class="container-fluid course-con">
            <h1>Program Management</h1>
            <p>Filter by:</p>
            <!--Filter Fields-->
            <div class="row">
                <!--ID field-->
                <div class="col-lg">
                    <input type="text" name="id" placeholder="ID" class="form-control input-filter" id="IdInput">
                </div>

                <!--Name field-->
                <div class="col-lg">
                    <input type="text" name="name" placeholder="Name" class="form-control input-filter" id="NameInput">
                </div>

                <!--Department field-->
                <div class="col-lg">
                    <input type="text" name="department" placeholder="Department" class="form-control input-filter" id="DepartmentInput">
                </div>

                <!--Abbreviation field-->
                <div class="col-lg">
                    <input type="text" name="abbreviation" placeholder="Abbreviation" class="form-control input-filter" id="AbbreviationInput">
                </div>

                <!--Add Program Button-->
                <div class="col">
                    <button type="submit" class="btn btn-dark input-filter fButton" data-bs-toggle="modal" data-bs-target="#modal">Add Program</button>
                </div>
            </div>
            <?php
            $subject = new Display();
            $subject->displayStatus();
            ?>
            <!--Course Management Table-->
            <table class="table table-hover" id="program-table">
                <thead class="thead">
                    <tr>
                        <td>Program ID</td>
                        <td>Program Registered in COECSA</td>
                        <td>Program Department </td>
                        <td>Program Abbreviation </td>
                        <td>Action</td>
                    </tr>
                </thead>

                <tbody class="tbody">
                    <?php
                    $result = DB::query('SELECT * FROM program');
                    foreach ($result as $row) {
                        echo "<td>" . $row['program_id'] . "</td>";
                        echo "<td>" . $row['program_name'] . "</td>";
                        echo "<td>" . $row['program_department'] . "</td>";
                        echo "<td>" . $row['program_abbreviation'] . "</td>";
                        echo "<td>";
                        echo '<div class="dropdown">';
                        echo '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton-' . $row['program_id'] . '" data-bs-toggle="dropdown" aria-expanded="false">';
                        echo 'Actions';
                        echo '</button>';
                        echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row['program_id'] . '">';
                        echo '<li><a class="dropdown-item" href="edit-forms.php?edit=program&program_id=' . $row['program_id'] . '">Edit</a></li>';
                        echo '<li><a class="dropdown-item" href="#" onclick="deleteConfirmation(\'program\',\'' . $row['program_id'] . '\')">Delete</a></li>';
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

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border border-dark rounded-5 overflow-hidden">
                <div class="modal-header popup-header">
                    <h1 class="modal-title fs-2" id="exampleModalLabel">Add Program</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="course-add-form" method="POST" action="./php/add-data.php">

                        <label for="course_name">Program Name</label>
                        <input type="text" name="course_name" id="course_name" class="form-control form-ele" placeholder="Computer Science">

                        <label for="course_dep">Program Department</label>
                        <input type="text" name="course_dep" id="course_dep" class="form-control form-ele" placeholder="DCS">

                        <label for="course_abbr">Program Abbreviation</label>
                        <input type="text" name="course_abbr" id="course_abbr" class="form-control form-ele" placeholder="CS">

                        <div class="btn-con">
                            <button type="submit" class="btn btn-dark fButton" name="add-course">Add Program</button>
                            <button type="button" class="btn btn-dark fButton" data-bs-dismiss="modal">Back</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--POPUP JAVASCRIPT-->
    <script>
        filterTable(["#IdInput", "#NameInput", "#DepartmentInput", "#AbbreviationInput"], "#program-table");
    </script>

</body>

</html>