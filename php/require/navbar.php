<style>
    .fixed-top {
        position: inherit;
    }

    .nav-link.active {
        text-underline-offset: 5px;
        text-decoration: underline;
    }

    /* CHANGES 4/8/2023 */
    .navbar-brand {
        font-size: 1.5rem;
        padding: 10px;
        text-align: center;
    }

    .navbar-brand>img {
        width: 50px;
        height: 50px;
        margin-right: 10px;
    }
</style>

<nav class="navbar bg-body-tertiary fixed-top">
    <div class="container-fluid">
        <!-- NAVBAR TITLE -->
        <a class="navbar-brand" href="./scheduling.php"><img src="./images/lpu-cavite.png" alt=""> COECSA Room Scheduling</a>
        <?php
        if (basename($_SERVER['PHP_SELF']) != "home.php") {
        ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <!-- OFFCANVAS TITLE -->
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">COECSA Room Scheduling</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body">
                    <!-- OFFCANVAS LINKS >>START -->
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">


                        <?php if ($_SESSION['user_type_id'] == 1) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == "home.php") echo "active"; ?>" href="./home.php">Home</a>
                            </li>
                            <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == "professor-manage.php") echo "active"; ?>" href="./professor-manage.php">Professor Management</a>
                            <li class="nav-item">
                                <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == "scheduling.php") echo "active"; ?>" href="./scheduling.php">Schedule Management</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == "room-manage.php") echo "active"; ?>" href="./room-manage.php">Room Management</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == "program-manage.php") echo "active"; ?>" href="./program-manage.php">Program Management</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == "section-manage.php") echo "active"; ?>" href="./section-manage.php">Section Management</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == "course-manage.php") echo "active"; ?>" href="./course-manage.php">Course Management</a>
                            </li>
                        <?php } else if ($_SESSION['user_type_id'] == 2) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == "scheduling.php") echo "active"; ?>" href="./scheduling.php">Scheduling Management</a>
                            </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="logoutConfirmation()">Logout</a>
                        </li>

                    </ul>
                    <!-- OFFCANVAS LINKS >>END -->
                </div>
            </div>
        <?php } ?>
    </div>
</nav>