<?php
    include_once "lib/session.php";
    
    $session = new session();
    
    if (!isset($_SESSION["kind"])) {
        header("Location: index.html");
        exit;
    }
    
    include_once "lib/user.php";

    $sql = "Select * From user Where username = '" . $_SESSION["name"] . "'";
//    $stmt = $con->prepare("SELECT password, email FROM accounts WHERE id = ?");
    
    $user = new user();
    $result = $user->makeSql($sql);

    foreach ($result as $row){
        $id = $row['id'];
        $username = $row["username"];
        $kind = $row['kind'];
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Perfil</title>
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
                <a href="home.php"><i class="fas fa-home"></i>Gestión</a>
                <a href=""><i class="fas fa-user-circle"></i>Perfil</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Cerrar sesión</a>
            </div>
        </nav>
        <div class="content">
            <h2>Profile Page</h2>
            <div>
                <p>Detalles de tu cuenta:</p>
                <table>
                    <tr>
                        <td>ID:</td>
                        <td><?=$id?></td>
                    </tr>
                    <tr>
                        <td>Nombre de usuario:</td>
                        <td><?=$username?></td>
                    </tr>
                    <tr>
                        <td>Tipo:</td>
<?php
    switch ($kind){
        case 1: echo "<td>Administrador</td>"; break;
        case 2: echo "<td>Repartidor</td>"; break;
        case 3: echo "<td>Vendedor</td>"; break;
        default: echo "<td> ¿...? </td>";
    }
?>
                        <td><?=$kind?></td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>
