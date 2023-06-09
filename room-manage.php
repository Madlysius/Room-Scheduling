<?php
$title = "Room Management";
$css_link = "./styles/room-manage.css?=" . time();
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
        <div class="container-fluid room-con">
            <h1>Room Management</h1>
            <p>Filter by:</p>

            <!--Filter Fields-->
            <div class="row">
                <!--Name field-->
                <div class="col-lg">
                    <input type="text" name="name" placeholder="Name" class="form-control input-filter" id="NameInput">
                </div>
                <!--Category field-->
                <div class="col-sm">
                    <select class="form-select input-filter" id="CategoryInput">
                        <option value="">All Room Category</option>
                        <option value="Lecture Room">Lecture Room</option>
                        <option value="Laboratory Room">Laboratory Room</option>
                    </select>
                </div>
                <!--Location field-->
                <div class="col-sm">
                    <select class="form-select input-filter" id="LocationInput">
                        <option value="">All Location</option>
                        <option value="Main">Main</option>
                        <option value="Annex">Annex</option>
                    </select>
                </div>
                <!--Add Room Button-->
                <div class="col">
                    <button type="submit" class="btn btn-dark input-filter fButton" data-bs-toggle="modal" data-bs-target="#modal">Add Room</button>
                </div>
            </div>
            <?php
            $status = new Display();
            $status->displayStatus();
            ?>
            <!--Room Management Table-->
            <div class="table-wrap">
                <table class="table table-hover" id="room-table">
                    <thead class="thead">
                        <tr>
                            <td>Room Name</td>
                            <td>Category</td>
                            <td>Location</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <?php
                        $rooms = DB::query('SELECT * FROM room');
                        foreach ($rooms as $row) {
                            echo "<tr>";;
                            echo "<td>" . $row['room_name'] . "</td>";
                            echo "<td>" . $row['room_category'] . "</td>";
                            echo "<td>" . $row['room_location'] . "</td>";
                            echo "<td>";
                            echo '<div class="dropdown">';
                            echo '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton-' . $row['room_id'] . '" data-bs-toggle="dropdown" aria-expanded="false">';
                            echo 'Actions';
                            echo '</button>';
                            echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row['room_id'] . '">';
                            echo '<li><a class="dropdown-item" href="edit-forms.php?edit=room&room_id=' . $row['room_id'] . '">Edit</a></li>';
                            echo '<li><a class="dropdown-item" href="#" onclick="deleteConfirmation(\'room\',\'' . $row['room_id'] . '\')">Delete</a></li>';
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
                    <h1 class="modal-title fs-2" id="exampleModalLabel">Add Room</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="room-add-form" action="./php/add-data.php" method="POST">
                        <label for="room_name">Room Name</label>
                        <input type="text" name="room_name" id="room_name" class="form-control form-ele" placeholder="Physics Room">
                        <label for="room_categ">Category</label>
                        <select class="form-select form-ele" id="room_categ" name="room_categ">
                            <option value="">Category</option>
                            <option value="Lecture Room">Lecture Room</option>
                            <option value="Laboratory Room">Laboratory Room</option>
                        </select>
                        <label for="room_addr">Location</label>
                        <select class="form-select form-ele" id="room_addr" name="room_addr">
                            <option value="">Location</option>
                            <option value="Main">Main</option>
                            <option value="Annex">Annex</option>
                        </select>
                        <div class="btn-con">
                            <button type="submit" class="btn btn-dark fButton" name="add-room">Add Room</button>
                            <button type="button" class="btn btn-dark fButton" data-bs-dismiss="modal">Back</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--POPUP JAVASCRIPT-->
    <script>
        filterTable(["#NameInput", "#CategoryInput", "#LocationInput"], "#room-table");
    </script>
</body>

</html>