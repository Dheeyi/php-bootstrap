<?php
ob_start();
session_start();
require_once('classes/dbconnection.php');

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['btn-login'])) {
    $email = $_POST['email'];
    $upass = $_POST['pass'];
    $password = hash('sha256', $upass);

    $db = Database::getInstance();
    $conn = $db->getConnection();

    $query = "SELECT id, username, password FROM users WHERE email= '$email'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    mysqli_close($conn);

    if ($row['password'] == $password) {
        $_SESSION['user'] = $row['id'];
        header("Location: index.php");
    } elseif ($count == 1) {
        $errMSG = "Password icorrecto";
    } else $errMSG = "Usuario no Encontrado";
}
?>

<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
</head>
<body>

<div class="top-content">
    <div class="container">

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 text">
                <h1><strong>GooWia</strong> <h3> by Dheeyi William</h3></h1>
                <div class="description">
                    <p>El mejor sitio de nuevas Tecnologias</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 form-box">
                <div class="form-top">
                    <div class="form-top-left">
                        <h3>Inicie sesión en nuestro sitio</h3>
                        <p>Ingrese su email y password:</p>
                    </div>
                </div>
                <div class="form-bottom">
                    <form method="post" autocomplete="off" class="login-form">
                        <?php
                        if (isset($errMSG)) {
                            ?>
                            <div class="form-group">
                                <div class="alert alert-danger">
                                    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="form-group">
                            <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                            <input type="email" name="email" class="form-control" placeholder="Email" required/>
                        </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                <input type="password" name="pass" class="form-control" placeholder="Password" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-primary" name="btn-login">Login</button>
                        </div>

                        <div class="form-group">
                            <a href="register.php" type="button" class="btn btn-block btn-danger"
                               name="btn-login">Register</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 social-login">
                <h3>...o ingresa con:</h3>
                <div class="social-login-buttons">
                    <a class="btn btn-link-1 btn-link-1-facebook" href="#">
                        <i class="fa fa-facebook"></i> Facebook
                    </a>
                    <a class="btn btn-link-1 btn-link-1-twitter" href="#">
                        <i class="fa fa-twitter"></i> Twitter
                    </a>
                    <a class="btn btn-link-1 btn-link-1-google-plus" href="#">
                        <i class="fa fa-google-plus"></i> Google Plus
                    </a>
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
