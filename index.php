<?php
$title = "Login";
$css_link = "./styles/index.css?=" . date("Ymd");
$filter = false;
$auth = false;
require_once('./php/require/header.php');
?>

<body>
    <div class="login-background">
        <div class="container-fluid login-con">
            <img src="./images/lpu-cavite.png" alt="">
            <h1 style="text-align:center">COECSA Room Scheduling</h1>
            <form id="login" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
                <div class="mb-3">
                    <label for="usernameInput" class="form-label">Username</label>
                    <input type="text" class="form-control" name="usernameInput" id="usernameInput" aria-describedby="emailHelp" placeholder="Username">
                </div>
                <div class="mb-3">
                    <label for="passInput" class="form-label">Password</label>
                    <input type="password" class="form-control" name="passInput" id="passInput" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-dark" name="login">Login</button>
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
                $username = htmlspecialchars($_POST['usernameInput']);
                $userpass = htmlspecialchars($_POST['passInput']);
                if (empty($username) || empty($userpass)) {
                    echo "<h3 class='text-danger mt-2'>Please fill out all fields.</h3>";
                }
                if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                    echo "<h3 class='text-danger mt-2'>Invalid username or password.</h3>";
                } else {
                    $stmt = $mysqli->prepare("SELECT * FROM user WHERE username = ?");
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if (mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_assoc($result);
                        $pass = $row['userpass'];
                        if ($userpass == $pass) {
                            session_start();
                            $_SESSION['user_id'] = $row['user_id'];
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['user_type_id'] = $row['user_type_id'];
                            if ($row['user_type_id'] == 1) {
                                // User type 1 can access all pages
                                header("Location: ./home.php");
                                $allowed_pages = array('schedule-manage.php', 'course-manage.php', 'room-manage.php', 'section-manage.php', 'subject-manage.php', 'edit-forms.php');
                            } else if ($row['user_type_id'] == 2) {
                                // User type 2 can only access scheduling page
                                header("Location: ./schedule-manage.php");
                                $allowed_pages = array('schedule-manage.php', 'edit-forms.php');
                            } else {
                                // Invalid user type
                                header('Location: login.php');
                                exit();
                            }
                        } else {
                            echo "<h3 class='text-danger mt-2'>Incorrect password.</h3>";
                        }
                    } else {
                        echo "<h3 class='text-danger mt-2'>Incorrect Username or Password.</h3>";
                    }
                }
            }
            ?>
        </div>
    </div>
</body>

</html>