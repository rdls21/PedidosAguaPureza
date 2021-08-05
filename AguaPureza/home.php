<?php
    include "lib/session.php";
    include_once "lib/alert.php";
    
    $session = new session();
    
    if(!isset($_SESSION["name"])) {
        header("location: index.html");
        exit;
    }
    if($_SESSION["active"] == 0) {
        alert("Cuenta desactivada");
        include "index.html";
        exit;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestión</title>
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body class="loggedin">
        <nav class="navtop">
            <div>
                <h1><l><object align='center 'height=60 width=60 data="css/svg/AguaPureza.svg">
                    Tu buscador no soporta formato SVG
                </object><l></h1>
                <a href="product.php"><i class="fas fa-home"></i>Productos</a>
                <a href="customer.php"><i class="fas fa-home"></i>Clientes</a>
                <a href=""><i class="fas fa-home"></i>Gestión</a>
                <a href="profile.php"><i class="fas fa-user-circle"></i>Perfil</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Cerrar sesión</a>
            </div>
        </nav>
        <div class="content">
            <h2>Página de inicio</h2>
            <p>Bienvendido, <?=$_SESSION["name"]?>!</p>
        </div>
<?php
    if ($_SESSION["kind"] == 1) {
        include_once "views/admin.php";
    }
    if ($_SESSION["kind"] == 2) {
        include_once "views/rep.php";
    }
    if ($_SESSION["kind"] == 3) {
        include_once "views/ven.php";
    }
?>
    </body>
</html>
