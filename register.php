<?php
ob_start();
session_start();
require_once('classes/dbconnection.php');

if (isset($_SESSION['user']) != "") {
    header("Location: index.php");
}

if (isset($_POST['signup'])) {

    $uname = trim($_POST['uname']);
    $email = trim($_POST['email']);
    $upass = trim($_POST['pass']);
    $password = hash('sha256', $upass);

    $db = Database::getInstance();
    $conn = $db->getConnection();

    // check email exist or not
    $query = "SELECT id, username, password FROM users WHERE email= '$email'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    // if email is not found add user
    if ($count == 0) {
        //insert new user
        $query = "INSERT INTO users(username,email,password) VALUES('$uname', '$email', '$password')";
        $result = mysqli_query($conn, $query);

        $user_id = mysqli_insert_id($conn);
        if ($user_id > 0) {
            // set session and redirect to index page
            $_SESSION['user'] = $user_id;
            header("Location: index.php");
            exit;
        } else {
            $errTyp = "danger";
            $errMSG = "Algo salió mal, intenta de nuevo";
        }
    } else {
        $errTyp = "warning";
        $errMSG = "El email ya está en uso";
    }
}
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
</head>
<body>
<div class="top-content" style="padding: 110px">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 form-box">
                <div class="form-top">
                    <div class="form-top-left">
                        <h3>Registrese en nuestro sitio</h3>
                    </div>
                </div>
                <div class="form-bottom">
                    <form method="post" autocomplete="off">

                        <?php
                        if (isset($errMSG)) {

                        ?>
                        <div class="form-group">
                            <div class="alert alert-<?php echo ($errTyp == "success") ? "success" : $errTyp; ?>">
                                <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                            </div>
                        </div>
                        <?php
                        }
                        ?>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                <input type="text" name="uname" class="form-control" placeholder="Enter Username"
                                       required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span
                                            class="glyphicon glyphicon-envelope"></span></span>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email"
                                       required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                <input type="password" name="pass" class="form-control" placeholder="Enter Password"
                                       required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn    btn-block btn-primary" name="signup" id="reg">Register
                            </button>
                        </div>

                        <div class="form-group">
                            <a href="login.php" type="button" class="btn btn-block btn-success"
                               name="btn-login">Login</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="js/jquery.backstretch.min.js"></script>
<script src="js/scripts.js"></script>

</body>
</html>
