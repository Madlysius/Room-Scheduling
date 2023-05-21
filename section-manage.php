<?php
$title = "Section Management";
$css_link = "./styles/section-manage.css?=" . date("y-m-d");
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
                    <input type="text" name="course" placeholder="Program" class="form-control input-filter" id="CourseInput">
                </div>
                <!--Year field-->
                <div class="col-md">
                    <select class="form-select input-filter" id="YearInput">
                        <option value="">All Year</option>
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                        <option value="3rd">3rd</option>
                        <option value="4th">4th</option>
                    </select>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-dark input-filter fButton" data-bs-toggle="modal" data-bs-target="#modal">Add Section</button>
                </div>
            </div>
            <?php

            $subject = new Display();
            $subject->displayStatus();
            ?>

            <!--Section Management Table-->
            <div class="table-wrap">
                <table class="table table-hover" id="sec-table">
                    <thead class="thead">
                        <tr>
                            <td>Section Name</td>
                            <td>Program</td>
                            <td>Year</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <?php
                        $stmt = $pdo->prepare("SELECT section.section_id, section.section_name, section.section_year, program.program_name FROM section INNER JOIN program ON section.program_id = program.program_id");
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<td>" . $row['section_name'] . "</td>";
                            echo "<td>" . $row['program_name'] . "</td>";
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
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border border-dark rounded-5 overflow-hidden">
                <div class="modal-header popup-header">
                    <h1 class="modal-title fs-2" id="exampleModalLabel">Add Section</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                        <label for="secProgram">Program</label>
                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add programs on program management to display program options on dropdown.">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z"/>
                            </svg>
                        </a>
                        <select class="form-select form-ele" id="secProgram" name="secProgram">
                            <?php
                            $secProgram = new Display();
                            $secProgram->displayOption("program", "program_id", "program_name");
                            ?>
                        </select>
                        <div class="btn-con">
                            <button type="submit" class="btn btn-dark fButton" name="add-section">Add Section</button>
                            <button type="button" class="btn btn-dark fButton" data-bs-dismiss="modal">Back</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--POPUP JAVASCRIPT-->
    <script>
        filterTable(["#SectionInput", "#CourseInput", "#YearInput"], "#sec-table");

        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>

</html>