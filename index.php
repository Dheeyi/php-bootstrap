<?php
ob_start();
session_start();
require_once('classes/dbconnection.php');

//if the session variable does not exist with a user we make a redirect to login.php
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
//We create an instance of the connection to the database
$db = Database::getInstance();
$conn = $db->getConnection();
$query = "SELECT * FROM users WHERE id=" . $_SESSION['user'];
$result = mysqli_query($conn, $query);
$userRow = mysqli_fetch_array($result, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hola,<?php echo $userRow['email']; ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="css/index.css" type="text/css"/>
</head>
<body>

<!-- Navigation Bar-->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">GooWia</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">PHP y mySQL</a></li>
                <li><a href="#">Android & iOS</a></li>
                <li><a href="#">Base de Datos</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <span class="glyphicon glyphicon-user"></span>&nbsp;Logged in: <?php echo $userRow['email']; ?>
                        &nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="logout.php?logout"><span
                                        class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="container">
    <div class="jumbotron">
        <h1>Hola, <?php echo $userRow['username']; ?></h1>
        <p>Bienvenido nuevamente a su espacio de trabajo. </p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Aprende mas</a></p>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h3>Noticias...</h3>
            <p>Nuevos cursos <a href="http://cegos.com.bo/" target="_blank">disponibles </a></p>
            <p>
                <small>Cada curso tiene nuevos materiales y actualizaciones recientes.</small>
            </p>
        </div>
    </div>
</div>

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
