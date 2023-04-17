<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Website Title -->
    <title><?php echo $title ?> | COECSA Room Scheduling</title>

    <!-- Website Styling and Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- Favicon -->
    <link rel="icon" href="./images/lpu-cavite.png" type="image/x-icon" />
    <script src="./javascript/javascript.js?=" <?php echo time() ?>></script>
    <?php
    if ($css_link) {
        echo '<link href="' . $css_link . '" rel="stylesheet">';
    } else {
        echo "";
    }
    if ($filter) {
        echo '<script src="./javascript/filter.js?=2' . time() . '"></script>';
    }
    if ($auth) {
        require_once('./php/require/auth.php');
    }

    // imports, include, require and such
    require_once('./php/function/display_function.php');
    require_once('./php/require/DBConfig.php');

    ?>
</head>