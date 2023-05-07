<?php
$title = "Professor Management";
$css_link = "./styles/professor-manage.css?=" . time();
$filter = true;
$auth = true;
require_once('./php/require/header.php');
?>

<body>

    <?php
    include './php/require/navbar.php';
    ?>

    <div id="overlay">
        <div class="container-fluid prof-con">
            <h1>Professor Management</h1>
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

                <!--department field-->
                <div class="col-lg">
                    <input type="text" name="department" placeholder="Department" class="form-control input-filter" id="DepInput">
                </div>

                <!--Add Professor Button-->
                <div class="col">
                    <button type="submit" class="btn btn-dark input-filter fButton" data-bs-toggle="modal" data-bs-target="#modal">Add Professor</button>
                </div>
            </div>
            <?php
            $subject = new Display();
            $subject->displayStatus();
            ?>
            <!--Professor Management Table-->
            <div class="table-wrap">
                <table class="table table-hover" id="prof-table">
                    <thead class="thead">
                        <tr>
                            <td>Professor ID</td>
                            <td>Professor Name</td>
                            <td>Professor Department</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <?php
                        $result = DB::query('SELECT * FROM professor');
                        foreach ($result as $row) {
                            echo "<td>" . $row['professor_id'] . "</td>";
                            echo "<td>" . $row['professor_name'] . "</td>";
                            echo "<td>" . $row['professor_department'] . "</td>";
                            echo "<td>";
                            echo '<div class="dropdown">';
                            echo '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton-' . $row['professor_id'] . '" data-bs-toggle="dropdown" aria-expanded="false">';
                            echo 'Actions';
                            echo '</button>';
                            echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row['professor_id'] . '">';
                            echo '<li><a class="dropdown-item" href="edit-forms.php?edit=professor&professor_id=' . $row['professor_id'] . '">Edit</a></li>';
                            echo '<li><a class="dropdown-item" href="#" onclick="deleteConfirmation(\'professor\',\'' . $row['professor_id'] . '\')">Delete</a></li>';
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

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border border-dark rounded-5 overflow-hidden">
                <div class="modal-header popup-header">
                    <h1 class="modal-title fs-2" id="exampleModalLabel">Add Professor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="prof-add-form" method="POST" action="./php/add-data.php">

                        <label for="professor_name">Professor Name</label>
                        <input type="text" name="professor_name" id="professor_name" class="form-control form-ele" placeholder="Joven Cajigas">

                        <label for="professor_department">Professor Department</label>
                        <input type="text" name="professor_department" id="professor_department" class="form-control form-ele" placeholder="DCS">

                        <div class="btn-con">
                            <button type="submit" class="btn btn-dark fButton" name="add-professor">Add Professor</button>
                            <button type="button" class="btn btn-dark fButton" data-bs-dismiss="modal">Back</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--POPUP JAVASCRIPT-->
    <script>
        filterTable(["#IdInput", "#NameInput", '#DepInput'], "#prof-table");
    </script>

</body>

</html>