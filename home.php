<?php
$title = "Home";
$css_link = "./styles/home.css?=" . time() . '';
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
            <!-- Programss Management -->
            <a href="./program-manage.php" class="card">
                <img src="./images/program.png" alt="">
                <h2>Program Management</h2>
            </a>

            <!-- Professor Card  -->
            <a href="./professor-manage.php" class="card">
                <img src="./images/professor.png" alt="">
                <h2>Professor Management</h2>
            </a>

            <!-- Section Management -->
            <a href="./section-manage.php" class="card">
                <img src="./images/section.png" alt="">
                <h2>Section Management</h2>
            </a>

            <!-- Room Management -->
            <a href="./room-manage.php" class="card">
                <img src="./images/classroom.png" alt="">
                <h2>Room Management</h2>
            </a>

            <!-- Course Management -->
            <a href="./course-manage.php" class="card">
                <img src="./images/course.png" alt="">
                <h2>Course Management</h2>
            </a>

            <!-- Scheduling Card -->
            <a href="./schedule-manage.php" class="card">
                <img src="./images/calendar.png" alt="">
                <h2>Schedule Management</h2>
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