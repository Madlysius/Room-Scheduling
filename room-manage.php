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
                <!--ID field-->
                <div class="col-lg">
                    <input type="text" name="search" placeholder="ID" class="form-control input-filter" id="IDInput">
                </div>
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
                    <button type="submit" class="btn btn-dark input-filter fButton" onclick="toggle()">Add Room</button>
                </div>
            </div>
            <?php
            $status = new Display();
            $status->displayStatus();
            ?>
            <!--Room Management Table-->
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

    <!--POPUP-->
    <div class="popup" id="popup">
        <div class="popup-header">
            <h1>Add Room</h1>
        </div>
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
        filterTable(["#IDInput", "#NameInput", "#CategoryInput", "#LocationInput"], "#room-table");
    </script>
</body>

</html>