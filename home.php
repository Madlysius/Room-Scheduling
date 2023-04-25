<?php
$title = "Home";
$css_link = "./styles/home.css?=" . time() .'';
$auth = true;
$filter = false;
require_once('./php/require/header.php');
?>

<body>
    <div class="container-fluid home mt-4">
        <div class="row">
            <div class="col">
                <h1>Home</h1>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <p>Welcome to the COECSA Room Scheduling System!</p>
            </div>
        </div>

        <div class="cards">

            <!-- Scheduling Card -->
            <a href="./scheduling.php" class="card">
                <img src="./images/calendar.png" alt="">
                <h2>Schedule</h2>
            </a>

            <!-- Room Management -->
            <a href="./room-manage.php" class="card">
                <img src="./images/classroom.png" alt="">
                <h2>Room Management</h2>
            </a>

            <!-- Programss Management -->
            <a href="./program-manage.php" class="card">
                <img src="./images/course.png" alt="">
                <h2>Program Management</h2>
            </a>
            <!-- Section Management -->
            <a href="./section-manage.php" class="card">
                <img src="./images/section.png" alt="">
                <h2>Section Management</h2>
            </a>
            <!-- Subject Management -->
            <a href="./subject-manage.php" class="card">
                <img src="./images/subject.png" alt="">
                <h2>Subject Management</h2>
            </a>
            <!-- Logout -->
            <a href="#" onclick="logoutConfirmation()" class="card">
                <img src="./images/logout.png" alt="">
                <h2>Logout</h2>
            </a>
        </div>
    </div>
</body>

</html>