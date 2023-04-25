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
                    <button type="button" class="btn btn-dark input-filter fButton" onclick="toggle()">Add Program</button>
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

    <!--POPUP-->
    <div class="popup" id="popup">
        <div class="popup-header">
            <h1>Add Program</h1>
        </div>
        <form id="course-add-form" method="POST" action="./php/add-data.php">

            <label for="program_name">Program Name</label>
            <input type="text" name="program_name" id="program_name" class="form-control form-ele" placeholder="Computer Science">

            <label for="program_department">Program Department</label>
            <input type="text" name="program_department" id="program_department" class="form-control form-ele" placeholder="DCS">

            <label for="program_abbreviation">Program Abbreviation</label>
            <input type="text" name="program_abbreviation" id="program_abbreviation" class="form-control form-ele" placeholder="CS">
            <div class="btn-con">
                <button type="submit" class="btn btn-dark fButton" name="add-program">Add program</button>
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

        filterTable(["#IdInput", "#NameInput", "#DepartmentInput", "#AbbreviationInput"], "#program-table");
    </script>

</body>

</html>