<?php
session_start();
//go to base directory using dirname
$loc = dirname($_SERVER['PHP_SELF']) . "/index.php";
if (!isset($_SESSION['username']) || !isset($_SESSION['user_type_id']) || !isset($_SESSION['user_id'])) {
    header("Location: $loc");
}

// Check user type
$user_type_id = $_SESSION['user_type_id'];
if ($user_type_id == 1) {
    // User type 1 can access all pages
    $allowed_pages = array('home.php', 'scheduling.php', 'program-manage.php', 'room-manage.php', 'section-manage.php', 'course-manage.php', 'edit-forms.php');
} else if ($user_type_id == 2) {
    // User type 2 can only access scheduling page
    $allowed_pages = array('scheduling.php', 'edit-forms.php');
} else {
    // Invalid user type
    header("Location: $loc");
    exit();
}

// Check if user is allowed to access the requested page
if (!in_array(basename($_SERVER['PHP_SELF']), $allowed_pages)) {
    // User is not allowed to access the requested page
    header("Location: $loc");
    exit();
}
